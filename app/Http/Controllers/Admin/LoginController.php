<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;

    protected $maxAttempts = 3;
    protected $decayMinutes = 5;
    protected $guard = 'admin';

    // protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('admin')->except('logout');
        // $this->middleware('guest')->except('logout');
        // $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        $id_user_session = Session::get('id_user');
        $id_jabatan_session = Session::get('id_jabatan');

        if ($id_user_session != '') {
            if ($id_jabatan_session == 2) {
                return redirect()->route('admin.koordinator');
            }else if($id_jabatan_session == 3){
                return redirect()->route('admin.subkoordinator');
            }else if($id_jabatan_session == 4){
                return redirect()->route('admin.evaluator');
            }else{
                return redirect()->route('admin.direktur');
            }
        }else{
            return view('admin.login');
        }
    }

    public function guard()
    {
        return auth()->guard('admin');
    }

    public function login(Request $request)
    {
        session(['_previous' => url('/admin/login')]);

        $request->validate([
            'captcha' => ['required', Rule::in([$request->session()->get('CAPTCHA_CODE')])],
            'username' => 'required|string|regex:/^[\pL\s\-]+$/u',
            'password' => 'required|string',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $admin = Admin::where('username', TRIM($request->username))->where('is_active', 1)->first();

        //get
        if ($admin) {
            $id_mst_jobposition = $admin->id_mst_jobposition;
            $getJabatan = DB::table('tb_mst_jobposition')->where('id', '=', $id_mst_jobposition)->first();

            $id_jabatan = $getJabatan->id_mst_jabatan;
            $id_departemen = $getJabatan->id_mst_departemen;

            $array_admin = $admin->toArray();

            if (Hash::check(TRIM($request->password), $admin->password)) {

                if ($this->guard()->attempt([
                    'username' => TRIM($request->username),
                    'password' => $request->password,
                ])) {
                    $this->clearLoginAttempts($request);
                    // session()->flash('message', 'Selamat datang kembali di halaman admin.');

                    Session::put('id_user', $array_admin['id']);
                    Session::put('id_jabatan', $id_jabatan);
                    Session::put('id_departemen', $id_departemen);
                    Session::put('username', $array_admin['username']);
                    Session::put('email', $array_admin['email']);
                    Session::put('nama', $array_admin['nama']);
                    Session::put('id_mst_jobposition', $id_mst_jobposition);

                    UserActivity::create([
                        'user_id' => $admin->id,
                        'activity' => 'Logged in',
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                    ]);

                    if ($id_jabatan == 1) { //Direktur
                        return redirect()->route('admin.direktur');
                    } else if ($id_jabatan == 2) { //koordinator
                        return redirect()->route('admin.koordinator');
                    } else if ($id_jabatan == 3) { //sub koordinator
                        return redirect()->route('admin.subkoordinator');
                    } else if ($id_jabatan == 4) { //evaluator
                        return redirect()->route('admin.evaluator');
                    } else {
                        return redirect()->route('admin.dashboard');
                    }
                } else {
                    session()->flash('message', 'Username atau Password anda salah');
                    return redirect('/admin/login');
                }
            } else {

                $this->incrementLoginAttempts($request);
                session()->flash('message', 'Password anda salah');
                return redirect('/admin/login');
            }
        } else {
            $this->incrementLoginAttempts($request);
            session()->flash('message', 'Username anda salah');
            return redirect('/admin/login');
        }
    }

    public function logout(Request $request)
    {

        auth()->guard('admin')->logout();
        session()->flush();
        session()->flash('message', 'Berhasil keluar dari sistem');

        return redirect('/admin/login');
    }

    public function username()
    {
        return 'username';
    }
}
