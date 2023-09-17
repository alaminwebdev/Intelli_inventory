<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Services\DepartmentRequisitionService;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use App\Services\ProductTypeService;
use App\Services\SectionRequisitionService;
use Illuminate\Http\Request;

class DistributionController extends Controller {
    private $productTypeService;
    private $sectionRequisitionService;
    private $departmentRequisitionService;
    private $departmentService;
    private $employeeService;

    public function __construct(
        DepartmentRequisitionService $departmentRequisitionService,
        ProductTypeService $productTypeService,
        SectionRequisitionService $sectionRequisitionService,
        DepartmentService $departmentService,
        EmployeeService $employeeService
    ) {
        $this->productTypeService           = $productTypeService;
        $this->departmentRequisitionService = $departmentRequisitionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->departmentService            = $departmentService;
        $this->employeeService              = $employeeService;
    }
    public function index() {
        $data['title']                  = 'প্রোডাক্ট বিতরনের তালিকা';
        $data['departmentRequisitions'] = $this->departmentRequisitionService->getAll();
        return view('admin.requisition-management.distribution.list', $data);
    }
    public function add() {
        // $data['title']                  = '';
        // $data['product_types']          = $this->productTypeService->getAll(1);
        // $data['departments']            = $this->departmentService->getAll(1);
        // return view('admin.requisition-management.distribution.add', $data);
    }
    public function store(Request $request) {
        // $this->departmentRequisitionService->create($request);
        // return redirect()->route('admin.distribution.list')->with('success', 'Data successfully inserted!');
    }

    public function edit($id) {
        $data['title']         = 'প্রোডাক্ট বিতরন করুন';
        $data['editData']      = $this->departmentRequisitionService->getByID($id);
        $data['product_types'] = $this->productTypeService->getAll(1);
        $data['departments']   = $this->departmentService->getAll(1);
        return view('admin.requisition-management.distribution.add', $data);
    }

    public function update(Request $request, $id) {
        dd($request->all());
        // $request->validate([
        //     'name' => 'required',
        // ]);
        // $this->sectionRequisitionService->update($request, $id);
        // return redirect()->route('admin.section.requisition.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        // $deleted = $this->sectionRequisitionService->delete($request->id);
        // if ($deleted) {
        //     return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        // }
    }
}
