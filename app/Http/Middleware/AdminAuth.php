<?php

namespace App\Http\Middleware;

use Auth, Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if (Auth::guard('admin')->check() === false) {
            
            return redirect()->route('admin.login.index')->withError('Silahkan Login Terlebih Dahulu!');
        }

        return $next($request);
    }
}
