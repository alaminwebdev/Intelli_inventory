<?php

namespace App\Http\Controllers\Admin\DemoServiceManagement\DemoController;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\DemoService\DemoService;
use App\Services\RoleService\RoleService;
use Illuminate\Http\Request;

class DemoController extends Controller {
    private $DemoService;
    private $roleService;

    public function __construct(DemoService $DemoService, RoleService $roleService) {
        $this->DemoService = $DemoService;
        $this->roleService = $roleService;
    }

    public function getUserRole(Request $request) {
        $this->DemoService->getUserRole($request);
    }

    public function index() {
        $data['user'] = $this->DemoService->getAll();
        $data['role'] = $this->roleService->getAll();
        // dd($data['user']);
        return view('backend.user_management.user.view-user', $data);
    }

    public function userAdd() {
        $data['roles'] = Role::all();
        return view('backend.user_management.user.add-user', $data);
    }

    public function userStore(Request $request) {
        // dd($request->all());
        $this->validate($request, [
            'email'  => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
        ]);
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'min:8',              // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        $this->DemoService->create($request);

        return redirect()->route('user')->with('success', 'Data Saved successfully');
    }

    public function userEdit($id) {
        $data['editData'] = $this->DemoService->getByID($id);
        // dd($data['editData']->toArray());
        $data['roles'] = Role::where('status', '1')->get();
        return view('backend.user_management.user.add-user', $data);
    }

    public function updateUser(Request $request, $id) {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
        ]);
        $this->DemoService->update($request, $id);
        return redirect()->route('user')->with('success', 'Data Updated successfully');
    }

    public function deleteUser(Request $request) {
        $this->DemoService->delete($request->id);
        return redirect()->route('user')->with('success', 'Data Deleted successfully');
    }

    public function userStatus(Request $request) {
        $this->DemoService->userStatus($request);
        return response()->json(['success' => 'Status Updated Successfully.']);
    }
}
