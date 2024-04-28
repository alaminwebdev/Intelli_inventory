<?php

namespace App\Http\Middleware;

use App\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user_role = Auth::user()->user_roles->pluck('role_id')->toArray();
        if (in_array(RoleEnum::VIEWER, $user_role)) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Access Permission Denied']);
            } else {
                return redirect()->back()->with('error', 'Access Permission Denied');
            }
        }
        return $next($request);
    }
}
