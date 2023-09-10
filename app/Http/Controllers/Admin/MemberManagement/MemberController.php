<?php

namespace App\Http\Controllers\Admin\MemberManagement;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Member;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Image;

class MemberController extends Controller
{
    public function list(Request $request)
    {
        $data['title'] = 'Member List';
        $data['designations'] = Designation::orderBy('sort','asc')->get();
        $where = [];
        if($request->designation_id){
            $where[] = ['designation_id','=',$request->designation_id];
        }
        if($request->name){
            $where[] = ['name','=',$request->name];
        }
        if($request->email){
            $where[] = ['email','=',$request->email];
        }
        if($request->mobile_no){
            $where[] = ['mobile_no','=',$request->mobile_no];
        }
        if($request->status){
            $where[] = ['status','=',$request->status];
        }
        $data['members'] = Member::where($where)->orderBy('sort','asc')->get();
        return view('admin.member-management.member-info.list',$data);
    }

    public function sorting(Request $request){
        $jsonData = json_decode($request->jsondata);

        DB::beginTransaction();
        try {            
            foreach ($jsonData as $key => $data) {
                if($data->id !=null){
                    Member::where('id',$data->id)->update(['sort' => $key+1]);
                }
            }
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Sorting']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function add()
    {
        $data['title'] = 'Add Member';
        $data['designations'] = Designation::orderBy('sort','asc')->get();
        return view('admin.member-management.member-info.add',$data);
    }

    public function duplicateEmailCheck(Request $request)
    {
        $exist = Member::where('id','!=',$request->edit_data)->where('email',$request->email)->first();
        if($exist){
            return response()->json('This Email already exist');
        }else{
            return response()->json(true);
        }
    }

    public function duplicateMobileNoCheck(Request $request)
    {
        $exist = Member::where('id','!=',$request->edit_data)->where('mobile_no',$request->mobile_no)->first();
        if($exist){
            return response()->json('This Mobile No already exist');
        }else{
            return response()->json(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name'     => ['required'],
                'email'     => ['required','email','unique:members,email'],
                'mobile_no'     => ['required','digits:11','unique:members,mobile_no'],
                'designation_id'     => ['required'],
                'status'     => ['required'],
                'image' => ['mimes:jpeg,png,jpg,gif,svg'],
                'password'     => ['required']
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
            $store                 = new Member();
            $store->name           = $request->name;
            $store->email          = $request->email;
            $store->mobile_no      = $request->mobile_no;
            $store->designation_id = $request->designation_id;
            $store->working_place  = $request->working_place;
            $store->status         = $request->status;
            $store->password       = bcrypt($request->password);
            $store->created_by     = auth()->user()->id;

            if($request->hasFile('image')){
                $folder_name = 'profile';
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file_path = $folder_name."_".date('YmdHis').".".$extension;
                $file_dir = "storage/".$folder_name;
                if (!file_exists($file_dir)) {
                    mkdir($file_dir, 0777, true);
                }

                $img = Image::make($file);
                $img->resize(100, 100);
                $img->save($file_dir."/".$file_path);
                $store->image = $file_path;
            }
            $store->save();

            DB::commit();

            return response()->json(['status'=>'success','message'=>'Data Successfully Inserted','reload_url'=>route('admin.member-management.member-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Update Member';
        $data['designations'] = Designation::orderBy('sort','asc')->get();
        $data['editData'] = Member::where('id',$id)->firstOrFail();
        return view('admin.member-management.member-info.add',$data);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), 
            [
                'name'     => ['required'],
                'email'     => ['required','email','unique:members,email,'.$id],
                'mobile_no'     => ['required','digits:11','unique:members,mobile_no,'.$id],
                'designation_id'     => ['required'],
                'status'     => ['required'],
                'image' => ['mimes:jpeg,png,jpg,gif,svg']
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
            $store                 = Member::where('id',$id)->firstOrFail();
            $store->name           = $request->name;
            $store->email          = $request->email;
            $store->mobile_no      = $request->mobile_no;
            $store->designation_id = $request->designation_id;
            $store->working_place  = $request->working_place;
            $store->status         = $request->status;
            if($request->change_password){
                $store->password = bcrypt($request->password);
            }
            $store->updated_by = auth()->user()->id;

            if($request->hasFile('image')){
                $folder_name = 'profile';
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file_path = $folder_name."_".date('YmdHis').".".$extension;
                $file_dir = "storage/".$folder_name;
                if (!file_exists($file_dir)) {
                    mkdir($file_dir, 0777, true);
                }

                $img = Image::make($file);
                $img->resize(100, 100);
                $img->save($file_dir."/".$file_path);
                $store->image = $file_path;
            }
            $store->save();

            DB::commit();

            return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('admin.member-management.member-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function destroy(Request $request){
        $member = Member::where('id','!=',1)->where('id',$request->id)->first();
        if(!$member){
            return response()->json(['status'=>'error','message'=>'Member not found']);
        }
        $member->deleted_by=auth()->user()->id;
        $member->save();
        $deleted = $member->delete();
        if($deleted){
            return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
        }else{
            return response()->json(['status'=>'error','message'=>'Sorry something wrong']);
        }
    }
    
}
