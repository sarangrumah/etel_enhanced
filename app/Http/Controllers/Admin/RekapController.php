<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;

use App\Models\Admin\Izin;
use App\Models\Admin\Nib;
use App\Models\Admin\Disposisi;
use App\Models\Admin\Penomoran;
use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Helpers\LogHelper;
use App\Helpers\DateHelper;
use App\Models\Admin\Ulolog;
use App\Models\Admin\TabelKodeAkses;
use App\Models\Admin\TabelMasterJenisKodeAkses;
use App\Models\Admin\Requestlog;
use App\Models\Admin\Historyperizinan;
use App\Models\Admin\Ulo;
use Illuminate\Validation\ValidationException;
use App\Models\Admin\Penomoranlog;
use App\Models\Admin\BlokNomor_List;
use App\Models\Admin\vw_penomoran_list;
use App\Models\Admin\vw_kodeakses_adds;
use App\Models\Viewizin;
use App\Helpers\UtilPerizinan;
use App\Models\Admin\KodeIzin;
use App\Models\Admin\reqBimtek;
use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;

class RekapController extends Controller
{
    //
    public function getizin($jenisperizinan)
    {
        try {
            if ($jenisperizinan == 'PENOMORAN_PENETAPAN') {
                $izin = Viewizin::where(['nib' =>
                Auth::user()->nib[0]->nib])->where('jenis_perizinan', ['K03'])->whereIn('status_checklist', [
                    '50',
                    '90'
                ])->get();
            } else if ($jenisperizinan == 'ALL_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'DONE_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereIn('status_checklist', ['50'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'PROSES_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereNotIn('status_checklist', ['50', '90'])->distinct('id_izin')->get();
            } else if ($jenisperizinan == 'REJECTED_NOMOR') {
                $izin = Viewizin::where('jenis_perizinan', ['K03'])->whereIn('status_checklist', ['90'])->distinct('id_izin')->get();
            }
        } catch (\Throwable $th) {
            $izin = [];
        }
        return $izin;
    }

    
    public function AllPenomoran()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        // $id_departemen_user = Session::get('id_departemen');

        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
            ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->with('KodeIzin')->with('KodeAkses')->get();
        $penomoran = $penomoran->toArray();
        $jenis_izin='';
        $utilizin = new UtilPerizinan();
        $date_reformat = new DateHelper();
        $izin = $utilizin->getizin_nonib("ALL_NOMOR");
        $total = count($utilizin->getizin_nonib("ALL_NOMOR"));
        $done = count($utilizin->getizin_nonib("DONE_NOMOR"));
        $proses = count($utilizin->getizin_nonib("PROSES_NOMOR"));
        $rejected = count($utilizin->getizin_nonib("REJECTED_NOMOR"));
        // dd($penomoran);

        return view('layouts.backend.rekap.semua-penomoran', ['date_reformat' => $date_reformat, 'penomoran' =>
        $penomoran, 'jenis_izin' => $jenis_izin,'izin' => $izin, 'total' => $total , 'done' => $done, 'proses' =>
        $proses,
        'rejected' => $rejected]);
    }

    public function AllPenetapan()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        // $id_departemen_user = Session::get('id_departemen');
        
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')->whereIn('t.status_permohonan',['50','95'])
        ->join('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->with('KodeIzin')->with('KodeAkses')->get();
        // $penomoran = DB::table('vw_all_penetapan')->get();
        // dd($penomoran);
        $penomoran = $penomoran->toArray();
        $jenis_izin='';
        $utilizin = new UtilPerizinan();
        $date_reformat = new DateHelper();
        $izin = $utilizin->getizin_nonib("ALL_NOMOR");
        $total = count($utilizin->getizin_nonib("ALL_NOMOR"));
        $done = count($utilizin->getizin_nonib("DONE_NOMOR"));
        $proses = count($utilizin->getizin_nonib("PROSES_NOMOR"));
        $rejected = count($utilizin->getizin_nonib("REJECTED_NOMOR"));
        $cabut= count($utilizin->getizin_nonib("CABUT_NOMOR"));
        $tetap= count($utilizin->getizin_nonib("TETAP_NOMOR"));
        // dd($tetap,$cabut);
        
        return view('layouts.backend.rekap.semua-penetapan', ['date_reformat' => $date_reformat, 'penomoran' =>
        $penomoran, 'jenis_izin' => $jenis_izin,'izin' => $izin, 'total' => $total , 'done' => $done, 'proses' =>
        $proses, 'cabut' => $cabut , 'tetap' => $tetap , 
        'rejected' => $rejected]);
    }

    public function AllLog()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');

        // $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen','=', $id_departemen_user)->take($limit_db);
        $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen', '=', $id_departemen_user)->get();

        // if ($log->count() > 0) { //handle paginate error division by zero
        //     $log = $log->paginate($limit_db);
        // }else{
        //     $log = $log->get();
        // }
        // $paginate = $log;
        $log = $log->toArray();
        // dd($id_departemen_user,$log);

        // return view('layouts.backend.rekap.rekap_log',['date_reformat'=>$date_reformat,'log'=>$log,'paginate'=>$paginate]);
        return view('layouts.backend.rekap.rekap_log', ['date_reformat' => $date_reformat, 'log' => $log]);
    }

