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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RequisitionReportController extends Controller
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

    public function getProductStatistics(Request $request)
    {
        $data['title']          = 'Product Statistics';
        $data['departments']    = $this->departmentService->getAll(1);
        $data['sections']       = [];

        if ($request->isMethod('post')) {
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
                // $date                   = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
                // $formatter              = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                // $formatter->setPattern('d-MMMM-y');
                // $data['date_in_bengali'] = $formatter->format($date);
                
                $date = Carbon::now();
                $data['date_in_english'] = $date->format('d-F-Y');
                
                if ($request['date_from'] != null) {
                    // $date_from              = DateTime::createFromFormat('d-m-Y', $request['date_from'])->setTimezone(new DateTimeZone('Asia/Dhaka'));
                    // $date_from_formatter    = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    // $date_from_formatter->setPattern('d-MMMM-y');
                    // $data['date_from']      = $date_from_formatter->format($date_from);
                    $data['date_from']      = date('d-F-Y', strtotime($request['date_from']));
                }else{
                    $data['date_from']      = null;
                }
                if ($request['date_to'] != null) {
                    // $date_to            = DateTime::createFromFormat('d-m-Y', $request['date_to'])->setTimezone(new DateTimeZone('Asia/Dhaka'));
                    // $date_to_formatter  = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    // $date_to_formatter->setPattern('d-MMMM-y');
                    // $data['date_to']    = $date_to_formatter->format($date_to);
                    $data['date_to']    = date('d-F-Y', strtotime($request['date_to']));
                }else{
                    $data['date_to']    = null;
                }

                return $this->productStatisticsPdfDownload($data);
            }
        } else {
            $data['productStatistics'] = $this->productInformationService->getProductStatistics();
        }

        return view('admin.reports.product-statistics', $data);
    }

    private function productStatisticsPdfDownload($data)
    {
        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.product-statistics-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'Product Statistics - ' . $data['date_in_english'] . '.pdf';
        return $pdf->stream($fileName);
    }

    public function getExpiringSoonProducts(Request $request){
        $data['title']          = 'Expiring Soon Products';
        $data['product_types']  = $this->productTypeService->getAll(1);


        if ($request->isMethod('post')){

            if ($request->product_type_id != 0){
                if ($request->product_information_id !=0) {
                    $data['products'] = $this->productInformationService->getProductsByTypeId([$request->product_type_id]);

                    $productIds = [$request->product_information_id];
                }else{
                    $data['products'] = $this->productInformationService->getProductsByTypeId([$request->product_type_id]);
                    
                    $productIds = $data['products']->pluck('id');
                }
            }else{
                $data['products'] = $this->productInformationService->getProductsByTypeId($data['product_types']->pluck('id'));
                $productIds = $data['products']->pluck('id');
            }


            if ($request['days'] != null ){
                $data['expiringSoonProducts']   = $this->productInformationService->getExpiringSoonProducts($productIds, $request['days']);
            }else{
                $data['expiringSoonProducts']   = [];
            }
            if ($request->type == 'pdf') {
                $date = Carbon::now();
                $data['date_in_english'] = $date->format('d-F-Y');
                return $this->expiringSoonProductsPdfDownload($data);
            }
        }else{
            $data['products']               = $this->productInformationService->getProductsByTypeId($data['product_types']->pluck('id'));
            $productIds                     = $data['products']->pluck('id');
            $data['expiringSoonProducts']   = $this->productInformationService->getExpiringSoonProducts($productIds, 60);
        }
        return view('admin.reports.expiring-soon-products', $data);
    }

    private function expiringSoonProductsPdfDownload($data)
    {
        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.expiring-soon-products-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'Expiring Soon Products -' . $data['date_in_english'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
