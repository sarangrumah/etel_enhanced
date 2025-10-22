<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Mail\Sendmail;
use App\Models\Admin\Izinoss;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Penanggungjawab;
use App\Models\Admin\User;
use App\Models\Admin\Nib;
use App\Models\DetailNIB;
use App\Models\Admin\Ulo;
use App\Models\Admin\IzinPrinsip;
use App\Models\Admin\KodeIzin;

class CommonHelper
{
    function send_email($email)
    {
        $kirimemail = \Mail::to($email['email'])->send(new \App\Mail\Sendmail($email));
    }

    function get_pj_nib($nib)
    {
        $penanggungjawab = Penanggungjawab::select('*')->where('nib', '=', $nib)->first();
        if ($penanggungjawab == null) {
            $penanggungjawab = array();
        } else {
            $penanggungjawab = $penanggungjawab->toArray();
        }

        return $penanggungjawab;
    }

    function get_user_disposisi($id_departemen)
    {
        $user = User::select(
            'tb_mst_user_bo.id',
            'tb_mst_user_bo.username',
            'tb_mst_user_bo.nama',
            'tb_mst_user_bo.email',
            'tb_mst_user_bo.id_mst_jobposition',
            'tb_mst_jobposition.name as jobposition_name',
            'tb_mst_jobposition.desc',
            'tb_mst_jobposition.id_mst_departemen',
            'tb_mst_jobposition.id_mst_jabatan',
            'tb_mst_departement.name as name_departemen',
            'tb_mst_jabatan.name as name_jabatan',
            'tb_mst_jobposition.short_desc'
        )
            ->join('tb_mst_jobposition', 'id_mst_jobposition', '=', 'tb_mst_jobposition.id')
            ->join('tb_mst_departement', 'tb_mst_jobposition.id_mst_departemen', '=', 'tb_mst_departement.id')
            ->join('tb_mst_jabatan', 'tb_mst_jobposition.id_mst_jabatan', '=', 'tb_mst_jabatan.id')
            ->where('tb_mst_user_bo.is_active', '=', '1')
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        ;

        if ($id_departemen == 2) { //jika user jasa dan jaringan
            $user = $user->where('tb_mst_user_bo.id_mst_jobposition', '=', 3); //jabatan koordinator jaringan
        } else if ($id_departemen == 1) {
            $user = $user->where('tb_mst_user_bo.id_mst_jobposition', '=', 6); //jabatan evaluator jasa
        } else if ($id_departemen == 3) { //jika user telsus
            $user = $user->where('tb_mst_user_bo.id_mst_jobposition', '=', 9); //jabatan evaluator Telsus
        } else if ($id_departemen == 5) { //jika user telsus
            $user = $user->where('tb_mst_user_bo.id_mst_jobposition', '=', 15); //jabatan penomoran
        } else if ($id_departemen == 4) { //jika user telsus
            $user = $user->where('tb_mst_user_bo.id_mst_jobposition', '=', 12); //jabatan penomoran
        }

        $user = $user->get()->toArray();
        return $user;
    }

    function get_user_disposisi_ulo($id_mst_jobposition)
    {
        $user = User::select(
            'tb_mst_user_bo.id',
            'tb_mst_user_bo.username',
            'tb_mst_user_bo.nama',
            'tb_mst_user_bo.email',
            'tb_mst_user_bo.id_mst_jobposition',
            'tb_mst_jobposition.name as jobposition_name',
            'tb_mst_jobposition.desc',
            'tb_mst_jobposition.id_mst_departemen',
            'tb_mst_jobposition.id_mst_jabatan',
            'tb_mst_departement.name as name_departemen',
            'tb_mst_jabatan.name as name_jabatan',
            'tb_mst_jobposition.short_desc'
        )
            ->join('tb_mst_jobposition', 'id_mst_jobposition', '=', 'tb_mst_jobposition.id')
            ->join('tb_mst_departement', 'tb_mst_jobposition.id_mst_departemen', '=', 'tb_mst_departement.id')
            ->join('tb_mst_jabatan', 'tb_mst_jobposition.id_mst_jabatan', '=', 'tb_mst_jabatan.id')
            // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        ;
        $user->where('tb_mst_user_bo.is_active', '=', 1);
        $user->where('tb_mst_user_bo.id_mst_jobposition', '=', 12);

        $user = $user->get()->toArray();
        return $user;
    }

    function get_detail_nib($nib)
    {
        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        return $detailNib;
    }


    function get_detail_nib_by_oss($oss)
    {
        $detailNib = Nib::select('*')->where('oss_id', '=', $oss)->first();
        // return $oss;die;

        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        return $detailNib;
    }



