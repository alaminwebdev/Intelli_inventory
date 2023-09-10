<?php

namespace App\Services\RoleService;

use App\Models\MenuPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\IService;
use App\Models\Role;

/**
 * Class PageService
 * @package App\Services
 */
class RoleService implements IService
{
    
    public function getAll()
	{
		try{
			$data = Role::all();
			return $data;
		}
		catch(\Exception $e){
			$d['error'] = 'Something wrong';
			return response()->json(["msg"=>$e->getMessage()]);
        }
    }
    
    public function create(Request $request)
    {            
        $roleData = new Role;
        $roleData->name = $request->name;
        $roleData->description = $request->description;
        $roleData->working_area = $request->working_area;
        $roleData->save();
        $request->session()->flash('success','Role Name Save Successfully');
    }  
	public function getByID($id)
	{ 
        $data = Role::find($id);
        
        return $data; 
	}
    public function update(Request $request, $id)
    {
        // dd($request,$id);

        $roleData = Role::find($id);

        $roleData->name = $request->name_update;
        $roleData->description = $request->description;
        $roleData->working_area = $request->working_area;
        $roleData->save();
        $request->session()->flash('success','Role Name Updated Successfully');
 
        try{
            $roleData->save();
            return true;

        }catch(Exception $e){
            return $e;
        }
    }

    public function delete($id)
    {
        $id=$request->id;
        Role::find($id)->delete();
        $request->session()->flash('success','Role Name Updated Successfully');
        
        return true;
    }

}
