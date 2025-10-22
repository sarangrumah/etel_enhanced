<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Str;
use Auth;
use Config;
use Session;
use Redirect;
use App\Mail\Sendmail;
use App\Models\Admin\Nib;
use App\Helpers\LogHelper;
use App\Helpers\DateHelper;
use App\Helpers\EmailHelper;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Admin\Penomoran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\AlokasiPenomoran;
use Illuminate\Validation\ValidationException;

class PencabutanPenomoranController extends Controller
{
    //

    public function index(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        
        $penomoran = AlokasiPenomoran::from('vw_alokasi_penomoran as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        // ->where('status_permohonan','=',50)
        // ->where('t.is_active','=',1)
        // ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
        ->orderBy('t.id')
        
        ->take($limit_db);
        // $penomoran = $penomoran->where(function($q) {
        //     $q->where('t.status_permohonan','=',20)->orWhere('t.status_permohonan','=',903);
        // });
            dd($penomoran->count());
        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        }else{
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        $penomoran = $penomoran->toArray();
       
        $jenis_izin = '';
        return view('layouts.backend.pencabutan-penomoran.dashboard',['penomoran'=>$penomoran,'date_reformat'=>$date_reformat]);
    }

    public function pencabutan($id,$id_kodeakses,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        // $status_penomoran = 904;
        $penomoran = AlokasiPenomoran::from('vw_alokasi_penomoran as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->where('t.id','=',$id_kodeakses)
        ->where('t.is_active','=',1)
        // ->where('t.status_permohonan','=',$status_penomoran)
        // ->with('KodeIzin')
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
        
        return view('layouts.backend.pencabutan-penomoran.pencabutan',['id'=>$id,'penomoran'=>$penomoran,'penanggungjawab'=>$penanggungjawab,'detailnib'=>$detailNib,'date_reformat'=>$date_reformat]);
    }

    public function pencabutanPost($id,$id_kodeakses,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];
        
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_oss_trxizin','=','v.id')->where('t.id','=',$id_kodeakses)
        ->where('t.is_active','=',1)
        ->where('status_permohonan','=',50)
        ->with('KodeIzin')->with('KodeAkses')->first();

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
            $penomorans = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first();
            $status_penomoran_update = 908;
        
            $penomorans->updated_by = Session::get('nama');
            $penomorans->updated_date = date('Y-m-d H:i:s');
            $penomorans->effective_date = date('Y-m-d H:i:s');
            $penomorans->expired_date = date('Y-m-d H:i:s');
            $penomorans->status_permohonan = $status_penomoran_update; 
            $penomorans->save();

            //insert log
            //insert log
            $penomoranToLog = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first()->toArray();
            $insertPenomoranLog = $log->createPenomoranLog($penomoranToLog,$status_penomoran_update);

            $putfile = $this->putFileSKPencabutan($id,$penomoran,$id_kodeakses);
            
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
                    ['path_sk_pencabutan_penomoran' => $putfile,'updated_by'=>$user,'updated_date'=>date('Y-m-d H:i:s')]
                );
            }

            DB::commit();
            session()->flash('message', 'Berhasil Menerbitkan Surat Penetapan Pencabutan Penomoran' );

            $email_jenis = 'pencabutan-sk-penomoran';
            $nama2 = '';
            
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$attachfile);
    
            
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }

        return Redirect::route('admin.pencabutan-penomoran');
    }

    private function putFileSKPencabutan($id_izin,$penomoran,$id_kodeakses){
        
        $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_oss_trxizin','=','v.id')
        ->where('t.id','=',$id_kodeakses)
        ->with('KodeIzin')->with('KodeAkses')->first()->toArray();
        
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        $pdf = PDF::loadView('layouts.backend.sk.cetak-pencabutan-penomoran', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat] );
        
        $pdf->render();

        $output = $pdf->output();
        $path = 'app/public/sk_pencabutan_penomoran/sk-pencabutan-penomoran-'.$id_izin.'-'.$id_kodeakses.'.pdf';
        $pathToPut = storage_path($path);
        $put = file_put_contents($pathToPut, $output);

        if ($put > 0) {
            return $path;
        }else{
            return null;
        }
    }

    public function historyPenomoran(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        
        $penomoran = AlokasiPenomoran::from('vw_alokasi_penomoran_rev as t')->select('*')
        // ->leftjoin('vw_list_izin as v','t.id_izin','=','v.id_izin')
        // ->whereNull('t.id_izin')
        ->orderBy('t.id','asc');
        // $penomoran = $penomoran->get();
        // ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')
        // ->take($limit_db);
        // ->get();
        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        }else{
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        $penomoran = $penomoran->toArray();
        // dd($penomoran);
        $jenis_izin = '';
        return view('layouts.backend.pencabutan-penomoran.history',['penomoran'=>$penomoran,'paginate'=> $paginate,'date_reformat'=>$date_reformat]);
    }

    public function rilisPenomoranPost(Request $request){
        $data = $request->all();
        if($request->ajax()){
            $data = json_encode($data);
            $data = json_decode($data,true);
            foreach ($data as $key=>$val){
                $data = json_decode($val,true);
            }

            $id = $data['id'];

            $penomoran = Penomoran::where('id','=',$id)->with('KodeIzin')->with('KodeAkses')->first();
            $penomoran->catatan_hasil_evaluasi = "Idle";
            $penomoran->status_permohonan = 908;
            $penomoran->is_active = 0;
            if($penomoran->save()){
                session()->flash('message', 'Berhasil Memperbaharui Status Penomoran' );
                return response()->json(['status'=>'success']);
            }else{
                return response()->json(['status'=>'failed']);
            }
        }else{
            return false;
        }
        
    }
}