    function get_map_izin($id_mst_izinlayanan)
    {
        $map_izin = DB::table('tb_map_listpersyaratan')
            ->select(
                'tb_map_listpersyaratan.id',
                'tb_map_listpersyaratan.id_mst_izinlayanan',
                'tb_map_listpersyaratan.component_name',
                'tb_map_listpersyaratan.id_mst_listpersyaratan',
                'tb_map_listpersyaratan.is_mandatory',
                'tb_map_listpersyaratan.order_no',
                'tb_map_listpersyaratan.is_active',
                'tb_mst_listpersyaratan.group_by',
                'tb_mst_listpersyaratan.persyaratan',
                'tb_mst_listpersyaratan.persyaratan_html',
                'tb_mst_listpersyaratan.file_type',
                'tb_mst_listpersyaratan.desc'
                // ,'tb_mst_listpersyaratan.component_name'
                ,
                'tb_mst_listpersyaratan.download_link'
            )
            ->join('tb_mst_listpersyaratan', 'tb_map_listpersyaratan.id_mst_listpersyaratan', '=', 'tb_mst_listpersyaratan.id')
            ->where('id_mst_izinlayanan', '=', $id_mst_izinlayanan)->where('tb_map_listpersyaratan.is_active', '=', '1')->orderBy('tb_map_listpersyaratan.order_no')->get();

        if (empty($map_izin)) {
            $map_izin = array();
        } else {
            $map_izin->toArray();
        }

        return $map_izin;
    }

    function get_map_izin_pre($id_parentizin)
    {
        $map_izin = DB::table('tb_map_listpersyaratan')
            ->select(
                'tb_map_listpersyaratan.id',
                'tb_map_listpersyaratan.id_mst_izinlayanan',
                'tb_map_listpersyaratan.component_name',
                'tb_map_listpersyaratan.id_mst_listpersyaratan',
                'tb_map_listpersyaratan.is_mandatory',
                'tb_map_listpersyaratan.order_no',
                'tb_map_listpersyaratan.is_active',
                'tb_mst_listpersyaratan.group_by',
                'tb_mst_listpersyaratan.persyaratan',
                'tb_mst_listpersyaratan.persyaratan_html',
                'tb_mst_listpersyaratan.file_type',
                'tb_mst_listpersyaratan.desc'
                // ,'tb_mst_listpersyaratan.component_name'
                ,
                'tb_mst_listpersyaratan.download_link'
            )
            ->join('tb_mst_listpersyaratan', 'tb_map_listpersyaratan.id_mst_listpersyaratan', '=', 'tb_mst_listpersyaratan.id')
            ->join('tb_mst_izinlayanan', 'tb_mst_izinlayanan.id', '=', 'tb_map_listpersyaratan.id_mst_izinlayanan')
            ->join('tb_oss_trx_izin', 'tb_oss_trx_izin.kd_izin', '=', 'tb_mst_izinlayanan.kode_izin')
            ->where('tb_oss_trx_izin.id_proyek', '=', $id_parentizin)->where('tb_map_listpersyaratan.is_active', '=', '1')->orderBy('tb_map_listpersyaratan.order_no')->get();

        if (empty($map_izin)) {
            $map_izin = array();
        } else {
            $map_izin->toArray();
        }

        return $map_izin;
    }

    function get_subkoordinator_telsus()
    {
    $subkoordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
    ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
    ->where('tb_mst_user_bo.id_mst_jobposition', '=', 8);

    $subkoordinator = $subkoordinator->first();
    return $subkoordinator;
    }

    function get_subkoordinator_kelayakan()
    {
    $subkoordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
    ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
    ->where('tb_mst_user_bo.id_mst_jobposition', '=', 11);

    $subkoordinator = $subkoordinator->first();
    return $subkoordinator;
    }

