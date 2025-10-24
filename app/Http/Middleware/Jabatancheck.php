<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
        // Check if user is authenticated
        if (!Auth::check()) {
            Log::warning('Unauthorized access attempt', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent()
            ]);
            return redirect()->route('admin.login.index')->withError('Silahkan Login Terlebih Dahulu!');
        }

        $id_user = Session::get('id_user');
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen = Session::get('id_departemen');

        // Validate session data integrity
        if (empty($id_user) || empty($id_jabatan) || empty($id_departemen)) {
            Log::warning('Invalid session data', [
                'user_id' => Auth::id(),
                'session_user' => $id_user,
                'session_jabatan' => $id_jabatan,
                'session_departemen' => $id_departemen,
                'ip' => $request->ip()
            ]);
            Auth::logout();
            Session::flush();
            return redirect()->route('admin.login.index')->withError('Sesi tidak valid, silahkan login kembali.');
        }

        // Verify session user matches authenticated user
        if ($id_user != Auth::id()) {
            Log::warning('Session user mismatch', [
                'auth_user_id' => Auth::id(),
                'session_user_id' => $id_user,
                'ip' => $request->ip()
            ]);
            Auth::logout();
            Session::flush();
            return redirect()->route('admin.login.index')->withError('Sesi tidak valid, silahkan login kembali.');
        }

        $is_url_login = $request->is('admin/login');
        if (!$is_url_login) {
            // Role-based access control with enhanced security
            $allowed = $this->checkRoleAccess($id_jabatan, $request->path());

            if (!$allowed) {
                Log::warning('Unauthorized role access attempt', [
                    'user_id' => Auth::id(),
                    'user_jabatan' => $id_jabatan,
                    'requested_path' => $request->path(),
                    'ip' => $request->ip()
                ]);
                return abort(403, 'Akses ditolak.');
            }
        }

        return $next($request);
    }

    /**
     * Check if user has access to the requested route based on their role
     */
    private function checkRoleAccess($id_jabatan, $path)
    {
        $roleRoutes = [
            1 => ['admin/direktur*'], // Direktur
            2 => ['admin/koordinator*'], // Koordinator
            3 => ['admin/subkoordinator*'], // Subkoordinator
            4 => ['admin/evaluator*'], // Evaluator
            5 => ['admin/verifikatornib*'], // Verifikator NIB
            6 => ['admin/ptsp*'], // PTSP
        ];

        // Check if user's role has access to the requested path
        if (isset($roleRoutes[$id_jabatan])) {
            foreach ($roleRoutes[$id_jabatan] as $pattern) {
                if (fnmatch($pattern, $path)) {
                    return true;
                }
            }
        }

        return false;
    }
}
