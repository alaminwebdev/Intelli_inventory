<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProductInformation;
use App\Models\Section;
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
            dd($request->all());

            if ($request->department_id != 0) {
                $data['department'] = Department::find($request->department_id);
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

                if ($sectionIds) {
                    $data['productStatistics'] = $this->productInformationService->getProductStatistics($sectionIds, $request);
                } else {
                    $data['productStatistics'] = [];
                }
            } else {
                $data['department']        = [];
                $data['productStatistics'] = $this->productInformationService->getProductStatistics(null, $request);
            }
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
                }else{
                    $data['date_from']      = null;
                }
                if ($request['date_to'] != null) {
                    $date_to            = DateTime::createFromFormat('d-m-Y', $request['date_to'])->setTimezone(new DateTimeZone('Asia/Dhaka'));
                    $date_to_formatter  = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $date_to_formatter->setPattern('d-MMMM-y');
                    $data['date_to']    = $date_to_formatter->format($date_to);
                }else{
                    $data['date_to']    = null;
                }

                return $this->productStatisticsPdfDownload($data);
            }
        } else {
            $data['productStatistics'] = $this->productInformationService->getProductStatistics();
        }

        return view('admin.reports.product-distribution', $data);
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
