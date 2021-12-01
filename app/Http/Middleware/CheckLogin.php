<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::guard('user')->check() && !in_array(Route::currentRouteName(), ['login', 'login.handle'])) {
        //     return redirect()->route('login');
        // }

        // if (Auth::guard('user')->check() && in_array(Route::currentRouteName(), ['login', 'login.handle'])) {
        //     return redirect()->route('dashboard');
        // }
        // if(Auth::user()->email == ''){
        //     return $next($request);
        // }else{
        //     return redirect()->route('category')
        // }
            return $next($request);

    }
}