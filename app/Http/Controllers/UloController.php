<?php

namespace App\Http\Controllers;
use App\Models\MstIzin;
use App\Models\MstUserBo;
use App\Models\TrxUlo;
use App\Models\OffDay;
use App\Models\Admin\Izin;
use App\Models\Nib;
use App\Models\Admin\Ulo;
use App\Models\Admin\Ulolog;
use App\Helpers\UtilPerizinan;
use App\Helpers\DateHelper;
use App\Models\Admin\Izinoss;
use App\Helpers\EmailHelper;
use App\Helpers\CommonHelper;
use Auth;
use PDF;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Ulo\Permohonan;
use App\Mail\Ulo\Permohonan_evaluator;

class UloController extends Controller
{
    public function permohonan(){
        $date_reformat = new DateHelper();
        // $kategori = MstIzin::where('name', strtoupper($req->izin))->first();
        $izins = DB::table('vw_list_izin as a')
        ->select('a.id_izin as id_izin','a.jenis_izin as jenis_izin', 'a.full_kbli as full_kbli', 'a.jenis_layanan as jenis_layanan', 'a.tgl_izin as tgl_izin', 'a.status_fo as status_fo','a.status_checklist','b.status_ulo as status_ulo','a.nama_master_izin as jenis_izin','b.tgl_pengajuan_ulo as tgl_pengajuan','b.tgl_submit as tgl_submit','c.name_status_fo', 'a.jenis_layanan_html')
        ->join('tb_oss_nib as d','d.nib','a.nib')
        ->leftjoin('tb_trx_ulo as b', 'b.id_izin', 'a.id_izin')
        ->leftjoin('tb_oss_mst_kodestatusizin as c', 'c.oss_kode', 'b.status_ulo')
        ->where('a.status_checklist', '=', '10')
        ->where('d.oss_id',Auth::user()->oss_id);
        // ->where('b.is_active','!=',0);
        $ijin = $izins->get();
        
        // ->where('a.nama_master_izin', strtoupper($req->izin))
        
        $izin = $ijin->toArray();

        // dd($ijin);
        
        $selesai = TrxUlo::whereIn('status_ulo', ['50', '90'])
        // ->where('jenis_izin', strtoupper($req->izin))
        ->count();

        $tolak = TrxUlo::where('status_ulo', '90')
        // ->where('jenis_izin', strtoupper($req->izin))
        ->count();


        $proses = $ijin->count() - $selesai;

        if($proses < 1){
            $proses = 0;
        }else{
            $proses = $proses;
        }
        
        // return view('ulo.index', compact('date_reformat','izin', 'kategori','proses','selesai','tolak'));
        return view('ulo.index', compact('date_reformat','izin','proses','selesai','tolak'));
    }

    public function pengajuan(Request $req){
        $date_reformat = new DateHelper();

        $id_izin = $req->id;
        $izin = Izin::where('id_izin','=', $req->id)->first();
        $izin = $izin->toArray();
        $date_now = Carbon::now();
        return view('ulo.pengajuan', compact('date_reformat','id_izin', 'izin', 'date_now'));
    }

    public function pengajuan_test(Request $req){
        $date_reformat = new DateHelper();

        $id_izin = $req->id;
        $izin = Izin::where('id_izin','=', $req->id)->first();
        $izin = $izin->toArray();
        $date_now = Carbon::now();
        return view('ulo.test', compact('date_reformat','id_izin', 'izin', 'date_now'));
    }

    public function mandiri(Request $req){
        $date_reformat = new DateHelper();
        $id_izin = $req->id;
        $izin = Izin::where('id_izin','=', $req->id)->first();
        $izin = $izin->toArray();
        return view('ulo.mandiri', compact('date_reformat','id_izin','izin'));
    }

