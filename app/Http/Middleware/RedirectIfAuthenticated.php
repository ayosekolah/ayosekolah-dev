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
        if ($guard == "busines" && Auth::guard($guard)->check()) {
            return redirect('/business/dashboard');
        }
        if ($guard == "personal" && Auth::guard($guard)->check()) {
            return redirect('/personal/dashboard');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('');
        }

        return $next($request);
    }
}
