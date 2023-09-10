<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class IsDeveloper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         if (Auth::user() && Auth::user()->id == 1) {
            return $next($request);        
        } 
                
        return redirect('/'); 
    }
}
