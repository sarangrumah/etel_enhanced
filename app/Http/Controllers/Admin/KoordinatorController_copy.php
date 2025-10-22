<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\JobPosition;
use App\Models\Admin\Izin;
use App\Models\Admin\Nib;
use App\Models\Admin\Disposisi;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Catatankoordinator;
use App\Models\Admin\Penanggungjawab;
use App\Models\Admin\Ulo;
use App\Models\Admin\uloView;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Disposisiulo;
use App\Models\Admin\Penomoran;
use App\Models\Admin\Penomoranlog;
use App\Models\Admin\UserSurvey;
use App\Models\Admin\Penyesuaian;
use App\Models\TrxIzinPrinsip;
use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Helpers\EmailHelper;
use App\Helpers\LogHelper;
use App\Helpers\DateHelper;
use App\Helpers\Osshub;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;
use PDF;
use PhpParser\Node\Stmt\TryCatch;

class KoordinatorController extends Controller
{
    //
    // public $date_reformat;
    function __construct()
    {
    $this->middleware('admin');
    // $this->middleware('auth');
    }

    public function index(){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');

        if ($id_departemen_user == 1) {
            return Redirect::route('admin.koordinator.jasa');
        }else if($id_departemen_user == 2){
            return Redirect::route('admin.koordinator.jaringan');
        }else if($id_departemen_user == 4){
            return Redirect::route('admin.koordinator.ulo');
        }else if($id_departemen_user == 5){
            return Redirect::route('admin.koordinator.penomoran');
        }else{
            return Redirect::route('admin.koordinator.telsus');
        }
    }

    public function jasa(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        
        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user != 1) {
            return abort(404);
        }
        // $izin = Izin::select('*')->where('status_checklist','=',20)->take($limit_db);
        
        $izin = Izin::select('*')->take($limit_db);
        // $izin = $izin->whereIn('status_checklist',[20,903]);
        $izin = $izin->where(function($q) {
            $q->where('status_checklist','=',20)
            ->orWhere('status_checklist','=',903)
            ->orWhere('status_penyesuaian','=',0)
            ->orWhere('status_penyesuaian','=',903);
        });

