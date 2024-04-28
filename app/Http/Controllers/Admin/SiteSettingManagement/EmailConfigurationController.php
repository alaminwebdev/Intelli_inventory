<?php

namespace App\Http\Controllers\Admin\SiteSettingManagement;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\RoleEnum;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailConfigurationController extends Controller
{
    public function list()
    {
        $data['title'] = "Update Email Configuration";
        $data['editData'] = SiteSetting::first();
        return view('admin.site-setting-management.email-configuration-info.list',$data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $store = SiteSetting::first();
            if(!$store){
                $store = new SiteSetting();
            }
            $store->email_configuration = json_encode($request->email_configuration);
            $store->save();
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('admin.site-setting-management.email-configuration-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
    
}