    function get_subkoordinator_first($id_departemen)
    {
        $subkoordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
            ->where('tb_mst_user_bo.is_accounttesting', '!=', 1);
        if ($id_departemen == 2) { //jika user jasa dan jaringan
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 2); //jabatan koordinator jaringan
        } else if ($id_departemen == 1) {
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 5); //jabatan evaluator jasa
        } else if ($id_departemen == 3) {
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 8); //jabatan evaluator Telsus
        } else if ($id_departemen == 4) {
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 11); //jabatan evaluator Kelayakan
        } else if ($id_departemen == 5) {
            $subkoordinator = $subkoordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 14); //jabatan evaluator Penomoran
        }

        $subkoordinator = $subkoordinator->first();
        return $subkoordinator;
    }

    function get_koordinator_first($id_departemen)
    {
        $koordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
            ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
            ->where('tb_mst_user_bo.is_active', '=', 1);
        if ($id_departemen == 2) { //jika user jasa dan jaringan
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 1); //jabatan koordinator jaringan
        } else if ($id_departemen == 1) {
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 4); //jabatan evaluator jasa
        } else if ($id_departemen == 3) {
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 7); //jabatan evaluator Telsus
        } else if ($id_departemen == 4) {
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 10); //jabatan evaluator Kelayakan
        } else if ($id_departemen == 5) {
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 13); //jabatan evaluator Penomoran
        }

        $koordinator = $koordinator->first();
        return $koordinator;
    }

    function get_koordinator_kelayakan()
    {
    $koordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
    ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
    ->where('tb_mst_user_bo.id_mst_jobposition', '=', 10);

    $koordinator = $koordinator->first();
    return $koordinator;
    }


    // ULO
    function countUlo($status)
    {
        $Ulo = Ulo::where('status_ulo', '=', $status)->get()->count();
        return $Ulo;
    }

    function countIP($status)
    {
        $IzinPrinsip = Izinoss::where('status_checklist', '=', $status)->get()->count();
        // dd($IzinPrinsip);
        return $IzinPrinsip;
    }

    function countIzinTelsus($status)
    {
        $IzinTelsus = Izinoss::where('status_checklist', '=', $status)->get()->count();
        return $IzinTelsus;
    }

    function getDepartemen($id_departemen)
    {
        $departemen = '';
        if ($id_departemen == 2) {
            $departemen = 'Jaringan'; //jika user jaringan
        } else if ($id_departemen == 1) {
            $departemen = 'Jasa'; //jabatan evaluator jasa
        } else if ($id_departemen == 3) { //jika user telsus
            $departemen = 'Telekomunikasi Khusus'; //jabatan evaluator Telsus
        } else if ($id_departemen == 5) { //jika user telsus
            $departemen = 'Penomoran'; //jabatan evaluator Telsus
        }

        return $departemen;
    }

    function getDetailKodeAkses($penomoran, $id_mst_kode_akses)
    {
        if ($penomoran['id_proyek'] == 'Blok Nomor') {
            $kode_akses = DB::table('vw_kodeakses_bloknomor')->select('*')->where('id_izin', '=',
            $penomoran['id_izin'])->where('is_active', '=', 1)->first();
        }else{
        $kode_akses =
            DB::table('tb_trx_kode_akses_alokasi')->select('*')->where('id', '=', $id_mst_kode_akses)->where('is_active', '=', 1)->first();
            }
        // dd($kode_akses);s
        if (!empty($kode_akses)) {
            $penomoran['kode_akses'] = collect($kode_akses)->toArray();
            $id_mst_jeniskodeakses =
                isset($penomoran['kode_akses']['id_mst_jenis_kode_akses']) ?
                $penomoran['kode_akses']['id_mst_jenis_kode_akses'] : '';
                // dd($penomoran['kode_akses']);
            if ($id_mst_jeniskodeakses != '') {
                #penomoran_bari
                $jenis_kode_akses =
                    DB::table('tb_mst_jenis_kode_akses')->select('*')->where('is_active', '=', 1)->where('tb_mst_jenis_kode_akses.id', '=', $id_mst_jeniskodeakses)->first();
                // dd($jenis_kode_akses);
                    if (!empty($jenis_kode_akses)) {
                    $penomoran['kode_akses']['jeniskodeakses'] = collect($jenis_kode_akses)->toArray();
                }
            }
        }
        // dd($penomoran);
        return $penomoran;
        // // if ($penomoran['id_proyek'] == 'Blok Nomor') {
        // //     $jenis_kode_akses = DB::table('tb_mst_jenis_kode_akses')->select('*')->where('is_active', '=', 1)->where('tb_mst_jenis_kode_akses.id', '=', '17')->first();

        // //     if (!empty($jenis_kode_akses)) {
        // //     $penomoran['kode_akses']['jeniskodeakses'] = collect($jenis_kode_akses)->toArray();
        // //     // dd($penomoran['kode_akses']['jeniskodeakses']);
        // //     }

        // // } else {
        //     // dd($id_mst_kode_akses);
        //     if ($penomoran['id_proyek'] == 'Blok Nomor') {
        //     // $kode_akses =
        //     //     DB::table('tb_trx_kode_akses_alokasi_bloknomor')->select('*')->where('id', '=',
        //     //     $id_mst_kode_akses)->where('is_active', '=', 1)->first();
        //     }else{
        //         $kode_akses =
        //         DB::table('tb_trx_kode_akses')->select('*')->where('id', '=',
        //         $id_mst_kode_akses)->where('is_active', '=', 1)->first();
        //     }
        //     // dd($kode_akses);
        //     // if (!empty($kode_akses)) {
        //         $penomoran['kode_akses'] = collect($kode_akses)->toArray();
        //         if ($penomoran['id_proyek'] == 'Blok Nomor') {
        //             $id_mst_jeniskodeakses = '17';
        //         }else{

        //         }

        //     // }
        // // }

        // // dd($jenis_kode_akses);
        return $penomoran;
    }

    function getMapKodeAkses($id_mst_kode_akses)
    {
        $map = DB::table('vw_list_penomoran')->select('*')->where('id', '=', $id_mst_kode_akses)->get();
        if (!empty($map)) {
            $map = json_decode(json_encode($map), true);
            foreach ($map as $key => $val) {
                // $map[$key]['kbli'] = json_decode(json_encode(DB::table('tb_mst_kbli as t')->select('*')->where('t.id','=',$val['id_mst_kbli'])->first()), true);
                // $map[$key]['jenis_layanan'] = json_decode(json_encode(DB::table('tb_mst_izinlayanan as i')->select('*')->where('i.id_mst_kbli','=',$val['id_mst_kbli'])->first()), true);
                $map[$key]['jenis_layanan'] = json_decode(json_encode(DB::table('tb_mst_izinlayanan as i')->select('*')->first()), true);
            }
        }

        return $map;
    }

    function transStatus($kode)
    {
        $status = KodeIzin::where('oss_kode', '=', $kode)->get();
        return $status;
    }
}