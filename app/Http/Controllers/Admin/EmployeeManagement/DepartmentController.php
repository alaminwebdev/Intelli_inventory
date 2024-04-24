<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    private $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService  = $departmentService;
    }
    public function index(){
        $data['title']          = 'Department List';
        $data['departments']    = $this->departmentService->getAll();
        return view('admin.employee-management.department.list', $data);
    }
    public function add()
    {
        $data['title'] = 'Add Department';
        return view('admin.employee-management.department.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->departmentService->create($request);
        return redirect()->route('admin.department.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Update Department';
        $data['editData'] = $this->departmentService->getByID($id);
        return view('admin.employee-management.department.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->departmentService->update($request, $id);
        return redirect()->route('admin.department.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        $deleted = $this->departmentService->delete($request->id);
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
}
