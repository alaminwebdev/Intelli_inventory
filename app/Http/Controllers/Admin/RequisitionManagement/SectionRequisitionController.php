<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

use App\Services\ProductTypeService;
use App\Services\SectionRequisitionService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;

class SectionRequisitionController extends Controller
{
    private $sectionRequisitionService;
    private $productTypeService;
    private $employeeService;

    public function __construct(
        SectionRequisitionService $sectionRequisitionService,
        ProductTypeService $productTypeService,
        EmployeeService $employeeService
    ) {
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->productTypeService           = $productTypeService;
        $this->employeeService              = $employeeService;
    }
    public function index()
    {
        $data['title']                  = 'Section Requisition List';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee                       = $this->employeeService->getByID($user->employee_id);
            $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll($employee->section_id);
        }else{
            $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        }
        return view('admin.requisition-management.section-requisition.list', $data);
    }
    public function add()
    {
        $data['title']                  = 'Add Section Requisition';
        $data['product_types']          = $this->productTypeService->getAll(1);
        $data['uniqueRequisitionNo']    = $this->sectionRequisitionService->getUniqueRequisitionNo();
        return view('admin.requisition-management.section-requisition.add', $data);
    }
    public function store(Request $request)
    {
        $this->sectionRequisitionService->create($request);
        return redirect()->route('admin.section.requisition.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        // $data['title']          = 'Edit Section Requisition';
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
