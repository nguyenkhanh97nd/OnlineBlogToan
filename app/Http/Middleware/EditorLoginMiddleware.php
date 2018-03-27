<?php

namespace App\Http\Middleware;

use Closure;

//Nhúng thư viện đăng nhập
use Illuminate\Support\Facades\Auth;

class EditorLoginMiddleware
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
            $user = Auth::user();
            if($user->level == 1 || $user->level == 2 ){
                // view()->share('admin',$user);
                return $next($request);
            }
            else{
                return redirect()->route('login')->withErrors('Bạn không phải là Editor');
            }
        }
        else{
            return redirect()->route('login')->withErrors('Bạn phải đăng nhập');
        }
    }
}
