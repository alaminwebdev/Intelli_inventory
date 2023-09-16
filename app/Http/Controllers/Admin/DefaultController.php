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
use App\Services\EmployeeService;

class DefaultController extends Controller
{
    private $productInformationService;
    private $productTypeService;
    private $unitService;
    private $supplierService;
    private $sectionService;
    private $sectionRequisitionService;
    private $employeeService;

    public function __construct(
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService,
        UnitService $unitService,
        SupplierService $supplierService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService,
        EmployeeService $employeeService

    ) {
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
        $this->unitService                  = $unitService;
        $this->supplierService              = $supplierService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->employeeService              = $employeeService;
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
    public function getSectionsRequisitionsByDepartment(Request $request)
    {
        $sections   = $this->sectionService->getSectionsByDepartment($request->department_id)->pluck('id');
        $data       = $this->sectionRequisitionService->getAllBySections($sections, 0);
        return response()->json($data);
    }
    public function getEmployeeById(Request $request)
    {
        $data = $this->employeeService->getByID($request->employee_id);
        return response()->json($data);
    }
}
