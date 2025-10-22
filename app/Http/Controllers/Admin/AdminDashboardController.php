<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;

class AdminDashboardController extends Controller
{
    //
    public function index(){

        $id_user = Session::get('id_user');
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen = Session::get('id_departemen');

        if ($id_jabatan == 1) {
            return redirect()->route('admin.direktur');
        }

        if ($id_jabatan == 2) {
            //
            return redirect()->route('admin.koordinator');
        }

        if ($id_jabatan == 3) {
            return redirect()->route('admin.subkoordinator');
        }

        if ($id_jabatan == 4) {
            return redirect()->route('admin.evaluator');
        }
        
        if ($id_jabatan == 5) {
            return redirect()->route('admin.verifikatornib.evaluasiregistrasi');
        }

        if ($id_jabatan == 6) {
            return redirect()->route('admin.ptsp.laporan-request');
        }
        //
    	
    	// return view('layouts.backend.dashboard');
    }
}