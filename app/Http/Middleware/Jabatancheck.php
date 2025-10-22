<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Auth;
use Route;
class Jabatancheck
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
        // if (Auth::guard('admin')->check() === false) { //sementara
        //     return redirect()->route('admin.login.index')->withError('Silahkan Login Terlebih Dahulu!');
        // }
        $id_user = Session::get('id_user');
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen = Session::get('id_departemen');

        $is_url_login = $request->is('admin/login');
        if ($is_url_login != 1) {
            if ($id_user == '') {
                return redirect()->route('admin.login.index');
            }else{
                if ($id_jabatan != 1 && $request->is('admin/direktur*')) {
                //
                    // return redirect()->route('admin.dashboard');
                    return abort(404);
                }

                if ($id_jabatan != 2 && $request->is('admin/koordinator*')) {
                    //
                    // return redirect()->route('admin.dashboard');
                    return abort(404);
                }

                if ($id_jabatan != 3 && $request->is('admin/subkoordinator*')) {
                    //
                    // return redirect()->route('admin.dashboard');
                    return abort(404);
                }

                if ($id_jabatan != 4 && $request->is('admin/evaluator*')) {
                    //
                    // return redirect()->route('admin.dashboard');
                    return abort(404);
                }

                if ($id_jabatan != 5 && $request->is('admin/verifikatornib*')) {
                //
                // return redirect()->route('admin.dashboard');
                return abort(404);
                }

                if ($id_jabatan != 6 && $request->is('admin/ptsp*')) {
                //
                // return redirect()->route('admin.dashboard');
                return abort(404);
                }
            }
            
        }

        return $next($request);
    }
}