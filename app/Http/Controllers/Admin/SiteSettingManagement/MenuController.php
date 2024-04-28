<?php

namespace App\Http\Controllers\Admin\SiteSettingManagement;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Menu;
use App\Models\MenuRoute;
use App\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
	public function list()
	{
        $data['title'] = 'Menu List';
		return view('admin.site-setting-management.menu-info.list',$data);
	}

	public function add()
	{
        $data['title'] = 'Add Menu';
		$data['menus'] =Menu::orderBy('sort','asc')->get();
		$data['modules'] =Module::orderBy('sort','asc')->get();
		return view('admin.site-setting-management.menu-info.add',$data);
	}


	public function store(Request $request)
	{
        $validator = Validator::make($request->all(), 
            [
			'name' => ['required'],
			'module_id' => ['required'],
			'url_path' => ['required'],
			'status' => ['required'],
			'sort' => ['required']
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
			$menuData = new Menu;
			$menuData->name   = $request->name;
			$menuData->module_id   = $request->module_id;

			if($request->sub_menu_4 != ''){
				$parent = $request->sub_menu_4;
			}else if($request->sub_menu_3 != ''){
				$parent = $request->sub_menu_3;
			}else if($request->sub_menu_2 != ''){
				$parent = $request->sub_menu_2;
			}else if($request->sub_menu_1 != ''){
				$parent = $request->sub_menu_1;
			}else if($request->main_menu != ''){
				$parent = $request->main_menu;
			}else{
				$parent = 0;
			}

			$menuData->parent = $parent;
			$menuData->url_path  = $request->url_path;
			$menuData->sort   = $request->sort;
			$menuData->status = $request->status;
			$menuData->icon   = $request->icon;

			if($menuData->save()){
				if($request->extra_name != null){
					foreach ($request->extra_name as $key => $value) {
						$section_or_route_exist = MenuRoute::where('route',@$request->extra_route[$key])->first();
						if($section_or_route_exist){
							return response()->json(['status'=>'error','message'=>'" '.@$request->extra_route[$key].' " Already Exist']);
						}
						$exist = MenuRoute::find($key);
						if($exist != null){
							$menuroute = $exist;
						}else{
							$menuroute = new MenuRoute;
						}

						$menuroute->menu_id = $menuData->id;
						$menuroute->section_or_route = $request->extra_section_or_route[$key];
						$menuroute->name = $request->extra_name[$key];
						$menuroute->sort = $request->extra_sort[$key];
						$menuroute->route = $request->extra_route[$key];
						$menuroute->status = '1';
						$menuroute->save();
					}
				}
			}
			DB::commit();
			return response()->json(['status'=>'success','message'=>'Data Successfully Insert','reload_url'=>route('admin.site-setting-management.menu-info.list')]);
		} catch (\Exception $e) {
			DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
		}
	}

	public function edit(Request $request,$id)
	{
        $data['title'] = 'Edit Menu';
		$data['editData'] = Menu::find($id);

		$menu_parent = [];
		$x = $data['editData']['parent'];
		while($x > 0) {
			$menu_parent[] = $x;
			$menu = Menu::find($x);
			$x = $menu['parent'];
		} 
		$data['modules'] =Module::orderBy('sort','asc')->get();
		$data['menu_parent']=array_reverse($menu_parent);
		$data['menuRoutes'] = MenuRoute::where('menu_id',$id)->orderBy('sort','asc')->get();
		return view('admin.site-setting-management.menu-info.add',$data);
	}

	public function update(Request $request,$id)
	{

        $validator = Validator::make($request->all(), 
            [
			'name' => ['required'],
			'module_id' => ['required'],
			'url_path' => ['required'],
			'status' => ['required'],
			'sort' => ['required']
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
			$menuData = Menu::find($id);
			$menuData->name   = $request->name;
			$menuData->module_id   = $request->module_id;

			if($request->sub_menu_4 != ''){
				$parent = $request->sub_menu_4;
			}else if($request->sub_menu_3 != ''){
				$parent = $request->sub_menu_3;
			}else if($request->sub_menu_2 != ''){
				$parent = $request->sub_menu_2;
			}else if($request->sub_menu_1 != ''){
				$parent = $request->sub_menu_1;
			}else if($request->main_menu != ''){
				$parent = $request->main_menu;
			}else{
				$parent = 0;
			}

			$menuData->parent = $parent;
			$menuData->url_path    = $request->url_path;
			$menuData->sort   = $request->sort;
			$menuData->status = $request->status;
			$menuData->icon   = $request->icon;
			$menuData->created_by   = auth()->user()->id;

			if($menuData->save()){
				if($request->extra_name){
				MenuRoute::where('menu_id',$menuData->id)->whereNotIn('id',array_keys($request->extra_name))->delete();
				}else{
				MenuRoute::where('menu_id',$menuData->id)->delete();
				}
				if($request->extra_name != null){
					foreach ($request->extra_name as $key => $value) {
						$section_or_route_exist = MenuRoute::where('route',@$request->extra_route[$key])->where('id','!=',$key)->first();
						if($section_or_route_exist){
							return response()->json(['status'=>'error','message'=>'" '.@$request->extra_route[$key].' " Already Exist']);
						}
						$exist = MenuRoute::find($key);
						if($exist != null){
							$menuroute = $exist;
						}else{
							$menuroute = new MenuRoute;
						}

						$menuroute->menu_id = $menuData->id;
						$menuroute->section_or_route = $request->extra_section_or_route[$key];
						$menuroute->name = $request->extra_name[$key];
						$menuroute->sort = $request->extra_sort[$key];
						$menuroute->route = $request->extra_route[$key];
						$menuroute->status = '1';
						$menuroute->created_by   = auth()->user()->id;
						$menuroute->save();
					}

				}
			}

			DB::commit();
			return response()->json(['status'=>'success','message'=>'Data Successfully Updated','reload_url'=>route('admin.site-setting-management.menu-info.list')]);
		} catch (\Exception $e) {
			DB::rollback();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
		}
	}

	public function getSubMenu(Request $request){
		$parent = $request->parent;
		return $this->getPrivateSubMenu($wheredata=['parent'=>$parent],$selected_sub_menu_id = null);
	}


	private function getPrivateSubMenu($wheredata = ['parent' => null], $selected_sub_menu_id = null)
	{
		$sub_menus = Menu::where('parent', $wheredata['parent'])->orderBy('sort', 'asc')->get();
		$html      = '<option value="">' . __('Select Sub Menu') . '</option>';
		foreach ($sub_menus as $key => $sub_menu) {
			if ($selected_sub_menu_id == $sub_menu->id) {
				$select = 'selected';
			} else {
				$select = '';
			}
			$html .= '<option value="' . $sub_menu['id'] . '" ' . @$select . '>' . $sub_menu['name'] . ' ( ' . $sub_menu['module']['name'] . ' ) ' . '</option>';
		}
		return $html;
	}

}
