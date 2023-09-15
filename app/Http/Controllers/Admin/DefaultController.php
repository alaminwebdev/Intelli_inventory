<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use App\Services\UnitService;
use App\Services\SupplierService;
use App\Services\SectionService;
use App\Services\SectionRequisitionService;

class DefaultController extends Controller
{
    private $productInformationService;
    private $productTypeService;
    private $unitService;
    private $supplierService;
    private $sectionService;
    private $sectionRequisitionService;

    public function __construct(
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService,
        UnitService $unitService,
        SupplierService $supplierService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService

    ) {
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
        $this->unitService                  = $unitService;
        $this->supplierService              = $supplierService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
    }

    public function getProductsByType(Request $request)
    {
        $data = $this->productInformationService->getProductsByTypeId($request->product_type_id);
        return response()->json($data);
    }
    public function getSectionsByDepartment(Request $request)
    {
        $data = $this->sectionService->getSectionsByDepartment($request->department_id);
        return response()->json($data);
    }
    public function getProductsBySectionRequisition(Request $request)
    {
        $data = $this->sectionRequisitionService->getRequisitionProductsByIDs($request->selectedRequisitionIds);
        return response()->json($data);
    }
}
