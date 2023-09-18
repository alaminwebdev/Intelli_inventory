<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\ProductTypeService;
use App\Services\DepartmentRequisitionService;
use App\Services\SectionRequisitionService;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;

class DepartmentRequisitionController extends Controller
{
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
    public function index()
    {
        $data['title']                      = 'চাহিদাপত্রের তালিকা - ডিপার্টমেন্ট';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee                           = $this->employeeService->getByID($user->employee_id);
            $data['departmentRequisitions']     = $this->departmentRequisitionService->getAll($employee->department_id);
        } else {
            $data['departmentRequisitions']     = $this->departmentRequisitionService->getAll();
        }
        return view('admin.requisition-management.department-requisition.list', $data);
    }
    public function add()
    {
        $data['title']                  = 'চাহিদাপত্র যুক্ত করুন';
        $data['product_types']          = $this->productTypeService->getAll(1);
        $data['uniqueRequisitionNo']    = $this->departmentRequisitionService->getUniqueRequisitionNo();

        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $data['employee']             = $this->employeeService->getByID($user->employee_id);
            $sectionIds                   = Employee::where('department_id', $data['employee']->department_id)->whereNotNull('section_id')->pluck('section_id');
            $data['section_requisitions'] = $this->sectionRequisitionService->getAllBySections($sectionIds, 0);
        } else {
            $data['employee']               = [];
            $data['section_requisitions']   = [];
        }
        
        $data['departments']            = $this->departmentService->getAll(1);
        return view('admin.requisition-management.department-requisition.add', $data);
    }
    public function store(Request $request)
    {
        $data = $this->departmentRequisitionService->create($request);
        return response()->json($data);
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
