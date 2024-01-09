<?php

namespace App\Http\Controllers\Admin\RoleManagement;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\OtpRole;
use App\Models\Role;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function list()
    {
        $data['title'] = 'Role List';
        $data['roles'] = Role::where('id','!=',1)->orderBy('sort','asc')->get();
        return view('admin.role-management.role-info.list',$data);
    }

    public function sorting(Request $request){
        $jsonData = json_decode($request->jsondata);

        DB::beginTransaction();
        try {            
            foreach ($jsonData as $key => $data) {
                if($data->id !=null){
                    Role::where('id',$data->id)->update(['sort' => $key+1]);
                }
            }
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Insert']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function add()
    {
        $data['title'] = 'Add Role';
        $data['otps'] = Otp::where('status',1)->get();
        return view('admin.role-management.role-info.add',$data);
    }

    public function duplicateNameCheck(Request $request){
        $exist = Role::where('id','!=',$request->edit_data)->where('name',$request->name)->first();
        if($exist){
            return response()->json('This name already exist');
        }else{
            return response()->json(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name'     => ['required', 'unique:roles']
            ]
        );

        if ($validator->fails()) {
            if($request->ajax()){
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
            $store = new Role();
            $store->name = $request->name;
            $store->description = $request->description;
            $store->status = $request->status;
            $store->is_super_power = (($request->is_super_power)?('1'):'0');
            $store->created_by = auth()->user()->id;
            if($store->save()){
                OtpRole::where('role_id',$store->id)->delete();
                if($request->otp_ids){
                    foreach($request->otp_ids as $otp_id){
                        $otp_rolestore = new OtpRole();
                        $otp_rolestore->role_id = $store->id;
                        $otp_rolestore->otp_id = $otp_id;
                        $otp_rolestore->save();
                    }
                }
            }
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Insert','reload_url'=>route('admin.role-management.role-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function edit(Role $editData)
    {
        $data['title'] = 'Update Role';
        $data['editData'] = $editData;
        $data['otps'] = Otp::where('status',1)->get();
        return view('admin.role-management.role-info.add',$data);
    }

    public function update(Role $editData, Request $request)
    {

        $validator = Validator::make($request->all(), 
            [
                'name'     => ['required', 'unique:roles,name,'.$editData->id]
            ]
        );

        if ($validator->fails()) {
            if($request->ajax()){
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
            $update = Role::find($editData->id);
            $update->name = $request->name;
            $update->description = $request->description;
            $update->status = $request->status;
            $update->is_super_power = (($request->is_super_power)?('1'):'0');
            $update->updated_by = auth()->user()->id;
            if($update->save()){
                OtpRole::where('role_id',$update->id)->delete();
                if($request->otp_ids){
                    foreach($request->otp_ids as $otp_id){
                        $otp_rolestore = new OtpRole();
                        $otp_rolestore->role_id = $update->id;
                        $otp_rolestore->otp_id = $otp_id;
                        $otp_rolestore->save();
                    }
                }
            }
            DB::commit();

            return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('admin.role-management.role-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function destroy(Request $request){
        $role = Role::find($request->id);
        if(!$role){
            return response()->json(['status'=>'error','message'=>'Role not found']);
        }
        $role->deleted_by=auth()->user()->id;
        $role->save();
        $deleted = $role->delete();
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
    
}
