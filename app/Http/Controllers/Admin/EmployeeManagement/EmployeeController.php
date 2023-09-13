<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DesignationService;
use App\Services\DepartmentService;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    private $designationService;
    private $departmentService;
    private $employeeService;

    public function __construct(
        DesignationService $designationService,
        DepartmentService $departmentService,
        EmployeeService $employeeService
    ) {
        $this->designationService   = $designationService;
        $this->departmentService    = $departmentService;
        $this->employeeService      = $employeeService;
    }
    public function index()
    {
        $data['title']      = 'Employee List';
        $data['employees']  = $this->employeeService->getAll();
        return view('admin.employee-management.employee.list', $data);
    }
    public function add()
    {
        $data['title']          = 'Add Employee';
        $data['designations']   = $this->designationService->getAll(1);
        $data['departments']    = $this->departmentService->getAll(1);
        return view('admin.employee-management.employee.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->employeeService->create($request);
        return redirect()->route('admin.employee.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Department';
        $data['editData'] = $this->employeeService->getByID($id);
        return view('admin.employee-management.employee.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
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
