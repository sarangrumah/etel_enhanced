<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Izin;
use App\Models\Admin\Nib;
use App\Models\Admin\User;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Catatandirektur;
use App\Models\Admin\IzinPrinsip;
use App\Models\TrxIzinPrinsip;
use App\Models\Admin\Ulo;
use App\Models\Admin\uloView;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Skulo;
use App\Models\Admin\Penomoran;
use App\Models\Admin\BlokNomor_List;
use App\Models\Admin\vw_penomoran_list;
use App\Models\Admin\vw_kodeakses_adds;
use App\Models\Admin\Penomoranlog;
use App\Models\Admin\SkPenomoran;
use App\Models\Admin\Penyesuaian;
use App\Models\Admin\vw_penomoran_req_detail;
use App\Models\Admin\SK_Penomoran;
use App\Models\Admin\UserSurvey;
use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Helpers\LogHelper;
use App\Helpers\EmailHelper;
use App\Helpers\DateHelper;
use App\Helpers\Osshub;
use Carbon\Carbon;
use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;
use PDF;
use Storage;

use Illuminate\Validation\ValidationException;
use App\Mail\Sendmail;
use Illuminate\Support\Facades\Mail;
use detail;

class DirekturController extends Controller
{
    //
    public function index()
    {
        // return Redirect::route('admin.direktur.ulo');
        $date_reformat = new DateHelper();
        $paginate = array();
        $common = new CommonHelper();
        $id_jabatan = Session::get('id_jabatan');
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');
        $ulo = array();
        $ulo = new Ulo();
        $ulo_full = $ulo->view_ulo($id_departemen_user, 'EMPTY', $id_jabatan);
        // dd($id_departemen_user, $id_jabatan);
        if ($ulo != null) { //handle paginate error division by zero
            $ulo_full = $ulo_full->paginate($limit_db);
            $paginate = $ulo_full;
            $ulo_full = $ulo_full->toArray();
        }
        $countulo = $common->countUlo(904);
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select(
            't.id as id_kode_akses',
            't.*',
            'v.*',
            'y.kode_akses',
            'x.kode_akses as bloknomor_list'
        )
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            // ->join('tb_trx_disposisi_evaluator_penomoran as d', 'd.id_izin', '=', 'v.id_izin')
            ->leftjoin('tb_trx_kode_akses_alokasi as y', 't.id_mst_kode_akses', '=', 'y.id')
            ->leftjoin('vw_kodeakses_bloknomor as x', 't.id_izin', '=', 'x.id_izin')
            // ->where('d.id_disposisi_user', '=', Session::get('id_user'))
            ->with('KodeIzin')->with('KodeAkses')->distinct('t.id', 't.id_izin');
        // ->whereIn('t.status_permohonan', [904, 915])->get();
        // dd($penomoran);
        $countevaluasi = $penomoran->clone()->where(function ($q) {
            $q->whereIn('t.status_permohonan', [904, 915]);
        })->get()->count();
        // $countevaluasi = $penomoran->whereIn('t.status_permohonan', [904, 915]);
        // if ($penomoran->count() > 0) { //handle paginate error division by zero
        //     $penomoran = $penomoran->paginate($limit_db);
        // } else {
        //     $penomoran = $penomoran->get();
        // }
        // $paginate = $penomoran;
        // $penomoran = $penomoran->toArray();
        $log = DB::table('vw_penomoran_all as t')->select('t.*')
            ->whereIn('t.status_permohonan', [904, 915])->get();
        // ->where('id_disposisi_user', '=', Session::get('id_user'))->get();
        $log = $log->toArray();
        // $countpenomoran = IzinHelper::countPenomoran(904);
        // $countpenomoran = $countpenomoran + IzinHelper::countPenomoran(915);

        $izinprinsip = array();
        // $izinprinsip = new IzinPrinsip();
        $izinprinsip = Izin::whereIn('status_checklist', [804, 8041, 704, 99903]);
        if ($izinprinsip->count() > 0) { //handle paginate error division by zero
            $izinprinsip = $izinprinsip->paginate($limit_db);
        } else {
            $izinprinsip = $izinprinsip->get();
        }
        $paginate = $izinprinsip;
        $izinprinsip = $izinprinsip->toArray();
        // $countip = count($izinprinsip);
        $countip = $common->countIP(804);
        $countip = $countip + $common->countIP(8041);
        $countip = $countip + $common->countIP(805);
        $countip = $countip + $common->countIP(704);
        $countip = $countip + $common->countIP(99903);
        // dd( $countip);

        $izintelsus = array();
        // $izintelsus = new IzinPrinsip();
        $izintelsus = Izin::where('status_checklist', '=', 805);
        if ($izintelsus->count() > 0) { //handle paginate error division by zero
            $izintelsus = $izintelsus->paginate($limit_db);
        } else {
            $izintelsus = $izintelsus->get();
        }
        $paginate = $izintelsus;
        $izintelsus = $izintelsus->toArray();
        // dd($izintelsus);
        $countizintelsus = $common->countIzinTelsus(805);
        $countip = $countip + $countizintelsus;

        // dd($ulo_full,$penomoran,$izinprinsip);
        return
            view('layouts.backend.direktur.dashboard', [
                'log' => $log, 'date_reformat' => $date_reformat, 'ulo' => $ulo_full, 'countulo' => $countulo, 'penomoran' =>
                $penomoran, 'countpenomoran' => $countevaluasi, 'izinprinsip' => $izinprinsip, 'countip' => $countip,
                'izintelsus' => $izintelsus, 'countizintelsus' =>
                $countizintelsus
            ]);
        // return view('layouts.backend.direktur.dashboard',['date_reformat'=>$date_reformat,'ulo'=>$ulo,'countulo'=>$countulo]);


    }

    public function ulo(Request $request)
    {
        $date_reformat = new DateHelper();
        $paginate = array();
        $common = new CommonHelper();
        $id_jabatan = Session::get('id_jabatan');
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');
        $ulo = array();
        $ulo = new Ulo();
        $ulo_full = $ulo->view_ulo($id_departemen_user, 'EMPTY', $id_jabatan);


        // if ($ulo_full->count() > 0) { //handle paginate error division by zero
        //     $ulo_full = $ulo_full->paginate($limit_db);
        // }else{
        //     $ulo_full = $ulo_full->get();
        // }
        $ulo_full = $ulo_full->paginate($limit_db);
        // dd($ulo_full);

        $paginate = $ulo_full;
        $ulo_full = $ulo_full->toArray();
        $countulo = $common->countUlo(904);
        return view('layouts.backend.direktur.dashboard-ulo', ['date_reformat' => $date_reformat, 'paginate' => $paginate, 'ulo' => $ulo_full, 'countulo' => $countulo]);
    }

    public function penetapanUlo($id_izin, $urut, Request $request)
    {
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);

