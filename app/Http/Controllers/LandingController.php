<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\reqBimtek;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;

class LandingController extends Controller
{
    public function index()
    {

        $list_faq = DB::table('tb_mst_faq')->where('is_active','=','1')->get();
        // dd($header);
        return view('layouts.landing.landing', compact(['list_faq']));
    }
    public function landing_izin($izin, Request $request)
    {

        $header = DB::table('tb_mst_izin')->where('name','=',$izin)->first();
        $izinlayanan = DB::table('tb_mst_izinlayanan')->where('is_active','=','1')->where('id_mst_izin','=',$header->id)->get();
        $izinlayanan_persyaratan = DB::table('vw_izinlayanan_persyaratan')->where('id_mst_izin','=',$header->id)->get();
        $list_faq = DB::table('tb_mst_faq')->where('is_active','=','1')->get();
        // dd($header);
        return view('layouts.landing.landing_izin', compact(['header','izinlayanan','izinlayanan_persyaratan','list_faq']));
    }

    public function faq()
    {

        $list_faq = DB::table('tb_mst_faq')->where('is_active','=','1')->get();
        // dd($header);
        return view('layouts.landing.faq_menu', compact(['list_faq']));
    }
    public function req_bimtek()
    {
        if (isset(Auth::user()->oss_id)) {
            $nama_entity = DB::table('tb_oss_nib')->where('oss_id','=',Auth::user()->oss_id)->first();
        }else{
            $nama_entity = null;
        }
        
        // dd($nama_entity);
        return view('layouts.landing.reg_bimtek',compact(['nama_entity']));
    }
    public function req_bimtekpost(Request $req)
    {
        // dd(Auth::user());

        try {
            DB::beginTransaction();
            $count_req = reqBimtek::where('nama_perusahaan','=',$req['nama_perusahaan'])->where('status','=','0')->count();
            if($count_req>0){
                return redirect('/landing/reqbimtek')->with('message', 'Mohon maaf Permohonan Anda tidak bisa diajukan, mohon menunggu proses verifikasi atas permohonan sebelumnya.');
            }

            $insertcatatan = reqBimtek::create([
                'oss_id' => isset(Auth::user()->oss_id) ? Auth::user()->oss_id : null,
                'type' => 'Request Bimbingan Teknis',
                'nama_perusahaan' => $req['nama_perusahaan'],
                'req_date' => Carbon::now(),
                'nama_pemohon' => $req['nama_pemohon'],
                'email_pemohon' => $req['email_pemohon'],
                'notelp_pemohon' => $req['no_telp_pemohon'],
                'status' => 0,
                // 'submitted_date' => Carbon::now(),
                'created_by' => Auth::user()->name,
                'created_date' => Carbon::now()
            ]);
            
            DB::commit();
            return redirect('/landing/reqbimtek')->with('message', 'Permohonan Anda sudah kami terima, mohon menunggu konfirmasi jadwal Bimbingan Teknis.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/landing/reqbimtek')->with('message', 'Permohonan Anda tidak berhasil diajukan, Silahkan ajukan kembali.');
        }
        // $list_faq = DB::table('tb_mst_faq')->where('is_active','=','1')->get();
        // dd($header);
        return view('layouts.landing.reg_bimtek');
    }
}