    public function submitUlo(Request $req){

        // dd($req->all());

        $date = $req->tgl_ulo;
        $timestamp = strtotime($date);
        $tgl_pelaksanaan_ulo = date("Y-m-d", $timestamp);

        $datenow = Carbon::now();
        $dates = new DateHelper();
        $date = $dates->dateday_lang_reformat_long($datenow);
        
        $izin = Izin::where('id_izin',$req->id_izin)->first();
        $nib = $izin['nib'];
        $nibs = Nib::where('nib',$req->nib_user)->first();
        $nibs = $nibs->toArray();
        // $izin_toarray = $izin->toArray();
        // dd($nib);
        $data = [
            "id_izin" => $req->id_izin,
            "nama_master_izin" => $req->id_izin,
            "nib_user" => $req->nib_user,
            "nib" => $req->nib_user,
            "tipe_ulo" => $req->tipe_ulo,
            "status" => $req->nama_status,
            "tgl_ulo" => $dates->dateday_lang_reformat_long($req->tgl_ulo),
            "tgl_submit" => $date,
            "nama_perseroan" => $izin->nama_perseroan,
            "jenis_izin" => $izin['jenis_izin'],
            "updated_at" => $izin['updated_at'],
            "tgl_permohonan" => $izin['tgl_permohonan'],
            "kbli" => $izin->kbli,
            "kbli_name" => $izin->kbli_name
        ];

        if($file = $req->file('sp_ulo'))
        {
            $filename = "ULO-".time().'.'.$file->extension();
            $path = $file->storeAs('public/file_ulo', $filename);
            $name = $file->getClientOriginalName();
            $path = str_replace('public/', 'storage/', $path);
        }

        $insert = new TrxUlo([
            'id_izin' => $req->id_izin,
            'jenis_izin' => $req->nama_master_izin,
            'tgl_pengajuan_ulo' => $tgl_pelaksanaan_ulo,
            'tgl_submit' => Carbon::now()->format('Y-m-d'),
            'surat_permohonan_ulo' => $path,
            'surat_permohonan_ulo_asli' => $name,
            'tipe_ulo' => $req->tipe_ulo,
            'status_ulo' => $req->status,
            'is_active' => 1,
        ]);  
        $insert->save();  

        $user = Auth::User()->email;
        $evaluator = MstUserBo::where('username','koordinatorkelayakan')->first();
        $evaluator = $evaluator->email;

        // if($insert->save()){

            $uloToLog = Ulo::select('*')->where('id_izin','=',$req->id_izin)->first();

            if (!empty($uloToLog)) {
                $uloToLog = $uloToLog->toArray();
            }else{
                $uloToLog = array();
            }
            
            unset($uloToLog['created_date']);
            unset($uloToLog['updated_date']);
            unset($uloToLog['id']);
            unset($uloToLog['status_ulo']);

            $uloToLog['status_ulo'] = '00';                
            $uloToLog['created_by'] = Auth::User()->email;
            $uloToLog['created_name'] = Auth::User()->name;
            $insertUloLog = Ulolog::create($uloToLog);
        // }
        
        // Mail::to($user)->send(new Permohonan($data));
        // Mail::to($evaluator)->send(new Permohonan_evaluator($data)); 
        $koreksi_all = 0;
        $common = new CommonHelper();
        $email = new EmailHelper();
        $koordinator = DB::table('tb_mst_user_bo')->select('id','nama','email','id_mst_jobposition')
        ->where('tb_mst_user_bo.id_mst_jobposition','=',10)
        ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        ->first();
        $jabatan = DB::table('tb_mst_jobposition')->where('id',$koordinator->id_mst_jobposition)->first();

        //pemohon dan kirim email
        $penanggungjawab = array();
        $email_data = array();
        $email_data_koordinator = array();
        $penanggungjawab = Auth()->user();
        $catatan_hasil_evaluasi = '';

        $departemen = '';
        $penanggungjawab['email_user_proses'] = $penanggungjawab->email;
        $penanggungjawab['nama_user_proses'] = $penanggungjawab->name;
        $email_jenis = 'pengajuan-ulo';
        $nama2 = '';
        $izins = $data;
        $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izins,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all);
        //end pemohon

        // kirim email koordinator
        // dd(isset($koordinator->email) ? $koordinator->email : '');
        $_email = isset($koordinator->email) ? $koordinator->email : '';
        // $user['email'] = $_email;
        // $user['nama'] = $koordinator->nama;
        $user = [
            'email' => $_email,
            'nama' => $koordinator->nama
        ];
        $nama2 = $koordinator->nama;
        $izins = $data;
        $email_jenis = 'koordinator-ulo';
        $catatan_hasil_evaluasi = '';

        //end mengirim email ke evaluator
        $kirim_email2 = $email->kirim_email2($user,$email_jenis,$izins,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$jabatan);

