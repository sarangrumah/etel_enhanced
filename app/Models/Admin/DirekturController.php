<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Izin;
use App\Models\Admin\Nib;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Catatandirektur;
use App\Models\Admin\IzinPrinsip;
use App\Models\Admin\Ulo;
use App\Models\Admin\ulo_view;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Skulo;
use App\Models\Admin\Penomoran;
use App\Models\Admin\Penomoranlog;
use App\Models\Admin\SkPenomoran;
use App\Helpers\IzinHelper;
use App\Helpers\CommonHelper;
use App\Helpers\LogHelper;
use App\Helpers\EmailHelper;
use App\Helpers\DateHelper;
use Carbon\Carbon;
use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;
use PDF;
use Storage;

use App\Mail\Sendmail;
use Illuminate\Support\Facades\Mail;

class DirekturController extends Controller
{
    //
    public function index(){
        // return Redirect::route('admin.direktur.ulo');
        $date_reformat = new DateHelper();
        $paginate = array();
        $common = new CommonHelper();
        $id_jabatan = Session::get('id_jabatan');
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');
        $ulo = array();
        $ulo = new ulo_view();
        $ulo = $ulo->view_ulo($id_departemen_user,0,$id_jabatan);

        if ($ulo != null) { //handle paginate error division by zero
            $ulo = $ulo->paginate($limit_db);
            $paginate = $ulo;
            $ulo = $ulo->toArray();
        }
        
       

        // dd($ulo);
        
        $countulo = $common->countUlo(904);

        // $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->take($limit_db);
        // $penomoran = $penomoran->where('t.status_permohonan','=',904);
        // if ($penomoran->count() > 0) { //handle paginate error division by zero
        //     $penomoran = $penomoran->paginate($limit_db);
        // }else{
        //     $penomoran = $penomoran->get();
        // }
        // $paginate = $penomoran;
        // $penomoran = $penomoran->toArray();
        
        // $countpenomoran = IzinHelper::countPenomoran(904);

        // $izinprinsip = array();
        // $izinprinsip = new IzinPrinsip();
        // $izinprinsip = $izinprinsip->where('status_checklist','=',804);
        // if ($izinprinsip->count() > 0) { //handle paginate error division by zero
        //     $izinprinsip = $izinprinsip->paginate($limit_db);
        // }else{
        //     $izinprinsip = $izinprinsip->get();
        // }
        // $paginate = $izinprinsip;
        // $izinprinsip = $izinprinsip->toArray();
        
        // $countip = $common->countIP(804);

        // dd($ulo);
        // return view('layouts.backend.direktur.dashboard',['date_reformat'=>$date_reformat,'data'=>$ulo,'countulo'=>$countulo,'penomoran'=>$penomoran,'countpenomoran' => $countpenomoran,'izinprinsip'=>$izinprinsip,'countip' => $countip]);
        return view('layouts.backend.direktur.dashboard',['date_reformat'=>$date_reformat,'data'=>$ulo,'countulo'=>$countulo]);


    }
    
    public function ulo(Request $request){
        $date_reformat = new DateHelper();
        $paginate = array();
        $common = new CommonHelper();
        $id_jabatan = Session::get('id_jabatan');
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');
        $ulo = array();
        $ulo = new Ulo();
        $ulo_full = $ulo->view_ulo($id_departemen_user,0,$id_jabatan);
        
        
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
        return view('layouts.backend.direktur.dashboard-ulo',['date_reformat'=>$date_reformat,'paginate'=>$paginate,'ulo'=>$ulo_full,'countulo'=>$countulo]);
    }

    public function penetapanUlo($id_izin,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$id_izin,$id_jabatan);

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
        
