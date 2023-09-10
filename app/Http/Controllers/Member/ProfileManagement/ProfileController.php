<?php

namespace App\Http\Controllers\Member\ProfileManagement;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Member;
use App\Models\Role;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Image;

class ProfileController extends Controller
{
    public function profile()
    {
        $data['title'] = 'Profile';
        $data['profile'] = auth()->user()->where('id',auth()->user()->id)->firstOrFail();
        return view('member.profile-management.profile-info.profile',$data);
    }

    public function edit()
    {
        $data['title'] = 'Update Profile';
        $data['designations'] = Designation::orderBy('sort','asc')->get();
        $data['editData'] = auth()->user()->where('id',auth()->user()->id)->firstOrFail();
        return view('member.profile-management.profile-info.edit',$data);
    }

    public function duplicateEmailCheck(Request $request)
    {
        $exist = Member::where('id','!=',auth()->user()->id)->where('email',$request->email)->first();
        if($exist){
            return response()->json('This Email already exist');
        }else{
            return response()->json(true);
        }
    }

    public function duplicateMobileNoCheck(Request $request)
    {
        $exist = Member::where('id','!=',auth()->user()->id)->where('mobile_no',$request->mobile_no)->first();
        if($exist){
            return response()->json('This Mobile No already exist');
        }else{
            return response()->json(true);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name'     => ['required'],
                'email'     => ['required','email','unique:users,email,'.auth()->user()->id],
                'mobile_no'     => ['required','digits:11','unique:users,mobile_no,'.auth()->user()->id],
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
            $update                 = auth()->user();
            $update->name           = $request->name;
            $update->email          = $request->email;
            $update->mobile_no      = $request->mobile_no;
            $update->designation_id = $request->designation_id;
            $update->working_place  = $request->working_place;

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
                $update->image = $file_path;
            }
            $update->save();
            DB::commit();

            return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('member.profile-management.profile-info.profile')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
    
}
