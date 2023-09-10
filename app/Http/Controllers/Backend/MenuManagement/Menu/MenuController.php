<?php

namespace App\Http\Controllers\Backend\MenuManagement\Menu;

use App\Http\Controllers\Controller;
use App\Models\Icon;
use App\Models\Menu;
use App\Models\MenuRoute;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function index()
    {
       $icon=Icon::all();  
       $menus =Menu::orderBy('sort','desc')->get();
       $parentMenu = Menu::where('parent', 0)->get();
       return view('backend.menu.view-menu',compact('menus','parentMenu','icon'));
    }

    public function add()
    {
       $icon=Icon::all();  
       $menus =Menu::orderBy('sort','desc')->get();
       $parentMenu = Menu::where('parent', 0)->get();
       return view('backend.menu.add-menu',compact('menus','parentMenu','icon'));
    }

   
    public function store(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'parent' => 'required',
        'url' => 'required',
        'status' => 'required',
        'sort' =>'required'
      ]);    

      $menuData = new Menu;
      $menuData->name   = $request->name;
      if($request->parentchield !='0'){
        $parent = $request->parentchield;
      }else{
        $parent = $request->parent;
      }
      $menuData->parent = $parent;
      $menuData->route    = $request->url;
      $menuData->sort   = $request->sort;
      $menuData->status = $request->status;
      $menuData->icon   = $request->icon;

      if($menuData->save()){
        if($request->newname != null){
          $countnewname = count($request->newname);
          for($i = 0; $i<$countnewname; $i++){
            $menuroute = new MenuRoute;
            $menuroute->menu_id = $menuData->id;
            $menuroute->name = $request->newname[$i];
            $menuroute->sort = $request->newsort[$i];
            $menuroute->route = $request->newurl[$i];
            $menuroute->status = '1';
            $menuroute->save();
          }
        }
      }





      $request->session()->flash('success','Menu Has Saved Successfully');
      return redirect()->back();

    }

    
    public function edit(Request $request,$id)
    {
         $menuId = $request->input('id');
         $menuData = Menu::find($menuId);
         $parentcheck = Menu::where('id',$menuData->parent)->first();
         if($parentcheck){
          if($parentcheck->parent =='0'){
             $menuData->parent_id = $parentcheck->id;
             $menuData->parentchield_id ='0';
          }else{
             $menuData->parent_id = $parentcheck->parent;
             $menuData->parentchield_id =$parentcheck->id;          
          }
         }else{
             $menuData->parent_id = '0';
             $menuData->parentchield_id ='0';  
         }

       $icon=Icon::all();  
       $menus =Menu::orderBy('sort','desc')->get();
       $parentMenu = Menu::where('parent', 0)->get();
       return view('backend.menu.add-menu',compact('menus','parentMenu','icon'));
    }
   
    public function update(Request $request,$id)
    {
       $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'parent' => 'required',      
            'status' => 'required',
            'sort' =>'required'
        ]);    
          

      $menuData = Menu::find($id);

      $menuData->name =$request->name;
       if($request->parentchield !='0'){
        $parent = $request->parentchield;
      }else{
        $parent = $request->parent;
      }
      $menuData->parent = $parent;
      $menuData->route = $request->url;
      $menuData->status = $request->status;
      $menuData->sort = $request->sort;
      $menuData->icon = $request->icon; 
       $menuData->add    = $request->add_route;
      $menuData->edit    = $request->edit_route;
      $menuData->delete    = $request->delete_route;    
      $menuData->save();
      $request->session()->flash('success','Menu Has Updated Successfully');
      return redirect()->back();       
    }

    public function getSubParent(Request $request){
      $parent = $request->input('parent');
      if($parent == '0'){
        $childparent = '';
      }else{
        $childparent = Menu::where('parent',$parent)->get();
      }
      return response()->json($childparent);
    }
}