        if($req->tipe_ulo == 1){
            return redirect()->route('ulo.permohonan',$req->nama_master_izin)->with('message', 'Data permohonan Uji Laik Operasi berhasil dikirim');
        }else{
            return redirect()->route('ulo.permohonan',$req->nama_master_izin)->with('warning', 'Pastikan anda melengkapi data pada Penilaian Mandiri');
        }
    }

    public function submitMandiri(Request $req){
        $date_reformat = new DateHelper();
        
        if($file1 = $req->file('stp_ulo_mandiri'))
        {
            $filename1 = "stp-mandiri-".time().'.'.$file1->extension();
            $path1 = $file1->storeAs('public/file_ulo', $filename1);
            $name1 = $file1->getClientOriginalName();
            $path1 = str_replace('public/', 'storage/', $path1);
        }

        if($file2 = $req->file('hp_ulo_mandiri'))
        {
            $filename2 = "hp-mandiri-".time().'.'.$file2->extension();
            $path2 = $file2->storeAs('public/file_ulo', $filename2);
            $name2 = $file2->getClientOriginalName();
            $path2 = str_replace('public/', 'storage/', $path2);

        }

        $update = TrxUlo::where('id_izin',$req->id_izin)->update([
            'surat_tugas_pelaksanaan_ulo_mandiri' => $path1,
            'hasil_pengujian_ulo_mandiri' => $path2,
            'surat_tugas_pelaksanaan_ulo_mandiri_asli' => $name1,
            'hasil_pengujian_ulo_mandiri_asli' => $name2,
            'status_ulo' => $req->status,
            'status_laik' => '99',
        ]);

        return redirect()->route('ulo.permohonan',$req->nama_master_izin)->with('message', 'Data berhasil dikirim');;
    }
    public function offDay(){
        $date_reformat = new DateHelper();
        $offday = OffDay::all();
        $arr = [];
        foreach($offday as $off){
            array_push($arr, $off['off_day']);
        };
        return response()->json($arr);
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
        ->select('i.nib','i.id_izin','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')
        ->where('i.id_izin','=',$id_izin)
        ->first();

        // $data2 = $data2->toArray();
        // dd($data2);
        // $data2 = '';
        
        $nib = $data2->nib;
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();
        $date_reformat = new DateHelper();

        $noizinprinsip = DB::table('latest_izinprinsipno')->first();

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
        
        $pdf = PDF::loadView('layouts.backend.sk.draft-perpanjangan-izin-prinsip-telsus', ['map_izin'=>$map_izin,'data'=>$data2,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$noizinprinsip->izinprisipno] );
        
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

    public function submitperpanjangip(Request $req)
    {

        $izin = Izin::select('*')->where('id_izin','=',$req->idizin)->first();
        $common = new CommonHelper();
        $email = new EmailHelper();
        if (empty($izin)) {
            return abort(404);
        }
        
        // $putfile = $this->putFileSK($id);
        // dd($putfile);

        $izin = $izin->toArray();

        // dd($izin['nama_master_izin']);
        $evaluator = DB::table('tb_trx_disposisi_evaluator as a')
        ->join('tb_mst_user_bo as b','b.id','=','a.id_disposisi_user')
        ->where('tb_mst_user_bo.is_accounttesting', '!=', 1)
        ->where('a.id_izin',$izin['id_izin'])
        ->first();

        $nib = $izin['nib'];
        $nibs = Nib::where('nib',$nib)->first();
        $nibs = $nibs->toArray();

        $id_izin = $req->idizin;

        // $date = Carbon::parse($update->tgl_berlaku)->addYear()->format('Y-m-d');
        $update = DB::table('tb_trx_izin_prinsip')->where('id_trx_izin', $req->idizin);
        $update->update([
            'tgl_berlaku' => Carbon::now()->addYear()->format('Y-m-d'),
        ]);

         //penanggungjawab dan kirim email
         $email_data = array();
         $email_data_subkoordinator = array();
         $penanggungjawab = array();
         $penanggungjawab = $common->get_pj_nib($nib);
         $putfile = $this->putFileSK($id_izin);
         $attachfile = '';
         if ($putfile != null) {
             $attachfile = $putfile;
             // DB::table('tb_trx_ulo_sk')->insert(
             //     ['id_izin' => $id, 'path_sk_ulo' => $putfile,'created_by'=>Session::get('id_user'),'created_at'=>date('Y-m-d H:i:s'),'is_active'=>1]
             // );
         }

         // dd($attachfile);
         
         session()->flash('message', 'Berhasil Memperpanjang izin prinsip' );

         $email_jenis = 'perpanjang-izin';
         $nama2 = $evaluator->nama;
         $departemen = '';
         $catatan_hasil_evaluasi = '';
         $koreksi_all = '';
         
         $kirim_email = $email->kirim_email($penanggungjawab,$email_jenis,$izin,$departemen,$catatan_hasil_evaluasi,$nama2,$nibs,$koreksi_all,$attachfile);
        
        return redirect('/')->with('success', 'Data Your files has been successfully added');
    }

}