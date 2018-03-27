<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Thực hiện redirect khi đăng nhập. Cần lưu section trước đó.
        // Khi có section sẽ quay về section đó (link)

        // if (Auth::guard($guard)->check()) {
        //     return redirect('/');
        // }
        return $next($request);
    }
}
