<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DesignationService;
use App\Services\DepartmentService;
use App\Services\SectionService;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    private $designationService;
    private $departmentService;
    private $employeeService;
    private $sectionService;

    public function __construct(
        DesignationService $designationService,
        DepartmentService $departmentService,
        EmployeeService $employeeService,
        SectionService $sectionService
    ) {
        $this->designationService   = $designationService;
        $this->departmentService    = $departmentService;
        $this->employeeService      = $employeeService;
        $this->sectionService       = $sectionService;
    }
    public function index()
    {
        $data['title']      = 'অফিসার্স তালিকা';
        $data['employees']  = $this->employeeService->getAll();
        return view('admin.employee-management.employee.list', $data);
    }
    public function add()
    {
        $data['title']          = 'অফিসার যুক্ত করুন';
        $data['designations']   = $this->designationService->getAll(1);
        $data['departments']    = $this->departmentService->getAll(1);
        $data['sections']       = [];
        return view('admin.employee-management.employee.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'bp_no'             => 'required',
            'name'              => 'required',
            'email'             => 'required',
            'designation_id'    => 'required',
            'department_id'     => 'required',
            'mobile_no'         => 'required|unique:employees,mobile_no',
            // 'section_id'        => 'required',
        ]);
        $this->employeeService->create($request);
        return redirect()->route('admin.employee.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title']          = 'অফিসার্স তথ্য হালনাগাদ করুন';
        $data['editData']       = $this->employeeService->getByID($id);
        $data['designations']   = $this->designationService->getAll(1);
        $data['departments']    = $this->departmentService->getAll(1);
        $data['sections']       = $this->sectionService->getSectionsByDepartment($data['editData']['department_id']);
        return view('admin.employee-management.employee.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bp_no'             => 'required',
            'name'              => 'required',
            'email'             => 'required',
            'designation_id'    => 'required',
            'department_id'     => 'required',
            // 'section_id'        => 'required',
        ]);
        $this->employeeService->update($request, $id);
        return redirect()->route('admin.employee.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        $deleted = $this->employeeService->delete($request->id);
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        }
    }
}
