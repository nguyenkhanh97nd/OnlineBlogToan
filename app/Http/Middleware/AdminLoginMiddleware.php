<?php

namespace App\Http\Middleware;

use Closure;

//Nhúng thư viện đăng nhập
use Illuminate\Support\Facades\Auth;
class AdminLoginMiddleware
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
        if(Auth::check()) {
            $user = Auth::user();
            if($user->level == 1){
                return $next($request);
            }
            else{
                return redirect()->route('page.index');
            }
        }
        return redirect()->route('page.index');
    }
}
