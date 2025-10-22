<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Admin\User;
// use App\Models\Admin\JobPosition;
use App\Models\Admin\Izin;
use App\Models\Admin\User;
use App\Models\Admin\Nib;
use App\Models\Admin\Disposisi;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Izinlog;
use App\Models\Admin\Catatansubkoordinator;
use App\Models\Admin\Penanggungjawab;
use App\Models\Admin\Ulo;
use App\Models\Admin\uloView;
use App\Models\Admin\Ulolog;
use App\Models\Admin\Penomoran;
use App\Models\Admin\Penomoranlog;
use App\Models\Admin\Penyesuaian;
use App\Helpers\CommonHelper;
use App\Helpers\LogHelper;
use App\Helpers\EmailHelper;
use App\Helpers\DateHelper;
use App\Helpers\Osshub;
use Illuminate\Validation\ValidationException;
use Session;
use Redirect;
use Auth;
use Config;
use DB;
use Str;
use App\Helpers\IzinHelper;

class SubkoordinatorController extends Controller
{
    //
    public function index(){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        if ($id_departemen_user == 1) {
            return Redirect::route('admin.subkoordinator.jasa');
        }else if($id_departemen_user == 2){
            return Redirect::route('admin.subkoordinator.jaringan');
        }else if($id_departemen_user == 4){
            return Redirect::route('admin.subkoordinator.ulo');
        }else if($id_departemen_user == 5){
            return Redirect::route('admin.subkoordinator.penomoran');
        }else{
            return Redirect::route('admin.subkoordinator.telsus');
        }

        
    }

    public function jasa(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $status_checklist = 902;
        $izin = Izin::select('*')->where('id_master_izin','=',$id_departemen_user);
        $izin = $izin->where(function ($q) use ($status_checklist) {
            $q->where('status_checklist', '=', $status_checklist)
                ->orWhere('status_penyesuaian', '=', $status_checklist);
        });
        $izin->take($limit_db)->distinct('id_izin');

        //getcountiizin 
        // $countdisposisi = IzinHelper::countIzin($status_checklist,$id_departemen_user);
        $countdisposisi = $izin->count();

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }

