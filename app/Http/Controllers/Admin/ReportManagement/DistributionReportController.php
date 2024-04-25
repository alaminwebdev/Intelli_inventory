<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;


use App\Models\SectionRequisition;
use Illuminate\Http\Request;
use PDF;

use App\Services\SectionService;
use App\Services\DepartmentService;
use App\Services\ProductInformationService;
use Carbon\Carbon;

class DistributionReportController extends Controller
{

    private $sectionService;
    private $departmentService;
    private $productInformationService;

    public function __construct(
        SectionService $sectionService,
        DepartmentService $departmentService,
        ProductInformationService $productInformationService
    ) {
        $this->sectionService               = $sectionService;
        $this->departmentService            = $departmentService;
        $this->productInformationService    = $productInformationService;
    }

    public function productDistributionReport(Request $request)
    {
        $data['title']          = 'Product Distribution report';
        $data['departments']    = $this->departmentService->getAll(1);
        $data['products']       = $this->productInformationService->getAll([1]);
        $data['sections']       = [];
        $data['product_ids']    = [];

        if ($request->isMethod('post')) {

            $request->validate([
                'department_id' => 'required'
            ], [
                'department_id.required' => 'Department Required'
            ]);

            if ($request->department_id == 0) {
                $data['sections']   = $this->sectionService->getAll();
            } else {
                $data['sections']   = $this->sectionService->getSectionsByDepartment($request->department_id);
            }
            $data['department'] = $this->departmentService->getByID($request->department_id);

            if ($request->section_id == 0) {
                $sections = $data['sections']->toArray();

                // Extract only the "id" values into a new array
                $sectionIds = array_map(function ($section) {
                    return $section['id'];
                }, $sections);

                $data['section'] = [];
            } else {
                $sectionIds         = [$request->section_id];
                $data['section']    = $this->sectionService->getByID($request->section_id);
            }

            if ($request->has('product_information_id')) {
                $data['product_ids'] = $request->product_information_id;
            } else {
                $data['product_ids'] = [];
            }


            $data['distributed_products'] = $this->getDistributedProducts($sectionIds, $data['product_ids'], $request->date_from, $request->date_to);

            if ($request->type == 'pdf') {
                $date = Carbon::now();
                $data['date_in_english'] = $date->format('d-F-Y');

                if ($request['date_from'] != null) {
                    $data['date_from']      = date('d-F-Y', strtotime($request['date_from']));
                } else {
                    $data['date_from']      = null;
                }
                if ($request['date_to'] != null) {
                    $data['date_to']    = date('d-F-Y', strtotime($request['date_to']));
                } else {
                    $data['date_to']    = null;
                }

                return $this->productDistributionPdfDownload($data);
            }
        } else {
            // $data['distributed_products'] = [];
        }

        return view('admin.reports.product-distribution', $data);
    }

    public function getDistributedProducts($sectionIds_ids = null, $product_ids = null, $from_date = null, $to_date = null)
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
            ->when($product_ids, function ($q, $product_ids) {
                if (count($product_ids) > 0) {
                    $q->whereIn('distributes.product_id', $product_ids);
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

    private function productDistributionPdfDownload($data)
    {

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.product-distribution-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'Product Distribution report -' . $data['date_in_english'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
