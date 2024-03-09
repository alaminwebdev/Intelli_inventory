<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Image;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $data['title'] = 'User List';
        $data['roles'] = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();

        // $data['designations'] = Designation::orderBy('sort', 'asc')->get();

        $where = [];

        // if ($request->designation_id) {
        //     $where[] = ['designation_id', '=', $request->designation_id];
        // }

        if ($request->name) {
            $where[] = ['name', 'LIKE', '%' . $request->name . '%'];
        }
        if ($request->email) {
            $where[] = ['email', '=', $request->email];
        }
        if ($request->mobile_no) {
            $where[] = ['mobile_no', '=', $request->mobile_no];
        }
        if ($request->status !== null) {
            $where[] = ['status', '=', $request->status];
        }
        // $data['users'] = User::whereHas('user_roles',function($w) use($request){
        //     if($request->role_ids){
        //         $w->whereIn('id',$request->role_ids);
        //     }
        // })->where($where)->where('id','!=',1)->orderBy('sort','asc')->get();

        $usersQuery = User::where($where)->where('id', '!=', 1)->orderBy('sort', 'asc');
        if ($request->role_ids) {
            $usersQuery->whereHas('user_roles', function ($query) use ($request) {
                $query->whereIn('role_id', $request->role_ids);
            });
        }
        $data['users'] = $usersQuery->get();

        // $data['users'] = User::where($where)->where('id', '!=', 1)->orderBy('sort', 'asc')->get();
        return view('admin.user-management.user-info.list', $data);
    }

    public function sorting(Request $request)
    {
        $jsonData = json_decode($request->jsondata);

        DB::beginTransaction();
        try {
            foreach ($jsonData as $key => $data) {
                if ($data->id != null) {
                    User::where('id', $data->id)->update(['sort' => $key + 1]);
                }
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Data Successfully Sorting']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function add()
    {
        $data['title'] = 'Add User';
        $data['roles'] = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();
        $data['designations'] = Designation::orderBy('sort', 'asc')->get();
        $data['employees'] = Employee::orderBy('sort', 'asc')->get();
        return view('admin.user-management.user-info.add', $data);
    }

    public function duplicateEmailCheck(Request $request)
    {
        $exist = User::where('id', '!=', $request->edit_data)
            ->where('email', $request->email)
            ->whereNull('deleted_at')
            ->first();
        if ($exist) {
            return response()->json('This Email already exist');
        } else {
            return response()->json(true);
        }
    }

    public function duplicateMobileNoCheck(Request $request)
    {
        $exist = User::where('id', '!=', $request->edit_data)
            ->where('mobile_no', $request->mobile_no)
            ->whereNull('deleted_at')
            ->first();
        if ($exist) {
            return response()->json('This Mobile No already exist');
        } else {
            return response()->json(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => ['required'],
                'email'     => ['required', 'email', 'unique:users,email'],
                'mobile_no'     => ['required', 'digits:11', 'unique:users,mobile_no'],
                // 'designation_id'     => ['required'],
                'role_ids'     => ['required'],
                'status'     => ['required'],
                'image' => ['mimes:jpeg,png,jpg,gif,svg'],
                'password'     => ['required']
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(
                    array(
                        'status' => 'validation',
                        'errors' => $validator->getMessageBag()->toArray()

                    )
                );
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $store                 = new User();
            $store->name           = $request->name;
            $store->email          = $request->email;
            $store->mobile_no      = $request->mobile_no;
            // $store->designation_id = $request->designation_id;
            // $store->working_place  = $request->working_place;
            $store->status         = $request->status;
            $store->password       = bcrypt($request->password);
            $store->created_by     = auth()->user()->id;

            if ($request->filled('employee_id')) {
                $store->employee_id  = $request->employee_id;
            }

            if ($request->hasFile('image')) {
                $folder_name = 'profile';
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file_path = $folder_name . "_" . date('YmdHis') . "." . $extension;
                $file_dir = "storage/" . $folder_name;
                if (!file_exists($file_dir)) {
                    mkdir($file_dir, 0777, true);
                }

                $img = Image::make($file);
                $img->resize(100, 100);
                $img->save($file_dir . "/" . $file_path);
                $store->image = $file_path;
            }
            if ($store->save()) {
                UserRole::where('user_id', $store->id)->whereNotIn('role_id', $request->role_ids)->update(['deleted_by' => auth()->user()->id]);
                UserRole::where('user_id', $store->id)->whereNotIn('role_id', $request->role_ids)->delete();
                if ($request->role_ids) {
                    foreach ($request->role_ids as $role_id) {
                        $user_role_exist = UserRole::where('user_id', $store->id)->where('role_id', $role_id)->first();
                        if ($user_role_exist) {
                            $user_role_store = $user_role_exist;
                        } else {
                            $user_role_store = new UserRole();
                        }
                        $user_role_store->user_id = $store->id;
                        $user_role_store->role_id = $role_id;
                        if ($user_role_exist) {
                            $user_role_store->updated_by = auth()->user()->id;
                        } else {
                            $user_role_store->created_by = auth()->user()->id;
                        }
                        $user_role_store->save();
                    }
                }
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data Successfully Inserted', 'reload_url' => route('admin.user-management.user-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Update User';
        $data['roles'] = Role::where('id', '!=', 1)->orderBy('sort', 'asc')->get();
        $data['designations'] = Designation::orderBy('sort', 'asc')->get();
        $data['editData'] = User::where('id', '!=', 1)->where('id', $id)->firstOrFail();
        $data['employees'] = Employee::orderBy('sort', 'asc')->get();
        return view('admin.user-management.user-info.add', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => ['required'],
                'email'     => ['required', 'email', 'unique:users,email,' . $id],
                'mobile_no'     => ['required', 'digits:11', 'unique:users,mobile_no,' . $id],
                // 'designation_id'     => ['required'],
                'role_ids'     => ['required'],
                'status'     => ['required'],
                'image' => ['mimes:jpeg,png,jpg,gif,svg']
            ]
        );

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(
                    array(
                        'status' => 'validation',
                        'errors' => $validator->getMessageBag()->toArray()

                    )
                );
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $store                 = User::where('id', '!=', 1)->where('id', $id)->firstOrFail();
            $store->name           = $request->name;
            $store->email          = $request->email;
            $store->mobile_no      = $request->mobile_no;
            // $store->designation_id = $request->designation_id;
            // $store->working_place  = $request->working_place;
            $store->status         = $request->status;
            if ($request->change_password) {
                $store->password = bcrypt($request->password);
            }
            $store->updated_by = auth()->user()->id;

            if ($request->hasFile('image')) {
                $folder_name = 'profile';
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file_path = $folder_name . "_" . date('YmdHis') . "." . $extension;
                $file_dir = "storage/" . $folder_name;
                if (!file_exists($file_dir)) {
                    mkdir($file_dir, 0777, true);
                }

                $img = Image::make($file);
                $img->resize(100, 100);
                $img->save($file_dir . "/" . $file_path);
                $store->image = $file_path;
            }
            if ($store->save()) {
                UserRole::where('user_id', $store->id)->whereNotIn('role_id', $request->role_ids)->update(['deleted_by' => auth()->user()->id]);
                UserRole::where('user_id', $store->id)->whereNotIn('role_id', $request->role_ids)->delete();
                if ($request->role_ids) {
                    foreach ($request->role_ids as $role_id) {
                        $user_role_exist = UserRole::where('user_id', $store->id)->where('role_id', $role_id)->first();
                        if ($user_role_exist) {
                            $user_role_store = $user_role_exist;
                        } else {
                            $user_role_store = new UserRole();
                        }
                        $user_role_store->user_id = $store->id;
                        $user_role_store->role_id = $role_id;
                        if ($user_role_exist) {
                            $user_role_store->updated_by = auth()->user()->id;
                        } else {
                            $user_role_store->created_by = auth()->user()->id;
                        }
                        $user_role_store->save();
                    }
                }
            }

            // Check if the user has an associated employee
            if ($store->employee_id) {
                $employee = Employee::findOrFail($store->employee_id);
                $employee->name         = $request->name;
                $employee->email        = $request->email;
                $employee->mobile_no    = $request->mobile_no;
                $employee->status       = $request->status;
                $employee->save();
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data Successfully Updated', 'reload_url' => route('admin.user-management.user-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', '!=', 1)->where('id', $request->id)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }
        $user->deleted_by = auth()->user()->id;
        $user->status = 0;
        $user->save();
        // $deleted = $user->delete();
        if ($user->save()) {
            return response()->json(['status' => 'success', 'message' => 'Successfully deactivated the user']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        }
    }
}
