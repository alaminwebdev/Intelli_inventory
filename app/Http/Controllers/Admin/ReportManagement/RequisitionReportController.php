<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
use App\Models\Department;
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

    public function __construct(
        CurrentStockService $currentStockService,
        EmployeeService $employeeService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService,
        DepartmentService $departmentService,
        DistributionService $distributionService,
        ProductInformationService $productInformationService

    ) {
        $this->currentStockService          = $currentStockService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->departmentService            = $departmentService;
        $this->distributionService          = $distributionService;
        $this->productInformationService    = $productInformationService;
    }

    public function getProductStatistics(Request $request)
    {
        $data['title']          = 'পন্যের পরিসংখ্যান';
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

        return view('admin.reports.product-statistics', $data);
    }

    private function productStatisticsPdfDownload($data)
    {
        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.product-statistics-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'পন্যের পরিসংখ্যান-' . $data['date_in_bengali'] . '.pdf';
        return $pdf->stream($fileName);
    }

    public function getExpiringSoonProducts(Request $request){
        $data['title']          = 'শীঘ্রই মেয়াদ উত্তীর্ণ হবে পণ্য';

        if ($request->isMethod('post')){
            if ($request['days'] != null ){
                $expiringSoonProducts   = $this->productInformationService->getExpiringSoonProducts($request['days']);
            }else{
                $expiringSoonProducts   = [];
            }
            if ($request->type == 'pdf') {
                $date                   = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
                $formatter              = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $formatter->setPattern('d-MMMM-y'); // Customize the date format if needed
                $date_in_bengali = $formatter->format($date);
                
                return $this->expiringSoonProductsPdfDownload($date_in_bengali, $expiringSoonProducts);
            }
        }else{
            $expiringSoonProducts   = $this->productInformationService->getExpiringSoonProducts(60);
        }

        $formattedProducts = [];

        foreach ($expiringSoonProducts  as $product) {
            $po_no = $product['po_no'];
    
            if (!isset($formattedProducts[$po_no])) {
                $formattedProducts[$po_no] = [
                    'po_no' => $po_no,
                    'products' => [],
                ];
            }
    
            $formattedProducts[$po_no]['products'][] = $product;
        }

        $data['expiringSoonProducts'] = $formattedProducts;
        return view('admin.reports.expiring-soon-products', $data);
    }

    private function expiringSoonProductsPdfDownload($date_in_bengali, $expiringSoonProducts)
    {
        $data['date_in_bengali'] = $date_in_bengali;
        $formattedProducts = [];

        foreach ($expiringSoonProducts  as $product) {
            $po_no = $product['po_no'];
    
            if (!isset($formattedProducts[$po_no])) {
                $formattedProducts[$po_no] = [
                    'po_no' => $po_no,
                    'products' => [],
                ];
            }
    
            $formattedProducts[$po_no]['products'][] = $product;
        }
        $data['expiringSoonProducts'] = $formattedProducts;
        
        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.expiring-soon-products-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        $fileName = 'মেয়াদ উত্তীর্ণ হবে পণ্য -' . $data['date_in_bengali'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