        $izin = $izin->where('id_master_izin','=',$id_departemen_user)->distinct('id_izin');
        // $countdisposisi = $izin->where(function($q) {
        //     $q->where('status_checklist','=',20);
        // })->get()->count();
        // $countpersetujuan = $izin->where(function($q) {
        //     $q->where('status_checklist','=',903);
        // })->get()->count();
        // dd($izin);]
        //getcountiizin 
        $countdisposisi = IzinHelper::countIzin(20,$id_departemen_user);
        // $countdisposisi = $izin->where('status_checklist','=',20)->count();
        $countpersetujuan = IzinHelper::countIzin(903,$id_departemen_user);
        // $countpersetujuan = $izin->where('status_checklist','=',903)->count();

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }

        $paginate = $izin;
        $izin = $izin->toArray();
        
        // dd($izin);
        $jenis_izin = 'Izin Penyelenggaraan Jasa Telekomunikasi';
        $date_reformat = new DateHelper();

        return view('layouts.backend.koordinator.dashboard',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'countdisposisi'=>$countdisposisi,'countpersetujuan'=>$countpersetujuan,'jenis_izin'=>$jenis_izin]);
    }

    public function jaringan(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        
        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user != 2) {
            return abort(404);
        }
        // $izin = Izin::select('*')->where('status_checklist','=',20)->take($limit_db);
        $izin = Izin::select('*')->take($limit_db);
        $izin = $izin->where(function($q) {
            $q->where('status_checklist','=',20)
            ->orWhere('status_checklist','=',903)
            ->orWhere('status_penyesuaian','=',0)
            ->orWhere('status_penyesuaian','=',903);
        });

        $izin = $izin->where('id_master_izin','=',$id_departemen_user)->distinct('id_izin');
        // $countdisposisi = $izin->where(function($q) {
        //     $q->where('status_checklist','=',20);
        // })->get()->count();
        // $countpersetujuan = $izin->where(function($q) {
        //     $q->where('status_checklist','=',903);
        // })->get()->count();

        //getcountiizin 
        $countdisposisi = IzinHelper::countIzin(20,$id_departemen_user);
        $countpersetujuan = IzinHelper::countIzin(903,$id_departemen_user);

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }

        $paginate = $izin;
        $izin = $izin->toArray();

        // dd($izin);

        $jenis_izin = 'Izin Penyelenggaraan Jaringan Telekomunikasi';
        return view('layouts.backend.koordinator.dashboard',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'countdisposisi'=>$countdisposisi,'countpersetujuan'=>$countpersetujuan,'jenis_izin'=>$jenis_izin]);
    }

    public function telsus(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        
        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user != 3) {
            return abort(404);
        }
        // $izin = Izin::select('*')->where('status_checklist','=',20)->take($limit_db);
        $izin = Izin::select('*')->take($limit_db);
        $izin = $izin->where(function($q) {
            $q->whereIn('status_checklist',[20,21,803,903]);
        });

        if($id_departemen_user=3){
            $izin = $izin->whereIn('id_master_izin',[$id_departemen_user,5])->distinct('id_izin');
        }else{
            $izin = $izin->where('id_master_izin','=',$id_departemen_user)->distinct('id_izin');
        }
        
        // $countdisposisi = $izin->where(function($q) {
        //     $q->where('status_checklist','=',20);
        // })->get()->count();
        // $countpersetujuan = $izin->where(function($q) {
        //     $q->where('status_checklist','=',903);
        // })->get()->count();

        //getcountiizin 
        $countdisposisi = IzinHelper::countIzin(20,$id_departemen_user);
        $countdisposisi = $countdisposisi + IzinHelper::countIzin(21,$id_departemen_user);

        $countpersetujuan = IzinHelper::countIzin(803,$id_departemen_user);
        $countpersetujuan = $countpersetujuan + IzinHelper::countIzin(903,$id_departemen_user);
        // dd($id_departemen_user, $countdisposisi,$countpersetujuan );
        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }

        $paginate = $izin;
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Telekomunikasi Khusus';
        return view('layouts.backend.koordinator.dashboard',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'countdisposisi'=>$countdisposisi,'countpersetujuan'=>$countpersetujuan,'jenis_izin'=>$jenis_izin]);
    }

    public function evaluasiRegistrasi(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $user = DB::table('tb_oss_user')->select('*','tb_oss_user.id as id','tb_oss_user.nama_user_proses as name','tb_mst_kabupaten.name as nama_kab','tb_mst_kecamatan.name as nama_kecamatan','tb_mst_kelurahan.name as nama_kelurahan');
        $user = $user->orwhere('tb_oss_user.status_evaluasi','=',0);
        $user = $user->orwhere('status_nib','=','02');
        $user = $user->join('users','users.id','=','tb_oss_user.no_id_user_proses');
        $user = $user->join('tb_oss_nib','tb_oss_nib.oss_id','=','users.oss_id');
        $user = $user->join('tb_trx_regisip','tb_oss_user.nib','=','tb_trx_regisip.id_inb');
        $user = $user->leftjoin('tb_mst_kabupaten','tb_mst_kabupaten.id','=','tb_oss_user.id_kota');
        $user = $user->leftjoin('tb_mst_kecamatan','tb_mst_kecamatan.id','=','tb_oss_user.id_kecamatan');
        $user = $user->leftjoin('tb_mst_kelurahan','tb_mst_kelurahan.id','=','tb_oss_user.id_kelurahan');
        $user = $user->orderBy('users.created_at','asc');
        $user = $user->take($limit_db);
        
        if ($user->count() > 0) {
            $user = $user->paginate($limit_db);
        }else{
            $user = $user->get();
        }
        
        $paginate = $user;
        $user = $user->toArray();

        
        return view('layouts.backend.koordinator.dashboard-evaluasi-registrasi',['date_reformat'=>$date_reformat,'user'=>$user,'paginate'=>$paginate]);
    }

    public function evaluasiRegistrasiProcess($id, Request $request){
        $date_reformat = new DateHelper();
        // $user = DB::table('tb_oss_user')->select('*');
        // $user = $user->join('users','users.id','=','tb_oss_user.no_id_user_proses');
        // $user = $user->join('tb_oss_nib','users.oss_id','=','tb_oss_nib.oss_id');
        // $user = $user->join('tb_trx_regisip','tb_oss_user.nib','=','tb_trx_regisip.id_inb');
        // $user = $user->join('tb_oss_mst_jenisperseroan','tb_oss_nib.jenis_perseroan','=','tb_oss_mst_jenisperseroan.oss_kode');   
        // $user = $user->leftjoin('tb_mst_provinsi','tb_mst_provinsi.id','=','tb_oss_user.id_provinsi');
        // $user = $user->leftjoin('tb_mst_kabupaten','tb_mst_kabupaten.id','=','tb_oss_user.id_kota');
        // $user = $user->leftjoin('tb_mst_kecamatan','tb_mst_kecamatan.id','=','tb_oss_user.id_kecamatan');
        // $user = $user->leftjoin('tb_mst_kelurahan','tb_mst_kelurahan.id','=','tb_oss_user.id_kelurahan');
        $user = DB::table('vw_pj_detail')->select('*');
        $user = $user->where('id','=',$id);
        // ->orwhere('tb_oss_user.status_evaluasi','=',0);
        // $user = $user->orwhere('tb_oss_nib.status_nib','=','02');
        // dd($user);
        $user = $user->first();
        // dd($user);
        $user_pt = DB::table('vw_nib_detail')->select('*');
        $user_pt = $user_pt->where('id',$id);
        // $user_pt = $user_pt->join('users','tb_oss_nib.oss_id','=','users.oss_id');
        // $user_pt = $user_pt->join('tb_oss_user','tb_oss_user.no_id_user_proses','=','users.id');
        // $user_pt = $user_pt->join('tb_trx_regisip','tb_oss_nib.nib','=','tb_trx_regisip.id_inb');
        // $user_pt = $user_pt->join('tb_oss_mst_jenisperseroan','tb_oss_nib.jenis_perseroan','=','tb_oss_mst_jenisperseroan.oss_kode'); 
        $user_pt = $user_pt->first();
        // $user = $user->toArray();
        if (empty($user)) {
            return abort(404);
        }

        $test = 'test';

        // dd($user_pt); 

        return view('layouts.backend.evaluator-evaluasi-register',['date_reformat'=>$date_reformat,'user'=>$user,'user_pt'=>$user_pt,'id'=>$id]);   
    }

    public function evaluasiRegistrasiPost($id, Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $user = DB::table('tb_oss_user')->select('*','users.email');
        $user = $user->join('users','users.id','=','tb_oss_user.no_id_user_proses');
        $user = $user->where('tb_oss_user.id','=',$id)->first();
        $email_user = $user->email;
        // dd($email_user);
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $toJson = array();
        $toJson['catatan_evaluasi'] = $request['catatan_evaluasi'];
        $toJson = json_encode($toJson);
        
        if(isset($data['is_setuju'])){
            if($data['is_setuju'] == 1){
            $status_evaluasi = 1;
            $status_nib = '01';
            }else{
            $status_evaluasi = 2;
            $status_nib = '07';
            }
        }else{
            
            return Redirect::route('admin.verifikatornib.evaluasiregistrasi')->with('message', 'Proses evaluasi gagal
            diproses, Harap pilih hasil evaluasi');
        }
        
        
        $email_data['email'] = $email_user;
        $email_data['user'] = $user;
        $email_data['id_izin'] = $id;
        $email_data['is_setuju'] = $data['is_setuju'];
        $email_data['jenis'] = 'evaluasi-register';
        $catatan_evaluasi = $request['catatan_evaluasi'];
        // dd($request->all(),$catatan_evaluasi );
        $email_data['catatan_evaluasi'] = $catatan_evaluasi;
        // dd($user);
        DB::beginTransaction();
        try {
            $detailpj = DB::table('tb_oss_user')->select('*')->where('id','=',$id)->where('status_evaluasi','=',0)->update([
                'status_evaluasi'=>$status_evaluasi,
                'catatan_evaluasi'=>$catatan_evaluasi,
                'hasil_evaluasi'=>$toJson
            ]);
            
            $detailnibstatus =
            DB::table('tb_oss_nib')->select('*')->where('nib','=',$user->nib)
            ->where('status_nib','=','02')->update([
            'status_nib'=>$status_nib
            ]);
            if ($email_user != '') {
                $common->send_email($email_data);
            }
            DB::commit();
            session()->flash('message', 'Berhasil Melakukan Evaluasi' );
        } catch (\Exception $e) {
            DB::rollback();
            throw ValidationException::withMessages(['message' => 'Gagal']);
        }

        return Redirect::route('admin.verifikatornib.evaluasiregistrasi');
    }
    
    public function evaluasi ($id, Request $request){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $izin = Izin::select('*')->where('id_izin','=',$id)
        ->whereIn('status_checklist',[903,803])
        ->whereIn('id_master_izin',[$id_departemen_user,5])->first();
        if ($izin == null){
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];

        $detailNib = $common->get_detail_nib($nib);
        
        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id','kode_izin','name')->where('kode_izin','=',$kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin','=',$id)->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }
        
        foreach ($map_izin as $key => $value) {
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;

                }
            }
        }

        $user = array();
        
        if (empty($izin)) {
            return Redirect::route('admin.koordinator');
        }

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $triger =Session::get('id_mst_jobposition');
        
        
        // dd($izin);
    	return view('layouts.backend.koordinator.evaluasi',['date_reformat'=>$date_reformat,'izin'=>$izin,'id'=>$id,'detailnib'=>$detailNib,'user'=>$user,'penanggungjawab'=>$penanggungjawab,'map_izin'=>$map_izin,'triger'=>$triger]);
    }

    private function putFileSK($id_izin){
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        $noUrutAkhir = Ulo::max('nomor_sklo');
        if($noUrutAkhir) {
            $nomor_sklo = sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        }
        // $data2 = Ulo::from('tb_trx_ulo as u')->select('u.*','i.nib','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')
        //         ->where('u.id_izin','=',$id_izin)
        //         ->where('u.is_active','=','1')
        //         ->join('vw_list_izin as i','u.id_izin','=','i.id_izin')
        //         ->first();
        $data2 = DB::table('vw_list_izin as i')
        ->select('i.nib','i.status_badan_hukum','i.id_izin','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')
        ->where('i.id_izin','=',$id_izin)
        ->first();

        // $data2 = $data2->toArray();
        // dd($data2);
        // $data2 = '';
        
        $nib = $data2->nib;
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();
        $date_reformat = new DateHelper();
        
        if ($data2->status_badan_hukum == '02') {
            $noizinprinsip = DB::table('latest_izinprinsipno_0301')->first();
            // dd("data2");
            // dd($data2);
        }

        $map_izin = array();
        $filled_persyaratan = array();
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $data2->kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        
        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $data2->id_izin)->get();
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
        // return view('layouts.backend.direktur.mypdf', $data);
        if ($data2->status_badan_hukum == '02') {
            if ($filled_persyaratan->count() > 0) {
                $pdf = PDF::loadView('layouts.backend.sk.draft-izin-prinsip-telsus', ['map_izin'=>$map_izin,'data'=>$data2,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$noizinprinsip->izinprisipno] );
            
            $pdf->render();
    
            $output = $pdf->output();
            // dd($output);
            $path = 'app/public/sk_ip/sk-ip-'.$id_izin.'.pdf';
            $pathToPut = storage_path($path);
            $put = file_put_contents($pathToPut, $output);
    
            if ($put > 0) {
                return $path;
            }else{
                return null;
            }
            }
        }
        
        
    }

    public function evaluasiPost ($id, Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_departemen_user = Session::get('id_departemen');
        $userbo = Session::get('nama');
        $status_checklist = 903;
        $izin = Izin::select('*')->where('id_izin','=',$id)
        ->whereIn('status_checklist',[$status_checklist,803])->first();
        
        if (empty($izin)) {
            return abort(404);
        }
        
        // $putfile = $this->putFileSK($id);
        // dd($putfile);

        $izin = $izin->toArray();

        // dd($izin['nama_master_izin']);
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$izin['id_izin'])
        ->first();

        $nib = $izin['nib'];
        $badanhukum = $izin['status_badan_hukum'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();

        $id_izin = $id;
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();
        $array_filled = array();

        foreach ($request->all() as $key => $value) {
            if (strpos($key,'is_koreksi_dokumen_') !== false ) {
                $id_koreksi[] = str_replace('is_koreksi_dokumen_','',$key);
            }
            
            if (strpos($key, 'catatan_dokumen_') !== false) {
                $catatan_koreksi[] = str_replace('catatan_dokumen_','',$key);
            }
        }

        foreach ($catatan_koreksi as $key => $value) {
            $array_filled[$value]['id_trx_izin'] = $id_izin;    
            $array_filled[$value]['id_pemenuhan_syarat'] = $value;
            $array_filled[$value]['catatan'] = $data['catatan_dokumen_'.$value];
            if (isset($data['is_koreksi_dokumen_'.$value]) && $data['is_koreksi_dokumen_'.$value] == 'on') {
                $array_filled[$value]['koreksi'] = 1;
                $koreksi_all = 1;
            }else{
                $array_filled[$value]['koreksi'] = 0;
            }
        }
        
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');
        $departemen = $common->getDepartemen($id_departemen_user);
        
        
        $penanggungjawabs = DB::table('users')->where('oss_id',$nibs['oss_id'])
        ->select('*')->first();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        
        DB::beginTransaction();

        try {
        
        if($badanhukum == '02'){
            $noizinprinsip = DB::table('latest_izinprinsipno_0301')->first();
            $insert = new TrxIzinPrinsip([
                'id_trx_izin' => $izin['id_izin'],
                'no_izin_prinsip' => $noizinprinsip->izinprisipno,
                'iterasi_perpanjangan' => '0',
                'tgl_berlaku' => Carbon::now()->addYear()->format('Y-m-d'),
                'created_by' => $userbo,
                'created_date' => Carbon::now()->format('Y-m-d'),
                'updated_by' => $userbo,
                'updated_date' => Carbon::now()->format('Y-m-d'),

            ]); 

            $insert->save();
        }


            if (count($array_filled) > 0) {
                foreach ($array_filled as $key => $value) {
                    $update = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan','=',$value['id_pemenuhan_syarat'])->where('id_trx_izin','=',$id)->where('is_active','=',1)->update([
                        'created_by'=>Session::get('id_user'),
                        'need_correction'=>$value['koreksi'],
                        'correction_note'=>$value['catatan']
                    ]);
                }
            }

            $Izinoss = Izinoss::where('id_izin','=',$id)->first(); //set status checklist telah didisposisi
            $catatan = $catatan_hasil_evaluasi;
            //insert log
            $insertIzinLog = $log->createIzinLog($Izinoss,$catatan);
            // dd($koreksi_all);
            if ($koreksi_all == 1) {
                if(substr($Izinoss['id_izin'],0,3) == 'TKI')
                {
                $Izinoss->status_checklist = 90;
                }
                else
                {
                $Izinoss->status_checklist = 43;
                }
            }else{
                if(substr($Izinoss['id_izin'],0,3) == 'TKI')
                {
                    $Izinoss->status_checklist = 804;
                }
                else
                {
                    if($Izinoss['kd_izin'] == '059000020066'){
                        $Izinoss->status_checklist = 805;
                    }else{
                        $Izinoss->status_checklist = 10;
                    }
                     
                }   
            }
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();

            //insert ke catatan
            $insert = DB::table('tb_evaluasi_catatan_koordinator')->insert(['id_izin'=>$id,'catatan_hasil_evaluasi'=>$catatan_hasil_evaluasi,'created_by'=>Session::get('id_user'),'is_active'=>1]);

            $code = bin2hex(random_bytes(20));

            // UserSurvey::create([
            //     'id_izin' => $id,
            //     'code' => $code,
            //     'is_active' => 1,
            //     'created_by' => Session::get('id_user'),
            // ]);

            

            if ($koreksi_all == 1) {
                $email_jenis = 'koreksi-pj';
            // }elseif($izin['nama_master_izin'] == "TELSUS"){
            //     $email_jenis = 'izin-prinsip';
            } else {
                $email_jenis = 'evaluasi-koordinator-pj-ulo';
            }

            // if($izin['status_badan_hukum'] = '02'){
               
                
            //     //penanggungjawab dan kirim email
            //     $email_data = array();
            //     $email_data_subkoordinator = array();
            //     // $putfile = $this->putFileSK($id);
            //     // $attachfile = '';
            //     // if ($putfile != null) {
            //     //     $attachfile = $putfile;
            //     //     // DB::table('tb_trx_ulo_sk')->insert(
            //     //     //     ['id_izin' => $id, 'path_sk_ulo' => $putfile,'created_by'=>Session::get('id_user'),'created_at'=>date('Y-m-d H:i:s'),'is_active'=>1]
            //     //     // );
            //     // }

            //     // dd($attachfile);
                
            //     session()->flash('message', 'Berhasil Menerbitkan Surat Keterangan Laik Operasi' );
    
            //     $email_jenis = 'evaluasi-koordinator-pj-ulo';
            //     $nama2 = $evaluator->nama;
            //     $departemen = '';
                
            //     $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$attachfile);
            // }else{
                //penanggungjawab dan kirim email
                $email_data = array();
                // $email_jenis = 'evaluasi-koordinator-pj-ulo';

                $nama2 = $evaluator->nama;

                $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs, 0);

                // $kirim_email_survey = $email->kirim_email($penanggungjawab,'',$izin,'','','', $nibs, 0, '', $id.'?code='.$code);

                session()->flash('message', 'Berhasil Melakukan Evaluasi' );
            // }
            // $email_data = array();
            //     $email_jenis = 'evaluasi-koordinator-pj-ulo';

            //     $nama2 = $evaluator->nama;

            //     $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs);

            //     session()->flash('message', 'Berhasil Melakukan Evaluasi' );
            DB::commit();
            // $izin_status = [
            //     "nib" => $nibs['nib'],
            //     "id_produk" => $Izinoss->id_produk,
            //     "id_proyek" => $Izinoss->id_proyek,
            //     "oss_id" => $Izinoss->oss_id,
            //     "id_izin" => $Izinoss->id_izin,
            //     "kd_izin" => $Izinoss->kd_izin,
            //     "kd_instansi" => '059',
            //     "kd_status" => '10',
            //     "tgl_status" => date('Y-m-d h:i:s'),
            //     "nip_status" => '198901012016011100',
            //     "nama_status" => 'Sheriff Woody S.IP Msc',
            //     "keterangan" => 'Update license status',
            //     "data_pnbp" => [
            //         "kd_akun" => '',
            //         "kd_penerimaan" => '',
            //         "kd_billing" => '',
            //         "tgl_billing" => '',
            //         "tgl_expire" => '',
            //         "nominal" => '',
            //         "url_dokumen" => ''
            //     ]
            // ];

            // $osshub = new Osshub();
            // $licenseStatus = $osshub->updateIzin($izin_status);
           
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Melakukan Evaluasi');
            return Redirect::route('admin.koordinator');
        }

        return Redirect::route('admin.koordinator');
    }

    public function evaluasiPostPenolakan($id,Request $request){
        $date_reformat = new DateHelper();
        $id_izin = $id;
        $izin = Izin::select('*')->where('id_izin','=',$id)->where('status_checklist','=',903)->first();
        if (empty($izin)) {
            return abort(404);
        }
        
        $izin = $izin->toArray();
        $data = $request->all();
        DB::beginTransaction();

        // try {
            $Izinoss = Izinoss::where('id_izin','=',$id)->first(); //set status checklist telah didisposisi
            $Izinoss->status_checklist = 90;
            $Izinoss->save();

            $insertcatatan = Catatankoordinator::create([
                'id_izin'=>$id,
                'catatan_hasil_evaluasi'=>$request['catatan_evaluasi'],
                'is_active'=>1,
                'created_by'=>Session::get('id_user')
            ]);

            session()->flash('message', 'Berhasil Melakukan Evaluasi' );

            DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.koordinator');
    }

    public function disposisi($id, Request $request){
        
        $date_reformat = new DateHelper();
        // dd(Session::get('id'));
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $izin =
        Izin::select('*')->where('id_izin','=',$id)
        ->whereIn('status_checklist',[20,21])
        ->whereIn('id_master_izin',[$id_departemen_user,5])
        ->first();
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        
        $detailNib = $common->get_detail_nib($nib);

        $user = $common->get_user_disposisi($id_departemen_user);

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $date_reformat = new DateHelper();


    	return view('layouts.backend.koordinator.disposisi',['date_reformat'=>$date_reformat,'izin'=>$izin,'id'=>$id,'detailnib'=>$detailNib,'user'=>$user,'penanggungjawab'=>$penanggungjawab]);

    }

    public function disposisiPost($id,Request $request){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $izin =
        Izin::select('*')->where('id_izin','=',$id)
        ->whereIn('status_checklist',[20,21])->first();

        if (empty($izin)) {
            return abort(404);
        }

        $izin = $izin->toArray();

        $data = $request->all();
        $nib = $izin['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $id_user = $data['id_user_disposisi'];

        // dd($data);

        DB::beginTransaction();
        
        $departemen = $common->getDepartemen($id_departemen_user);
        
        try {

            $Izinoss = Izinoss::where('id_izin','=',$id)->first(); //set status checklist telah didisposisi

            //insert log
            $status_checklist = null;
            $insertIzinLog = $log->createIzinLog($Izinoss,$status_checklist);
            $id_izin_init = substr($data['id_izin'],0,3);
            // dd($id_izin_init);
            if ($id_izin_init=='TKI') {
                $Izinoss->status_checklist = 801;
            }
            else{
                $Izinoss->status_checklist = 901;
            }
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();

            $disposisi = Disposisi::create([
                    'id_izin'=>$id,
                    'id_disposisi_user'=>$id_user,
                    'catatan'=>$data['catatan'],
                    'created_by'=>Session::get('id_user'),
                    'status_checklist_awal'=>$izin['status_checklist'],
                    'is_active'=>1
            ]);

            
            DB::commit();
            
            // Session::flash('message', 'Berhasil Melakukan Disposisi ke Evaluator');

            
            //penanggungjawab dan kirim email
            // $evaluator = User::select('nama','email')->where('id','=',$id_user)->first();
            $evaluator = User::select('nama','email','id_mst_jobposition')->where('id','=',$id_user)->first()->toArray();
            $jabatan = DB::table('tb_mst_jobposition')->where('id',$evaluator['id_mst_jobposition'])->first();
            // dd($evaluator['id_mst_jobposition']);
            $evaluator_email = $evaluator['email']?$evaluator['email']:'';
            $evaluator_nama = $evaluator['nama']?$evaluator['nama']:'';

            $email_data = array();
            $email_data_evaluator = array();
            
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            //mengirim email ke penanggung jawab
            $nama2 = $evaluator_nama;
            $email_jenis = 'disposisi-pj';
            $catatan_hasil_evaluasi = $data['catatan'];
            // dd($email_data);

            // if ($email_data['email'] != '') {
            //     $common->send_email($email_data);
            // }
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs);

            //end mengirim email ke penanggung jawab

            //mengirim email ke evaluator
            $is_koreksi = 0;
            $user['email'] = $evaluator_email;
            $user['nama'] = $evaluator_nama;
            $nama2 = $evaluator_nama;
            $email_jenis = 'disposisi';
            $catatan_hasil_evaluasi = $data['catatan'];
            // dd($email_data_evaluator);

            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$is_koreksi,$jabatan);

            // $izin_status = [
            //     "nib" => $nibs['nib'],
            //     "id_produk" => $Izinoss->id_produk,
            //     "id_proyek" => $Izinoss->id_proyek,
            //     "oss_id" => $Izinoss->oss_id,
            //     "id_izin" => $Izinoss->id_izin,
            //     "kd_izin" => $Izinoss->kd_izin,
            //     "kd_instansi" => '059',
            //     "kd_status" => '20',
            //     "tgl_status" => date('Y-m-d h:i:s'),
            //     "nip_status" => '198901012016011100',
            //     "nama_status" => 'Sheriff Woody S.IP Msc',
            //     "keterangan" => 'Update license status',
            //     "data_pnbp" => [
            //         "kd_akun" => '',
            //         "kd_penerimaan" => '',
            //         "kd_billing" => '',
            //         "tgl_billing" => '',
            //         "tgl_expire" => '',
            //         "nominal" => '',
            //         "url_dokumen" => ''
            //     ]
            // ];

            // $osshub = new Osshub();
            // $licenseStatus = $osshub->updateIzin($izin_status);

        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Melakukan Disposisi ke Evaluator');
            return Redirect::route('admin.koordinator');
        }
        
        return Redirect::route('admin.koordinator')->with('message', 'Berhasil Melakukan Disposisi ke Evaluator.');
    }

    public function getLogIzin(Request $request){
        $date_reformat = new DateHelper();
        $id_izin = $request['id_izin'];
        
        if($request->ajax()){
            $log = Izinlog::select('*')->where('id_izin','=',$id_izin)->orderBy('created_at')->get()->toArray();
            if (empty($log)) {
                return response()->json('is_empty');
            }else{
                return response()->json($log);    
            }

            return response()->json($log);
        }else{
            return abort(404);
        }   
    }

    public function ulo(){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $paginate = array();
        $id_jabatan = Session::get('id_jabatan');
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');

        if (Session::get('id_mst_jobposition') != 10) {
            return abort(404);
        }

        $ulo = array();
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,'EMPTY',$id_jabatan);
        // dd($ulo);
        if ($ulo->count() > 0) { //handle paginate error division by zero
            $ulo = $ulo->paginate($limit_db);
        }else{
            $ulo = $ulo->get();
        }
        // dd ($ulo);
        $paginate = $ulo;
        $ulo = $ulo->toArray();
        $countdisposisi = $common->countUlo(20);
        $countpersetujuan = $common->countUlo(903);
        // dd($ulo);
        return view('layouts.backend.koordinator.dashboard-ulo',['date_reformat'=>$date_reformat,'paginate'=>$paginate,'ulo'=>$ulo,'countdisposisi'=>$countdisposisi,'countpersetujuan'=>$countpersetujuan]);
    }

    public function disposisiUlo($id_izin, $urut, Request $request){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        $id_jabatan = Session::get('id_jabatan');
        $id_mst_jobposition = Session::get('id_mst_jobposition');
        
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)->first();
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $penanggungjawab = array();
        $detailNib = array();
        $user = array();
        $common = new CommonHelper;

        $id = $id_izin;

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$urut,$id_jabatan);
        // dd($ulo);
        if ($ulo == null) {
            return abort(404);
        }
        $ulo = $ulo->toArray();
        
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];

        $map_izin = array();
        $filled_persyaratan = array();

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id','kode_izin','name')->where('kode_izin','=',$kd_izin)->first();
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

        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);

        $user = $common->get_user_disposisi_ulo($id_mst_jobposition);
        // dd($user);
        return view('layouts.backend.koordinator.disposisi-ulo',['date_reformat'=>$date_reformat,'ulo'=>$ulo,'id'=>$id,'izin' => $izin,'detailnib'=>$detailNib,'user'=>$user,'penanggungjawab'=>$penanggungjawab,'map_izin' => $map_izin]);
    }

    public function disposisiUloPost($id_izin, $urut, Request $request){
        // dd($request->all());

        $date_reformat = new DateHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$urut,$id_jabatan);
        // dd($ulo);

        // dd($izin);  
        // $status_checklist = $izin->status_checklist;
        
        if (empty($ulo)) {
            return abort(404);
        }

        $data = $request->all();
        $nib = $ulo['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $id_user = $data['id_user_disposisi'];
        $Izinoss = Izinoss::where('id_izin', '=', $id_izin)->first(); //set status checklist telah didisposisi
        $departemen = $common->getDepartemen($id_departemen_user);

        DB::beginTransaction();
        try{
            $id_ulo = $ulo['id_ulo'];
            $uloToLog = Ulo::select('*')->where('id','=',$id_ulo)->first();
            $uloSave = $uloToLog;
            
            $status_ulo = 20;
            //insert log
            $catatan = null;
            $insertUloLog = $log->createUloLog($uloToLog,$catatan,$status_ulo);

            $uloSave->updated_date = date('Y-m-d H:i:s');
            $uloSave->updated_by = Session::get('id_user');
            $uloSave->status_ulo = 901;
            $uloSave->save();

            $disposisi = Disposisiulo::create([
                    'id_izin'=>$id_izin,
                    'id_ulo'=>$ulo['id'],
                    'id_disposisi_user'=>$id_user,
                    'catatan'=>$data['catatan'],
                    'created_by'=>Session::get('id_user'),
                    'status_checklist_awal'=>$ulo['status_ulo'],
                    'is_active'=>1
                ]);
            DB::commit();

            //penanggungjawab dan kirim email
            // $evaluator = User::select('nama','email')->where('id','=',$id_user)->first();
            $evaluator = User::select('nama','email','id_mst_jobposition')->where('id','=',$id_user)->first()->toArray();
            $evaluator_email = $evaluator['email']?$evaluator['email']:'';
            $evaluator_nama = $evaluator['nama']?$evaluator['nama']:'';
            $jabatan = DB::table('tb_mst_jobposition')->where('id',$evaluator['id_mst_jobposition'])->first();
            // dd($jabatan);   
          
            $email_data = array();
            $email_data_evaluator = array();
            
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);
            $koreksi_all = 0;   

            //mengirim email ke penanggung jawab
            
            $nama2 = $evaluator_nama;
            $catatan_hasil_evaluasi = $data['catatan'];
            $email_jenis = 'disposisi-ulo';
            $izin = $ulo;
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs);
            //end mengirim email ke penanggung jawab

            //mengirim email ke evaluator
            $user['email'] = $evaluator_email;
            $user['nama'] = $evaluator_nama;
            $nama2 = $evaluator_nama;
            $email_jenis = 'disposisi';
            $catatan_hasil_evaluasi = $data['catatan'];
            // dd($email_data_evaluator);

            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$jabatan);

            // $izin_status = [
            //     "nib" => $nibs['nib'],
            //     "id_produk" => $Izinoss->id_produk,
            //     "id_proyek" => $Izinoss->id_proyek,
            //     "oss_id" => $Izinoss->oss_id,
            //     "id_izin" => $Izinoss->id_izin,
            //     "kd_izin" => $Izinoss->kd_izin,
            //     "kd_instansi" => '059',
            //     "kd_status" => '20',
            //     "tgl_status" => date('Y-m-d h:i:s'),
            //     "nip_status" => '198901012016011100',
            //     "nama_status" => 'Sheriff Woody S.IP Msc',
            //     "keterangan" => 'Update license status',
            //     "data_pnbp" => [
            //         "kd_akun" => '',
            //         "kd_penerimaan" => '',
            //         "kd_billing" => '',
            //         "tgl_billing" => '',
            //         "tgl_expire" => '',
            //         "nominal" => '',
            //         "url_dokumen" => ''
            //     ]
            // ];

            // $osshub = new Osshub();
            // $licenseStatus = $osshub->updateIzin($izin_status);

        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Disposisi ULO');
            return Redirect::route('admin.koordinator.ulo');
        }

        return Redirect::route('admin.koordinator.ulo');
    }

    public function evaluasiUlo($id_izin,$urut,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$urut,$id_jabatan);
        // dd($ulo);
        $izin = Izin::select('*')->where('id_izin', '=', $id_izin)->first();
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();

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

        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id','kode_izin','name')->where('kode_izin','=',$kd_izin)->first();
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
        
        return view('layouts.backend.koordinator.evaluasi-ulo',['date_reformat'=>$date_reformat,'id'=>$id_izin,'ulo'=>$ulo,'izin' => $izin,'detailnib'=>$detailNib ,'penanggungjawab'=>$penanggungjawab,'map_izin' => $map_izin]);
    }

    public function evaluasiUloPost($id,$urut,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.koordinator-ulo');
        }

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$urut,$id_jabatan);
        
        if (empty($ulo)) {
            return abort(404);
        }

        $ulo = $ulo->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$ulo['id_izin'])
        ->first();
        $nib = $ulo['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $ulo['kd_izin'];
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first();
        $status_badan_hukum = $ulo['nama_master_izin'];
        
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();
        
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get subkoordinator
        // $subkoordinator = $common->get_subkoordinator_first($id_departemen_user);
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();
        
        try {
            //
            $id_ulo = $ulo['id_ulo'];
            $uloToLog = Ulo::select('*')->where('id','=',$id_ulo)->first();
            $uloSave = $uloToLog;

            if ((isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan'] == 'on') 
                || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on' 
                || isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas'] == 'on') {
                $koreksi_all = 1;
            }

            if ($koreksi_all == 1) {
                $status_ulo = 43;
                $uloSave->status_ulo = 43;
            }else{
                $status_ulo = 903;
                $uloSave->status_ulo = 904;    
            }
            
            //insert log
            // $insertUloLog = $log->createUloLog($uloToLog,$status_ulo);
            $catatan = $catatan_hasil_evaluasi;
            //insert log
            $insertUloLog = $log->createUloLog($uloToLog,$catatan,$status_ulo);

            if (isset($data['is_koreksi_surat_permohonan']) && $data['is_koreksi_surat_permohonan']) {
                $uloSave->is_koreksi_surat_permohonan = 1;
            }

            if (isset($data['is_koreksi_surat_tugas']) && $data['is_koreksi_surat_tugas']) {
                $uloSave->is_koreksi_surat_tugas = 1;
            }

            if (isset($data['is_koreksi_hasil_pengujian']) && $data['is_koreksi_hasil_pengujian']) {
                $uloSave->is_koreksi_hasil_pengujian = 1;
            }
            
            $uloSave->catatan_surat_permohonan = isset($data['catatan_surat_permohonan']) ? $data['catatan_surat_permohonan'] : '';
            $uloSave->catatan_surat_tugas = isset($data['catatan_surat_tugas']) ? $data['catatan_surat_tugas'] : '';
            $uloSave->catatan_hasil_pengujian = isset($data['catatan_hasil_pengujian']) ? $data['catatan_hasil_pengujian'] : '';
            $uloSave->catatan_evaluasi = $data['catatan_hasil_evaluasi'];
            $uloSave->updated_date = date('Y-m-d H:i:s');
            // $uloSave->status_laik = $data['status_laik'];
            $uloSave->save();

            //update persyaratan
            $id_konfigurasi_sistem = $data['id_konfigurasi_sistem'];
                
            if ($status_badan_hukum=='TELSUS') {

            }else if(isset($data['id_bukti_perangkat'])){
                $id_bukti_perangkat = $data['id_bukti_perangkat'];
            }
            $id_daftar_perangkat = $data['id_daftar_perangkat'];

            $path_sertifikat_alat = '';
            $path_bukti_perangkat = '';
            $path_foto_sn_perangkat = '';
            $path_konfigurasi_sistem = '';

            if($konfigurasi_sistem = $request->file('konfigurasi_sistem')){
                $filename_konfigurasi_sistem = "KOMINFO_konfigurasi_sistem".time().'.'.$konfigurasi_sistem->extension();
                $path_konfigurasi_sistem = $konfigurasi_sistem->storeAs('public/file_ulo', $filename_konfigurasi_sistem);
                if ($path_konfigurasi_sistem == '' || $path_konfigurasi_sistem == NULL) {
                    $path_konfigurasi_sistem = $data['path_konfigurasi_sistem'];
                    // dd($path_konfigurasi_sistem);
                }
                // dd($path_konfigurasi_sistem);
                $name_konfigurasi_sistem = $konfigurasi_sistem->getClientOriginalName();
                $path_konfigurasi_sistem = str_replace('public/', 'storage/', $path_konfigurasi_sistem);
            }
            
            if($sertifikat_alat = $request->file('sertifikat_alat')){
                $filename_sertifikat_alat = "KOMINFO_sertifikat_alat".time().'.'.$sertifikat_alat->extension();
                $path_sertifikat_alat = $sertifikat_alat->storeAs('public/file_ulo', $filename_sertifikat_alat);
                $name_sertifikat_alat = $sertifikat_alat->getClientOriginalName();
                $path_sertifikat_alat = str_replace('public/', 'storage/', $path_sertifikat_alat);
            }
            if($foto_sn_perangkat = $request->file('foto_sn_perangkat')){
                $filename_foto_sn_perangkat = "KOMINFO_foto_sn_perangkat".time().'.'.$foto_sn_perangkat->extension();
                $path_foto_sn_perangkat = $foto_sn_perangkat->storeAs('public/file_ulo', $filename_foto_sn_perangkat);
                $name_foto_sn_perangkat = $foto_sn_perangkat->getClientOriginalName();
                $path_foto_sn_perangkat = str_replace('public/', 'storage/', $path_foto_sn_perangkat);
            }
            if ($status_badan_hukum=='TELSUS') {
                
            }else{
                if($bukti_perangkat = $request->file('bukti_perangkat')){
                    $filename_bukti_perangkat = "KOMINFO_bukti_perangkat".time().'.'.$bukti_perangkat->extension();
                    $path_bukti_perangkat = $bukti_perangkat->storeAs('public/file_ulo', $filename_bukti_perangkat);
                    if ($path_bukti_perangkat == '' || $path_bukti_perangkat == NULL) {
                        $path_bukti_perangkat = $data['path_bukti_perangkat'];
                        // dd($path_bukti_perangkat);
                    }
                    $name_bukti_perangkat = $bukti_perangkat->getClientOriginalName();
                    $path_bukti_perangkat = str_replace('public/', 'storage/', $path_bukti_perangkat);
                }
                // if($foto_sn_perangkat = $request->file('foto_sn_perangkat')){
                //     $filename_foto_sn_perangkat = "KOMINFO_foto_sn_perangkat".time().'.'.$foto_sn_perangkat->extension();
                //     $path_foto_sn_perangkat = $foto_sn_perangkat->storeAs('public/file_ulo', $filename_foto_sn_perangkat);
                //     if ($path_foto_sn_perangkat == '' || $path_foto_sn_perangkat == NULL) {
                //         $path_foto_sn_perangkat = $data['path_foto_sn_perangkat'];
                //         // dd($path_bukti_perangkat);
                //     }
                //     $name_foto_sn_perangkat = $foto_sn_perangkat->getClientOriginalName();
                //     $path_foto_sn_perangkat = str_replace('public/', 'storage/', $path_foto_sn_perangkat);
                // }
            }
            
            if ($status_badan_hukum=='TELSUS') {
                $data['daftar_perangkat_telsus'][0]['sertifikasi_alat'] = $path_sertifikat_alat;
            } else {
                $data['daftar_perangkat'][0]['sertifikasi_alat'] = $path_sertifikat_alat;
                $data['daftar_perangkat'][0]['foto_sn_perangkat'] = $path_foto_sn_perangkat;
            }


            // if($path_bukti_perangkat != ''){
            //     $data['bukti_perangkat'][0]['sertifikasi_alat'] = $path_bukti_perangkat;
            // }
            // if($path_konfigurasi_sistem != ''){
            //     $data['konfigurasi_sistem'][0]['sertifikasi_alat'] = $path_konfigurasi_sistem;
            // }
            /**
             * 
             * Disable update daftar perangket
             * 
             
            if ($status_badan_hukum=='TELSUS') {
                $daftar_perangkat_save = json_encode($data['daftar_perangkat_telsus']);
    
                //update konfigurasi teknis
                $update_daftar_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_daftar_perangkat)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $daftar_perangkat_save]);
            } else {
                $daftar_perangkat_save = json_encode($data['daftar_perangkat']);
    
                //update konfigurasi teknis
                $update_daftar_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_daftar_perangkat)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $daftar_perangkat_save
                ]);
            }
             */
            
    
            $update_konfigurasi_sistem = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_konfigurasi_sistem)->where('id_trx_izin', '=', $id)->update([
                'filled_document' => $path_konfigurasi_sistem
            ]);
            if ($status_badan_hukum=='TELSUS') {
                
            } else if (isset($data['id_bukti_perangkat'])) {
                $update_bukti_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_bukti_perangkat)->where('id_trx_izin', '=', $id)->update([
                    'filled_document' => $path_bukti_perangkat
                ]);
                // $update_foto_sn_perangkat = DB::table('tb_trx_persyaratan')->select('*')->where('id_map_listpersyaratan', '=', $id_foto_sn_perangkat)->where('id_trx_izin', '=', $id)->update([
                //     'filled_document' => $foto_sn_perangkat
                // ]);
            }
            //end update persyaratan
            
            DB::commit();
            session()->flash('message', 'Berhasil Mengirim Evaluasi ke Direktur' );
            //penanggungjawab dan kirim email
            $email_data = array();
            $email_data_subkoordinator = array();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            $direktur = DB::table('tb_mst_user_bo')->select('id','nama','email','id_mst_jobposition')
            ->where('tb_mst_user_bo.id_mst_jobposition','=',16)
            ->first();
            $jabatan = DB::table('tb_mst_jobposition')->where('id',$direktur->id_mst_jobposition)->first();

            // dd($direktur);
            // if ($email_data['email'] != '') {
            //     $common->send_email($email_data);
            // }
            
            $email_jenis = 'direktur-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$ulo,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);

            $is_koreksi = 0;
            $user['email'] = $direktur->email;
            $user['nama'] = $direktur->nama;
            $nama2 = $evaluator->nama;
            $email_jenis = 'direktur';
            $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            // dd($ulo);
    
            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user,$email_jenis,$ulo,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$is_koreksi,$jabatan);

            // //kirim email subkoordinator
            // $email_data_subkoordinator['email'] = isset($subkoordinator->email)?$subkoordinator->email:'';
            // $email_data_subkoordinator['jenis'] = 'evaluasi-koordinator';
            // $email_data_subkoordinator['izin'] = $ulo;
            // $email_data_subkoordinator['departemen'] = $departemen;
            // $email_data_subkoordinator['nama'] = $subkoordinator->nama;
            // $email_data['is_koreksi'] = $koreksi_all;
            // $email_data['catatan'] = $catatan_hasil_evaluasi;

            // if ($subkoordinator->email != '') {
            //     $common->send_email($email_data_subkoordinator);
            // }
            // $izin_status = [
            //         "nib" => $nibs['nib'],
            //         "id_produk" => $Izinoss->id_produk,
            //         "id_proyek" => $Izinoss->id_proyek,
            //         "oss_id" => $Izinoss->oss_id,
            //         "id_izin" => $Izinoss->id_izin,
            //         "kd_izin" => $Izinoss->kd_izin,
            //         "kd_instansi" => '059',
            //         "kd_status" => '10',
            //         "tgl_status" => date('Y-m-d h:i:s'),
            //         "nip_status" => '198901012016011100',
            //         "nama_status" => 'Sheriff Woody S.IP Msc',
            //         "keterangan" => 'Update license status',
            //         "data_pnbp" => [
            //             "kd_akun" => '',
            //             "kd_penerimaan" => '',
            //             "kd_billing" => '',
            //             "tgl_billing" => '',
            //             "tgl_expire" => '',
            //             "nominal" => '',
            //             "url_dokumen" => ''
            //         ]
            //     ];

            // $osshub = new Osshub();
            // $licenseStatus = $osshub->updateIzin($izin_status);
            
        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Mengirim Evaluasi ke Direktur');
            return Redirect::route('admin.koordinator.ulo');
        }

        return Redirect::route('admin.koordinator.ulo');
    }

    public function penomoran(){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user != 5) {
            return abort(404);
        }
        
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*', 'z.name_status_fo as penomoran_fo', 'z.name_status_bo as penomoran_bo', 'y.kode_akses')
        ->join('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->join('tb_oss_mst_kodestatusizin as z','t.status_permohonan','=','z.oss_kode')
        ->join('tb_mst_kode_akses as y','t.id_mst_kode_akses','=','y.id')->with('KodeIzin')->with('KodeAkses')
        ->take($limit_db);
        // ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->take($limit_db);
        // dd($penomoran);
        $countdisposisi = $penomoran->clone()->where(function($q) {
            $q->where('t.status_permohonan','=',20);
        })->get()->count();
        $countevaluasi = $penomoran->clone()->where(function($q) {
            $q->where('t.status_permohonan','=',903);
        })->get()->count();
        $penomoran = $penomoran->clone()->whereIn('t.status_permohonan',[20,903]);
        
        // dd($penomoran);
        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        }else{
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        // dd($penomoran);
        $penomoran = $penomoran->toArray();

        //getcountiizin 
        // $countdisposisi = IzinHelper::countPenomoran(20,$id_departemen_user);
        // $countevaluasi = IzinHelper::countPenomoran(903,$id_departemen_user);
        // dd($penomoran);
        $jenis_izin = 'Izin Penyelenggaraan Penomoran Telekomunikasi';
        // return view('layouts.frontend.penomoran.main_penomoran');
        return view('layouts.backend.koordinator.dashboard-penomoran',['date_reformat'=>$date_reformat,'penomoran'=>$penomoran,'paginate'=>$paginate,'jenis_izin'=>$jenis_izin,'countdisposisi'=>$countdisposisi,'countevaluasi'=>$countevaluasi]);
    }

    public function disposisiPenomoran(Request $request, $id_izin,$id_kodeakses){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.id_izin','v.nib','v.id_proyek','v.kd_izin','v.jenis_izin','v.id_master_izin','v.nama_master_izin','v.kbli','v.kbli_name','v.nama_perseroan','v.full_kbli','v.jenis_layanan','v.kabupaten_name','v.provinsi_name')
        // $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->where('t.id','=',$id_kodeakses)
        ->where('t.status_permohonan','=',20)
        ->with('KodeIzin')->with('KodeAkses')->first();

        if ($penomoran == null) {
            return abort(404);
        }
        DB::beginTransaction();
        try {
            $penomoran = $penomoran->toArray();
            $log = new LogHelper();
            $id_mst_kode_akses = isset($penomoran['id_mst_kode_akses'])?$penomoran['id_mst_kode_akses']:'';
            // dd($id_mst_kode_akses);
            $penomoran = $common->getDetailKodeAkses($penomoran,$id_mst_kode_akses);
           
            // $map = $common->getMapKodeAkses($id_mst_kode_akses);

            $nib = $penomoran['nib'];

            $detailNib = $common->get_detail_nib($nib);

            $user = $common->get_user_disposisi($id_departemen_user);

            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            $penomoranlog = Penomoranlog::where('id_izin','=',$id_izin)
            // ->where('id_kode_akses','=',$id_kodeakses)
            ->with('KodeIzin')->get()->toArray();

            $Izinoss = Izinoss::where('id_izin','=',$id_izin)->first(); //set status checklist telah didisposisi

            //insert log
            $status_checklist = null;
            $insertIzinLog = $log->createIzinLog($Izinoss,$status_checklist);
            $id_izin_init = substr($Izinoss['id_izin'],0,3);
            if ($id_izin_init=='PTB') {
            $Izinoss->status_checklist = 801;
            }
            else{
            $Izinoss->status_checklist = 901;
            }
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Melakukan Disposisi ke Evaluator');
            return Redirect::route('admin.koordinator');
        }
        
       
        // dd($penomoranlog);

        return view('layouts.backend.koordinator.disposisi-penomoran',['date_reformat'=>$date_reformat,'penomoran'=>$penomoran,'id'=>$id_izin,'detailnib'=>$detailNib,'user'=>$user,'penanggungjawab'=>$penanggungjawab,'penomoranlog'=>$penomoranlog]);

    } 

    public function evaluasiUloPostPenolakan($id,$urut,Request $request){
        $date_reformat = new DateHelper();
        $status_ulo = 903;
        $id_izin = $id;
        $ulo = Ulo::select('*')->where('id','=',$urut)->where('status_ulo','=',$status_ulo)->first();
        if (empty($ulo)) {
            return abort(404);
        }
        
        $ulo = $ulo->toArray();
        $data = $request->all();
        
        DB::beginTransaction();
        // try {

            $uloSave = Ulo::where('id','=',$urut)->first(); //set status checklist telah didisposisi
            $uloSave->status_ulo = 90;
            $uloSave->catatan_evaluasi = $data['catatan_hasil_evaluasi'];
            $uloSave->save();

            // $insertcatatan = Catatansubkoordinator::create([
            //     'id_izin'=>$id,
            //     'catatan_hasil_evaluasi'=>$request['catatan_evaluasi'],
            //     'is_active'=>1,
            //     'created_by'=>Session::get('id_user')
            // ]);
            DB::commit();
            session()->flash('message', 'Berhasil Melakukan Evaluasi' );

            
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.koordinator');
    }

    public function disposisiPenomoranPost($id,$id_kodeakses,Request $request){
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')
        ->select('t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->where('t.id','=',$id_kodeakses)->where('t.status_permohonan','=',20)->with('KodeIzin')->with('KodeAkses')->first();
        
        if (empty($penomoran)) {
            return abort(404);
        }

        $penomoran = $penomoran->toArray();
        
        $mst_kodeakses = $common->getDetailKodeAkses($penomoran,$penomoran['id_mst_kode_akses']);
        
        // dd($mst_kodeakses);

        $data = $request->all();
        $nib = $penomoran['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $id_user = $data['id_user_disposisi'];

        DB::beginTransaction();
        
        $departemen = $common->getDepartemen($id_departemen_user);
        $penomoranid = $penomoran['id'];
        $penomorans = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first();
        // $penomoranToLog = $penomorans->toArray();

        //insert log
        $status_permohonan = 20;
        $penomorans->status_permohonan = 901;
        $penomorans->updated_by = Session::get('nama');
        $penomorans->updated_date = date('Y-m-d H:i:s');
        $penomorans->save();
        
        $penomoranToLog = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first()->toArray();
        $insertPenomoranLog = $log->createPenomoranLog($penomoranToLog,$status_permohonan);

        DB::commit();
        $disposisi = DB::table('tb_trx_disposisi_evaluator_penomoran')->insert([
            'id_izin'=>$id,
            'id_disposisi_user'=>$id_user,
            'catatan'=>$data['catatan'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'created_by'=>Session::get('id_user'),
            'status_checklist_awal'=>$penomorans['status_permohonan'],
            'is_active'=>1
        ]);

        Session::flash('message', 'Berhasil Melakukan Disposisi ke Evaluator');

        //penanggungjawab dan kirim email
        $evaluator = User::select('nama','email','id_mst_jobposition')->where('id','=',$id_user)->first()->toArray();
        $jabatan = DB::table('tb_mst_jobposition')->where('id',$evaluator['id_mst_jobposition'])->first();
        $evaluator_email = $evaluator['email']?$evaluator['email']:'';
        $evaluator_nama = $evaluator['nama']?$evaluator['nama']:'';

        $email_data = array();
        $email_data_evaluator = array();
        
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);

        // $mst_kodeakses = DB::table('tb_mst_kode_akses')->where('id',$penomoran['id_mst_kode_akses'])->first();

        $departemen = [
            "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
            "jenis_penomoran" => $mst_kodeakses['kode_akses']['jeniskodeakses']['full_name'],
            "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
        ];

        //mengirim email ke penanggung jawab
        $nama2 = $evaluator_nama;
        $email_jenis = 'disposisi-pj';
        $catatan_hasil_evaluasi = $data['catatan'];
        // dd($email_data);

        // if ($email_data['email'] != '') {
        //     $common->send_email($email_data);
        // }
        $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs);

        //end mengirim email ke penanggung jawab

        //mengirim email ke evaluator
        $is_koreksi = 0;
        $user['email'] = $evaluator_email;
        $user['nama'] = $evaluator_nama;
        $nama2 = $evaluator_nama;
        $email_jenis = 'disposisi';
        $catatan_hasil_evaluasi = $data['catatan'];
        // dd($email_data_evaluator);

        //end mengirim email ke evaluator
        $kirim_email2 = $email->kirim_email2($user,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$is_koreksi,$jabatan);

        return Redirect::route('admin.koordinator')->with('message', 'Disposisi berhasil di prosess');
        
    } 

    public function evaluasiPenomoran($id,$id_kodeakses,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 903;
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_oss_trxizin','=','v.id')
        ->where('t.id','=',$id_kodeakses)
        ->where('t.status_permohonan','=',$status_penomoran)
        ->with('KodeIzin')->with('KodeAkses')->first();

        if ($penomoran == null) {
            return abort(404);
        }
        $penomoran = $penomoran->toArray();
        
        $id_mst_kode_akses = isset($penomoran['id_mst_kode_akses'])?$penomoran['id_mst_kode_akses']:'';
        $penomoran = $common->getDetailKodeAkses($penomoran,$id_mst_kode_akses);
        
        $map = $common->getMapKodeAkses($id_mst_kode_akses);
        
        $nib = $penomoran['nib'];
        
        $detailNib = $common->get_detail_nib($nib);
        
        $penanggungjawab = array();
        $detailNib = $common->get_detail_nib($nib);
        $penanggungjawab = $common->get_pj_nib($nib);
        
        $penomoranlog = Penomoranlog::where('id_izin','=',$id)
        // ->where('id_kode_akses','=',$id_kodeakses)
        ->with('KodeIzin')->get()->toArray();
        
        return view('layouts.backend.koordinator.evaluasi-penomoran',['date_reformat'=>$date_reformat,'id'=>$id,'penomoran'=>$penomoran,'detailnib'=>$detailNib ,'penanggungjawab'=>$penanggungjawab,'map'=>$map,'penomoranlog'=>$penomoranlog]);
    } 

    public function evaluasiPenomoranPost($id,$id_kodeakses,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];
        $status_penomoran = 903;
        
        if ($id_izin != $id) {
            return Redirect::route('admin.koordinator.penomoran');
        }

        $penomoran = Penomoran::from('tb_trx_kode_akses as t')
        ->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->where('t.id','=',$id_kodeakses)
        ->where('t.status_permohonan','=',$status_penomoran)->with('KodeIzin')->with('KodeAkses')->first();
        
        if ($penomoran == null) {
            return abort(404);
        }
        $penomoran = $penomoran->toArray();

        // dd($penomoran);

        $mst_kodeakses = $common->getDetailKodeAkses($penomoran,$penomoran['id_mst_kode_akses']);

        $nib = $penomoran['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $penomoran['kd_izin'];
        
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $catatan_koreksi = array();
        
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //kondisional departemen
        // $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();
        
        // try {
            
            $penomoranid = $penomoran['id'];
            $getPenomoran = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first();
            $penomoranToSave = $getPenomoran;

            if($data['status_sk'] == 0){ //jika ditolak
                $penomoranToSave->status_permohonan = 90;
            }else{
                if(isset($data['is_koreksi_dokumen_1']) && $data['is_koreksi_dokumen_1'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_dok_pengguna_penomoran = 1;}else{$penomoranToSave->is_koreksi_dok_pengguna_penomoran = 0;}
                if(isset($data['is_koreksi_dokumen_2']) && $data['is_koreksi_dokumen_2'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_dok_kode_akses_konten = 1;}else{$penomoranToSave->is_koreksi_dok_kode_akses_konten = 0;}
                if(isset($data['is_koreksi_dokumen_3']) && $data['is_koreksi_dokumen_3'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_dok_call_center = 1;}else{$penomoranToSave->is_koreksi_dok_call_center = 0;}
                if(isset($data['is_koreksi_dokumen_4']) && $data['is_koreksi_dokumen_4'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_pe_dok_sk = 1;}else{$penomoranToSave->is_koreksi_pe_dok_sk = 0;}
                if(isset($data['is_koreksi_dokumen_5']) && $data['is_koreksi_dokumen_5'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_pe_dok_perizinan_terakhir = 1;}else{$penomoranToSave->is_koreksi_pe_dok_perizinan_terakhir = 0;}
                if(isset($data['is_koreksi_dokumen_6']) && $data['is_koreksi_dokumen_6'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_pe_pe_dok_pendukung = 1;}else{$penomoranToSave->is_koreksi_pe_pe_dok_pendukung = 0;}
                if(isset($data['is_koreksi_dokumen_7']) && $data['is_koreksi_dokumen_7'] == 'on'){$koreksi_all = 1;$penomoranToSave->is_koreksi_dok_izin_penyelenggaraan = 1;}else{$penomoranToSave->is_koreksi_dok_izin_penyelenggaraan = 0;}

                //kondisional jika koreksi
                if($koreksi_all == 1){
                    $penomoranToSave->status_permohonan = 90;
                    $penomoranToSave->catatan_dok_pengguna_penomoran = isset($data['catatan_dok_pengguna_penomoran ']) ? $data['catatan_dok_pengguna_penomoran '] :'';
                    $penomoranToSave->catatan_dok_kode_akses_konten = isset($data['catatan_dok_kode_akses_konten']) ? $data['catatan_dok_kode_akses_konten'] : '';
                    $penomoranToSave->catatan_dok_call_center = isset($data['catatan_dok_call_center']) ? $data['catatan_dok_call_center'] : '';
                    $penomoranToSave->catatan_dok_izin_penyelenggaraan = isset($data['catatan_dok_izin_penyelenggaraan']) ? $data['catatan_dok_izin_penyelenggaraan'] : '';
                    $penomoranToSave->catatan_pe_dok_sk = isset($data['catatan_pe_dok_sk']) ? $data['catatan_pe_dok_sk'] : '';
                    $penomoranToSave->catatan_pe_dok_perizinan_terakhir = isset($data['catatan_pe_dok_perizinan_terakhir']) ? $data['catatan_pe_dok_perizinan_terakhir'] : '';
                    $penomoranToSave->catatan_pe_dok_pendukung = isset($data['catatan_pe_dok_pendukung']) ? $data['catatan_pe_dok_pendukung'] : '';
                }else{
                    $penomoranToSave->catatan_dok_pengguna_penomoran = '';
                    $penomoranToSave->catatan_dok_kode_akses_konten = '';
                    $penomoranToSave->catatan_dok_call_center = '';
                    $penomoranToSave->catatan_dok_izin_penyelenggaraan = '';
                    $penomoranToSave->catatan_pe_dok_sk = '';
                    $penomoranToSave->catatan_pe_dok_perizinan_terakhir = '';
                    $penomoranToSave->catatan_pe_dok_pendukung = '';
                    $penomoranToSave->status_permohonan = 915;
                }
            }
            $penomoranToSave->catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            $penomoranToSave->updated_date = date('Y-m-d H:i:s');
            $penomoranToSave->updated_by = Session::get('name');
            $penomoranToSave->save();
            
            //insert log
            $penomoranToLog = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first()->toArray();
            $insertPenomoranLog = $log->createPenomoranLog($penomoranToLog,$status_penomoran);
            
            $Izinoss = Izinoss::where('id_izin','=',$data['id_izin'])->first(); //set status checklist telah didisposisi
            $catatan = $catatan_hasil_evaluasi;
            //insert log
            $insertIzinLog = $log->createIzinLog($Izinoss,$catatan);

            if ($koreksi_all == 1) {
            $Izinoss->status_checklist = 90;
            }else{
            
            $Izinoss->status_checklist = 915;
            
            }
            
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();

            DB::commit();

            $departemen = [
                "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
                "jenis_penomoran" => $mst_kodeakses['kode_akses']['jeniskodeakses']['full_name'],
                "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
            ];

            //penanggungjawab dan kirim email
            $email_data = array();
            $email_data_subkoordinator = array();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);
            $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
            ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
            ->where('a.id_izin',$request['id_izin'])
            ->first();

            
            if($data['status_sk'] == 0 || $koreksi_all == 1){
                session()->flash('message', 'Permohonan Ditolak');
                $email_jenis = 'tolak-penomoran-pj';
                $nama2 = $evaluator->nama;
                $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);
            }else{
                session()->flash('message', 'Berhasil Mengirim Evaluasi ke Direktur' );
                // $evaluator = User::select('nama','email','id_mst_jobposition')->where('id','=',$id_user)->first()->toArray();
                // $jabatan = DB::table('tb_mst_jobposition')->where('id',$evaluator['id_mst_jobposition'])->first();
                // $evaluator_email = $evaluator['email']?$evaluator['email']:'';
                // $evaluator_nama = $evaluator['nama']?$evaluator['nama']:'';
                
                $direktur = DB::table('tb_mst_user_bo')->select('id','nama','email','id_mst_jobposition')
                ->where('tb_mst_user_bo.id_mst_jobposition','=',16)
                ->first();
                $jabatan = DB::table('tb_mst_jobposition')->where('id',$direktur->id_mst_jobposition)->first();

                $nama2 = $evaluator->nama;
                $email_jenis = 'direktur-pj';

                $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs);
                
                $is_koreksi = 0;
                $user['email'] = $direktur->email;
                $user['nama'] = $direktur->nama;
                $nama2 = $evaluator->nama;
                $email_jenis = 'direktur';
                $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
                // dd($ulo);
        
                //end mengirim email ke evaluator
                $kirim_email2 = $email->kirim_email2($user,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$is_koreksi,$jabatan);
            }
            
            
            // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.koordinator.penomoran');
    }

    // public function penomoranse(){
    //     return view('layouts.frontend.penomoran.penomoran-se');
    // }

    // public function penomoranpe(){
    //     return view('layouts.frontend.penomoran.penomoran-pe');
    // }

    // public function penomorantambahan(){
    //     return view('layouts.frontend.penomoran.penomoran-tambahan');
    // }    

    public function disposisiPenyesuaian($id, Request $request)
    {
        // dd(Auth::user()->name);

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
        if ($izin == null) {
            return abort(404);
        }
        $izin = $izin->toArray();
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];

        $detailNib = Nib::select('*')->where('nib',
            '=',
            $nib
        )->first();
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
        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);


        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin','=',$id)->get();
        $filled_persyaratan = $filled_persyaratan->toArray();

        // dd($filled_persyaratan);

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

        $filled_perubahan = DB::table('tb_trx_persyaratan_komitmen')->where('id_izin', $id)->get()->toArray();

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
        
        $html = array();
        // $html = view('users.edit', compact('user'))->render();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $triger = Session::get('id_mst_jobposition');

        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();

        $user = $common->get_user_disposisi($id_departemen_user);
        // dd($triger);
        // die;
        $penyesuaian = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', $id)->where('is_active', NULL)->first();
        
        $component['roll_out_plan_jartup_fo_ter'] = "roll_out_plan_jartup_fo_ter";
        $component['komitmen_kinerja_layanan_lima_tahun'] = "komitmen_kinerja_layanan_lima_tahun";

        return view('layouts.backend.koordinator.disposisi-penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'penyesuaian' => $penyesuaian, 'component' => $component, 'user' => $user, 'map_izin_perubahan' => $map_izin_perubahan]);
    }

    public function disposisiPenyesuaianPost($id_izin, Request $request)
    {
        // dd($request->all());

        $date_reformat = new DateHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        $email = new EmailHelper();
        // $log = new LogHelper();
        $izin = Izin::select('*')
        ->where('id_izin', '=', $id_izin)
        ->where('status_penyesuaian', '=', 0)
        ->first();
        // // dd($ulo);

        // // dd($izin);  
        // // $status_checklist = $izin->status_checklist;

        // if (empty($ulo)) {
        //     return abort(404);
        // }

        $data = $request->all();
        $nib = $izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $id_user = $data['id_user_disposisi'];
        // $Izinoss = Izinoss::where('id_izin', '=', $id_izin)->first(); //set status checklist telah didisposisi
        $departemen = $common->getDepartemen($id_departemen_user);

        DB::beginTransaction();
        try {
            $save = DB::table('tb_trx_penyesuaian_komitmen')->where('id_izin', '=', $id_izin)->update([
                'updated_date' => date('Y-m-d H:i:s'),
                'updated_by' => Session::get('id_user'),
                'status_penyesuaian' => 20

            ]);

            $disposisi = DB::table('tb_trx_disposisi_evaluator_komitmen')->insert([
                'id_izin' => $id_izin,
                'id_disposisi_user' => $id_user,
                'catatan' => $data['catatan'],
                'created_by' => Session::get('id_user'),
                'status_checklist_awal' => 20,
                'is_active' => 1
            ]);

            DB::commit();

            // penanggungjawab dan kirim email
            $evaluator = User::select('nama','email')->where('id','=',$id_user)->first();
            $evaluator = User::select('nama', 'email', 'id_mst_jobposition')->where('id', '=', $id_user)->first()->toArray();
            $evaluator_email = $evaluator['email'] ? $evaluator['email'] : '';
            $evaluator_nama = $evaluator['nama'] ? $evaluator['nama'] : '';
            $jabatan = DB::table('tb_mst_jobposition')->where('id', $evaluator['id_mst_jobposition'])->first();
            // dd($jabatan);   

            $email_data = array();
            $email_data_evaluator = array();

            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);
            $koreksi_all = 0;

            //mengirim email ke penanggung jawab

            $nama2 = $evaluator_nama;
            $catatan_hasil_evaluasi = $data['catatan'];
            $email_jenis = 'disposisi-ulo';
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs);
            //end mengirim email ke penanggung jawab

            //mengirim email ke evaluator
            $user['email'] = $evaluator_email;
            $user['nama'] = $evaluator_nama;
            $nama2 = $evaluator_nama;
            $email_jenis = 'disposisi';
            $catatan_hasil_evaluasi = $data['catatan'];
            // dd($email_data_evaluator);

            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);

        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Disposisi Penyesuaian Komitmen');
            return Redirect::route('admin.koordinator');
        }

        return Redirect::route('admin.koordinator');
    }
    public function evaluasiPenyesuaianPost($id, Request $request)
    {
        $common = new CommonHelper();
        $email = new EmailHelper();
        $log = new LogHelper();
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.subkoordinator');
        }

        $getPenyesuaian = Penyesuaian::where('id_izin', '=', $id_izin)->where('status_penyesuaian', '=', 903)->first();

        if (empty($getPenyesuaian)) {
            return abort(404);
        }

        $id_departemen_user = Session::get('id_departemen');
        $userbo = Session::get('nama');
        $status_checklist = 903;
        $izin = Izin::select('*')
        ->where('id_izin', '=', $id_izin)
        ->where('status_penyesuaian', '=', 903)
        ->first();

        if (empty($izin)) {
            return abort(404);
        }

        // $putfile = $this->putFileSK($id);
        // dd($putfile);

        $izin = $izin->toArray();

        // dd($izin['nama_master_izin']);
        $evaluator = DB::table('tb_trx_disposisi_evaluator_komitmen as a')
        ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
        ->where('a.id_izin', $izin['id_izin'])
        ->first();

        $nib = $izin['nib'];
        $badanhukum = $izin['status_badan_hukum'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');
        $departemen = $common->getDepartemen($id_departemen_user);


        $penanggungjawabs = DB::table('users')->where('oss_id', $nibs['oss_id'])
        ->select('*')->first();

        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);

        $koreksi_all = 0;
        $data = $request->all();

        DB::beginTransaction();
        try {
            $penyesuaianToSave = $getPenyesuaian;

            if (isset($data['is_koreksi_dokumen']) && $data['is_koreksi_dokumen'] == 'on') {
                $koreksi_all = 1;
                $penyesuaianToSave->need_correction = 1;
            } else {
                $penyesuaianToSave->need_correction = 0;
            }

            //kondisional jika koreksi
            if ($koreksi_all == 1) {
                $penyesuaianToSave->status_penyesuaian = 90;
                $penyesuaianToSave->correction_note = isset($data['catatan_dokumen']) ? $data['catatan_dokumen'] : '';
            } else {
                $penyesuaianToSave->correction_note = '';
                $penyesuaianToSave->status_penyesuaian = 804;
            }

            $penyesuaianToSave->updated_date = date('Y-m-d H:i:s');
            $penyesuaianToSave->updated_by = Session::get('name');
            $penyesuaianToSave->save();

            DB::commit();
            session()->flash('message', 'Berhasil Evaluasi Penyesuaian Komitmen');

            $email_data = array();
            $email_jenis = 'evaluasi-koordinator-pj-ulo';

            $nama2 = $evaluator->nama;

            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, 0);

            $direktur = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition')
            ->where('tb_mst_user_bo.id_mst_jobposition', '=', 16)
            ->first();
            $jabatan = DB::table('tb_mst_jobposition')->where('id', $direktur->id_mst_jobposition)->first();
            $is_koreksi = 0;
            $user['email'] = $direktur->email;
            $user['nama'] = $direktur->nama;
            $nama2 = $evaluator->nama;
            $email_jenis = 'direktur';
            $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            // dd($ulo);

            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $is_koreksi, $jabatan);

        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Evaluasi gagal di prosess');
            return Redirect::route('admin.koordinator');
        }

        return Redirect::route('admin.koordinator')->with('message', 'Evaluasi berhasil di prosess');
    }

    public function evaluasiPenyesuaian($id, Request $request) {
        // dd(Auth::user()->name);

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
        if ($izin == null
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

        return view('layouts.backend.koordinator.evaluasi-penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'penyesuaian' => $penyesuaian, 'component' => $component, 'map_izin_perubahan' => $map_izin_perubahan]);
    }
}