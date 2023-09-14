<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductTypeService;
use App\Services\DepartmentRequisitionService;

class DepartmentRequisitionController extends Controller
{
    private $productTypeService;
    private $departmentRequisitionService;

    public function __construct(
        DepartmentRequisitionService $departmentRequisitionService,
        ProductTypeService $productTypeService
    ) {
        $this->productTypeService           = $productTypeService;
        $this->departmentRequisitionService = $departmentRequisitionService;
    }
    public function index()
    {
        $data['title']                  = 'Department Requisition List';
        $data['sectionRequisitions']    = $this->departmentRequisitionService->getAll();
        return view('admin.requisition-management.department-requisition.list', $data);
    }
    public function add()
    {
        $data['title']                  = 'Add Department Requisition';
        $data['product_types']          = $this->productTypeService->getAll(1);
        $data['uniqueRequisitionNo']    = $this->departmentRequisitionService->getUniqueRequisitionNo();
        return view('admin.requisition-management.department-requisition.add', $data);
    }
    public function store(Request $request)
    {
        $this->departmentRequisitionService->create($request);
        return redirect()->route('admin.department.requisition.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        // $data['title']          = 'Edit Department Requisition';
        // $data['editData']       = $this->sectionRequisitionService->getByID($id);
        // return view('admin.requisition-management.section-requisition.add', $data);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        // ]);
        // $this->sectionRequisitionService->update($request, $id);
        // return redirect()->route('admin.section.requisition.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        // $deleted = $this->sectionRequisitionService->delete($request->id);
        // if ($deleted) {
        //     return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        // }
    }
}
