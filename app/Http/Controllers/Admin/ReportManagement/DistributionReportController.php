<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Distribute;
use App\Models\ProductInformation;
use App\Models\Section;
use App\Models\SectionRequisition;
use App\Models\UserRole;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use PDF;
use IntlDateFormatter;

use App\Services\CurrentStockService;
use App\Services\EmployeeService;
use App\Services\SectionService;
use App\Services\SectionRequisitionService;
use App\Services\DepartmentService;
use App\Services\DistributionService;
use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use Hamcrest\Core\AllOf;
use Illuminate\Support\Facades\Auth;


class DistributionReportController extends Controller
{

    private $currentStockService;
    private $employeeService;
    private $sectionService;
    private $sectionRequisitionService;
    private $departmentService;
    private $distributionService;
    private $productInformationService;
    private $productTypeService;

    public function __construct(
        CurrentStockService $currentStockService,
        EmployeeService $employeeService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService,
        DepartmentService $departmentService,
        DistributionService $distributionService,
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService

    ) {
        $this->currentStockService          = $currentStockService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->departmentService            = $departmentService;
        $this->distributionService          = $distributionService;
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
    }

    public function productDistributionReport(Request $request)
    {
        $data['title']          = 'পণ্য বিতরণ রিপোর্ট';
        $data['departments']    = $this->departmentService->getAll(1);
        $data['products']       = $this->productInformationService->getAll([1]);
        $data['sections']       = [];

        if ($request->isMethod('post')) {

            $request->validate([
                'department_id' => 'required'
            ], [
                'department_id.required' => 'দপ্তর প্রয়োজন।'
            ]);

            $data['sections'] = $this->sectionService->getSectionsByDepartment($request->department_id);

            if ($request->section_id == 0) {
                $sections = $data['sections']->toArray();

                // Extract only the "id" values into a new array
                $sectionIds = array_map(function ($section) {
                    return $section['id'];
                }, $sections);

                $data['section'] = [];
            } else {
                $sectionIds = [$request->section_id];
                $data['section'] = Section::find($request->section_id);
            }

            $data['distributed_products'] = $this->getDistributedProducts($sectionIds, $request->product_information_id, $request->date_from, $request->date_to);

            if ($request->type == 'pdf') {
                $date                   = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
                $formatter              = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $formatter->setPattern('d-MMMM-y'); // Customize the date format if needed
                $data['date_in_bengali'] = $formatter->format($date);

                if ($request['date_from'] != null) {
                    $date_from              = DateTime::createFromFormat('d-m-Y', $request['date_from'])->setTimezone(new DateTimeZone('Asia/Dhaka'));
                    $date_from_formatter    = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $date_from_formatter->setPattern('d-MMMM-y');
                    $data['date_from']      = $date_from_formatter->format($date_from);
                } else {
                    $data['date_from']      = null;
                }
                if ($request['date_to'] != null) {
                    $date_to            = DateTime::createFromFormat('d-m-Y', $request['date_to'])->setTimezone(new DateTimeZone('Asia/Dhaka'));
                    $date_to_formatter  = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $date_to_formatter->setPattern('d-MMMM-y');
                    $data['date_to']    = $date_to_formatter->format($date_to);
                } else {
                    $data['date_to']    = null;
                }

                return $this->productStatisticsPdfDownload($data);
            }
        } else {
            // $data['distributed_products'] = [];
        }

        return view('admin.reports.product-distribution', $data);
    }

    public function getDistributedProducts($sectionIds_ids = null, $product_id = null, $from_date = null, $to_date = null)
    {

        $distributed_goods = SectionRequisition::join('distributes', 'distributes.section_requisition_id', 'section_requisitions.id')
            ->join('stock_in_details', 'stock_in_details.id', 'distributes.stock_in_detail_id')
            ->join('product_information', 'product_information.id', 'distributes.product_id')
            ->leftJoin('units', 'units.id', 'product_information.unit_id')
            ->leftJoin('sections', 'sections.id', 'section_requisitions.section_id')
            // ->leftJoin('departments', 'departments.id', 'sections.department_id')
            ->whereNotNull('distribute_quantity')
            ->whereIn('section_requisitions.section_id', $sectionIds_ids)
            ->where('section_requisitions.status', 4)
            ->whereBetween('distributes.created_at', [date('Y-m-d', strtotime($from_date)) . ' 00:00:00', date('Y-m-d', strtotime($to_date)) . ' 23:59:59'])
            ->when($product_id, function ($q, $product_id) {
                if (($product_id != 0)) {
                    $q->where('distributes.product_id', $product_id);
                }
            })
            ->select(
                'distributes.id as id',
                'section_requisitions.requisition_no as requisition_no',
                'product_information.id as product_id',
                'product_information.name as product',
                'units.name as unit_name',
                'sections.name as section',
                // 'departments.name as department',
                'stock_in_details.po_no as po_no',
                'distributes.distribute_quantity as distribute_quantity',
                'distributes.created_at as date'
            )
            ->get();

        $grouped_goods = $distributed_goods->groupBy('product_id')->toArray();
        return $grouped_goods;
    }

    private function currentStockPdfReport($data)
    {

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.current-stock-list-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'বর্তমান মজুদ-' . $data['date_in_bengali'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
