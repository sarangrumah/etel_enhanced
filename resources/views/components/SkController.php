<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Str;
use Auth;
use Config;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Mail\Sendmail;
use App\Models\Admin\Nib;
use App\Models\Admin\Ulo;
use App\Models\Admin\Izin;
use App\Helpers\DateHelper;
use App\Helpers\IzinHelper;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use App\Models\Admin\Izinoss;
use App\Models\Admin\Penomoran;
use App\Models\Admin\IzinPrinsip;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Catatandirektur;


class SkController extends Controller
{
    //
    public function index(){
    	return Redirect::route('admin.direktur.ulo');
    }

    public function draft(Request $request, $id_izin){

        $qrcode = new Generator;
        $link = 'https://e-telekomunikasi.kominfo.go.id/validasi-sk/' .$id_izin;
        // dd($link);
        $qr = $qrcode->size(100)->generate('TSET');
        // $png = QrCode::format('png')->size(512)->generate(1);
        // $qr = base64_encode($qr);
        // QrCode::format('png')->merge('/public/global_assets/images/'. $id_izin .'.png');
        // QrCode::generate('Make me into a QrCode!', '../public/global_assets/images/'. $id_izin .'.svg');
        // dd($qr);
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        // $tengah = 'Tel.04.02';
        // $noUrutAkhir = Ulo::max('nomor_sklo');
        // if($noUrutAkhir) {
        //     $nomor_sklo = sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        // }
        // dd($nomor_urut);
        $data = Ulo::from('tb_trx_ulo as u')->select('u.*','i.nib','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')->where('u.id_izin','=',$id_izin)
                    ->join('vw_list_izin as i','u.id_izin','=','i.id_izin')
                    ->first()->toArray();
        // dd($data);
        $awal = '';
        if ($data['nama_master_izin']=='JARINGAN') {
            $awal = 'JAR';
        } 
        if ($data['nama_master_izin']=='JASA') {
            $awal = 'JASA';
        } 
        if ($data['nama_master_izin']=='TELSUS') {
            $awal = 'TELSUS';
        }
        // if($noUrutAkhir) {
        //     $nomor_sklo = $awal.'-'.sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        // }
        $nomor_sklo = $awal.'-'.$data['nomor_sklo_fixed'];

        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();


        $map_izin = array();
        $filled_persyaratan = array();
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $data['kd_izin'])->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        
        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $data['id_izin'])->get();
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
        // die;
        // dd($data);

        if ($data['nama_master_izin'] == "TELSUS") {

            $pdf = PDF::loadView('layouts.backend.sk.draft-telsus', ['map_izin'=>$map_izin, 'link'=> $link, 'data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        } else {
            $pdf = PDF::loadView('layouts.backend.sk.draft',
            ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        }
        
        
        // return view('layouts.backend.direktur.mypdf', $data);

        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function cetakSKUlo(Request $request, $id_izin){
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        // $noUrutAkhir = Ulo::max('nomor_sklo');
       
        // dd($nomor_sklo);
        $data = Ulo::from('tb_trx_ulo as u')->select('u.*','u.id_izin','i.nib','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')->where('u.id_izin','=',$id_izin)
                    ->join('vw_list_izin as i','u.id_izin','=','i.id_izin')
                    ->first()->toArray();
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        $awal = '';
        if ($data['nama_master_izin']=='JARINGAN') {
            $awal = 'JAR';
        } 
        if ($data['nama_master_izin']=='JASA') {
            $awal = 'JASA';
        } 
        if ($data['nama_master_izin']=='TELSUS') {
            $awal = 'TELSUS';
        }
        // if($noUrutAkhir) {
        //     $nomor_sklo = $awal.'-'.sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        // }
        // dd($nokomitmen);

        

        $map_izin = array();
        $filled_persyaratan = array();
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $data['kd_izin'])->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        
        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $data['id_izin'])->get();
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
        // die;
        // dd($map_izin);

        if ($data['nama_master_izin'] == "TELSUS") {
        // return view('layouts.backend.direktur.mypdf', $data);
            $pdf = PDF::loadView('layouts.backend.sk.cetak-telsus', ['map_izin'=>$map_izin,'data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat] );
        } else {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-ulo', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat] );
        }
        $pdf->output();
        $put = file_put_contents($id_izin.'.pdf', $pdf);
        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function draftPenomoran($id,$id_kodeakses,Request $request){
        $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*','v.*')
        ->leftjoin('vw_list_izin as v','t.id_oss_trxizin','=','v.id')
        ->where('t.id','=',$id_kodeakses)
        ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first()->toArray();
        
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();
        // $pdf = PDF::setOptions(['']);
        if($dataNib['jenis_pu'] == "NPT"){
            $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran',
            ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,] )->setPaper('a4', 'portrait');
        }else{
            $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran-nib',
            ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,] )->setPaper('a4', 'portrait');
        }
        
        return $pdf->stream();
        
    }

    public function draftIzinPrinsip($id,Request $request){
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        $noUrutAkhir = Ulo::max('nomor_sklo');
        if($noUrutAkhir) {
        $nomor_sklo = sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        }

        $data = IzinPrinsip::select('*')->where('id_izin','=',$id)->first()->toArray();
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        $izin = Izin::select('*')->where('id_izin', '=', $id)->first();
        if ($izin == null) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $kd_izin = $izin['kd_izin'];
        
        $map_izin = array();
        $filled_persyaratan = array();

        
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        
        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }
        
        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);

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
        
        // $data = array();
        // $nib = array();
        // $date_reformat = new DateHelper();  
        // $dataNib = array();
        // return view('layouts.backend.sk.draft-izin-prinsip-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        $pdf = PDF::loadView('layouts.backend.sk.draft-izin-prinsip-telsus',
        ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin, 'nomor_sklo' =>
        $nomor_sklo]
        )->setPaper('legal', 'portrait');
        return $pdf->stream();
    }

    public function draftIzinPenyelenggaraan($id,Request $request){
        $common = new CommonHelper;
        $izin = Izin::select('*')->where('id_izin', '=', $id)->first();
        if ($izin == null) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $kd_izin = $izin['kd_izin'];
        
        $map_izin = array();
        $filled_persyaratan = array();

        
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        
        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        if ($filled_persyaratan->count() > 0) {
            $filled_persyaratan = $filled_persyaratan->toArray();
        }
        
        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);

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
        
        $data = array();
        $nib = array();
        $date_reformat = new DateHelper();  
        $dataNib = array();
        // return view('layouts.backend.sk.draft-izin-penyelenggaraan-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        $pdf = PDF::loadView('layouts.backend.sk.draft-izin-penyelenggaraan-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin] )->setPaper('legal', 'portrait');
        return $pdf->stream();
    }

    public function draftIzinPencabutan($id, Request $request){
        $common = new CommonHelper;
        $izin = Izin::select('*')->where('id_izin', '=', $id)->first();
        if ($izin == null) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $kd_izin = $izin['kd_izin'];
        
        $data = array();
        $nib = array();
        $date_reformat = new DateHelper();  
        $dataNib = array();
        // return view('layouts.backend.sk.draft-pencabutan-izin-prinsip-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        $pdf = PDF::loadView('layouts.backend.sk.draft-pencabutan-izin-prinsip-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat] )->setPaper('legal', 'portrait');
        return $pdf->stream();
    }
    
    public function draftIzinPerpanjangan($id, Request $request){
        $common = new CommonHelper;
        $izin = Izin::select('*')->where('id_izin', '=', $id)->first();
        if ($izin == null) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $kd_izin = $izin['kd_izin'];
        
        $data = array();
        $nib = array();
        $date_reformat = new DateHelper();  
        $dataNib = array();
        // return view('layouts.backend.sk.draft-perpanjangan-izin-prinsip-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        $pdf = PDF::loadView('layouts.backend.sk.draft-perpanjangan-izin-prinsip-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat] )->setPaper('legal', 'portrait');
        return $pdf->stream();
    }

    public function draftPenetapanKomitmen($id_izin){
        $data['rolloutplan'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [179,201,223,263,269,293,315,337,359])->pluck('filled_document')->first();
        $data['komitmen_kinerja_layanan_lima_tahun'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [180,202,224,247,270,294,316,338,360])->pluck('filled_document')->first();
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $idizin = $id_izin;
        $ulos = DB::table('tb_trx_ulo')
        ->where('id_izin', '=', $id_izin)    
        ->first();
        $izin = Izin::select('*')
        ->where('id_izin', '=', $id_izin)    
        ->first();
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

        if ($id_master_izin == 1) {
            $nokomitmen = DB::table('latest_izinkomitmenno_jasa')->select('izinkomitmenno')->first();
            $latest_nokomitmen = $nokomitmen->izinkomitmenno;
            $pdf = PDF::loadView('layouts.backend.sk.draft-penetapan-jasa', ['ulos'=>$ulos,'latest_nokomitmen'=>$latest_nokomitmen,'idizin'=>$idizin,'date_reformat'=>$date_reformat,'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' =>$map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }else{
            $nokomitmen = DB::table('latest_izinkomitmenno_jaringan')->select('izinkomitmenno')->first();
            $latest_nokomitmen = $nokomitmen->izinkomitmenno;
            $pdf = PDF::loadView('layouts.backend.sk.draft-penetapan', ['ulos'=>$ulos,'latest_nokomitmen'=>$latest_nokomitmen,'idizin'=>$idizin,'date_reformat'=>$date_reformat,'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' =>$map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }
        $put = file_put_contents($id_izin.'.pdf', $pdf);
        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }
    public function cetakPenetapanKomitmen($id_izin){
        $data['rolloutplan'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [179,201,223,263,269,293,315,337,359])->pluck('filled_document')->first();
        $data['komitmen_kinerja_layanan_lima_tahun'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [180,202,224,247,270,294,316,338,360])->pluck('filled_document')->first();
        $date_reformat = new DateHelper();
        $common = new CommonHelper;
        $idizin = $id_izin;
        $ulos = DB::table('tb_trx_ulo')
        ->where('id_izin', '=', $id_izin)    
        ->first();
        $izin = Izin::select('*')
        ->where('id_izin', '=', $id_izin)    
        ->first();
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
                ->where('tb_trx_komitmen_sk.id_izin','=',$idizin)
                ->where('tb_trx_komitmen_sk.jenis_sk','=','Penetapan')
                ->first();

        if ($id_master_izin == 1) {
            // $nokomitmen = DB::table('latest_izinkomitmenno_jasa')->select('izinkomitmenno')->first();
            // $latest_nokomitmen = $nokomitmen->izinkomitmenno;
            $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan-jasa', ['ulos'=>$ulos,'latest_nokomitmen'=>$komitmenSK->sk_no,'idizin'=>$idizin,'date_reformat'=>$date_reformat,'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' =>$map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }else{
            // $nokomitmen = DB::table('latest_izinkomitmenno_jaringan')->select('izinkomitmenno')->first();
            // $latest_nokomitmen = $nokomitmen->izinkomitmenno;
            $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan', ['ulos'=>$ulos,'latest_nokomitmen'=>$komitmenSK->sk_no,'idizin'=>$idizin,'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' =>$map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }
        $put = file_put_contents($id_izin.'.pdf', $pdf);
        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        // dd($ulos);
        return $pdf->stream();
    }
}