        if ($ulo == null) {
            return abort(404);
        }
        $ulo = $ulo->toArray();
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];

        $penanggungjawab = array();
        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id_izin)->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);

        foreach ($map_izin as $key => $value) {
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                }
            }
        }
        // dd($ulo);
        return view('layouts.backend.direktur.penetapan-ulo', ['date_reformat' => $date_reformat, 'id' => $id_izin, 'ulo' => $ulo, 'detailnib' => $detailNib, 'map_izin' => $map_izin, 'penanggungjawab' => $penanggungjawab]);
    }

    public function penetapanIP($id_izin, Request $request)
    {
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        // / $izinprinsip = array();
        // $izinprinsip = new IzinPrinsip();
        $izinprinsip = Izin::select('*')->where('id_izin', '=', $id_izin)->first();

        if ($izinprinsip == null) {
            return abort(404);
        }
        // $izinprinsip = $izinprinsip->toArray();
        $nib = $izinprinsip['nib'];
        $kd_izin = $izinprinsip['kd_izin'];

        $penanggungjawab = array();
        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id_izin)->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        $need_correction_all = 0;
        foreach ($map_izin as $key => $value) {
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                    if ($value2->need_correction == '1') {
                        $need_correction_all = 1;
                    }
                }
            }
        }

        $map_izin_pre = array();
        $filled_persyaratan_pre = array();

        $mst_kode_izin_pre = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', '059000010066')->first();
        $id_mst_izinlayanan_pre = $mst_kode_izin_pre->id;

        $filled_persyaratan_pre = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $izinprinsip['id_proyek'])->get();
        if ($filled_persyaratan_pre->count() > 0) {
            $filled_persyaratan_pre = $filled_persyaratan_pre->toArray();
        }

        $map_izin_pre = $common->get_map_izin($id_mst_izinlayanan_pre);

        foreach ($map_izin_pre as $key => $value) {
            $map_izin_pre[$key] = $value;
            foreach ($filled_persyaratan_pre as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin_pre[$key]->form_isian = $value2->filled_document;
                    $map_izin_pre[$key]->nama_asli = $value2->nama_file_asli;
                    if ($value2->need_correction == '1') {
                        $need_correction_all = 1;
                    }
                }
            }
        }

        return view(
            'layouts.backend.direktur.penetapan-ip',
            [
                'need_correction_all' => $need_correction_all, 'date_reformat' => $date_reformat, 'id' => $id_izin, 'izinprinsip'
                => $izinprinsip, 'detailnib' => $detailNib, 'map_izin' => $map_izin, 'map_izin_pre' => $map_izin_pre,
                'penanggungjawab' => $penanggungjawab
            ]
        );
    }

    public function penetapanIPPost($id, Request $request)
    {
        // dd($request);
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.direktur.ulo');
        }

        $izinprinsip = Izin::select('*')->where('id_izin', '=', $id_izin)->first();

        if (empty($izinprinsip)) {
            return abort(404);
        }

        // $izinprinsip = $izinprinsip->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $izinprinsip['id_izin'])
            ->first();
        $nib = $izinprinsip['nib'];
        $kd_izin = $izinprinsip['kd_izin'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        // dd($izinprinsip->all());
        $izin = Izin::select('*')->where('id_izin', '=', $id)
            ->whereIn('status_checklist', [704, 804, 8041, 99903])->first();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($izinprinsip['nib']);
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        // dd($ulo['id']);

        DB::beginTransaction();

        // try {
        $data = $request->all();
        $userbo = Session::get('nama');
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first(); //set status checklist telah didisposisi
        $catatan = $catatan_hasil_evaluasi;
        //insert log
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan);
        //
        $id_izinprinsip = $izinprinsip['id'];
        // $uloSave = $izinprinsipToLog;
        $updateIzinPrinsip = Izinoss::select('*')->where('id_izin', '=', $id_izin)->first();

        //insert log
        // $insertUloLog = $log->createUloLog($uloToLog,$catatan,50);
        if ($updateIzinPrinsip['status_checklist'] == '99903') {
            $updateIzinPrinsip->status_checklist = 90;
            $updateIzinPrinsip->updated_at = date('Y-m-d H:i:s');
            $updateIzinPrinsip->save();
            // dd($updateIzinPrinsip['status_checklist']);
        } else {
            if (isset($updateIzinPrinsip['id_proyek'])) {
                $updateIzinPrinsip_pre = TrxIzinPrinsip::select('*')->where('id_trx_izin', '=', $updateIzinPrinsip['id_proyek'])->first();

                $updateIzinPrinsip_pre->tgl_berlaku = date('Y-m-d');
                $updateIzinPrinsip_pre->updated_date = date('Y-m-d H:i:s');
                $updateIzinPrinsip_pre->updated_by = $userbo;
                $updateIzinPrinsip_pre->save();

                $updateIzin_pre = Izinoss::select('*')->where('id_izin', '=', $updateIzinPrinsip['id_proyek'])->first();
                $updateIzin_pre->status_checklist = 52;
                $updateIzin_pre->updated_at = date('Y-m-d H:i:s');
                $updateIzin_pre->save();
            }
            if ($updateIzinPrinsip['kd_izin'] == '059000040066') {
                $check_izinprinsip_pre = DB::table('vw_izinprinsip_derivative')->select('*')
                    ->where('vw_izinprinsip_derivative.id_izin_prinsip', '=', $updateIzinPrinsip['id_proyek'])->first();
                if (isset($check_izinprinsip_pre->no_izin_prinsip_ext)) {
                    $updateIzinPrinsip_pre = TrxIzinPrinsip::select('*')->where(
                        'id_trx_izin',
                        '=',
                        $check_izinprinsip_pre->id_izin_prinsip_ext
                    )->first();
                    $updateIzinPrinsip_pre->tgl_berlaku = date('Y-m-d');
                    $updateIzinPrinsip_pre->updated_date = date('Y-m-d H:i:s');
                    $updateIzinPrinsip_pre->updated_by = $userbo;
                    $updateIzinPrinsip_pre->save();

                    $updateIzin_ext = Izinoss::select('*')->where(
                        'id_izin',
                        '=',
                        $check_izinprinsip_pre->id_izin_prinsip_ext
                    )->first();
                    $updateIzin_ext->status_checklist = 94;
                    $updateIzin_ext->updated_at = date('Y-m-d H:i:s');
                    $updateIzin_ext->save();


                    $updateIzinPrinsip_init = Izinoss::select('*')->where(
                        'id_izin',
                        '=',
                        $updateIzinPrinsip['id_proyek']
                    )->first();
                    $updateIzinPrinsip_init->status_checklist = 93;
                    $updateIzinPrinsip_init->updated_at = date('Y-m-d H:i:s');
                    $updateIzinPrinsip_init->save();
                } else {
                    // $updateIzinPrinsip_pre = TrxIzinPrinsip::select('*')->where('id_trx_izin', '=',
                    //     $updateIzinPrinsip['id_proyek'])->first();
                    $updateIzin_pre = Izinoss::select('*')->where(
                        'id_izin',
                        '=',
                        $updateIzinPrinsip['id_proyek']
                    )->first();
                    $updateIzin_pre->status_checklist = 93;
                    $updateIzin_pre->updated_at = date('Y-m-d H:i:s');
                    $updateIzin_pre->save();

                    $updateIzinPrinsip_pre = TrxIzinPrinsip::select('*')->where(
                        'id_trx_izin',
                        '=',
                        $check_izinprinsip_pre->id_izin_prinsip_ext
                    )->first();
                    $updateIzinPrinsip_pre->tgl_berlaku = date('Y-m-d');
                    $updateIzinPrinsip_pre->updated_date = date('Y-m-d H:i:s');
                    $updateIzinPrinsip_pre->updated_by = $userbo;
                    $updateIzinPrinsip_pre->save();
                }

                $updateIzinPrinsip->status_checklist = 54;
            } else {
                $updateIzinPrinsip->status_checklist = 51;
            }

            $updateIzinPrinsip->updated_at = date('Y-m-d H:i:s');
            $updateIzinPrinsip->save();
            // dd($updateIzinPrinsip);
        }
        $vw_izin = DB::table('vw_izinprinsip_derivative')->select('*')->get();
        $data = DB::table('vw_list_izin as i')
            ->select(
                'i.nib',
                'i.status_badan_hukum',
                'i.id_izin',
                'i.id_proyek',
                'i.kbli',
                'i.kbli_name',
                'i.nama_perseroan',
                'i.full_kbli',
                'i.jenis_izin',
                'i.kd_izin',
                'i.jenis_layanan',
                'i.jenis_layanan_html',
                'i.kabupaten_name',
                'i.no_izin',
                'i.provinsi_name',
                'i.nama_master_izin',
                'vw_izinprinsip_derivative.tgl_izin_prinsip_init',
                'vw_izinprinsip_derivative.no_izin_prinsip',
                'vw_izinprinsip_derivative.tgl_izin_prinsip_ext_init',
                'vw_izinprinsip_derivative.no_izin_prinsip_ext',
                'i.no_izinprinsip',
                'i.submitted_date'
            )
            ->leftjoin('vw_izinprinsip_derivative', 'vw_izinprinsip_derivative.id_izin_prinsip', '=', 'i.id_proyek')
            ->where('i.id_izin', '=', $id_izin)
            ->first();
        // dd($data,$vw_izin);



        // dd($updateIzinPrinsip['kd_izin']);
        // if ($updateIzinPrinsip['kd_izin'] == '059000030066') {
        //     $noizinprinsip = DB::table('latest_izinprinsipno_0303')->first();
        // } else {
        //     $noizinprinsip = DB::table('latest_izinprinsipno_0301')->first();
        // }


        // $insert = new TrxIzinPrinsip([
        //     'id_trx_izin' => $izin['id_izin'],
        //     'no_izin_prinsip' => $noizinprinsip->izinprisipno,
        //     'iterasi_perpanjangan' => '0',
        //     'tgl_berlaku' => Carbon::now()->addYear()->format('Y-m-d'),
        //     'tgl_berlaku_init' => Carbon::now()->format('Y-m-d'),
        //     'created_by' => $userbo,
        //     'created_date' => Carbon::now()->format('Y-m-d'),
        //     'updated_by' => $userbo,
        //     'updated_date' => Carbon::now()->format('Y-m-d'),

        // ]); 

        // $insert->save();

        // $putfile = $this->putFileSK($id);

        //penanggungjawab dan kirim email
        DB::commit();
        if ($updateIzinPrinsip['status_checklist'] != 90) {
            // dd($updateIzinPrinsip['nib']);
            $email_data = array();
            $email_data_subkoordinator = array();
            $putfile = $this->putFileSKIP($id_izin);
            $attachfile = '';
            if ($putfile != null) {
                $attachfile = $putfile;
                DB::table('tb_trx_ulo_sk')->insert(
                    ['id_izin' => $id, 'path_sk_ulo' => $putfile, 'created_by' => Session::get('id_user'), 'created_at' => date('Y-m-d H:i:s'), 'is_active' => 1]
                );
            }
            if ($updateIzinPrinsip['kd_izin'] == '059000040066') {
                session()->flash('message', 'Berhasil Menerbitkan Surat Penetapan Pencabutan Izin Prinsip');
            } else {
                session()->flash('message', 'Berhasil Menerbitkan Surat Penetapan Izin Prinsip');
            }

            $email_jenis = 'evaluasi-direktur-izinprinsip';

            $nama2 = $evaluator->nama;
            $departemen = '';
            // dd($izin);
            $kirim_email = $email->kirim_email(
                $penanggungjawab,
                $email_jenis,
                $izin,
                $departemen,
                $catatan_hasil_evaluasi,
                $nama2,
                $nibs,
                $koreksi_all,
                $attachfile,
                '',
                '',
                ''
            );
            DB::commit();
        } else {
            session()->flash('message', 'Berhasil Menolak Permohonan Penetapan Izin Prinsip');
            $email_jenis = 'tolak-pj-ip';
            $attachfile = '';

            $nama2 = $evaluator->nama;
            $departemen = '';
            $catatan_koreksi = DB::table('vw_koreksi_persyaratan')->where('id_trx_izin', '=', $id_izin)->get();
            // dd($izin);
            $kirim_email = $email->kirim_email_tolak(
                $penanggungjawab,
                $email_jenis,
                $izin,
                $departemen,
                $catatan_hasil_evaluasi,
                $nama2,
                $nibs,
                $koreksi_all,
                $attachfile,
                '',
                '',
                '',
                $catatan_koreksi
            );
            DB::commit();
            // dd($updateIzinPrinsip['status_checklist']);
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.direktur');
    }

    public function penetapanUloPost($id, $urut, Request $request)
    {
        // dd($request);
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.direktur.ulo');
        }

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $urut, $id_jabatan);
        if (empty($ulo)) {
            return abort(404);
        }

        $ulo = $ulo->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $ulo['id_izin'])
            ->first();
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();

        $Izinoss = Izinoss::where('id_izin', '=', $id)->first();

        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        // dd($ulo['id']);

        DB::beginTransaction();

        // try {
        $data = $request->all();
        //
        $id_ulo = $ulo['id'];
        $uloToLog = Ulo::select('*')
            ->where('id', '=', $urut)
            ->where('is_active', '=', '1')
            ->first();
        $uloSave = $uloToLog;

        //insert log
        $status_ulo = 50;
        $catatan = $catatan_hasil_evaluasi;
        $insertUloLog = $log->createUloLog($uloToLog, $catatan, $status_ulo);


        $Izinoss = Izinoss::where('id_izin', '=', $id)->first(); //set status checklist telah didisposisi
        $catatan = $catatan_hasil_evaluasi;
        //insert log
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan);
        $Izinoss->status_checklist = 50;
        // dd($koreksi_all);
        $Izinoss->updated_at = date('Y-m-d H:i:s');
        // dd($Izinoss['kd_izin']);
        $Izinoss->save();
        // dd($uloSave);
        $uloSave->status_ulo = $status_ulo;
        $uloSave->updated_date = date('Y-m-d H:i:s');
        // $uloSave->nomor_sklo = $nomor_sklo;
        $path = 'app/public/sk_ulo/sk-ulo-' . $id . '.pdf';
        $uloSave->path_sk_ulo = $path;
        $uloSave->tgl_berlaku_ulo = date('Y-m-d H:i:s');
        // $uloSave->status_sk_ulo = 1;
        $uloSave->save();

        // if(){

        // }
        $putfile = $this->putFileSK($id, $urut);

        // dd($ulo['nama_master_izin']);
        if ($ulo['nama_master_izin'] !== 'TELSUS') {
            if ($Izinoss['kd_izin'] != '059000020066') {
                $putfile2 = $this->putFileSKPenetapan($id, $urut);
            }
        }
        if ($Izinoss['kd_izin'] == '059000020066') {
            $putfile3 = $this->putFileSKIzinPenyelenggaraan($id, $urut);
        }

        // $datenow = Carbon::now();
        // $common = new CommonHelper;

        // $datenow = $datenow->year;
        // $tengah = 'Tel.04.02';
        // $noUrutAkhir = Ulo::max('nomor_sklo');
        // if($noUrutAkhir) {
        //     $nomor_sklo = sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        // }


        // dd($uloSave, $putfile);
        //penanggungjawab dan kirim email
        $email_data = array();
        $email_data_subkoordinator = array();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $attachfile = '';
        if (isset($putfile)) {
            $attachfile = $putfile;
            DB::table('tb_trx_ulo_sk')->insert(
                ['id_izin' => $id, 'path_sk_ulo' => $putfile, 'created_by' => Session::get('id_user'), 'created_at' => date('Y-m-d H:i:s'), 'is_active' => 1]
            );
        }

        $attachfile2 = '';
        if (isset($putfile2)) {
            $attachfile2 = $putfile2;
            DB::table('tb_trx_komitmen_sk')->insert(
                ['id_izin' => $id, 'path_sk_ulo' => $putfile2, 'created_by' => Session::get('id_user'), 'created_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'jenis_sk' => 'Penetapan']
            );
        }

        $attachfile3 = '';
        if (isset($putfile3)) {
            $attachfile3 = $putfile3;

            $updatepathip =
                DB::table('tb_trx_ulo_sk')->select('*')->where('id_izin', '=', $id)
                ->where('path_sk_ulo', 'like', '%sk-ip%')
                ->update([
                    'path_sk_izinpenyelenggaraan' => $putfile3
                ]);
        }
        DB::commit();


        $email_jenis = 'penetapan-sk-ulo';
        $nama2 = $evaluator->nama;
        // // dd($ulo);
        $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $ulo, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $attachfile, '', $attachfile2, $attachfile3);

        // $izin_final = [
        //     "nib" => $nibs['nib'],
        //     "id_produk" => $Izinoss->id_produk,
        //     "id_proyek" => $Izinoss->id_proyek,
        //     "oss_id" => $Izinoss->oss_id,
        //     "id_izin" => $Izinoss->id_izin,
        //     "kd_izin" => $Izinoss->kd_izin,
        //     "kd_daerah" => $Izinoss->kd_daerah,
        //     "kewenangan" => '',
        //     "nomor_izin" => '059',
        //     "tgl_terbit_izin" => '059',
        //     "tgl_berlaku_izin" => '059',
        //     "nama_ttd" => 'Sheriff Woody S.IP Msc',
        //     "nip_ttd" => '198901012016011100',
        //     "jabatan_ttd" => 'Direktur Telekomunikasi',
        //     "status_izin" => '50',
        //     "file_izin" => $attachfile,
        //     "keterangan" => 'License final',
        //     "file_lampiran" => $attachfile,
        //     "nomenklatur_nomor_izin" => '',
        //     "bln_berlaku_izin" => '',
        //     "thn_berlaku_izin" => '',
        //     "data_pnbp" => [
        //         "kd_akun" => '',
        //         "kd_penerimaan" => '',
        //         "nominal" => '',
        //         ]
        //     ];

        //     $osshub = new Osshub();
        //     $licenseStatus = $osshub->sendIzinFinal($izin_final);

        session()->flash('message', 'Berhasil Menerbitkan Surat Keterangan Laik Operasi');
        // } catch (\Exception $e) {
        //     // dd($e);
        //     DB::rollback();
        //     // throw ValidationException::withMessages(['message' => 'Gagal']);
        //     // session()->flash('message', 'Gagal Menerbitkan Surat Keterangan Laik Operasi');
        //     return Redirect::route('admin.direktur');
        // }
        // $map_izin = array();
        // $filled_persyaratan = array();

        // $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        // $id_mst_izinlayanan = $mst_kode_izin->id;

        // $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        // if ($filled_persyaratan->count() > 0) {
        //     $filled_persyaratan = $filled_persyaratan->toArray();
        // }
        // $map_izin = $common->get_map_izin($id_mst_izinlayanan);

        // foreach ($map_izin as $key => $value) {
        //     $map_izin[$key] = $value;
        //     foreach ($filled_persyaratan as $key2 => $value2) {
        //         if ($value->id == $value2->id_map_listpersyaratan) {
        //             $map_izin[$key]->form_isian = $value2->filled_document;
        //             $map_izin[$key]->nama_asli = $value2->nama_file_asli;
        //         }
        //     }
        // }

        return Redirect::route('admin.direktur');
        // return view('layouts.backend.direktur.penetapan-ulo',['date_reformat'=>$date_reformat,'id'=>$id,'ulo'=>$ulo,'detailnib'=>$nibs ,'map_izin'=>$map_izin,'penanggungjawab'=>$penanggungjawab]);
        // return Redirect::route('admin.direktur.ulo');
        // }catch (\Exception $e) {
        //     //     // dd($e);
        //         DB::rollback();
        //         // throw ValidationException::withMessages(['message' => 'Gagal']);
        //         session()->flash('message', 'Gagal Menerbitkan Surat Keterangan Laik Operasi');
        //         return Redirect::route('admin.direktur.ulo');
        // }
    }

    public function kirimSK($id, Request $request)
    {
        $common = new CommonHelper();
        $email = new EmailHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user, $id, $id_jabatan);


        $departemen = $common->getDepartemen($id_departemen_user);

        if (empty($ulo)) {
            return abort(404);
        }

        $ulo = $ulo->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $ulo['id_izin'])
            ->first();

        $komitmenSK = DB::table('tb_trx_komitmen_sk')->select('*')
            ->where('tb_trx_komitmen_sk.id_izin', '=', $ulo['id_izin'])
            ->where('tb_trx_komitmen_sk.jenis_sk', '=', 'Penetapan')
            ->first();
        // dd($id_departemen_user,$id,$id_jabatan,$ulo,$komitmenSK);
        if (empty($komitmenSK)) {
            return abort(404);
        }

        $koreksi_all = 0;
        $nib = $ulo['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $ulo['id_izin'])
            ->first();
        $attachfile = $ulo['path_sk_ulo'];
        $attachfile2 = $komitmenSK->path_sk_ulo;
        $attachfile3 = $ulo['path_sk_izinpenyelenggaraan'];
        $nama2 = $evaluator->nama;
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $email_jenis = 'penetapan-sk-ulo';
        DB::beginTransaction();
        try {
            $kirim_email = $email->kirim_email(
                $penanggungjawab,
                $email_jenis,
                $ulo,
                $departemen,
                '',
                $nama2,
                $nibs,
                $koreksi_all,
                $attachfile,
                '',
                $attachfile2,
                $attachfile3
            );
            $ulo_updated = DB::table('tb_trx_ulo')
                ->where(['id' => $id])
                ->update(
                    ['status_sk_ulo' => 1, 'updated_date' => date('Y-m-d H:i:s')]
                );
            DB::commit();
            session()->flash('message', 'Berhasil Mengirimkan Surat Keterangan Laik Operasi');
        } catch (\Exception $e) {
            //     // dd($e);
            DB::rollback();
            throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Menerbitkan Surat Keterangan Laik Operasi');
            return Redirect::route('admin.direktur');
        }

        return Redirect::route('admin.direktur.ulo');
    }

    private function putFileSK($id_izin, $urut)
    {
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        // $noUrutAkhir = Ulo::select('nomor_sklo_fixed')->where('id_izin','=',$id_izin)->first;

        //     $nomor_sklo = $noUrutAkhir->nomor_sklo_fixed;

        $data2 = Ulo::from('tb_trx_ulo as u')->select(
            'ip.no_izin_prinsip',
            'ip.tgl_izin_prinsip_init',
            'ip.no_izin_prinsip_ext',
            'ip.tgl_izin_prinsip_ext_init',
            'ip.no_izin_penyelenggaraan',
            'ip.no_sk_ulo',
            'ip.tgl_izin_prinsip_ulo',
            'u.*',
            'i.id_proyek',
            'i.nib',
            'i.kbli',
            'i.kbli_name',
            'i.nama_perseroan',
            'i.full_kbli',
            'i.jenis_izin',
            'i.kd_izin',
            'i.jenis_layanan',
            'i.jenis_layanan_html',
            'i.kabupaten_name',
            'i.no_izin',
            'i.provinsi_name',
            'i.nama_master_izin'
        )
            ->leftjoin('vw_list_izin as i', 'u.id_izin', '=', 'i.id_izin')
            // ->leftjoin('vw_izinprinsip_pathsk as ip', 'ip.id_izin_prinsip', '=', 'i.id_proyek')
            ->leftjoin('vw_izinprinsip_derivative as ip', 'ip.id_izin_prinsip', '=', 'i.id_proyek')
            ->where('u.id_izin', '=', $id_izin)
            ->where('u.id', '=', $urut)
            ->where('u.is_active', '=', '1')
            ->first()->toArray();
        $nib = $data2['nib'];
        $dataNib = Nib::where('nib', $nib)->first();
        $dataNib = $dataNib->toArray();
        $date_reformat = new DateHelper();
        // dd($date_reformat);
        $map_izin = array();
        $filled_persyaratan = array();
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $data2['kd_izin'])->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $data2['id_izin'])->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);

        foreach ($map_izin as $key => $value) {
            // if($value->file_type == "table"){
            // echo $value->file_type;
            // echo "<br>============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                }
            }
            // }
        }

        $map_izin_pre = array();
        $filled_persyaratan_pre = array();

        $mst_kode_izin_pre = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', '059000010066')->first();
        $id_mst_izinlayanan_pre = $mst_kode_izin_pre->id;

        $filled_persyaratan_pre = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $data2['id_proyek'])->get();
        if ($filled_persyaratan_pre->count() > 0) {
            $filled_persyaratan_pre = $filled_persyaratan_pre->toArray();
        }

        $map_izin_pre = $common->get_map_izin($id_mst_izinlayanan_pre);

        foreach ($map_izin_pre as $key => $value) {
            $map_izin_pre[$key] = $value;
            foreach ($filled_persyaratan_pre as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin_pre[$key]->form_isian = $value2->filled_document;
                    $map_izin_pre[$key]->nama_asli = $value2->nama_file_asli;
                    if ($value2->need_correction == '1') {
                        $need_correction_all = 1;
                    }
                }
            }
        }

        // return view('layouts.backend.direktur.mypdf', $data);
        if ($data2['nama_master_izin'] == "TELSUS") {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-telsus', ['map_izin' => $map_izin, 'data' => $data2, 'datanib' => $dataNib, 'date_reformat' => $date_reformat]);
        } elseif ($data2['nama_master_izin'] == "TELSUS_INSTANSI") {
            if (isset($data2['no_izin_prinsip_ext'])) {
                $pdf = PDF::loadView('layouts.backend.sk.cetak_sklo_ext', ['map_izin' => $map_izin, 'data' => $data2, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'map_izin_pre' => $map_izin_pre]);
            } else {
                $pdf = PDF::loadView('layouts.backend.sk.cetak_sklo_noext', [
                    'map_izin' => $map_izin, 'data' => $data2,
                    'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'map_izin_pre' => $map_izin_pre
                ]);
            }
        } else {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-ulo', ['data' => $data2, 'datanib' => $dataNib, 'date_reformat' => $date_reformat]);
        }
        $pdf->render();

        $output = $pdf->output();
        // dd($output);
        $path = 'app/public/sk_ulo/sk-ulo-' . $id_izin . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }

    public function skUlo(Request $request)
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $skquery = Skulo::select('*')->leftjoin('vw_list_izin', 'tb_trx_ulo_sk.id_izin', '=', 'vw_list_izin.id_izin');
        $sk = array();
        if ($skquery->count() > 0) { //handle paginate error division by zero
            $sk = $skquery->paginate($limit_db);
        } else {
            $sk = $skquery->get();
        }

        $paginate = $sk;
        $sk = $sk->toArray();

        return view('layouts.backend.direktur.dashboard-sk-ulo', ['date_reformat' => $date_reformat, 'sk' => $sk, 'paginate' => $paginate]);
    }

    public function lihatSK($id, Request $request)
    {
        $date_reformat = new DateHelper();
        $sk = Skulo::where('id_izin', '=', $id)->where('is_active', '=', 1)->first();
        $id_jabatan = Session::get('id_jabatan');

        if ($sk->count() == 0) {
            return abort(404);
        }
        if ($id_jabatan != 1) {
            return abort(404);
        }

        $path = storage_path($sk->path_sk_ulo);

        if (!file_exists($path)) {
            return abort(404);
        }

        return response()->file($path);
    }

    public function penomoran(Request $request)
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');

        $penomoran = Penomoran::from('tb_trx_kode_akses as t')
            ->select(
                't.id as id_kode_akses',
                't.*',
                'v.*',
                'y.kode_akses',
                'x.kode_akses as bloknomor_list'
            )
            ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->leftjoin('tb_trx_kode_akses_alokasi as y', 't.id_mst_kode_akses', '=', 'y.id')
            ->leftjoin('vw_kodeakses_bloknomor as x', 't.id_izin', '=', 'x.id_izin')
            // ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
            ->with('KodeIzin')->with('KodeAkses')->take($limit_db);
        $penomoran = $penomoran->whereIn('t.status_permohonan', [904, 915]);

        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        } else {
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        $penomoran = $penomoran->toArray();

        $countpenomoran = IzinHelper::countPenomoran(904) + IzinHelper::countPenomoran(915);

        // dd($penomoran);

        return view('layouts.backend.direktur.dashboard-penomoran', ['date_reformat' => $date_reformat, 'paginate' => $paginate, 'penomoran' => $penomoran, 'countpenomoran' => $countpenomoran]);
    }

    public function penetapanPenomoran($id, $id_kodeakses, Request $request)
    {
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 904;
        $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $id)->get()->toArray();
        $vw_kodeakses_additional = vw_kodeakses_adds::where(
            'id_izin',
            '=',
            $id
        )->get();
        $vw_kodeakses_additional_count = $vw_kodeakses_additional->count();
        $vw_kodeakses_additional = $vw_kodeakses_additional->toArray();
        $vw_kodeakses_additional_nonarray = vw_kodeakses_adds::where(
            'id_izin',
            '=',
            $id
        )
            ->get();
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->where('t.id', '=', $id_kodeakses)
            ->whereIn('t.status_permohonan', [$status_penomoran, 915])
            ->with('KodeIzin')->with('KodeAkses')
            ->first();

        if ($penomoran == null) {
            return abort(404);
        }
        $penomoran = $penomoran->toArray();
        $id_mst_kode_akses = isset($penomoran['id_mst_kode_akses']) ? $penomoran['id_mst_kode_akses'] : '';
        $vw_kodeakses_additional = vw_kodeakses_adds::where(
            'id_izin',
            '=',
            $id
        )->get()->toArray();
        $penomoran = $common->getDetailKodeAkses($penomoran, $id_mst_kode_akses);

        $note = $penomoran['jenis_permohonan'] . ' (' . $penomoran['note'] . ')';
        $map = $common->getMapKodeAkses($id_mst_kode_akses);
        $nib = $penomoran['nib'];

        $detailNib = $common->get_detail_nib($nib);

        $penanggungjawab = array();
        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $penomoranlog = Penomoranlog::where('id_izin', '=', $id)
            // ->where('id_kode_akses','=',$id_kodeakses)
            ->with('KodeIzin')->get()->toArray();

        return view('layouts.backend.direktur.penetapan-penomoran', [
            'date_reformat' => $date_reformat, 'id' => $id,
            'penomoran' => $penomoran, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map' => $map,
            'penomoranlog' => $penomoranlog,
            'penomoran_bloknomor' => $penomoran_bloknomor, 'vw_kodeakses_additional' => $vw_kodeakses_additional,
            'vw_kodeakses_additional_nonarray' =>
            $vw_kodeakses_additional_nonarray, 'vw_kodeakses_additional_count' => $vw_kodeakses_additional_count,
            'note' => $note
        ]);
    }

    public function penetapanPenomoranPost($id, $id_kodeakses, Request $request)
    {
        // dd($request->all());
        $date_reformat = new DateHelper();
        $flag_cabut = 0;
        $flag_tetap = 0;
        $putfile2 = NULL;
        $concatenated_izin = '';
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.direktur.penomoran');
        }

        $status_penomoran = 904;
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->where('t.id', '=', $id_kodeakses)
            ->whereIn('t.status_permohonan', [$status_penomoran, 915])
            ->with('KodeIzin')->with('KodeAkses')->first();

        // $penomoran_alokasi = DB::table('tb_trx_kode_akses_alokasi as t')->select('t.*')
        // ->where('t.id','=',$penomoran->id_mst_kode_akses)
        // // ->whereIn('t.status_permohonan',[$status_penomoran,915])
        // ->first();
        // dd($penomoran->id_mst_kode_akses,$id_kodeakses,$penomoran_alokasi);
        if (empty($penomoran)) {
            return abort(404);
        }
        // if (empty($penomoran_alokasi)) {
        // return abort(404);
        // }

        $penomoran = $penomoran->toArray();
        // dd($penomoran);
        // $penomoran_alokasi = $penomoran_alokasi->toArray();
        $nib = $penomoran['nib'];
        $kd_izin = $penomoran['kd_izin'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $data = $request->all();

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();

        // try {
        //
        $penomoranid = $penomoran['id'];
        $penomorans = Penomoran::where('id', '=', $id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first();
        $status_penomoran_update = 50;


        $penomorans->updated_by = Session::get('nama');
        $penomorans->updated_date = date('Y-m-d H:i:s');
        $penomorans->effective_date = date('Y-m-d H:i:s');
        $penomorans->status_permohonan = $status_penomoran_update;
        $penomorans->save();

        // $penomoran_alokasi->status = "Aktif";
        // $penomoran_alokasi->save();
        // dd($penomoran['jenis_permohonan']);
        if (
            $penomoran['jenis_permohonan'] == 'Pengembalian Penomoran' || $penomoran['jenis_permohonan'] ==
            'Perubahan Penetapan'
        ) {
            $ls_nomor = vw_penomoran_req_detail::where(
                'id_izin',
                '=',
                $penomoran['id_izin']
            )->get();
            // dd($penomoran['jenis_permohonan'],$ls_nomor);
            // $no_izin_latest_penetapanpencabutan = DB::table('latest_nomor_0506')->select('*')->first();
            // $no_izin_latest_penetapanulang = DB::table('latest_nomor_0505')->select('*')->first();
            // $no_izin_cabut = $no_izin_latest_penetapanpencabutan->izinpenomoran;
            // $no_izin_ulang = $no_izin_latest_penetapanulang->izinpenomoran;
            $penomoran_kodeakses =
                DB::table('vw_penomoran_raw_additional')->where('id_izin', '=', $penomoran['id_permohonan'])->get()->toArray();
            // dd($penomoran_kodeakses);
            foreach ($penomoran_kodeakses as $key => $value) {
                $no_izin_latest_penetapanpencabutan = DB::table('latest_nomor_0506')->select('*')->first();
                $no_izin_latest_penetapanulang = DB::table('latest_nomor_0505')->select('*')->first();
                $no_izin_cabut = $no_izin_latest_penetapanpencabutan->izinpenomoran;
                $no_izin_ulang = $no_izin_latest_penetapanulang->izinpenomoran;
                // dd()
                if ($value->kode_akses_status == 'NONBN') {
                    if ($value->jenis_permohonan == 'Pencabutan') {
                        $penomoran_alokasi =
                            DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                                'id',
                                '=',
                                $value->id_mst_kode_akses
                            )->update([
                                'status' => 'Idle', 'id_mst_kodestatusizin' => NULL, 'nomor_penetapan' => NULL, 'tanggal_penetapan' => NULL, 'nib' => NULL, 'nama_pelakuusaha' => NULL
                            ]);
                        // $flag_cabut = 1;
                        $concatenated_izin .= $no_izin_cabut . ', ';
                        $insert = new SK_Penomoran([
                            'id_izin' => $penomoran['id_izin'],
                            'kode_akses' => $value->kode_akses,
                            'jenis_permohonan' => $value->jenis_permohonan,
                            'no_sk' => $no_izin_cabut,
                            'tgl_sk' => Carbon::now()->format('Y-m-d'),
                            // 'file_sk' => Carbon::now()->format('Y-m-d'),
                            'created_by' => Session::get('nama'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'updated_date' => date('Y-m-d H:i:s'),

                        ]);

                        $insert->save();
                    } else {
                        $penomoran_alokasi =
                            DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                                'id',
                                '=',
                                $value->id_mst_kode_akses
                            )->update([
                                'status' => 'Aktif', 'id_mst_kodestatusizin' =>
                                '914', 'nomor_penetapan' => $no_izin_ulang, 'tanggal_penetapan' => date('Y-m-d H:i:s'),
                                'nib' => $nib, 'nama_pelakuusaha' => $nibs['nama_perseroan']
                            ]);
                        // $flag_tetap = 1;
                        $concatenated_izin .= $no_izin_ulang . ', ';
                        $insert = new SK_Penomoran([
                            'id_izin' => $penomoran['id_izin'],
                            'kode_akses' => $value->kode_akses,
                            'jenis_permohonan' => $value->jenis_permohonan,
                            'no_sk' => $no_izin_ulang,
                            'tgl_sk' => Carbon::now()->format('Y-m-d'),
                            // 'file_sk' => Carbon::now()->format('Y-m-d'),
                            'created_by' => Session::get('nama'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_by' => Session::get('nama'),
                            'updated_date' => date('Y-m-d H:i:s'),

                        ]);

                        $insert->save();
                    }
                } elseif ($value->kode_akses_status == 'BN') {
                    $penomoran_alokasi =
                        DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                            'id_izin',
                            '=',
                            $value['id_izin']
                        )->where(
                            'is_active',
                            '=',
                            1
                        )->update([
                            'status' => 'Aktif', 'id_mst_kodestatusizin' =>
                            '914', 'nomor_penetapan' => $no_izin_ulang, 'tanggal_penetapan' => date('Y-m-d H:i:s'),
                            'nib' => $nib, 'nama_pelakuusaha' => $nibs->nama_perseroan
                        ]);
                    $flag_tetap = 1;
                    $concatenated_izin .= $no_izin_ulang . ', ';
                    $insert = new SK_Penomoran([
                        'id_izin' => $penomoran['id_izin'],
                        'kode_akses' => $value->kode_akses,
                        'jenis_permohonan' => $value->jenis_permohonan,
                        'no_sk' => $no_izin_ulang,
                        'tgl_sk' => Carbon::now()->format('Y-m-d'),
                        // 'file_sk' => Carbon::now()->format('Y-m-d'),
                        'created_by' => Session::get('nama'),
                        'created_date' => date('Y-m-d H:i:s'),
                        'updated_by' => Session::get('nama'),
                        'updated_date' => date('Y-m-d H:i:s'),

                    ]);

                    $insert->save();
                }
            }

            // foreach ($ls_nomor as $key => $value) {
            //     // dd($value['jenis_permohonan'],$ls_nomor);
            //     if ($value['jenis_permohonan'] == 'Penetapan Pencabutan') {
            //         $penomoran_alokasi =
            //             DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
            //                 'id',
            //                 '=',
            //                 $value['id_mst_kode_akses']
            //             )->update([
            //                 'status' => 'Idle', 'id_mst_kodestatusizin' => NULL, 'nomor_penetapan' => NULL, 'tanggal_penetapan' => NULL
            //             ]);
            //         $flag_cabut = 1;
            //         $insert = new SK_Penomoran([
            //             'id_izin' => $penomoran['id_izin'],
            //             'kode_akses' => $value['kode_akses'],
            //             'jenis_permohonan' => $value['jenis_permohonan'],
            //             'no_sk' => $no_izin_cabut,
            //             'tgl_sk' => Carbon::now()->format('Y-m-d'),
            //             // 'file_sk' => Carbon::now()->format('Y-m-d'),
            //             'created_by' => Session::get('nama'),
            //             'created_date' => date('Y-m-d H:i:s'),
            //             'updated_by' => Session::get('nama'),
            //             'updated_date' => date('Y-m-d H:i:s'),

            //         ]);

            //         $insert->save();
            //     } else {
            //         $penomoran_alokasi =
            //             DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
            //                 'id',
            //                 '=',
            //                 $value['id_mst_kode_akses']
            //             )->update([
            //                 'status' => 'Aktif', 'id_mst_kodestatusizin' =>
            //                 '914', 'nomor_penetapan' => $no_izin_ulang, 'tanggal_penetapan' => date('Y-m-d H:i:s')
            //             ]);
            //         $flag_tetap = 1;
            //         $insert = new SK_Penomoran([
            //             'id_izin' => $penomoran['id_izin'],
            //             'kode_akses' => $value['kode_akses'],
            //             'jenis_permohonan' => $value['jenis_permohonan'],
            //             'no_sk' => $no_izin_ulang,
            //             'tgl_sk' => Carbon::now()->format('Y-m-d'),
            //             // 'file_sk' => Carbon::now()->format('Y-m-d'),
            //             'created_by' => Session::get('nama'),
            //             'created_date' => date('Y-m-d H:i:s'),
            //             'updated_by' => Session::get('nama'),
            //             'updated_date' => date('Y-m-d H:i:s'),

            //         ]);

            //         $insert->save();
            //     }
            // }


            // dd($id, $penomoran, $id_kodeakses, $no_izin_cabut, $flag_cabut, $flag_tetap);
            // if ($flag_cabut == 1) {
            //     $putfile2 = $this->putFileSKPenomoranPencabutan($id, $penomoran, $id_kodeakses, $no_izin_cabut);
            // }
            // if ($flag_tetap == 1) {
            $putfile = $this->putFileSKPenomoran($id, $penomoran, $id_kodeakses, $no_izin_ulang);
            // }
            // dd($putfile2,$putfile);
        } else {
            // $no_izin_latest_penetapanpencabutan = DB::table('latest_nomor_0506')->select('*')->first();
            // $no_izin_latest_penetapanulang = DB::table('latest_nomor_0505')->select('*')->first();
            // $no_izin_cabut = $no_izin_latest_penetapanpencabutan->izinpenomoran;
            // $no_izin_ulang = $no_izin_latest_penetapanulang->izinpenomoran;
            $no_izin_latest = DB::table('latest_nomor_0505')->select('*')->first();
            $no_izin = $no_izin_latest->izinpenomoran;
            $penomoran_alokasi =
                DB::table('tb_trx_kode_akses_alokasi')->select('*')->where('id', '=', $penomoran['id_mst_kode_akses'])->update([
                    'status' => 'Aktif', 'nomor_penetapan' => $no_izin, 'tanggal_penetapan' => date('Y-m-d H:i:s'),
                    'nib' => $nib, 'nama_pelakuusaha' => $nibs['nama_perseroan']
                ]);
            $concatenated_izin .= $no_izin . ', ';
            $insert = new SK_Penomoran([
                'id_izin' => $penomoran['id_izin'],
                'kode_akses' => $penomoran['kode_akses']['kode_akses'],
                'jenis_permohonan' => $penomoran['jenis_permohonan'],
                'no_sk' => $no_izin,
                'tgl_sk' => Carbon::now()->format('Y-m-d'),
                // 'file_sk' => Carbon::now()->format('Y-m-d'),
                'created_by' => Session::get('nama'),
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => Session::get('nama'),
                'updated_date' => date('Y-m-d H:i:s'),

            ]);

            $insert->save();



            $putfile = $this->putFileSKPenomoran($id, $penomoran, $id_kodeakses, $no_izin);
        }
        //insert log
        //insert log
        $penomoranToLog = Penomoran::where('id', '=', $id_kodeakses)->first()->toArray();
        $insertPenomoranLog = $log->createPenomoranLog($penomoranToLog, $status_penomoran_update);
        // $no_izin = DB::table('latest_nomor_0505')->select('izinpenomoran')->get();

        // $izin = Izinoss::where('id_izin', '=', $id_izin)->first();
        // // dd($izin);
        // $izin->status_checklist = 50;
        // // $izin->updated_by = Session::get('nama');
        // $izin->updated_at = date('Y-m-d H:i:s');
        // $izin->save();
        // $izin->effective_date = date('Y-m-d H:i:s');



        //penanggungjawab dan kirim email
        $email_data = array();
        $email_data_subkoordinator = array();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $catatan_hasil_evaluasi = '';
        $koreksi_all = 0;
        $attachfile = '';
        $attachfile2 = '';
        $user = Session::get('username');
        if (isset($putfile)) {
            $attachfile = $putfile;
            DB::table('tb_trx_kode_akses')
                ->where(['id_izin' => $id, 'id' => $id_kodeakses])
                ->update(
                    ['path_sk_penomoran' => $putfile, 'updated_by' => $user, 'updated_date' => date('Y-m-d H:i:s')]
                );
            // $no_izin_latest = DB::table('latest_nomor_0505')->select('*')->first();
            // $no_izin = $no_izin_latest->izinpenomoran;


            $concatenated_izin = rtrim($concatenated_izin, ', ');

            $izin = Izinoss::where('id_izin', '=', $id_izin)->first();
            // dd($izin);

            if ($penomoran['jenis_permohonan'] == 'Pengembalian Penomoran') {
                $izin->status_checklist = 50;
            } else {
                $izin->status_checklist = 95;
            }
            $izin->tgl_izin = date('Y-m-d H:i:s');
            $izin->no_izin = $concatenated_izin;
            $izin->file_izin = $putfile;
            $izin->updated_at = date('Y-m-d H:i:s');
            $izin->save();

            DB::table('tb_trx_sk_penomoran')
                ->where(['id_izin' => $id])
                ->update(
                    ['file_sk' => $putfile, 'updated_by' => $user, 'updated_date' => date('Y-m-d H:i:s')]
                );
        }


        // $code = bin2hex(random_bytes(20));

        // UserSurvey::create([
        //     'id_izin' => $id,
        //     'code' => $code,
        //     'jenis_perizinan' => 2,
        //     'is_active' => 0,
        //     'created_by' => Session::get('id_user'),
        // ]);
        // dd($attachfile,$attachfile2);
        DB::commit();
        session()->flash('message', 'Berhasil Menerbitkan Surat Penetapan Penomoran');


        $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $id)
            ->first();
        // $email_jenis = 'penetapan-sk-penomoran';
        $nama2 = $evaluator->nama;

        if ($penomoran['jenis_permohonan'] == 'Pengembalian Penomoran') {
            $email_jenis = 'penetapan-sk-penomoran';
            $kirim_email = $email->kirim_email(
                $penanggungjawab,
                $email_jenis,
                $penomoran,
                $departemen,
                $catatan_hasil_evaluasi,
                $nama2,
                $nibs,
                $koreksi_all,
                $attachfile,
                '',
                '',
                ''
            );
        } else {
            $email_jenis = 'kirim-survei';
            $link = 'https://e-telekomunikasi.kominfo.go.id/survei/detail/' . $penomoran['id_izin'];
            $kirim_email = $email->kirim_email(
                $penanggungjawab,
                $email_jenis,
                $penomoran,
                $departemen,
                $catatan_hasil_evaluasi,
                $nama2,
                $nibs,
                $koreksi_all,
                '',
                $link,
                '',
                ''
            );
            // dd($link);
        }

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.direktur.penomoran');
    }

    public function pencabutanPenomoran($id_izin)
    {
        // dd($id_izin);
        // $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $date = new DateHelper();

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 915;

        $penomoran = DB::table('vw_penomoran_all as t')
            ->where('t.id_izin', '=', $id_izin);
        // $penomoran = $penomoran->where('t.status_permohonan', '=', $status_penomoran);

        $penomoran = $penomoran->first();
        if (empty($penomoran)) {
            return abort(404);
        }
        // $penomoran = $penomoran->toArray();
        // dd($penomoran);

        $date_reformat = new DateHelper();
        // $id = $penomoran_alokasi->id;
        // dd($penomoran_alokasi->id_mst_kode_akses);
        $penomoranlog = Penomoranlog::where('id_izin', '=', $id_izin)
            // ->where('id_kode_akses','=',$id_kodeakses)
            ->with('KodeIzin')->get()->toArray();
        // dd($penomoranlog);
        return view('layouts.backend.direktur.penetapan-pencabutan-penomoran', [
            'date_reformat' => $date_reformat, 'id' => $id_izin,
            'penomoran' => $penomoran, 'penomoranlog' => $penomoranlog
        ]);
    }

    public function pencabutanPenomoranPost($id_izin, Request $request)
    {

        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $koreksi_all = 0;
        $id_departemen_user = Session::get('id_departemen');
        $status_penomoran = 915;

        $penomoran_query = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses');

        $penomoran_query = $penomoran_query->where('t.status_permohonan', '=', $status_penomoran)->where(
            't.id_izin',
            '=',
            $id_izin
        );
        $penomoran_query = $penomoran_query->first();
        // dd($penomoran_query);
        if (empty($penomoran_query)) {
            return abort(404);
        }
        $penomoran = $penomoran_query->toArray();
        // dd($penomoran);
        $mst_kodeakses = $common->getDetailKodeAkses($penomoran, $penomoran['id_mst_kode_akses']);

        $getPenomoran = Penomoran::where('id_izin', '=', $id_izin)->where(
            'status_permohonan',
            '=',
            $status_penomoran
        )->with('KodeIzin')->with('KodeAkses')->first();

        if (empty($getPenomoran)) {
            return abort(404);
        }

        $data = $request->all();
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');
        $jenis_permohonan = "Pencabutan Penetapan Penomoran Telekomunikasi";

        $penomoranToSave = $getPenomoran;
        DB::beginTransaction();
        // try {
        // $check_kodeakses_ = DB::table('tb_trx_kode_akses_alokasi')->select('tb_trx_kode_akses_alokasi.*')
        // ->join('tb_trx_kode_akses','tb_trx_kode_akses.id_mst_kode_akses','=','tb_trx_kode_akses_alokasi.id')
        // ->where('tb_trx_kode_akses.id_izin', '=', $id_izin)
        // ->first();
        // if ($data['status_sk'] == 0) { //jika ditolak
        // $penomoranToSave->status_permohonan = 90;
        // } else {
        // $penomoranToSave->status_permohonan = 915;
        // // $penomoran_alokasi = DB::table('tb_trx_kode_akses_alokasi')
        // // ->select('*')
        // // ->where('id', '=', $check_kodeakses_->id)
        // // ->update(['status' => 'DALAM PROSES']);
        // }
        $penomoranToSave->status_permohonan = 50;
        $penomoranToSave->catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
        $penomoranToSave->updated_date = date('Y-m-d H:i:s');
        $penomoranToSave->updated_by = Session::get('name');

        $penomoranToSave->save();

        $penomoranToLog = Penomoran::where('id_izin', '=', $id_izin)->first()->toArray();
        $insertUloLog = $log->createPenomoranLog($penomoranToLog, $status_penomoran);

        $Izinoss = Izinoss::where('id_izin', '=', $id_izin)->first(); //set status checklist telah
        $insertIzinLog = $log->createIzinLog($Izinoss, $catatan_hasil_evaluasi);

        // if ($data['status_sk'] == 0) {
        // $Izinoss->status_checklist = 90;
        // } else {
        // $Izinoss->status_checklist = 903;
        // }
        $Izinoss->status_checklist = 50;
        $Izinoss->updated_at = date('Y-m-d H:i:s');
        $Izinoss->save();

        $no_izin_latest_penetapanpencabutan = DB::table('latest_nomor_0506')->select('*')->first();
        // $no_izin_latest_penetapanulang = DB::table('latest_nomor_0505')->select('*')->first();
        $no_izin_cabut = $no_izin_latest_penetapanpencabutan->izinpenomoran;
        // $penomoran_alokasi =
        // DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
        // 'id',
        // '=',
        // $penomoran['id_mst_kode_akses']
        // )->update([
        // 'status' => 'Idle', 'id_mst_kodestatusizin' => NULL, 'nomor_penetapan' => NULL, 'tanggal_penetapan' => NULL, 'nib'
        // => NULL, 'nama_pelakuusaha' => NULL
        // ]);
        // $flag_cabut = 1;
        $insert = new SK_Penomoran([
            'id_izin' => $penomoran['id_izin'],
            'kode_akses' => $penomoran['kode_akses']['kode_akses'],
            'jenis_permohonan' => $penomoran['jenis_permohonan'],
            'no_sk' => $no_izin_cabut,
            'tgl_sk' => Carbon::now()->format('Y-m-d'),
            // 'file_sk' => Carbon::now()->format('Y-m-d'),
            'created_by' => Session::get('nama'),
            'created_date' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('nama'),
            'updated_date' => date('Y-m-d H:i:s'),

        ]);

        $insert->save();
        $putfile = $this->putFileSKPenomoranPencabutan(
            $penomoran['id_izin'],
            $penomoran,
            $penomoran['id_mst_kode_akses'],
            $no_izin_cabut
        );

        // $data_cabut = DB::table('vw_penomoran_alokasi_new as t')->select('t.*')
        // ->where('t.id', '=', $penomoran['id_mst_kode_akses'])
        // ->first();
        $penomoran_alokasi = DB::table('vw_penomoran_alokasi_new as t')->select(
            't.*',
            'v.dasar_pencabutan',
            'v.pertimbangan_pencabutan'
        )
            ->leftjoin('tb_trx_penomoran_pencabutan as v', 't.id', '=', 'v.id_mst_kode_akses')
            ->where('t.id', '=', $penomoran['id_mst_kode_akses'])
            // ->whereIn('t.status_permohonan',[$status_penomoran,915])
            ->first();
        // dd($data_cabut);


        // $pdf = PDF::loadView('layouts.backend.sk.cetak-pencabutan-penomoran', [
        // 'penomoran_alokasi' => $penomoran_alokasi, 'datanib' => $penomoran,
        // 'date_reformat' => $date_reformat, 'no_izin' => $no_izin_cabut
        // ]);

        // $pdf->render();

        // $output = $pdf->output();
        // $path = 'app/public/sk_penomoran/sk-pencabutan-penomoran-' . $id_izin . '-' . $id_kodeakses . '.pdf';
        // $pathToPut = storage_path($path);
        // $put = file_put_contents($pathToPut, $output);
        // $putfile = $path;
        $user = Session::get('username');
        if (isset($putfile)) {
            $attachfile = $putfile;



            DB::table('tb_trx_kode_akses')
                ->where(['id_izin' => $penomoran['id_izin'], 'id' => $penomoran['id_mst_kode_akses']])
                ->update(
                    ['path_sk_penomoran' => $putfile, 'updated_by' => Session::get('nama'), 'updated_date' => date('Y-m-d H:i:s')]
                );
            // $no_izin_latest = DB::table('latest_nomor_0505')->select('*')->first();
            $no_izin = $no_izin_cabut;

            $izin = Izinoss::where('id_izin', '=', $id_izin)->first();
            // dd($izin);
            $izin->status_checklist = 50;
            $izin->tgl_izin = date('Y-m-d H:i:s');
            $izin->no_izin = $no_izin;
            $izin->file_izin = $putfile;
            $izin->updated_at = date('Y-m-d H:i:s');
            $izin->save();
        }

        session()->flash('message', 'Berhasil Menerbitkan Surat Penetapan Penomoran');
        DB::commit();

        $penomoran_alokasi =
            DB::table('tb_trx_kode_akses_alokasi')->select('*')->where(
                'id',
                '=',
                $penomoran['id_mst_kode_akses']
            )->update([
                'status' => 'Karantina', 'id_mst_kodestatusizin' => '917', 'nomor_penetapan' => NULL, 'tanggal_penetapan' => NULL,
                'nib'
                => NULL, 'nama_pelakuusaha' => NULL
            ]);

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($penomoran['nib']);
        $departemen = $common->getDepartemen($id_departemen_user);
        $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $id_izin)
            ->first();
        // dd($evaluator);
        $evaluator_ = User::select('nama', 'email', 'id_mst_jobposition')->where('id', '=', $evaluator->id)->first()->toArray();
        $evaluator_email = $evaluator_['email'] ? $evaluator_['email'] : '';
        $evaluator_nama = $evaluator_['nama'] ? $evaluator_['nama'] : '';
        // dd($evaluator->email);
        $nama2 = $evaluator->nama;
        // $user['email'] = $evaluator_email;
        // $user['nama'] = $evaluator_nama;
        // dd($evaluator_);

        $nib = $penomoran['nib'];
        $nibs = Nib::where('nib', $nib)->first();

        $email_jenis = 'penetapan-sk-penomoran';
        $kirim_email = $email->kirim_email(
            $evaluator_,
            $email_jenis,
            $penomoran,
            $departemen,
            $catatan_hasil_evaluasi,
            $nama2,
            $nibs,
            $koreksi_all,
            $attachfile,
            '',
            '',
            '',
            ''
        );

        $departemen = [
            "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
            "jenis_penomoran" => $mst_kodeakses['kode_akses']['jenis_penomoran'],
            "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
        ];

        // $koordinator = $common->get_koordinator_first($id_departemen_user);
        // $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();
        //end get koordinator

        //kondisional departemen
        // $departemen = $common->getDepartemen($id_departemen_user);


        // $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $penomoran, $departemen,
        // $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);
        // $direktur = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
        // ->where('tb_mst_user_bo.id_mst_jobposition', '=', 16)
        // ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        // ->first();
        // $jabatan = DB::table('tb_mst_jobposition')->where('id', $direktur->id_mst_jobposition)->first();
        //kirim email koordinator
        // dd($direktur);
        // $user['email'] = $direktur->email;
        // $user['nama'] = $direktur->nama;
        // $nama2 = $evaluator->nama;
        // $email_jenis = 'direktur';
        // $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
        // $nib = $penomoran['nib'];
        // $nibs = Nib::where('nib', $nib)->first();
        // $nibs = $nibs->toArray();
        //end mengirim email ke evaluator
        // $kirim_email = $email->kirim_email(
        // $penanggungjawab,
        // $email_jenis,
        // $penomoran,
        // $departemen,
        // $catatan_hasil_evaluasi,
        // $nama2,
        // $nibs,
        // $koreksi_all,
        // $attachfile
        // );



        return Redirect::route('admin.direktur.penomoran');
    }


    private function putFileSKPenomoran($id_izin, $penomoran, $id_kodeakses, $no_izin)
    {
        // $data = $penomoran;
        // $nib = $data['nib'];
        // $dataNib = Nib::where('nib',$nib)->first();
        // $dataNib = $dataNib->toArray();
        // $date_reformat = new DateHelper();
        // return view('layouts.backend.direktur.mypdf', $data);
        // dd($penomoran['jenis_permohonan']);
        if ($penomoran['jenis_permohonan'] == "Penetapan Nomor Baru") {
            $status = 'Penetapan Penomoran';
        } elseif ($penomoran['jenis_permohonan'] == "Penetapan Nomor Tambahan") {
            $status = 'Penetapan Penomoran';
        } elseif ($penomoran['jenis_permohonan'] == "Pengembalian Penomoran") {
            $status = 'Penetapan Penomoran Ulang';
        } elseif ($penomoran['jenis_permohonan'] == "Perubahan Penetapan") {
            $status = 'Penetapan Penomoran Ulang';
        }
        // $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*', 'v.*', 'w.*')
        //     ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
        //     ->leftjoin('vw_penomoran_kodeakses_additional_new as w', 't.id_izin', '=', 'w.id_izin')
        //     ->where('t.id', '=', $id_kodeakses)
        //     ->where('w.group_permohonan', '=', $status)
        //     ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first()->toArray();
        $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*', 'v.*', 'w.*')
            ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->leftjoin('vw_penomoran_kodeakses_additional_new as w', 't.id_izin', '=', 'w.id_izin')
            ->where('t.id', '=', $id_kodeakses)
            // ->where('w.group_permohonan','=',$status)
            ->with('KodeIzin')
            ->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
            ->first()->toArray();
        // dd($data);
        $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $data['id_permohonan'])
            ->where('status_evaluasi_bloknomor', '=', 1)->get()->toArray();
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib', $nib)->first();
        $dataNib = $dataNib->toArray();

        // dd($data);

        if ($dataNib['jenis_pu'] == "NPT") {
            if ($data['id_proyek'] == 'Blok Nomor') {
                $pdf = PDF::loadView(
                    'layouts.backend.sk.cetak-penomoran-bn',
                    [
                        'data' => $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'penomoran_bloknomor' => $penomoran_bloknomor,
                        'no_izin' => $no_izin
                    ]
                ); //->setPaper('a4', 'portrait');
            } else {
                $penomoran_kodeakses =
                    DB::table('vw_penomoran_raw_additional')->where(
                        'vw_penomoran_raw_additional.id_izin',
                        '=',
                        $penomoran['id_permohonan']
                    )
                    ->leftjoin('tb_trx_sk_penomoran', function ($join) {
                        $join->on('tb_trx_sk_penomoran.kode_akses', '=', 'vw_penomoran_raw_additional.kode_akses')
                            ->on('tb_trx_sk_penomoran.id_izin', '=', 'vw_penomoran_raw_additional.id_izin');
                    })->get()->toArray();
                $penomoran_list = vw_penomoran_list::where('group_permohonan', '=', $status);
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran', [
                    'data' => $data, 'datanib' => $dataNib,
                    'date_reformat' => $date_reformat, 'no_izin' => $no_izin,
                    'penomoran_list' => $penomoran_list, 'penomoran_kodeakses' => $penomoran_kodeakses
                ]);
            }
        } else {
            if ($data['id_proyek'] == 'Blok Nomor') {
                $pdf = PDF::loadView(
                    'layouts.backend.sk.cetak-penomoran-nib-bn',
                    [
                        'data' => $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat,
                        'penomoran_bloknomor' => $penomoran_bloknomor, 'no_izin' => $no_izin
                    ]
                ); //->setPaper('a4', 'portrait');
            } else {
                $penomoran_kodeakses =
                    DB::table('vw_penomoran_raw_additional')->where(
                        'vw_penomoran_raw_additional.id_izin',
                        '=',
                        $penomoran['id_permohonan']
                    )
                    ->leftjoin('tb_trx_sk_penomoran', function ($join) {
                        $join->on('tb_trx_sk_penomoran.kode_akses', '=', 'vw_penomoran_raw_additional.kode_akses')
                            ->on('tb_trx_sk_penomoran.id_izin', '=', 'vw_penomoran_raw_additional.id_izin');
                    })->get()->toArray();
                $penomoran_list = vw_penomoran_list::where('group_permohonan', '=', $status);
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran-nib', [
                    'data' => $data, 'datanib' => $dataNib,
                    'date_reformat' => $date_reformat, 'no_izin' => $no_izin,
                    'penomoran_list' => $penomoran_list, 'penomoran_kodeakses' => $penomoran_kodeakses
                ]);
            }
        }



        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/sk_penomoran/sk-penomoran-' . $id_izin . '-' . $id_kodeakses . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }
    private function putFileSKPenomoranPencabutan($id_izin, $penomoran, $id_kodeakses, $no_izin)
    {
        // $data = $penomoran;
        // dd($id_kodeakses);
        // $nib = $data['nib'];
        // $dataNib = Nib::where('nib',$nib)->first();
        // $dataNib = $dataNib->toArray();
        // $date_reformat = new DateHelper();
        // return view('layouts.backend.direktur.mypdf', $data);
        $status = 'Penetapan Pencabutan';
        $data = DB::table('vw_penomoran_all as t')->select('t.*')
            // ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            // ->leftjoin('vw_penomoran_alokasi_new as w', 't.id_mst_kode_akses', '=', 'w.id')
            ->where('t.id_mst_kode_akses', '=', $id_kodeakses)
            // ->where('w.group_permohonan', '=', $status)
            // ->with('KodeIzin')
            // ->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
            ->first();
        $eff_date = Carbon::now()->format('Y-m-d');
        // dd( $data);
        // $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $data['id_izin'])
        //     ->where('status_evaluasi_bloknomor', '=', 1)->get()->toArray();
        // $penomoran_list =
        //     vw_penomoran_list::where('id_izin', '=', $data['id_izin'])->where('group_permohonan', '=', $status)->get()->toArray();
        // dd($penomoran_list);
        $date_reformat = new DateHelper();
        // $nib = $data['nib'];
        // $dataNib = Nib::where('nib', $nib)->first();
        // $dataNib = $dataNib->toArray();

        // dd($data);

        $pdf = PDF::loadView('layouts.backend.sk.cetak-pencabutan-penomoran', [
            'penomoran_alokasi' => $data, 'eff_date' => $eff_date,
            'date_reformat' => $date_reformat, 'no_izin' => $no_izin
        ]);



        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/sk_penomoran/sk-pencabutan-penomoran-' . $id_izin . '-' . $id_kodeakses . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);
        // dd($path);
        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }
    private function putFileSKIP($id_izin)
    {
        $datenow = Carbon::now();
        $common = new CommonHelper;
        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';

        // $noizinprinsip = DB::table('latest_izinprinsipno_0301')->first();
        // $data = IzinPrinsip::select('*')->where('id_izin','=',$id_izin)->first()->toArray();
        $data = DB::table('vw_list_izin as i')
            ->select(
                'i.nib',
                'i.status_badan_hukum',
                'i.id_izin',
                'i.id_proyek',
                'i.kbli',
                'i.kbli_name',
                'i.nama_perseroan',
                'i.full_kbli',
                'i.jenis_izin',
                'i.kd_izin',
                'i.jenis_layanan',
                'i.jenis_layanan_html',
                'i.kabupaten_name',
                'i.no_izin',
                'i.provinsi_name',
                'i.nama_master_izin',
                'vw_izinprinsip_derivative.tgl_izin_prinsip_init',
                'vw_izinprinsip_derivative.no_izin_prinsip',
                'vw_izinprinsip_derivative.tgl_izin_prinsip_ext_init',
                'vw_izinprinsip_derivative.no_izin_prinsip_ext',
                'vw_izinprinsip_derivative.no_izin_prinsip_cabut',
                'vw_izinprinsip_derivative.tgl_izin_prinsip_cabut',
                'i.no_izinprinsip',
                'i.submitted_date'
            )
            ->leftjoin('vw_izinprinsip_derivative', 'vw_izinprinsip_derivative.id_izin_prinsip', '=', 'i.id_proyek')
            ->where('i.id_izin', '=', $id_izin)
            ->first();
        $date_reformat = new DateHelper();
        $nib = $data->nib;
        $dataNib = Nib::where('nib', $nib)->first();
        $dataNib = $dataNib->toArray();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        if ($data->kd_izin == '059000030066') {
            $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', '059000010066')->first();
        } else {
            $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $data->kd_izin)->first();
        }
        $id_mst_izinlayanan = $mst_kode_izin->id;

        // dd($mst_kode_izin->id);

        // $map_izin = array();
        // $filled_persyaratan = array();
        if ($data->kd_izin == '059000030066') {
            $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $data->id_proyek)->get();
        } else {
            $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id_izin)->get();
        }
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }
        $map_izin = $common->get_map_izin($id_mst_izinlayanan);

        foreach ($map_izin as $key => $value) {
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                }
            }
        }
        if ($data->kd_izin == '059000030066') {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-perpanjangan-izin-prinsip-telsus', [
                'map_izin' => $map_izin,
                'data' => $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'nomor_sklo' =>
                $data->no_izinprinsip
            ])->setPaper('legal', 'portrait');
        } elseif ($data->kd_izin == '059000040066') {

            $pdf = PDF::loadView('layouts.backend.sk.cetak-pencabutan-izin-prinsip-telsus', [
                'map_izin' => $map_izin,
                'data' =>
                $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'nomor_sklo' =>
                $data->no_izinprinsip
            ])->setPaper('legal', 'portrait');
        } else {

            $pdf = PDF::loadView('layouts.backend.sk.cetak-izin-prinsip-telsus', ['map_izin' => $map_izin, 'data' =>
            $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'nomor_sklo' =>
            $data->no_izinprinsip])->setPaper('legal', 'portrait');
        }
        // dd($data);

        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/sk_ip/sk-ip-' . $id_izin . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }

    public function skPenomoran(Request $request)
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $skquery = SkPenomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
            ->where('t.path_sk_penomoran', '!=', null)
            ->where('t.status_permohonan', '=', '50');
        $sk = array();
        if ($skquery->count() > 0) { //handle paginate error division by zero
            $sk = $skquery->paginate($limit_db);
        } else {
            $sk = $skquery->get();
        }

        $paginate = $sk;
        $sk = $sk->toArray();

        return view('layouts.backend.direktur.dashboard-sk-penomoran', ['date_reformat' => $date_reformat, 'sk' => $sk, 'paginate' => $paginate]);
    }

    public function lihatSKPenomoran($id, $id_kodeakses, Request $request)
    {

        $sk = SkPenomoran::select('*')
            ->join('vw_list_izin', 'tb_trx_kode_akses.id_izin', '=', 'vw_list_izin.id_izin')
            ->where('tb_trx_kode_akses.id', '=', $id_kodeakses)
            ->where('tb_trx_kode_akses.is_active', '=', 1)

            ->first();
        $id_jabatan = Session::get('id_jabatan');

        if ($sk->count() == 0) {
            return abort(404);
        }
        if ($id_jabatan != 1) {
            return abort(404);
        }

        if ($sk->path_sk_penomoran == '') {
            return abort(404);
        }

        $path = storage_path(str_replace('app/public/', 'storage/', $sk->path_sk_penomoran));

        if (!file_exists($path)) {
            return abort(404);
        }

        return response()->file($path);
    }

    public function penyesuaian(Request $request)
    {
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');

        $penomoran = Penomoran::from('tb_trx_penyesuaian_komitmen as t')->select('t.*', 'v.*')->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->with('KodeIzin')->with('KodeAkses')->take($limit_db);
        $penomoran = $penomoran->where('t.status_penyesuaian', '=', 804);

        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        } else {
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        $penomoran = $penomoran->toArray();

        $countpenomoran = IzinHelper::countPenomoran(904);

        // dd($penomoran);

        return view('layouts.backend.direktur.dashboard-penyesuaian', ['date_reformat' => $date_reformat, 'paginate' => $paginate, 'penomoran' => $penomoran, 'countpenomoran' => $countpenomoran]);
    }

    public function penetapanPenyesuaian($id, Request $request)
    {
        $date_reformat = new DateHelper();

        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        // $status_checklist = 901;
        $izin = Izin::select('*')->where('id_izin', '=', $id)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        // dd($izin);
        if (
            $izin == null
        ) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];

        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);


        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        $filled_persyaratan = $filled_persyaratan->toArray();

        // dd($map_izin);

        foreach ($map_izin as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin[$key]->need_correction = $value2->need_correction;
                    $map_izin[$key]->correction_note = $value2->correction_note;
                }
            }
        }

        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        $filled_perubahan = DB::table('tb_trx_persyaratan_komitmen')->where('id_izin', $id)->get()->toArray();

        // foreach ($map_izin_perubahan as $key => $value) {
        //     // echo $value->persyaratan;
        //     // echo "<br>=============<br>";
        //     $map_izin_perubahan[$key] = $value;
        //     foreach ($filled_perubahan as $key2 => $value2) {
        //         if ($value->id == $value2->id_map_listpersyaratan) {
        //             // echo $value->persyaratan;
        //             // echo "<br>=============<br>";
        //             // echo $value2->filled_document;
        //             // echo "<br>******************<br>";
        //             $map_izin_perubahan[$key]->form_isian = $value2->filled_document;
        //             $map_izin_perubahan[$key]->nama_asli = $value2->nama_file_asli;
        //             $map_izin_perubahan[$key]->need_correction = $value2->need_correction;
        //             $map_izin_perubahan[$key]->correction_note = $value2->correction_note;
        //         }
        //     }
        // }

        $html = array();
        // $html = view('users.edit', compact('user'))->render();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');
        // dd($triger);
        // die;
        $penyesuaian = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $id)->where('is_active', NULL)->first();
        $component['roll_out_plan_jartup_fo_ter'] = "roll_out_plan_jartup_fo_ter";
        $component['komitmen_kinerja_layanan_lima_tahun'] = "komitmen_kinerja_layanan_lima_tahun";

        return view('layouts.backend.direktur.evaluasi-penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'penyesuaian' => $penyesuaian, 'component' => $component, 'map_izin_perubahan' => $map_izin_perubahan]);
    }

    public function penetapanPenyesuaianPost($id, Request $request)
    {
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.direktur');
        }

        $getPenyesuaian = Penyesuaian::where('id_izin', '=', $id_izin)->where('status_penyesuaian', '=', 804)->first();

        if (empty($getPenyesuaian)) {
            return abort(404);
        }

        $koreksi_all = 0;
        $data = $request->all();

        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $common = new CommonHelper();
        $email = new EmailHelper();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $email_jenis = 'penetapan-sk-ulo';
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $ulo = [];

        $evaluator = DB::table('tb_trx_disposisi_evaluator_komitmen as a')
            ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
            ->where('a.id_izin', $id_izin)
            ->first();

        DB::beginTransaction();
        try {
            $penyesuaianToSave = $getPenyesuaian;

            $penyesuaianToSave->correction_note = '';
            $penyesuaianToSave->status_penyesuaian = 50;
            $penyesuaianToSave->is_active = 0;

            $penyesuaianToSave->updated_date = date('Y-m-d H:i:s');
            $penyesuaianToSave->updated_by = Session::get('name');
            $penyesuaianToSave->save();

            DB::commit();

            $jenis_sk = '';
            if ($penyesuaianToSave->status_komitmen == 2) {
                $putfile = $this->putFileSKPenyesuaian($id_izin);
                $jenis_sk = 'Penyesuaian';
            } else {
                $putfile = $this->putFileSKPerubahan($id_izin);
                $jenis_sk = 'Perubahan';
            }
            $attachfile = '';
            if ($putfile != null) {
                $attachfile = $putfile;
                DB::table('tb_trx_komitmen_sk')->insert(
                    ['id_izin' => $id, 'path_sk_ulo' => $putfile, 'created_by' => Session::get('id_user'), 'created_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'jenis_sk' => $jenis_sk]
                );
            }

            $catatan_hasil_evaluasi = '';

            //kondisional departemen
            $departemen = $common->getDepartemen($id_departemen_user);

            $email_jenis = 'penetapan-sk-ulo';
            $nama2 = $evaluator->nama;
            // dd($ulo);
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $attachfile, '', '', '');

            // $kirim_email = $email->kirim_email($penanggungjawab, '', $izin, '', '', '', $nibs, 0, $attachfile);

            session()->flash('message', 'Berhasil Penetapan Komitmen');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Evaluasi gagal di prosess');
            return Redirect::route('admin.direktur');
        }

        return Redirect::route('admin.direktur.penyesuaian')->with('message', 'Berhasil Penetapan Komitmen');
    }

    public function putFileSKPerubahan($id_izin)
    {
        $data = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $id_izin)->first();

        $common = new CommonHelper;
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        $id_master_izin = $izin['id_master_izin'];
        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        $filled_perubahan = DB::table('tb_trx_persyaratan_komitmen')->where('id_izin', $id_izin)->get()->toArray();

        foreach ($map_izin_perubahan as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin_perubahan[$key] = $value;
            foreach ($filled_perubahan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin_perubahan[$key]->form_isian = $value2->filled_document;
                    $map_izin_perubahan[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin_perubahan[$key]->need_correction = $value2->need_correction;
                    $map_izin_perubahan[$key]->correction_note = $value2->correction_note;
                }
            }
        }
        // dd($map_izin_perubahan);
        $nama_perseroan = DB::table('tb_oss_trx_izin')
            ->leftJoin('tb_oss_nib', 'tb_oss_trx_izin.oss_id', '=', 'tb_oss_nib.oss_id')->where('tb_oss_trx_izin.id_izin', $id_izin)->pluck('nama_perseroan')->first();

        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();

        if ($id_master_izin == 1) {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-perubahan-jasa', ['nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        } else {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-perubahan', ['nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }

        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/penyesuaian/sk-perubahan-' . $id_izin . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }

    public function putFileSKPenyesuaian($id_izin)
    {
        $data = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $id_izin)->first();

        $common = new CommonHelper;
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)
            // ->where('status_checklist', '=', $status_checklist)
            // ->orWhere(function($query) {
            //     $query->where('status_checklist', 901);
            // })
            ->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        $id_master_izin = $izin['id_master_izin'];
        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        $filled_perubahan = DB::table('tb_trx_persyaratan_komitmen')->where('id_izin', $id_izin)->get()->toArray();

        foreach ($map_izin_perubahan as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin_perubahan[$key] = $value;
            foreach ($filled_perubahan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin_perubahan[$key]->form_isian = $value2->filled_document;
                    $map_izin_perubahan[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin_perubahan[$key]->need_correction = $value2->need_correction;
                    $map_izin_perubahan[$key]->correction_note = $value2->correction_note;
                }
            }
        }
        // dd($map_izin_perubahan);
        $nama_perseroan = DB::table('tb_oss_trx_izin')
            ->leftJoin('tb_oss_nib', 'tb_oss_trx_izin.oss_id', '=', 'tb_oss_nib.oss_id')->where('tb_oss_trx_izin.id_izin', $id_izin)->pluck('nama_perseroan')->first();

        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();

        if ($id_master_izin == 1) {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-penyesuaian-jasa', ['nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        } else {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-penyesuaian', ['nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }

        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/penyesuaian/sk-penyesuaian-' . $id_izin . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }

    public function putFileSKPenetapan($id_izin)
    {
        $data['rolloutplan'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [179, 201, 223, 263, 269, 293, 315, 337, 359])->pluck('filled_document')->first();
        $data['komitmen_kinerja_layanan_lima_tahun'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [180, 202, 224, 247, 270, 294, 316, 338, 360])->pluck('filled_document')->first();
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $idizin = $id_izin;
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)->first();
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $ulo = Ulo::select('*')->where('id_izin', '=', $id_izin)->first();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name', 'short_name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        $id_master_izin = $izin['id_master_izin'];
        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        $filled_perubahan = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->get()->toArray();

        foreach ($map_izin_perubahan as $key => $value) {
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin_perubahan[$key] = $value;
            foreach ($filled_perubahan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    // echo $value->persyaratan;
                    // echo "<br>=============<br>";
                    // echo $value2->filled_document;
                    // echo "<br>******************<br>";
                    $map_izin_perubahan[$key]->form_isian = $value2->filled_document;
                    $map_izin_perubahan[$key]->nama_asli = $value2->nama_file_asli;
                    $map_izin_perubahan[$key]->need_correction = $value2->need_correction;
                    $map_izin_perubahan[$key]->correction_note = $value2->correction_note;
                }
            }
        }

        // dd($map_izin_perubahan);
        $nama_perseroan = DB::table('tb_oss_trx_izin')
            ->leftJoin('tb_oss_nib', 'tb_oss_trx_izin.oss_id', '=', 'tb_oss_nib.oss_id')->where('tb_oss_trx_izin.id_izin', $id_izin)->pluck('nama_perseroan')->first();

        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();

        $komitmenSK = DB::table('tb_trx_komitmen_sk')
            ->where('tb_trx_komitmen_sk.id_izin', '=', $idizin)
            ->where('tb_trx_komitmen_sk.jenis_sk', '=', 'Penetapan')
            ->first();
        // dd($komitmenSK->sk_no);
        if (isset($komitmenSK->sk_no)) {
            if ($id_master_izin == 1) {
                // $nokomitmen = DB::table('latest_izinkomitmenno_jasa')->select('izinkomitmenno')->first();
                // $latest_nokomitmen = $nokomitmen->izinkomitmenno;

                $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan-jasa', ['ulo' => $ulo, 'latest_nokomitmen' => $komitmenSK->sk_no, 'idizin' => $idizin, 'date_reformat' => $date_reformat, 'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
            } else {
                // $nokomitmen = DB::table('latest_izinkomitmenno_jaringan')->select('izinkomitmenno')->first();
                // $latest_nokomitmen = $nokomitmen->izinkomitmenno;
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan', ['ulo' => $ulo, 'latest_nokomitmen' => $komitmenSK->sk_no, 'idizin' => $idizin, 'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
            }

            $path = $komitmenSK->path_sk_ulo;
            DB::table('tb_trx_komitmen_sk')->update(
                ['id_izin' => $id_izin, 'updated_by' => Session::get('id_user'), 'updated_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'jenis_sk' => 'Penetapan']
            );
        } else {
            if ($id_master_izin == 1) {
                $nokomitmen = DB::table('latest_izinkomitmenno_jasa')->select('izinkomitmenno')->first();
                $latest_nokomitmen = $nokomitmen->izinkomitmenno;

                $path = 'app/public/penyesuaian/sk-penetapan-' . $id_izin . '.pdf';
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan-jasa', ['ulo' => $ulo, 'latest_nokomitmen' => $latest_nokomitmen, 'idizin' => $idizin, 'date_reformat' => $date_reformat, 'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
            } else {
                $nokomitmen = DB::table('latest_izinkomitmenno_jaringan')->select('izinkomitmenno')->first();
                $latest_nokomitmen = $nokomitmen->izinkomitmenno;
                $path = 'app/public/penyesuaian/sk-penetapan-' . $id_izin . '.pdf';
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan', ['ulo' => $ulo, 'latest_nokomitmen' => $latest_nokomitmen, 'idizin' => $idizin, 'date_reformat' => $date_reformat, 'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
            }

            // $pdf->render();

            // $output = $pdf->output();
            // $path = 'app/public/penyesuaian/sk-penetapan-' . $id_izin . '.pdf';
            // $pathToPut = storage_path($path);
            // $put = file_put_contents($pathToPut, $output);

            DB::table('tb_trx_komitmen_sk')->insert(
                ['id_izin' => $id_izin, 'sk_no' => $latest_nokomitmen, 'path_sk_ulo' => $path, 'created_by' => Session::get('id_user'), 'created_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'jenis_sk' => 'Penetapan']
            );
        }



        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/penyesuaian/sk-penetapan-' . $id_izin . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }

    public function putFileSKIzinPenyelenggaraan($id_izin)
    {
        // $data['rolloutplan'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)
        // ->whereIn('id_map_listpersyaratan', [179,201,223,263,269,293,315,337,359])->pluck('filled_document')->first();
        // $data['komitmen_kinerja_layanan_lima_tahun'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin',
        // $id_izin)->whereIn('id_map_listpersyaratan',
        // [180,202,224,247,270,294,316,338,360])->pluck('filled_document')->first();
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $idizin = $id_izin;
        $izin = Izin::from('vw_list_izin as u')
            ->select(
                'ip.no_izin_prinsip',
                'ip.tgl_izin_prinsip_init',
                'ip.no_izin_prinsip_ext',
                'ip.tgl_izin_prinsip_ext_init',
                'ip.no_izin_penyelenggaraan',
                'ip.no_sk_ulo',
                'ip.tgl_izin_prinsip_ulo',
                'u.*'
            )
            ->leftjoin('vw_izinprinsip_derivative as ip', 'u.id_proyek', '=', 'ip.id_izin_prinsip')
            ->where('u.id_izin', '=', $id_izin)->first();
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $ulo = Ulo::select('*')->where('id_izin', '=', $id_izin)->first();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name', 'short_name')->where(
            'kode_izin',
            '=',
            $kd_izin
        )->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        $map_izin_perubahan = array();
        $map_izin_perubahan = DB::table('vw_pre_izin_telsus')->select('*')
            ->where('id_proyek', '=', $izin['id_proyek'])
            ->where('kd_izin', '!=', $izin['kd_izin'])
            ->get();
        $id_master_izin = $izin['id_master_izin'];
        // $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        // $filled_perubahan = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->get()->toArray();

        // foreach ($map_izin_perubahan as $key => $value) {
        //     // echo $value->persyaratan;
        //     // echo "<br>=============<br>";
        //     $map_izin_perubahan[$key] = $value;
        //     foreach ($filled_perubahan as $key2 => $value2) {
        //         if ($value->id == $value2->id_map_listpersyaratan) {
        //             // echo $value->persyaratan;
        //             // echo "<br>=============<br>";
        //             // echo $value2->filled_document;
        //             // echo "<br>******************<br>";
        //             $map_izin_perubahan[$key]->form_isian = $value2->filled_document;
        //             $map_izin_perubahan[$key]->nama_asli = $value2->nama_file_asli;
        //             $map_izin_perubahan[$key]->need_correction = $value2->need_correction;
        //             $map_izin_perubahan[$key]->correction_note = $value2->correction_note;
        //         }
        //     }
        // }

        // dd($map_izin_perubahan);
        $nama_perseroan = DB::table('tb_oss_trx_izin')
            ->leftJoin('tb_oss_nib', 'tb_oss_trx_izin.oss_id', '=', 'tb_oss_nib.oss_id')->where(
                'tb_oss_trx_izin.id_izin',
                $id_izin
            )->pluck('nama_perseroan')->first();

        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();

        // $komitmenSK = DB::table('tb_trx_komitmen_sk')
        //     ->where('tb_trx_komitmen_sk.id_izin', '=', $idizin)
        //     ->where('tb_trx_komitmen_sk.jenis_sk', '=', 'Penetapan')
        //     ->first();
        // dd($komitmenSK->sk_no);
        $nokomitmen = DB::table('latest_izinprinsipno_0302')->select('izinprisipno')->first();
        $latest_nokomitmen = $nokomitmen->izinprisipno;

        $path = 'app/public/sk_ip/sk-izinpenyelenggaraan-' . $id_izin . '.pdf';

        $ip_idproyek = DB::table('tb_trx_ulo')
            ->join('tb_oss_trx_izin as b', 'b.id_izin', '=', 'tb_trx_ulo.id_izin')
            ->select('b.id_proyek')
            ->where('tb_trx_ulo.id_izin', '=', $id_izin)
            ->first();
        $ip_idproyek_iterasi = DB::table('tb_oss_trx_izin')
            ->join('tb_trx_izin_prinsip as b', 'b.id_trx_izin', '=', 'tb_oss_trx_izin.id_izin')
            ->select('b.id_trx_izin')
            ->where('tb_oss_trx_izin.id_proyek', '=', $ip_idproyek->id_proyek)
            ->where('b.iterasi_perpanjangan', '=', 1)
            ->first();
        if (isset($ip_idproyek_iterasi->id_trx_izin)) {
            $id_trxizinip = $ip_idproyek_iterasi->id_trx_izin;
            $id_trxizinip_stat = 1;
        } else {
            $id_trxizinip = $ip_idproyek->id_proyek;
            $id_trxizinip_stat = 0;
        }
        $IzinPrinsip = TrxIzinPrinsip::where('id_trx_izin', '=', $id_trxizinip)->first();
        $map_izin = array();
        $map_izin = DB::table('vw_pre_izin_telsus')->select('*')
            ->where('id_proyek', '=', $izin['id_proyek'])
            // ->where('kd_izin', '!=', $izin['kd_izin'])
            ->get();
        $data = array();
        $data = $izin;
        // dd($data);
        $pdf = PDF::loadView(
            'layouts.backend.sk.cetak-izin-penyelenggaraan-telsus',
            [
                'data' => $data, 'ulo' => $ulo, 'latest_nokomitmen' => $latest_nokomitmen, 'map_izin' => $map_izin, 'idizin' =>
                $idizin, 'date_reformat' =>
                $date_reformat, 'nama_perseroan'
                => $nama_perseroan, 'cities' => $cities, 'map_izin_perubahan' => $map_izin_perubahan,
                'mst_kode_izin' => $mst_kode_izin, 'IzinPrinsip' => $IzinPrinsip, 'id_trxizinip_stat' => $id_trxizinip_stat
            ]
        )->setPaper('legal', 'portrait');

        $pdf->render();

        $output = $pdf->output();
        // $path = 'app/public/penyesuaian/sk-penetapan-' . $id_izin . '.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        DB::table('tb_trx_komitmen_sk')->insert(
            ['id_izin' => $id_izin, 'sk_no' => $latest_nokomitmen, 'path_sk_ulo' => $path, 'created_by' =>
            Session::get('id_user'), 'created_at' => date('Y-m-d H:i:s'), 'is_active' => 1, 'jenis_sk' => 'Penetapan']
        );



        // $pdf->render();

        // $output = $pdf->output();
        // $path = 'app/public/penyesuaian/sk-penetapan-' . $id_izin . '.pdf';
        // $pathToPut = storage_path($path);
        // $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        } else {
            return null;
        }
    }
}