    public function AllRegister()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');

        // $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen','=', $id_departemen_user)->take($limit_db);
        $log = DB::table('vw_rpt_registrasi as t')->select('t.*')->get();

        // if ($log->count() > 0) { //handle paginate error division by zero
        //     $log = $log->paginate($limit_db);
        // }else{
        //     $log = $log->get();
        // }
        // $paginate = $log;
        $log = $log->toArray();
        // dd($id_departemen_user,$log);

        // return view('layouts.backend.rekap.rekap_log',['date_reformat'=>$date_reformat,'log'=>$log,'paginate'=>$paginate]);
        return view('layouts.backend.rekap.rekap_register', ['date_reformat' => $date_reformat, 'log' => $log]);
    }

    public function RekapAlokasi()
    {
        // dd(request()->session()->all());
        ini_set('memory_limit', '8056M');
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_jobposition_user = Session::get('id_mst_jobposition');

        // $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen','=',$id_departemen_user)->take($limit_db);
        $log = DB::table('vw_alokasi_penomoran_rev as t')->select('t.*')->get();

        // if ($log->count() > 0) { //handle paginate error division by zero
        // $log = $log->paginate($limit_db);
        // }else{
        // $log = $log->get();
        // }
        // $paginate = $log;
        $log = $log->toArray();
        // dd($log);
        // dd($id_departemen_user,$log);

        // return  view('layouts.backend.rekap.rekap_log',['date_reformat'=>$date_reformat,'log'=>$log,'paginate'=>$paginate]);
        return view('layouts.backend.rekap.rekap_alokasi', ['date_reformat' => $date_reformat, 'log' => $log, 'id_jobposition_user' => $id_jobposition_user]);
    }
    
    public function RekapPelakuUsaha()
    {
        $date_reformat = new DateHelper();
        $id_jobposition_user = Session::get('id_mst_jobposition');
        $log = DB::table('vw_rekap_pelakuusaha as t')->select('t.*')->get();
        $log = $log->toArray();
        // dd($log);
        return view('layouts.backend.rekap.rekap_pelakuusaha', ['date_reformat' => $date_reformat, 'log' => $log, 'id_jobposition_user' => $id_jobposition_user]);
    }
    
    public function RekapBimtek()
    {
        $date_reformat = new DateHelper();
        $id_jobposition_user = Session::get('id_mst_jobposition');
        $log = reqBimtek::where('type','=','Request Bimbingan Teknis')->get();
        $log_invited = $log->where('status','=','1')->count();
        $log_notyetinvited = $log->where('status','=','0')->count();
        $log_meeting_count = DB::table('tb_trx_req_bimtek')->select('submitted_date')->where('status','=','1')->groupby('submitted_date')->count();
        $log = $log->toArray();
        // dd($log);
        return view('layouts.backend.rekap.rekap_bimtek', ['date_reformat' => $date_reformat, 'log' => $log, 'log_invited'=>$log_invited, 'log_notyetinvited'=>$log_notyetinvited, 'log_meeting_count'=>$log_meeting_count, 'id_jobposition_user' => $id_jobposition_user]);
    }

    public function DetailPelakuUsaha($id, Request $request)
    {
        $date_reformat = new DateHelper();
        $user = DB::table('vw_pj_detail')->select('*');
        $user = $user->where('id', '=', $id);
        $user = $user->first();
        $user_pt = DB::table('vw_nib_detail')->select('*');
        $user_pt = $user_pt->where('id', $id);
        $user_pt = $user_pt->first();
        if (empty($user)) {
            return abort(404);
        }

        $test = 'test';

        // dd($user_pt); 

        return view('layouts.backend.rekap.detail_pelakuusaha', ['date_reformat' => $date_reformat, 'user' => $user, 'user_pt' => $user_pt, 'id' => $id]);
    }


    public function AllRequestKBLI()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');

        // $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen','=', $id_departemen_user)->take($limit_db);
        $log = DB::table('vw_rpt_kblirequest as t')->select('t.*')->where('id_mst_izin', '=', $id_departemen_user)->get();

        // if ($log->count() > 0) { //handle paginate error division by zero
        //     $log = $log->paginate($limit_db);
        // }else{
        //     $log = $log->get();
        // }
        // $paginate = $log;
        $log = $log->toArray();
        // dd($id_departemen_user,$log);

        // return view('layouts.backend.rekap.rekap_log',['date_reformat'=>$date_reformat,'log'=>$log,'paginate'=>$paginate]);
        return view('layouts.backend.rekap.rekap_requestkbli', ['date_reformat' => $date_reformat, 'log' => $log]);
    }
    public function AllDisposisi()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');

        // $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen','=', $id_departemen_user)->take($limit_db);
        $log = DB::table('vw_rpt_disposisi as t')->select('t.*')->where('id_mst_izin', '=', $id_departemen_user)->get();

        // if ($log->count() > 0) { //handle paginate error division by zero
        //     $log = $log->paginate($limit_db);
        // }else{
        //     $log = $log->get();
        // }
        // $paginate = $log;
        $log = $log->toArray();
        // dd($id_departemen_user,$log);

        // return view('layouts.backend.rekap.rekap_log',['date_reformat'=>$date_reformat,'log'=>$log,'paginate'=>$paginate]);
        return view('layouts.backend.rekap.rekap_disposisi', ['date_reformat' => $date_reformat, 'log' => $log]);
    }

    public function evaluasiPenomoran_view($id, Request $request)
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
            ->where('t.id_izin', '=', $id)
            // ->whereIn('t.status_permohonan', [$status_penomoran, 915])
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
        if (isset($nib)) {
            // dd($nib);
            $detailNib = $common->get_detail_nib($nib);

        } else {
            $detailNib = null;
        }

        $penomoran_ulang = DB::table('tb_trx_penomoran_penetapanulang')->select('tb_trx_penomoran_penetapanulang.*','vw_detail_loc.detail_loc')
        ->leftjoin('vw_detail_loc','vw_detail_loc.id','=','tb_trx_penomoran_penetapanulang.id_mst_kelurahan')
        ->where('id_izin','=',$id)->first();

        
        // dd($penomoran_ulang);


        $penanggungjawab = array();
        // $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $penomoranlog = Penomoranlog::where('id_izin', '=', $id)
            // ->where('id_kode_akses','=',$id_kodeakses)
            ->with('KodeIzin')->get()->toArray();

        return view('layouts.backend.rekap.penetapan-penomoran', [
            'date_reformat' => $date_reformat, 'id' => $id,
            'penomoran' => $penomoran, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map' => $map,
            'penomoranlog' => $penomoranlog,
            'penomoran_bloknomor' => $penomoran_bloknomor, 'vw_kodeakses_additional' => $vw_kodeakses_additional,
            'vw_kodeakses_additional_nonarray' =>
            $vw_kodeakses_additional_nonarray, 'vw_kodeakses_additional_count' => $vw_kodeakses_additional_count,
            'note' => $note,
            'penomoran_ulang' => $penomoran_ulang
        ]);
    }
    public function AllRequest()
    {
        $date_reformat = new DateHelper();
        // $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        // dd($id_departemen_user);
        if ($id_departemen_user != 4 && $id_departemen_user != 6) {
            $log = DB::table('vw_rpt_request as t')->select('t.*')->where('id_mst_izin', '=', $id_departemen_user)->get();
        } else {
            $log = DB::table('vw_rpt_request as t')->select('t.*')->get();
        }

        // $log = DB::table('vw_rpt_log as t')->select('t.*')->where('id_mst_departemen','=', $id_departemen_user)->take($limit_db);


        // if ($log->count() > 0) { //handle paginate error division by zero
        //     $log = $log->paginate($limit_db);
        // }else{
        //     $log = $log->get();
        // }
        // $paginate = $log;
        $log = $log->toArray();
        // dd($id_departemen_user,$log);

        // return view('layouts.backend.rekap.rekap_log',['date_reformat'=>$date_reformat,'log'=>$log,'paginate'=>$paginate]);
        return view('layouts.backend.rekap.rekap_request', ['date_reformat' => $date_reformat, 'log' => $log]);
    }


    public function evaluasi($id, $urut, Request $request)
    {
        // dd(Auth::user()->name);
        // dd($urut);
        $date_reformat = new DateHelper();

        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        // $status_checklist = 901;
        if ($urut != '-') {
            $izin = Izin::select('*')->where('id_izin', '=', $id)
                ->first();
        } else {
            $izin = Izin::select('*')->where('id_izin', '=', $id)
                ->first();
        }
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }
        if ($urut != '-') {
            $ulo = Ulo::select('tb_trx_ulo.*', 'tb_oss_mst_kodestatusizin.name_status_bo')
                ->join('tb_oss_mst_kodestatusizin', 'tb_oss_mst_kodestatusizin.oss_kode', '=', 'tb_trx_ulo.status_ulo')
                ->where('tb_trx_ulo.id', '=', $urut)->where('id_izin', '=', $id)
                ->first();
        } else {
            $ulo = Ulo::select('*')->where('id_izin', '=', $id)
                ->first();
        }
        // dd($ulo);
        // if ($ulo == null) {
        //     return abort(404);
        // }
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

        $html = array();
        // $html = view('users.edit', compact('user'))->render();
        $requestlog = Historyperizinan::where('id_izin', '=', $id)
            // ->where('id_kode_akses','=',$id_kodeakses)
            // ->with('KodeIzin')
            ->get()->toArray();

        $historyizin = Historyperizinan::select('*')->where('id_izin', '=', $id)->orderBy('created_at')->get();
        if (empty($historyizin)) {
            return abort(404);
        }
        $historyizin = $historyizin->toArray();

        $itemkodestatus = TabelKodeAkses::get()->pluck('id_mst_jeniskodeakses', 'id');
        $itemnamakodestatus = TabelMasterJenisKodeAkses::get()->pluck('full_name', 'id');

        $history = Ulolog::select('*')->join('vw_list_izin', 'tb_trx_ulo_log.id_izin', '=', 'vw_list_izin.id_izin')->where('tb_trx_ulo_log.id_izin', '=', $id)->with('KodeIzin')->orderBy('created_date')->get();
        if (empty($history)) {
            return abort(404);
        }

        $history = $history->toArray();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');
        // dd($ulo);
        // die;

        return view('layouts.backend.rekap.view-persyaratan', ['ulo' => $ulo, 'history' => $history, 'historyizin' => $historyizin, 'itemkodestatus' => $itemkodestatus, 'itemnamakodestatus' => $itemnamakodestatus, 'requestlog' => $requestlog, 'date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger]);
    }

    public function pentapanSKLO(Request $request)
    {
    }

    public function UpdateNomor($id){

        $log = DB::table('vw_penomoran_alokasi_new as t')->select('t.*')->where('id', '=', $id)->first();

        $status_umku = DB::table('tb_oss_mst_kodestatusizin')->select('*')->where('desc', '=', 'UMKU Alokasi')->get()->toArray();
        
        $jenis_perseroan = DB::table('vw_jenisperseroan_penomoran')->select('*')->get()->toArray();
        $result = [
            'log' => $log,
            'status_umku' => $status_umku,
            'jenis_perseroan' => $jenis_perseroan,
            ];
        return response()->json($result);
    }
    
    public function UpdateNomorPost(Request $request){

        // dd($request->alokasi_kodeakses);
        DB::beginTransaction();

        // try {
            $get_kodeizin = DB::table('tb_oss_mst_kodestatusizin')->select('*')->where('oss_kode','=',$request->alokasi_status)->first();
            $get_jenisperseroan = DB::table('vw_jenisperseroan_penomoran')->select('*')->where('oss_kode','=',$request->alokasi_jenispengguna)->first();

            $get_alokasi = TabelKodeAkses::where('kode_akses','=',$request->alokasi_kodeakses)->first();
            // dd($request,$get_jenisperseroan, $get_kodeizin);

            DB::table('tb_trx_kode_akses_alokasi_log')->insert(
                        ['id' => $get_alokasi->id, 
                            'id_mst_jenis_kode_akses' => $get_alokasi->id_mst_jenis_kode_akses, 
                            'jenis_penomoran' => $get_alokasi->jenis_penomoran, 
                            'id_mst_kode_akses' => $get_alokasi->id_mst_kode_akses, 
                            'format_kode_akses' => $get_alokasi->format_kode_akses, 
                            'kode_akses' => $get_alokasi->kode_akses, 
                            'id_mst_kodestatusizin' => $get_alokasi->id_mst_kodestatusizin, 
                            'status' => $get_alokasi->status, 
                            'nomor_penetapan' => $get_alokasi->nomor_penetapan, 
                            'tanggal_penetapan' => $get_alokasi->tanggal_penetapan, 
                            'nama_pelakuusaha' => $get_alokasi->nama_pelakuusaha, 
                            'nib' => $get_alokasi->nib, 
                            'is_active' => $get_alokasi->is_active, 
                            'jenis_pengguna' => $get_alokasi->jenis_pengguna, 
                            'is_penyelenggara' => $get_alokasi->is_penyelenggara, 
                            'created_by' => Session::get('id_user'), 
                            'created_date' => date('Y-m-d H:i:s'), 
                            'updated_by' => Session::get('id_user'), 
                            'updated_at' => date('Y-m-d H:i:s') ] 
                    );

            $get_alokasi->id_mst_kodestatusizin = isset($request->alokasi_status) ? $request->alokasi_status: null;
            $get_alokasi->status = $get_kodeizin->name_status_fo;
            $get_alokasi->nomor_penetapan = isset($request->alokasi_nopenetapan) ? $request->alokasi_nopenetapan: null;
            $get_alokasi->tanggal_penetapan = isset($request->alokasi_tglpenetapan) ? $request->alokasi_tglpenetapan: null;
            $get_alokasi->nama_pelakuusaha = isset($request->alokasi_namapengguna) ? $request->alokasi_namapengguna: null;
            $get_alokasi->nib = isset($request->alokasi_nib) ? $request->alokasi_nib : null;
            $get_alokasi->jenis_pengguna =  isset($get_jenisperseroan->name) ? $get_jenisperseroan->name : null;
            $get_alokasi->updated_by = Session::get('id_user');
            $get_alokasi->updated_at = date('Y-m-d H:i:s');
            $get_alokasi->save();
            DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        $date_reformat = new DateHelper();
        $id_jobposition_user = Session::get('id_mst_jobposition');

        $log = DB::table('vw_alokasi_penomoran_rev as t')->select('t.*')->get();
        $log = $log->toArray();
        
        return view('layouts.backend.rekap.rekap_alokasi', ['date_reformat' => $date_reformat, 'log' => $log, 'id_jobposition_user' => $id_jobposition_user]);
    }
}