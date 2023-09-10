<?php

namespace App\Services\UserService;

use App\Models\MenuPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\IService;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;

/**
 * Class PageService
 * @package App\Services
 */
class UserService implements IService
{
    
    public function getAll()
	{
		try{
			$data = User::with(['user_roles'])->get();
			return $data;
		}
		catch(\Exception $e){
			$d['error'] = 'Something wrong';
			return response()->json(["msg"=>$e->getMessage()]);
        }
    }
    
    public function getUserRole(Request $request){
		$user_role_type_id = $request->user_role_type_id;
		$allRole = Role::where('user_role_type_id',$user_role_type_id)->get();
		return response()->json($allRole);
    }
    
    public function create(Request $request)
    {            
        $data              = new User();
        $data->name        = $request->name;
    	$data->username    = $request->username;
    	$data->email       = $request->email;
    	$data->mobile       = $request->mobile;
        $data->password    = bcrypt($request->password);
        $data->status = $request->status ?? 0;
    	$data->save();

        if ($request->role_id) {
            $user_data           = new UserRole();
            $user_data->user_id  = $data->id;
            $user_data->role_id  = $request->role_id;
            $user_data->save();
        }
    }  
	public function getByID($id)
	{ 
        $data = User::with(['user_roles'])->find($id);
        
        return $data; 
	}
    public function update(Request $request, $id)
    {
        //return $request->all();
        // dd($request->role_id);
        $data              = User::find($id);
        
    	$data->name        = $request->name;
        $data->username    = $request->username;
        $data->mobile       = $request->mobile;
        $data->email       = $request->email;
        $data->status = $request->status ?? 0;
    	$data->save();
        if ($request->role_id) {
            $user_data           = UserRole::where('user_id', $id)->first();
            if(!$user_data){
                $user_data           = new UserRole();
                $user_data->user_id  = $data->id;
                $user_data->role_id  = $request->role_id;
                $user_data->save();
            }else{
                $user_data->role_id  = $request->role_id;
                $user_data->save();
            }
        }
 
        try{
            $data->save();
            return true;

        }catch(Exception $e){
            return $e;
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        
        return true;
    }

    public function userStatus(Request $request)
    {
        //return $request->all();
        $data = User::findOrFail($request->id);
        $data->status = $request->status;
        $data->save();
    }

}
