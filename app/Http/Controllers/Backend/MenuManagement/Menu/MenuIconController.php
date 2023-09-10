<?php

namespace App\Http\Controllers\Backend\MenuManagement\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Icon;

class MenuIconController extends Controller
{
    public function index()
    {
    	$icons = ICon::all();
    	return view('backend.menu.icons')->with('icons', $icons);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
        'name' => 'required'
        ]);    
      
      $iconData = new Icon;
      $iconData->name = $request->name;
      $iconData->save();
      $request->session()->flash('success','Icon Name Save Successfully');
      return redirect()->back();
     
    }

    public function edit(Request $request)
    {
         $iconId = $request->input('id');
         $iconData = Icon::find($iconId);
         return response()->json($iconData);
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'name' => 'required'
        ]);

      $iconData = Icon::find($id);
      $iconData->name =$request->name;
      $iconData->save();
      $request->session()->flash('success','Icon Name Updated Successfully');
      return redirect()->back();
    	
    }

    
    public function delete(Request $request)
    {
      $id=$request->id;
      Icon::find($id)->delete();
      $request->session()->flash('success','Icon Name Updated Successfully');
	    return redirect()->back();
    }

}
