<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Auth;

class RequisitionReportController extends Controller
{

    private $currentStockService;
    private $employeeService;
    private $sectionService;
    private $sectionRequisitionService;
    private $departmentService;
    private $distributionService;

    public function __construct(
        CurrentStockService $currentStockService,
        EmployeeService $employeeService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService,
        DepartmentService $departmentService,
        DistributionService $distributionService

    ) {
        $this->currentStockService          = $currentStockService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->departmentService            = $departmentService;
        $this->distributionService          = $distributionService;
    }

    // public function mostRequisitionProducts(Request $request)
    // {
    //     $data['title']  = 'সর্বাধিক চাহিদাকৃত পণ্য';
    //     $data['departments']    = $this->departmentService->getAll(1);
    //     $data['sections']       = [];

    //     if ($request->isMethod('post')) {
    //         if ($request->department_id != 0) {
    //             $data['sections'] = $this->sectionService->getSectionsByDepartment($request->department_id);
    //             if ($request->section_id == 0) {
    //                 $sections = $data['sections']->toArray();

    //                 // Extract only the "id" values into a new array
    //                 $sectionIds = array_map(function ($section) {
    //                     return $section['id'];
    //                 }, $sections);
    //             } else {
    //                 $sectionIds = [$request->section_id];
    //             }

    //             if ($sectionIds) {
    //                 $data['mostRequestedProducts'] = $this->sectionRequisitionService->getMostRequestedProducts($sectionIds, $request);
    //             } else {
    //                 $data['mostRequestedProducts'] = [];
    //             }
    //         } else {
    //             $data['mostRequestedProducts'] =$this->sectionRequisitionService->getMostRequestedProducts(null, $request);
    //         }
    //     } else {
    //         $data['mostRequestedProducts'] = $this->sectionRequisitionService->getMostRequestedProducts();
    //     }


    //     return view('admin.partials.requisition-products', $data);
    // }
    public function getProductStatistics(Request $request)
    {
        $data['title']          = 'পন্যের পরিসংখ্যান';
        $data['departments']    = $this->departmentService->getAll(1);
        $data['sections']       = [];

        if ($request->isMethod('post')) {
            // dd($request->all());
            if ($request->department_id != 0) {
                $data['sections'] = $this->sectionService->getSectionsByDepartment($request->department_id);
                if ($request->section_id == 0) {
                    $sections = $data['sections']->toArray();

                    // Extract only the "id" values into a new array
                    $sectionIds = array_map(function ($section) {
                        return $section['id'];
                    }, $sections);
                } else {
                    $sectionIds = [$request->section_id];
                }

                if ($sectionIds) {
                    $data['mostDistributedProducts'] = $this->distributionService->getMostDistributedProducts($sectionIds, $request);
                } else {
                    $data['mostDistributedProducts'] = [];
                }
            } else {
                $data['mostDistributedProducts'] = $this->distributionService->getMostDistributedProducts(null, $request);
            }
        } else {
            $data['mostDistributedProducts'] = $this->distributionService->getMostDistributedProducts();
        }

        return view('admin.partials.product-statistics', $data);
    }
}
