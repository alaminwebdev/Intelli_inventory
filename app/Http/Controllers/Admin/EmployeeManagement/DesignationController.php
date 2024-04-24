<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DesignationService;

class DesignationController extends Controller
{
    private $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService  = $designationService;
    }
    public function index(){
        $data['title'] = 'Designation List';
        $data['designations'] = $this->designationService->getAll();
        return view('admin.employee-management.designation.list', $data);
    }
    public function add()
    {
        $data['title'] = 'Add Designation';
        return view('admin.employee-management.designation.add', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->designationService->create($request);
        return redirect()->route('admin.employee.designation.list')->with('success', 'Data successfully inserted!');
    }
    public function edit($id)
    {
        $data['title'] = 'Update Designation';
        $data['editData'] = $this->designationService->getByID($id);
        return view('admin.employee-management.designation.add', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->designationService->update($request, $id);
        return redirect()->route('admin.employee.designation.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request) {
        $deleted = $this->designationService->delete($request->id);
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
}
