<?php

namespace App\Http\Controllers\Backend\UserManagement\Designation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Designation;
use App\Services\DesignationService\DesignationService;

class DesignationController extends Controller
{
    private $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }

    public function index(){
    	$data['designations'] = $this->designationService->getAll();
    	return view('backend.user_management.designation.view-designation',$data);
    }

    public function add()
    {
    	return view('backend.user_management.designation.add-designation');
    }

    public function store(Request $request)
    {
        $request->validate([

        ]);

        $this->designationService->create($request);
        
    	return redirect()->route('user.designation')->with('success','Data Saved successfully');
    }

    public function edit($id)
    {
        $data['editData'] = $this->designationService->getByID($id);
        return view('backend.user_management.designation.add-designation',$data);
    }

    public function update(Request $request,$id)
    {
        $request->validate([

        ]);
        $this->designationService->update($request,$id);

        return redirect()->route('user.designation')->with('success','Data Updated successfully');
    }

    public function delete(Request $request)
    {
        $this->designationService->delete($request->id);
        return redirect()->route('user.designation')->with('success','Data Deleted successfully');
    }
}