        return view('layouts.backend.direktur.penetapan-ulo',['date_reformat'=>$date_reformat,'id'=>$id_izin,'ulo'=>$ulo,'detailnib'=>$detailNib ,'map_izin'=>$map_izin,'penanggungjawab'=>$penanggungjawab]);
    }

    public function penetapanIP($id_izin,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        // / $izinprinsip = array();
        // $izinprinsip = new IzinPrinsip();
        $izinprinsip = IzinPrinsip::select('*')->where('id_izin','=',$id_izin)->first();

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
        
        return view('layouts.backend.direktur.penetapan-ip',['date_reformat'=>$date_reformat,'id'=>$id_izin,'izinprinsip'=>$izinprinsip,'detailnib'=>$detailNib ,'map_izin'=>$map_izin,'penanggungjawab'=>$penanggungjawab]);
    }

    public function penetapanIPPost($id,Request $request){
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

        $izinprinsip = IzinPrinsip::select('*')->where('id_izin','=',$id_izin)->first();
        
        if (empty($izinprinsip)) {
            return abort(404);
        }

        // $izinprinsip = $izinprinsip->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$izinprinsip['id_izin'])
        ->first();
        $nib = $izinprinsip['nib'];
        $kd_izin = $izinprinsip['kd_izin'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();

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
            $id_izinprinsip = $izinprinsip['id'];
            // $uloSave = $izinprinsipToLog;
            $updateIzinPrinsip = Izinoss::select('*')->where('id_izin','=',$id_izin)->first();
        
            //insert log
            // $insertUloLog = $log->createUloLog($uloToLog,$catatan,50);

            $updateIzinPrinsip->status_checklist = 51;
            $updateIzinPrinsip->updated_at = date('Y-m-d H:i:s');
            $updateIzinPrinsip->save();

            // $putfile = $this->putFileSK($id);
            
                //penanggungjawab dan kirim email
                $email_data = array();
                $email_data_subkoordinator = array();
                $putfile = $this->putFileSKIP($id_izin);
                $attachfile = '';
                if ($putfile != null) {
                    $attachfile = $putfile;
                    // DB::table('tb_trx_ulo_sk')->insert(
                    //     ['id_izin' => $id, 'path_sk_ulo' => $putfile,'created_by'=>Session::get('id_user'),'created_at'=>date('Y-m-d H:i:s'),'is_active'=>1]
                    // );
                }

                // dd($attachfile);
                
                session()->flash('message', 'Berhasil Menerbitkan Surat Keterangan Laik Operasi' );
    
                $email_jenis = 'evaluasi-koordinator-pj-ulo';
                $nama2 = $evaluator->nama;
                $departemen = '';
                
                $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$attachfile);
            
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.direktur');
    }

    public function penetapanUloPost($id,Request $request){
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
        $ulo = $ulo->view_ulo($id_departemen_user,$id_izin,$id_jabatan);
        
        if (empty($ulo)) {
            return abort(404);
        }

        $ulo = $ulo->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$ulo['id_izin'])
        ->first();
        $nib = $ulo['nib'];
        $kd_izin = $ulo['kd_izin'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();

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
        
        try {
            $data = $request->all();
            //
            $id_ulo = $ulo['id'];
            $uloToLog = Ulo::select('*')
            ->where('id_izin','=',$id)
            ->where('is_active','=','1')
            ->first();
            $uloSave = $uloToLog;
            
            //insert log
            $status_ulo = 50;
            $catatan = $catatan_hasil_evaluasi;
            $insertUloLog = $log->createUloLog($uloToLog,$catatan,$status_ulo);

            $uloSave->status_ulo = $status_ulo;
            $uloSave->updated_date = date('Y-m-d H:i:s');
            $uloSave->save();

            $putfile = $this->putFileSK($id);
            
            //penanggungjawab dan kirim email
            $email_data = array();
            $email_data_subkoordinator = array();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);
            $attachfile = '';
            if ($putfile != null) {
                $attachfile = $putfile;
                DB::table('tb_trx_ulo_sk')->insert(
                    ['id_izin' => $id, 'path_sk_ulo' => $putfile,'created_by'=>Session::get('id_user'),'created_at'=>date('Y-m-d H:i:s'),'is_active'=>1]
                );
            }

            DB::commit();
            session()->flash('message', 'Berhasil Menerbitkan Surat Keterangan Laik Operasi' );

            $email_jenis = 'penetapan-sk-ulo';
            $nama2 = $evaluator->nama;
            
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$ulo,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$attachfile);
    
            
        } catch (\Exception $e) {
            DB::rollback();
            throw ValidationException::withMessages(['message' => 'Gagal']);
        }

        return Redirect::route('admin.direktur');
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
        $data2 = Ulo::from('tb_trx_ulo as u')->select('u.*','i.nib','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')
                ->where('u.id_izin','=',$id_izin)
                ->where('u.is_active','=','1')
                ->join('vw_list_izin as i','u.id_izin','=','i.id_izin')
                ->first()->toArray();
        $nib = $data2['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();
        $date_reformat = new DateHelper();

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
        // return view('layouts.backend.direktur.mypdf', $data);
        if ($data2['nama_master_izin'] == "TELSUS") {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-telsus', ['map_izin'=>$map_izin,'data'=>$data2,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        }else{
            $pdf = PDF::loadView('layouts.backend.sk.cetak-ulo', ['data'=>$data2,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        }
        $pdf->render();

        $output = $pdf->output();
        // dd($output);
        $path = 'app/public/sk_ulo/sk-ulo-'.$id_izin.'.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        }else{
            return null;
        }
    }

    public function skUlo(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $skquery = Skulo::select('*')->leftjoin('vw_list_izin','tb_trx_ulo_sk.id_izin','=','vw_list_izin.id_izin');
        $sk = array();
        if ($skquery->count() > 0) { //handle paginate error division by zero
            $sk = $skquery->paginate($limit_db);
        }else{
            $sk = $skquery->get();
        }

        $paginate = $sk;
        $sk = $sk->toArray();

        return view('layouts.backend.direktur.dashboard-sk-ulo',['date_reformat'=>$date_reformat,'sk'=>$sk,'paginate'=>$paginate]);
    }

    public function lihatSK($id,Request $request){
        $date_reformat = new DateHelper();
        $sk = Skulo::where('id_izin','=',$id)->where('is_active','=',1)->first();
        $id_jabatan = Session::get('id_jabatan');

        if($sk->count() == 0){ return abort(404);}
        if($id_jabatan != 1){ return abort(404);}
        
        $path = storage_path($sk->path_sk_ulo);
        
        if(!file_exists($path)){
            return abort(404);
        }

        return response()->file($path);
    }

    public function penomoran(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');
       
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->take($limit_db);
        $penomoran = $penomoran->where('t.status_permohonan',[904,915]);

        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        }else{
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        $penomoran = $penomoran->toArray();
        
        $countpenomoran = IzinHelper::countPenomoran(904) + IzinHelper::countPenomoran(915);
        
        // dd($penomoran);
        
        return view('layouts.backend.direktur.dashboard-penomoran',['date_reformat'=>$date_reformat,'paginate'=>$paginate,'penomoran'=>$penomoran,'countpenomoran'=>$countpenomoran]);
    }

    public function penetapanPenomoran($id,$id_kodeakses, Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 904;
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->where('t.id','=',$id_kodeakses)
        ->where('t.status_permohonan','=',$status_penomoran)
        ->where('t.status_permohonan','=',915)
        ->with('KodeIzin')
        ->first();

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

        return view('layouts.backend.direktur.penetapan-penomoran',['date_reformat'=>$date_reformat,'id'=>$id,'penomoran'=>$penomoran,'detailnib'=>$detailNib ,'penanggungjawab'=>$penanggungjawab,'map'=>$map,'penomoranlog'=>$penomoranlog]);
    }

    public function penetapanPenomoranPost($id,$id_kodeakses, Request $request){
        $date_reformat = new DateHelper();
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
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_oss_trxizin','=','v.id')->where('t.id','=',$id_kodeakses)
        ->whereIn('t.status_permohonan',[$status_penomoran,915])->first();

        if (empty($penomoran)) {
            return abort(404);
        }

        $penomoran = $penomoran->toArray();
        $nib = $penomoran['nib'];
        $kd_izin = $penomoran['kd_izin'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $data = $request->all();

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();
        
        // try {
            //
            $penomoranid = $penomoran['id'];
            $penomorans = Penomoran::where('id','=',$id_kodeakses)->first();
            $status_penomoran_update = 50;
            

            $penomorans->updated_by = Session::get('nama');
            $penomorans->updated_date = date('Y-m-d H:i:s');
            $penomorans->status_permohonan = $status_penomoran_update; 
            $penomorans->save();

            //insert log
            //insert log
            $penomoranToLog = Penomoran::where('id','=',$id_kodeakses)->first()->toArray();
            $insertPenomoranLog = $log->createPenomoranLog($penomoranToLog,$status_penomoran_update);

            $putfile = $this->putFileSKPenomoran($id,$penomoran,$id_kodeakses);
            
            //penanggungjawab dan kirim email
            $email_data = array();
            $email_data_subkoordinator = array();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);
            $catatan_hasil_evaluasi = '';
            $koreksi_all = 0;
            $attachfile = '';
            $user = Session::get('username');
            if ($putfile != null) {
                $attachfile = $putfile;
                DB::table('tb_trx_kode_akses')
                ->where(['id_izin' => $id, 'id' => $id_kodeakses ])
                ->update(
                    ['path_sk_penomoran' => $putfile,'updated_by'=>$user,'updated_date'=>date('Y-m-d H:i:s')]
                );
                DB::table('tb_oss_trx_izin')
                ->where(['id_izin' => $id])
                ->update(
                ['status_checklist' => '50','updated_by'=>$user,'updated_date'=>date('Y-m-d H:i:s')]
                );
            }

            DB::commit();
            session()->flash('message', 'Berhasil Menerbitkan Surat Penetapan Penomoran' );

            $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
            ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
            ->where('a.id_izin',$id)
            ->first();
            $email_jenis = 'penetapan-sk-penomoran';
            $nama2 = $evaluator->nama;
            
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$attachfile);
    
            
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.direktur.penomoran');
    }

    private function putFileSKPenomoran($id_izin,$penomoran,$id_kodeakses){
        // $data = $penomoran;
        // $nib = $data['nib'];
        // $dataNib = Nib::where('nib',$nib)->first();
        // $dataNib = $dataNib->toArray();
        // $date_reformat = new DateHelper();
        // return view('layouts.backend.direktur.mypdf', $data);
        $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_oss_trxizin','=','v.id')
        ->where('t.id','=',$id_kodeakses)
        ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first()->toArray();
        
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        // dd($data);


        $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat] );
        
        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/sk_penomoran/sk-penomoran-'.$id_izin.'-'.$id_kodeakses.'.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        }else{
            return null;
        }
    }
    private function putFileSKIP($id_izin){
        $datenow = Carbon::now();
        $common = new CommonHelper;
        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        $noizinprinsip = DB::table('latest_izinprinsipno_0301')->first();
        $data = IzinPrinsip::select('*')->where('id_izin','=',$id_izin)->first()->toArray();
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        // dd($data);
        $id_mst_izinlayanan = $data['id_kd_izin'];

        // dd($data);

        $map_izin = array();
        $filled_persyaratan = array();
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

        $pdf = PDF::loadView('layouts.backend.sk.draft-izin-prinsip-telsus', ['map_izin'=>$map_izin,'data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$noizinprinsip->izinprisipno] );
        
        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/sk_ip/sk-ip-'.$id_izin.'.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        }else{
            return null;
        }
    }

    public function skPenomoran(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $skquery = SkPenomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')->join('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->where('t.path_sk_penomoran','!=',null)
        ->where('t.status_permohonan','=','50');
        $sk = array();
        if ($skquery->count() > 0) { //handle paginate error division by zero
            $sk = $skquery->paginate($limit_db);
        }else{
            $sk = $skquery->get();
        }
        
        $paginate = $sk;
        $sk = $sk->toArray();
        
        return view('layouts.backend.direktur.dashboard-sk-penomoran',['date_reformat'=>$date_reformat,'sk'=>$sk,'paginate'=>$paginate]);
    }

    public function lihatSKPenomoran($id,$id_kodeakses,Request $request){

        $sk = SkPenomoran::select('*')
        ->join('vw_list_izin','tb_trx_kode_akses.id_izin','=','vw_list_izin.id_izin')
        ->where('tb_trx_kode_akses.id','=',$id_kodeakses)
        ->where('tb_trx_kode_akses.is_active','=',1)
        
        ->first();
        $id_jabatan = Session::get('id_jabatan');
        
        if($sk->count() == 0){ return abort(404);}
        if($id_jabatan != 1){ return abort(404);}
        
        if($sk->path_sk_penomoran == ''){
            return abort(404);
        }

        $path = storage_path($sk->path_sk_penomoran);
        
        if(!file_exists($path)){
            return abort(404);
        }

        return response()->file($path);
    }
}