        $paginate = $izin;
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Jasa Telekomunikasi';
        return view('layouts.backend.subkoordinator.dashboard',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'jenis_izin'=>$jenis_izin,'countdisposisi'=>$countdisposisi]);
    }

    public function jaringan(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $status_checklist = 902;
        $izin = Izin::select('*')->where('id_master_izin','=',$id_departemen_user);
        $izin = $izin->where(function ($q) use ($status_checklist) {
            $q->where('status_checklist', '=', $status_checklist)
            ->orWhere('status_penyesuaian', '=', $status_checklist);
        });
        $izin->take($limit_db)->distinct('id_izin');

        //getcountiizin 
        // $countdisposisi = IzinHelper::countIzin($status_checklist,$id_departemen_user);
        $countdisposisi = $izin->count();

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }

        $paginate = $izin;
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Jaringan Telekomunikasi';
        return view('layouts.backend.subkoordinator.dashboard',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'jenis_izin'=>$jenis_izin,'countdisposisi'=>$countdisposisi]);
    }

    public function telsus(Request $request){
        $date_reformat = new DateHelper();
        $limit_db = Config::get('app.admin.limit');
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        // dd($id_departemen_user);
        $status_checklist = 902;
        $izin = Izin::select('*')
        ->whereIn('status_checklist',[$status_checklist,802])
        ->whereIn('id_master_izin_parent',[$id_departemen_user])
        ->take($limit_db)
        ->distinct('id_izin');
        // dd($izin);
        //getcountiizin 
        // $countdisposisi = IzinHelper::countIzin($status_checklist,$id_departemen_user);
        $countdisposisi = $izin->count();

        if ($izin->count() > 0) { //handle paginate error division by zero
            $izin = $izin->paginate($limit_db);
        }else{
            $izin = $izin->get();
        }
        $paginate = $izin;
        $izin = $izin->toArray();
        $jenis_izin = 'Izin Penyelenggaraan Telekomunikasi Khusus';
        return view('layouts.backend.subkoordinator.dashboard',['date_reformat'=>$date_reformat,'izin'=>$izin,'paginate'=>$paginate,'jenis_izin'=>$jenis_izin,'countdisposisi'=>$countdisposisi]);
    }

    public function evaluasi($id, Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
    	$limit_db = Config::get('app.admin.limit');
        $status_checklist = 902;
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $izin = Izin::select('*')->where('id_izin','=',$id)
        ->whereIn('status_checklist',[$status_checklist,802])
        ->first();

        if (empty($izin)) {
            return abort(404);
        }

        $izin = $izin->toArray();
        
        $nib = $izin['nib'];
        $kd_izin = $izin['kd_izin'];

        $detailNib = Nib::select('*')->where('nib','=',$nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        }else{
            $detailNib->toArray();
        }

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
        
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        $triger =Session::get('id_mst_jobposition');
        $triger =Session::get('id_mst_jobposition');

        // dd($map_izin);

        return view('layouts.backend.subkoordinator.evaluasi',['date_reformat'=>$date_reformat,'id'=>$id,'izin'=>$izin , 'detailnib'=>$detailNib,'user'=>$user,'penanggungjawab'=>$penanggungjawab,'map_izin'=>$map_izin,'triger'=>$triger]);
    }

    public function evaluasiPost($id, Request $request){
        $date_reformat = new DateHelper();
        $id_departemen_user = Session::get('id_departemen');
        $status_checklist = 902;
        $izin = Izin::select('*')->where('id_izin','=',$id)
        ->whereIn('status_checklist',[$status_checklist,802])
        ->first();
        if ($izin == null) {
            return abort(404);
        }
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $izin = $izin->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$izin['id_izin'])
        ->first();
        $data = $request->all();
        $nib = $izin['nib'];
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

        //get koordinator
        $koordinator = DB::table('tb_mst_user_bo')->select('id','nama','email','id_mst_jobposition');
        if ($id_departemen_user == 2) { //jika user jasa dan jaringan
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',1); //jabatan koordinator jaringan
        }else if($id_departemen_user == 1){
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',4); //jabatan evaluator jasa
        }else if($id_departemen_user == 3){ //jika user telsus
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',7); //jabatan evaluator Telsus
        }

        $koordinator = $koordinator->first();
        
        $jabatan = DB::table('tb_mst_jobposition')->where('id',$koordinator->id_mst_jobposition)->first();
        // dd($jabatan);
        //end get subkoordinator
        
        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();

        try {

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
                    $Izinoss->status_checklist = 803;
                }
                else
                {
                    $Izinoss->status_checklist = 903;
                }
            }
            $Izinoss->updated_at = date('Y-m-d H:i:s');
            $Izinoss->save();

            //insert ke catatan
            $insert = DB::table('tb_evaluasi_catatan_subkoordinator')->insert(['id_izin'=>$id,'catatan_hasil_evaluasi'=>$catatan_hasil_evaluasi,'created_by'=>Session::get('id_user'),'is_active'=>1]);

            DB::commit();

            session()->flash('message', 'Berhasil Melakukan Evaluasi Subkoordinator ke Koordinator' );

            if ($koreksi_all == 1) {
                $email_jenis = 'koreksi-pj';
            } else {
                $email_jenis = 'evaluasi-subkoordinator-pj';
            }

            //penanggungjawab dan kirim email
            $penanggungjawab = array();
            $email_data = array();
            $email_data_koordinator = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            // $email_jenis = 'evaluasi-subkoordinator-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);
            
            if($koreksi_all != 1){
            //kirim email koordinator
            $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
            $user['nama'] = isset($koordinator->nama) ? $koordinator->nama : '';
            $nama2 = $evaluator->nama;
            $email_jenis = 'evaluasi-subkoordinator';
            $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            
            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$jabatan);
            }

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
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Gagal Melakukan Evaluasi Subkoordinator ke Koordinator');
            return Redirect::route('admin.subkoordinator');
        }
        
        return Redirect::route('admin.subkoordinator');
    }

    public function evaluasiPostPenolakan($id, Request $request){
        $date_reformat = new DateHelper();

        $status_checklist = 902;
        $id_izin = $id;
        $izin = Izin::select('*')->where('id_izin','=',$id)->where('status_checklist','=',$status_checklist)->first();
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

            $insertcatatan = Catatansubkoordinator::create([
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

        return Redirect::route('admin.subkoordinator');
    }

    public function ulo(){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $paginate = array();
        $id_jabatan = Session::get('id_jabatan');
        $limit_db = Config::get('app.admin.limit');
        $id_departemen_user = Session::get('id_departemen');

        if (Session::get('id_mst_jobposition') != 11) {
            return abort(404);
        }
        // dd($id_departemen_user, $id_jabatan);
        $ulo = array();
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,'EMPTY',$id_jabatan);
        
        if ($ulo->count() > 0) { //handle paginate error division by zero
            $ulo = $ulo->paginate($limit_db);
        }else{
            $ulo = $ulo->get();
        }

        $paginate = $ulo;
        $ulo = $ulo->toArray();
        // $data = isset($ulo['data']) ? count($ulo['data']) : 0;
        
        $countevaluasiulo = $common->countUlo(902);
        return view('layouts.backend.subkoordinator.dashboard-ulo',['date_reformat'=>$date_reformat,'paginate'=>$paginate,'ulo'=>$ulo,'countevaluasiulo'=>$countevaluasiulo]);
    }

    public function evaluasiUlo($id_izin,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $id_departemen_user = Session::get('id_departemen');
        $limit_db = Config::get('app.admin.limit');
        $status_checklist = 901;
        $id_jabatan = Session::get('id_jabatan');
        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$id_izin,$id_jabatan);
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
            // echo $value->persyaratan;
            // echo "<br>=============<br>";
            $map_izin[$key] = $value;
            foreach ($filled_persyaratan as $key2 => $value2) {
                if ($value->id == $value2->id_map_listpersyaratan) {
                    $map_izin[$key]->form_isian = $value2->filled_document;
                    $map_izin[$key]->nama_asli = $value2->nama_file_asli;
                }
            }
        }

        $html = array();
        // $html = view('users.edit', compact('user'))->render();
        // dd($map_izin);
        
        return view('layouts.backend.subkoordinator.evaluasi-ulo',['date_reformat'=>$date_reformat,'id'=>$id_izin,'ulo'=>$ulo,'izin' => $izin,'detailnib'=>$detailNib ,'penanggungjawab'=>$penanggungjawab,'map_izin' => $map_izin]);
    }

    public function evaluasiUloPost($id,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $id_jabatan = Session::get('id_jabatan');
        $id_departemen_user = Session::get('id_departemen');
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.subkoordinator-ulo');
        }
        
        $status_ulo = 902;

        $ulo = new Ulo();
        $ulo = $ulo->view_ulo($id_departemen_user,$id_izin,$id_jabatan);
        $ulo = $ulo->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_ulo as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$ulo['id_izin'])
        ->first();

        if (empty($ulo)) {
            return abort(404);
        }

        
        $nib = $ulo['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        $kd_izin = $ulo['kd_izin'];
        $status_badan_hukum = $ulo['nama_master_izin'];
        $Izinoss = Izinoss::where('id_izin', '=', $id)->first();
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        dd($data);
        $id_koreksi = array();
        $catatan_koreksi = array();
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get koordinator
        // dd($id_departemen_user);
        $koordinator = DB::table('tb_mst_user_bo')->select('id','nama','email');
        if ($id_departemen_user == 2) { //jika user jasa dan jaringan
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',1); //jabatan koordinator jaringan
        }else if($id_departemen_user == 1){
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',4); //jabatan evaluator jasa
        }else if($id_departemen_user == 3){ //jika user telsus
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',7); //jabatan evaluator Telsus
        }else if($id_departemen_user == 4){ //jika user telsus
        $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition','=',7); //jabatan evaluator Telsus
        }

        $koordinator = $koordinator->first();
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);
        //end konsidisional departemen

        DB::beginTransaction();
        // try {
            $data = $request->all();

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
                $status_ulo = 902;
                $uloSave->status_ulo = 903;    
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
            $uloSave->catatan_surat_tugas = isset($data['catatan_surat_tugas']) ? $data['catatan_surat_tugas'] :'';
            $uloSave->catatan_hasil_pengujian = isset($data['catatan_hasil_pengujian']) ? $data['catatan_hasil_pengujian'] : '';
            $uloSave->catatan_evaluasi = $data['catatan_hasil_evaluasi'];
            $uloSave->updated_date = date('Y-m-d H:i:s');
            $uloSave->save();

            //update persyaratan
            $id_konfigurasi_sistem = isset($data['id_konfigurasi_sistem'])? $data['id_konfigurasi_sistem'] :'NULL';
                
            if ($status_badan_hukum=='TELSUS') {

            }else if(isset($data['id_bukti_perangkat'])){
                $id_bukti_perangkat = $data['id_bukti_perangkat'];
            }

            $id_daftar_perangkat = $data['id_daftar_perangkat'];

            $path_sertifikat_alat = '';
            $path_foto_sn_perangkat = '';
            $path_bukti_perangkat = '';
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
            }
            //end update persyaratan
             
            DB::commit();
            session()->flash('message', 'Berhasil Mengirim Evaluasi ke Koordinator' );

            $subkoorulo = DB::table('tb_mst_user_bo')->select('id','nama','email','id_mst_jobposition')
            ->where('tb_mst_user_bo.id_mst_jobposition','=',10)
            ->first();
            $jabatan = DB::table('tb_mst_jobposition')->where('id',$subkoorulo->id_mst_jobposition)->first();
            //penanggungjawab dan kirim email
            $email_data = array();
            $email_data_koordinator = array();
            $penanggungjawab = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            $email_jenis = 'evaluasi-subkoordinator-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$ulo,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);

            //kirim email koordinator
            $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
            $user['nama'] = isset($koordinator->nama) ? $koordinator->nama : '';
            $nama2 = $evaluator->nama;
            $email_jenis = 'evaluasi-subkoordinator';
            $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            
            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user,$email_jenis,$ulo,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$jabatan);

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
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // throw ValidationException::withMessages(['message' => 'Gagal']);
        //     session()->flash('message', 'Gagal Mengirim Evaluasi ke Koordinator');
        //     return Redirect::back();
        // }

        return Redirect::route('admin.subkoordinator.ulo');
    }

    public function evaluasiUloPostPenolakan($id, Request $request){
        $date_reformat = new DateHelper();
        $status_ulo = 902;
        $id_izin = $id;
        $ulo = Ulo::select('*')->where('id_izin','=',$id)->where('status_ulo','=',$status_ulo)->first();
        if (empty($ulo)) {
            return abort(404);
        }
        
        $ulo = $ulo->toArray();
        $data = $request->all();

        DB::beginTransaction();
        // try {

            $uloSave = Ulo::where('id_izin','=',$id)->first(); //set status checklist telah didisposisi
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

        return Redirect::route('admin.subkoordinator');
    }

    public function penomoran(Request $request){
        $date_reformat = new DateHelper();
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');

        if ($id_departemen_user != 5) {
            return abort(404);
        }

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 902;

        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->join('vw_list_izin as v','t.id_izin','=','v.id_izin')
        ->with('KodeIzin')->with('KodeAkses')
        ->take($limit_db);
        $penomoran = $penomoran->where('t.status_permohonan','=',$status_penomoran);
        $countdisposisi = $penomoran->count();

        if ($penomoran->count() > 0) { //handle paginate error division by zero
            $penomoran = $penomoran->paginate($limit_db);
        }else{
            $penomoran = $penomoran->get();
        }
        $paginate = $penomoran;
        $penomoran = $penomoran->toArray();
        
        //getcountiizin 
        // $countdisposisi = IzinHelper::countPenomoran($status_penomoran,$id_departemen_user);
        $jenis_izin = 'Penomoran';
        // dd($penomoran);

        return view('layouts.backend.subkoordinator.dashboard-penomoran',['date_reformat'=>$date_reformat,'penomoran'=>$penomoran,'paginate'=>$paginate,'jenis_izin'=>$jenis_izin,'countdisposisi'=>$countdisposisi]);
    }

    public function evaluasiPenomoran($id,$id_kodeakses,Request $request){
        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $id_user_session = Session::get('id_user');
        $id_departemen_user = Session::get('id_departemen');
        $common = new CommonHelper();
        if ($id_departemen_user != 5) {
            return abort(404);
        }

        $limit_db = Config::get('app.admin.limit');
        $status_penomoran = 902;

        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->join('vw_list_izin as v','t.id_izin','=','v.id_izin')->where('t.id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses');
        
        $penomoran = $penomoran->where('t.status_permohonan','=',$status_penomoran);

        $penomoran = $penomoran->first();
        if (empty($penomoran)) {
            return abort(404);
        }
        $penomoran = $penomoran->toArray();

        $id_mst_kode_akses = isset($penomoran['id_mst_kode_akses'])?$penomoran['id_mst_kode_akses']:'';
        $penomoran = $common->getDetailKodeAkses($penomoran,$id_mst_kode_akses);
        
        $map = $common->getMapKodeAkses($id_mst_kode_akses);

        $nib = $penomoran['nib'];
        $kd_izin = $penomoran['kd_izin'];
        $date_reformat = new DateHelper();

        $detailNib = Nib::select('*')->where('nib', '=', $nib)->first();
        if (empty($detailNib)) {
            $detailNib = array();
        } else {
            $detailNib->toArray();
        }

        $jenis_izin = 'Penomoran';

        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        
        $penomoranlog = Penomoranlog::where('id_izin','=',$id)
        // ->where('id_kode_akses','=',$id_kodeakses)
        ->with('KodeIzin')->get()->toArray();

    	return view('layouts.backend.subkoordinator.evaluasi-penomoran',['date_reformat'=>$date_reformat,'id'=>$id,'penomoran'=>$penomoran,'detailnib'=>$detailNib ,'penanggungjawab'=>$penanggungjawab,'penomoranlog'=>$penomoranlog]);

    }

    public function evaluasiPenomoranPost($id,$id_kodeakses,Request $request){


        $date_reformat = new DateHelper();
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $koreksi_all = 0;

        $id_departemen_user = Session::get('id_departemen');
        $status_penomoran = 902;
        $penomoran_query = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses','t.*','v.*')
        ->join('vw_list_izin as v','t.id_oss_trxizin','=','v.id')->with('KodeIzin')->with('KodeAkses');
        
        $penomoran_query = $penomoran_query->where('t.status_permohonan','=',$status_penomoran)->where('t.id','=',$id_kodeakses);
        $penomoran_query = $penomoran_query->first();

        if (empty($penomoran_query)) {
            return abort(404);
        }
        $penomoran = $penomoran_query->toArray();

        $mst_kodeakses = $common->getDetailKodeAkses($penomoran,$penomoran['id_mst_kode_akses']);

        $idPenomoran = $penomoran['id'];
        $getPenomoran = Penomoran::where('id','=',$id_kodeakses)->where('status_permohonan','=',$status_penomoran)->with('KodeIzin')->with('KodeAkses')->first();
        
        if (empty($getPenomoran)) {
            return abort(404);
        }

        $data = $request->all();
        // dd($data);
        $nib = $penomoran['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();
        
        $koreksi_all = 0;
        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');
        $penomoranToSave = $getPenomoran;
        DB::beginTransaction();
        // try {
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
                $penomoranToSave->status_permohonan = 903;
            }
        }
        
        $penomoranToSave->catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
        $penomoranToSave->updated_date = date('Y-m-d H:i:s');
        $penomoranToSave->updated_by = Session::get('name');
        
        $penomoranToSave->save();

        //insert log
        $penomoranToLog = Penomoran::where('id','=',$id_kodeakses)->with('KodeIzin')->with('KodeAkses')->first()->toArray();
        $insertUloLog = $log->createPenomoranLog($penomoranToLog,$status_penomoran);

        $Izinoss = Izinoss::where('id_izin','=',$data['id_izin'])->first(); //set status checklist telah
        $catatan = $catatan_hasil_evaluasi;
        //insert log
        $insertIzinLog = $log->createIzinLog($Izinoss,$catatan);
        if ($koreksi_all == 1) {
        $Izinoss->status_checklist = 90;
        }else{
        if(substr($Izinoss['id_izin'],0,2) == 'IP')
        {
        $Izinoss->status_checklist = 803;
        }
        else
        {
        $Izinoss->status_checklist = 903;
        }
        }
        $Izinoss->updated_at = date('Y-m-d H:i:s');
        $Izinoss->save();
        DB::commit();
        $departemen = [
            "full_kode_akses" => $mst_kodeakses['kode_akses']['kode_akses'],
            "jenis_penomoran" => $mst_kodeakses['kode_akses']['jeniskodeakses']['full_name'],
            "jenis_permohonan" => $mst_kodeakses['jenis_permohonan'],
        ];
        //end konsidisional departemen

        //penanggungjawab dan kirim email
        $penanggungjawab = array();
        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = $common->get_pj_nib($nib);
        // $jabatan = DB::table('tb_trx_disposisi_evaluator_penomoran')->where('id_izin',$subkoordinator->id_mst_jobposition)->first();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_penomoran as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('a.id_izin',$id)
        ->first();

        
        if($data['status_sk'] == 0 || $koreksi_all == 1){
            session()->flash('message', 'Permohonan Ditolak');
            $email_jenis = 'tolak-penomoran-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);
        }else{
            session()->flash('message', 'Berhasil Mengirim Evaluasi ke Koordinator' );

            //get koordinator
            $koordinator = $common->get_koordinator_first($id_departemen_user);
            $jabatan = DB::table('tb_mst_jobposition')->where('id',$koordinator->id_mst_jobposition)->first();
            //end get koordinator
            
            //kondisional departemen
            // $departemen = $common->getDepartemen($id_departemen_user);
            

            $email_jenis = 'evaluasi-subkoordinator-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);

            //kirim email koordinator
            $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
            $user['nama'] = isset($koordinator->nama) ? $koordinator->nama : '';
            $nama2 = $evaluator->nama;
            $email_jenis = 'evaluasi-subkoordinator';
            $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;
            
            //end mengirim email ke evaluator
            $kirim_email2 = $email->kirim_email2($user,$email_jenis,$penomoran,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$jabatan);
        }

        

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw ValidationException::withMessages(['message' => 'Gagal']);
        // }
        
        return Redirect::route('admin.subkoordinator');
    }

    public function evaluasiPenyesuaianPost($id, Request $request)
    {
        $id_izin = $id;
        $id_departemen_user = Session::get('id_departemen');
        $izin = Izin::select('*')
        ->where('id_izin', '=', $id_izin)
        ->where('status_penyesuaian', '=', 902)
        ->first();
        if ($izin == null) {
            return abort(404);
        }
        $common = new CommonHelper();
        $log = new LogHelper();
        $email = new EmailHelper();
        $izin = $izin->toArray();
        $evaluator = DB::table('tb_trx_disposisi_evaluator_komitmen as a')
        ->join('tb_mst_user_bo as b', 'b.id', '=', 'a.id_disposisi_user')
        ->where('a.id_izin', $izin['id_izin'])
        ->first();
        $data = $request->all();
        $nib = $izin['nib'];
        $nibs = Nib::where('nib', $nib)->first();
        $nibs = $nibs->toArray();
        $koreksi_all = 0;
        $insert = array();
        $data = $request->all();
        $id_koreksi = array();
        $id_izin = $request['id_izin'];

        if ($id_izin != $id) {
            return Redirect::route('admin.subkoordinator');
        }

        $getPenyesuaian = Penyesuaian::where('id_izin', '=', $id_izin)->where('status_penyesuaian', '=', 902)->first();

        if (empty($getPenyesuaian)) {
            return abort(404);
        }

        $koreksi_all = 0;
        $data = $request->all();

        $catatan_hasil_evaluasi = $request->get('catatan_hasil_evaluasi');

        //get koordinator
        $koordinator = DB::table('tb_mst_user_bo')->select('id', 'nama', 'email', 'id_mst_jobposition');
        if ($id_departemen_user == 2) { //jika user jasa dan jaringan
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 1); //jabatan koordinator jaringan
        } else if ($id_departemen_user == 1) {
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 4); //jabatan evaluator jasa
        } else if ($id_departemen_user == 3) { //jika user telsus
            $koordinator = $koordinator->where('tb_mst_user_bo.id_mst_jobposition', '=', 7); //jabatan evaluator Telsus
        }

        $koordinator = $koordinator->first();

        $jabatan = DB::table('tb_mst_jobposition')->where('id', $koordinator->id_mst_jobposition)->first();
        // dd($jabatan);
        //end get subkoordinator

        //kondisional departemen
        $departemen = $common->getDepartemen($id_departemen_user);

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
                $penyesuaianToSave->status_penyesuaian = 903;
            }

            $penyesuaianToSave->updated_date = date('Y-m-d H:i:s');
            $penyesuaianToSave->updated_by = Session::get('name');
            $penyesuaianToSave->save();

            DB::commit();
            session()->flash('message', 'Berhasil Evaluasi Penyesuaian Komitmen');

            //penanggungjawab dan kirim email
            $penanggungjawab = array();
            $email_data = array();
            $email_data_koordinator = array();
            $penanggungjawab = $common->get_pj_nib($nib);

            $email_jenis = 'evaluasi-subkoordinator-pj';
            $nama2 = $evaluator->nama;
            $kirim_email = $email->kirim_email($penanggungjawab, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all);

            if ($koreksi_all != 1) {
                //kirim email koordinator
                $user['email'] = isset($koordinator->email) ? $koordinator->email : '';
                $user['nama'] = isset($koordinator->nama) ? $koordinator->nama : '';
                $nama2 = $evaluator->nama;
                $email_jenis = 'evaluasi-subkoordinator';
                $catatan_hasil_evaluasi = $catatan_hasil_evaluasi;

                //end mengirim email ke evaluator
                $kirim_email2 = $email->kirim_email2($user, $email_jenis, $izin, $departemen, $catatan_hasil_evaluasi, $nama2, $nibs, $koreksi_all, $jabatan);
            }
        } catch (\Exception $e) {
            DB::rollback();
            // throw ValidationException::withMessages(['message' => 'Gagal']);
            session()->flash('message', 'Evaluasi gagal di prosess');
            return Redirect::route('admin.subkoordinator');
        }

        return Redirect::route('admin.subkoordinator')->with('message', 'Evaluasi berhasil di prosess');
    }

    public function evaluasiPenyesuaian($id, Request $request)
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

        return view('layouts.backend.subkoordinator.evaluasi-penyesuaian', ['date_reformat' => $date_reformat, 'id' => $id, 'cities' => $cities, 'izin' => $izin, 'detailnib' => $detailNib, 'penanggungjawab' => $penanggungjawab, 'map_izin' => $map_izin, 'filled_persyaratan' => $filled_persyaratan, 'triger' => $triger, 'penyesuaian' => $penyesuaian, 'component' => $component, 'map_izin_perubahan' => $map_izin_perubahan]);
    }
}