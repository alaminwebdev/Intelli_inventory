<?php

namespace App\Helpers;
use App\Models\MenuPermission;



if(!function_exists('inner_permission')){
	function inner_permission($permitted_route){
		if(Auth::user()->id=='1'){
			return true;
		}
		
		$user_role_array=Auth::user()->user_role;
		if(count($user_role_array)==0){
			$user_role = [];
		}else{
			foreach($user_role_array as $rolee){
				$user_role[] = $rolee->role_id;
			}
		}
		
		$existpermission = MenuPermission::where('permitted_route',$permitted_route)->whereIn('role_id',@$user_role)->first();
		if($existpermission){
			return true;
		}else{
			return false;
		}
	}
}
