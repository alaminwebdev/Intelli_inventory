<?php

namespace App\Http\Controllers\Admin\SiteSettingManagement;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Image;

class SiteSettingController extends Controller
{
    public function list()
    {
        $data['title'] = "Update Site Settings";
        $data['editData'] = SiteSetting::first();
        return view('admin.site-setting-management.site-setting-info.list',$data);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), 
            [
            'logo' => ['mimes:jpeg,png,jpg,gif,svg'],
            'favicon' => ['mimes:jpeg,png,jpg,gif,svg']
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
            $store = SiteSetting::first();
            if(!$store){
                $store = new SiteSetting();
            }
            $store->name = $request->name;
            $store->version = $request->version;
            $store->copy_right_year = $request->copy_right_year;
            $store->copy_right_org_link = $request->copy_right_org_link;

            if($request->hasFile('logo')){
                $folder_name = 'logo';
                $file = $request->file('logo');
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
                $store->logo = $file_path;
            }

            if($request->hasFile('favicon')){
                $folder_name = 'favicon';
                $file = $request->file('favicon');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $file_path = $folder_name."_".date('YmdHis').".".$extension;
                $file_dir = "storage/".$folder_name;
                if (!file_exists($file_dir)) {
                    mkdir($file_dir, 0777, true);
                }

                $img = Image::make($file);
                $img->resize(64, 64);
                $img->save($file_dir."/".$file_path);
                $store->favicon = $file_path;
            }


            $store->title_suffix = $request->title_suffix;
            $store->save();
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('admin.site-setting-management.site-setting-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
    
}
