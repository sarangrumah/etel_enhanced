<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class CheckUserActivity
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
        if (Auth::check()) {
            $user = User::find(Auth::id());

            if ($user->last_login_at < Carbon::now()->subMonth()) {
                $user->status = false;
                $user->save();

                Auth::logout();

                return redirect('/login')->with('notification', 'Your account has been deactivated due to inactivity. Please submit an Activation request letter to reactivate it.');
            }

            if (!$user->status) {
                 Auth::logout();
                 return redirect('/login')->with('notification', 'Your account is deactivated. Please submit an Activation request letter to reactivate it.');
            }
        }

        return $next($request);
    }
}
