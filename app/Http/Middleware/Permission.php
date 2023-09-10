<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\MenuPermission;
use App\Models\MenuRoute;
use Auth;
use Closure;
use Session;
class Permission
{
    public function handle($request, Closure $next){
        $url_path=request()->path();
        $route= \Route::currentRouteName();
        $user_role = Auth::user()->user_roles->pluck('role_id')->toArray();

        if(in_array(1, $user_role)){
            return $next($request);        
        }else{
            $mainmenu = Menu::where('url_path',$url_path)->first();
            $mainmenuroute = MenuRoute::where('route',$route)->first();
            if($mainmenu != null || $mainmenuroute != null){
                if($mainmenu){
                    $permission=MenuPermission::whereIn('role_id',$user_role)->where('menu_from', 'menu')->where('permitted_route',$url_path)->first();
                }else{
                    $permission=MenuPermission::whereIn('role_id',$user_role)->where('menu_from', 'menu_route')->where('permitted_route',$route)->first();
                }
                if($permission){
                    return $next($request);
                }else{  
                    if($request->ajax()){
                        return response()->json(['status'=>'error','message'=>'Access Permission Denied'],401);
                    }
                    return redirect()->route(getGuard().'.dashboard')->with('error','Access Permission Denied');
                }
            }else{
                return $next($request);
            }
        }
    }


}
