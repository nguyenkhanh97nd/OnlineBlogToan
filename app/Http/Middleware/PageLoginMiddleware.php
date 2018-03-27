<?php

namespace App\Http\Middleware;

use Closure;
/*-- Quản lí user --*/
use Illuminate\Support\Facades\Auth;
class PageLoginMiddleware
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
        if(Auth::check()){
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['confirm_email'=>'Bạn cần đăng nhập']); 
    }
}
