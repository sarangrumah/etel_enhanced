<?php

namespace App\Http\Controllers;
use DB;
use Session;
use App\Models\Nib;
use App\Models\Admin\Izin;
use App\Helpers\DateHelper;
use App\Helpers\EmailHelper;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class testEmailController extends Controller
{
    public function testemail_ketuatim_disposisi_ip($id,Request $req)
    {
        // dd($id);
        $email = new EmailHelper();
        $common = new CommonHelper();
        $catatan_hasil_evaluasi = '';
        $koreksi_all = 0;
        $jenis_izin = Izin::where('id_izin', $id)->first();
        $izins = Izin::where('id_izin',$id)->first();
        $nib = $jenis_izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $id_departemen_user = Session::get('id_departemen');
        $departemen = $common->getDepartemen($id_departemen_user);
        $email_jenis = 'pemenuhan-syarat';
        if ($jenis_izin == 'TELSUS' || $jenis_izin == 'TELSUS_INSTANSI') {
                $id_departemen_user = 3;
            } elseif ($jenis_izin == 'JASA') {
                $id_departemen_user = 1;
            } elseif ($jenis_izin == 'JARINGAN') {
                $id_departemen_user = 2;
            }
        $koordinator = $common->get_koordinator_first($id_departemen_user);
        $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
        $user['nama'] = $koordinator->nama;
        $nama2 = $koordinator->nama;
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();
        $email_data['izin'] = $izins;
        $check_badanhukum = DB::table('vw_jenisbadanhukum')->select('*')->where('nib','=',$email_data['izin']['nib'])->first();
        
        // dd($email_data['izin']['nib'],$check_badanhukum->oss_kode);
        $kirim_email2 = $email->kirim_email2_test($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
    }

    
    public function testemail_ketuatim_disposisi_instansi($id,Request $req)
    {
        // dd($id);
        $koreksi_all = 0;
        $common = new CommonHelper;
        $email = new EmailHelper();
        $id_departemen_user = Session::get('id_departemen');
        $departemen = $common->getDepartemen($id_departemen_user);
        $jenis_izin = Izin::where('id_izin', $id)->first();
        
        $nib = $jenis_izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $izins = $jenis_izin->toArray();
        $izins = Izin::where('id_izin', $id)->first();
        if ($jenis_izin['layanan'] == 'TELSUS' || $jenis_izin['layanan'] == 'TELSUS_INSTANSI') {
                $id_departemen_user = 3;
            } elseif ($jenis_izin['layanan'] == 'JASA') {
                $id_departemen_user = 1;
            } elseif ($jenis_izin['layanan'] == 'JARINGAN') {
                $id_departemen_user = 2;
            } elseif ($jenis_izin['layanan'] == 'PENOMORAN') {
                $id_departemen_user = 5;
            }
        $koordinator = $common->get_koordinator_first($id_departemen_user);
        $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();

        $user['email'] = 'am.ademaryadi@gmail.com';
        $user['nama'] = $koordinator->nama;
        $nama2 = $koordinator->nama;
        $email_jenis = 'koordinator-syarat';
        $catatan_hasil_evaluasi = '';
        dd($jenis_izin,$id_departemen_user,$koordinator,$jenis_izin['nama_master_izin']);
        $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izins, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
    }
} 