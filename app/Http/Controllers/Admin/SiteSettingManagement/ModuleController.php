<?php

namespace App\Http\Controllers\Admin\SiteSettingManagement;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\RoleEnum;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    public function list()
    {
        $data['title'] = 'Module List';
        $data['modules'] = Module::orderBy('sort','asc')->get();
        return view('admin.site-setting-management.module-info.list',$data);
    }

    public function sorting(Request $request){
        $jsonData = json_decode($request->jsondata);
        foreach ($jsonData as $key => $val) {
            if($val->id !=null){
                Module::where('id',$val->id)->update(['sort' => $key+1]);
            }
        }
    }

    public function add()
    {
        $data['title'] = 'Add Module';
        return view('admin.site-setting-management.module-info.add',$data);
    }

    public function duplicateNameCheck(Request $request){
        $exist = Module::where('name',$request->name)->where('id','!=',$request->edit_data)->first();
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
                'name'     => ['required', 'unique:modules']
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
            $params               = $request->all();
            $params['created_by'] = Auth::id();
            $createmodule = Module::create($params);
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Insert','reload_url'=>route('admin.site-setting-management.module-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function edit(Module $editData)
    {
        $data['title'] = 'Edit Module';
        $data['editData'] = $editData;
        return view('admin.site-setting-management.module-info.add',$data);
    }

    public function update(module $editData, Request $request)
    {

        $validator = Validator::make($request->all(), 
            [
                'name'     => ['required', 'unique:modules']
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
            $params               = $request->all();
            $params['updated_by'] = Auth::id();
            $editData->update($params);
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('admin.site-setting-management.module-info.list')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
    
}
