<?php

namespace App\Http\Controllers\Backend\UserManagement\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\RoleService\RoleService;


class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAll();
    	return view('backend.user_management.role.view-user-role')->with('roles', $roles);
    }

    public function storeRole(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'required|unique:roles,name'
        ],[
            'name.required' => 'The Role Name field is required',
            'unique'    => 'This Role is already used'
        ]);

        $this->roleService->create($request);

        return redirect()->back();
    }

    public function getRole(Request $request)
    {
        $roleId = $request->input('id');
        $roleData = $this->roleService->getByID($roleId);
        return response()->json($roleData);
    }

    public function updateRole(Request $request, $id)
    {
        
        $this->validate($request, [
            'name_update' => 'required|unique:roles,name,'
        ],[
            'name_update.required' => 'The Role Name field is required',
            'unique'    => 'This Role is already used'
        ]);

        $this->roleService->update($request,$id);

        return redirect()->back();
    }

    public function deleteRole(Request $request)
    {
        $this->roleService->delete($request->id);
        return redirect()->back();
    }
}
