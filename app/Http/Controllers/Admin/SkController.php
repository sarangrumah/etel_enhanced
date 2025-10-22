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
use App\Models\TrxIzinPrinsip;
use App\Models\Admin\Penomoran;
use App\Models\Admin\BlokNomor_List;
use App\Models\Admin\vw_penomoran_list;
use App\Models\Admin\IzinPrinsip;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Catatandirektur;
use SimpleSoftwareIO\QrCode\Generator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class SkController extends Controller
{
    //
    public function index(){
    	return Redirect::route('admin.direktur.ulo');
    }

    public function draft(Request $request, $id_izin, $urut){

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
        $data = Ulo::from('tb_trx_ulo as u')
        ->select('ip.no_izin_prinsip',
        'ip.no_izin_prinsip_ext',
        'ip.tgl_izin_prinsip_init',
        'ip.tgl_izin_prinsip_ext_init',
        'u.*','i.nib','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.id_proyek','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')->where('u.id_izin','=',$id_izin)
                    ->join('vw_list_izin as i','u.id_izin','=','i.id_izin')
                    // ->leftjoin('vw_izinprinsip_pathsk as ip','u.id_izin','=','ip.id_izin_prinsip_ulo')
                    ->leftjoin('vw_izinprinsip_derivative as ip','ip.id_izin_prinsip_ulo','=','i.id_izin')
                    ->where('u.id','=',$urut)
                    ->first()->toArray();
        // dd($data);
        $awal = '';
        // if ($data['nama_master_izin']=='JARINGAN') {
        //     $awal = 'JAR';
        // } 
        // if ($data['nama_master_izin']=='JASA') {
        //     $awal = 'JASA';
        // } 
        // if ($data['nama_master_izin']=='TELSUS') {
        //     $awal = 'TELSUS';
        // }
        // if($noUrutAkhir) {
        //     $nomor_sklo = $awal.'-'.sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        // }
        // $nomor_sklo = $awal.'-'.$data['nomor_sklo_fixed'];
        $nomor_sklo = $data['nomor_sklo_fixed'];

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
        $filled_persyaratan_pre = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=',
        $data['id_proyek'])->get();
        if ($filled_persyaratan_pre->count() > 0) {
        $filled_persyaratan_pre = $filled_persyaratan_pre->toArray();
        }

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        $map_izin_pre = $common->get_map_izin_pre($data['id_proyek']);
        // dd($map_izin_pre);

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
        foreach ($map_izin_pre as $key => $value) {
        // if($value->file_type == "table"){
        // echo $value->file_type;
        // echo "<br>============<br>";
        $map_izin_pre[$key] = $value;
        foreach ($filled_persyaratan_pre as $key2 => $value2) {
        if ($value->id == $value2->id_map_listpersyaratan) {
        $map_izin_pre[$key]->form_isian = $value2->filled_document;
        $map_izin_pre[$key]->nama_asli = $value2->nama_file_asli;
        }
        }
        // }
        }
        // die;
        // dd($map_izin_pre);

        if ($data['nama_master_izin'] == "TELSUS") {

            $pdf = PDF::loadView('layouts.backend.sk.draft-telsus', ['map_izin'=>$map_izin, 'link'=> $link, 'data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        } elseif ($data['nama_master_izin'] == "TELSUS_INSTANSI"){
            if(isset($data['no_izin_prinsip_ext'])){
                $pdf = PDF::loadView('layouts.backend.sk.draft_sklo_ext',
                ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo,'map_izin_pre'=>$map_izin_pre]
                );
            }else{
                $pdf = PDF::loadView('layouts.backend.sk.draft_sklo_noext',
                ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo,'map_izin_pre'=>$map_izin_pre]
                );
            }
            
        }
        else {
            $pdf = PDF::loadView('layouts.backend.sk.draft',
            ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        }
        
        
        // return view('layouts.backend.direktur.mypdf', $data);

        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function cetakSKUlo(Request $request, $id_izin, $urut){
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        // $noUrutAkhir = Ulo::max('nomor_sklo');
       
        // dd($nomor_sklo);
        $data = Ulo::from('tb_trx_ulo as u')->select('u.*','u.id_izin','i.nib','i.kbli','i.kbli_name','i.nama_perseroan','i.full_kbli','i.jenis_izin','i.kd_izin','i.jenis_layanan','i.jenis_layanan_html','i.kabupaten_name','i.no_izin','i.provinsi_name','i.nama_master_izin')->where('u.id_izin','=',$id_izin)
                    ->join('vw_list_izin as i','u.id_izin','=','i.id_izin')
                    ->where('u.id','=',$urut)
                    ->first()->toArray();
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        // $awal = '';
        // if ($data['nama_master_izin']=='JARINGAN') {
        //     $awal = 'JAR';
        // } 
        // if ($data['nama_master_izin']=='JASA') {
        //     $awal = 'JASA';
        // } 
        // if ($data['nama_master_izin']=='TELSUS') {
        //     $awal = 'TELSUS';
        // }
        // $nomor_sklo = $awal.'-'.$data['nomor_sklo_fixed'];
        // if($noUrutAkhir) {
        //     $nomor_sklo = $awal.'-'.sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        // }
        // dd($nokomitmen);

        $nomor_sklo = $data['nomor_sklo_fixed'];

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
            $pdf = PDF::loadView('layouts.backend.sk.cetak-telsus', ['map_izin'=>$map_izin,'data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        } else {
            $pdf = PDF::loadView('layouts.backend.sk.cetak-ulo', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'nomor_sklo'=>$nomor_sklo] );
        }
        $pdf->output();
        $put = file_put_contents($id_izin.'.pdf', $pdf);
        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function draftPenomoran($id,$id_kodeakses,Request $request){
        // dd($id,$id_kodeakses,$request->all());
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
        ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->where('t.id', '=', $id_kodeakses)
        // ->whereIn('t.status_permohonan', [$status_penomoran, 915])
        ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first();

        $penomoran = $penomoran->toArray();
        // dd($penomoran['jenis_permohonan']);
        if($penomoran['jenis_permohonan']=="Penetapan Nomor Baru"){
        $status = 'Penetapan Penomoran';
        }elseif($penomoran['jenis_permohonan']=="Penetapan Nomor Tambahan"){
        $status = 'Penetapan Penomoran';
        }elseif($penomoran['jenis_permohonan']=="Pengembalian Penomoran"){
        $status = 'Penetapan Penomoran Ulang';
        }elseif($penomoran['jenis_permohonan']=="Perubahan Penetapan"){
        $status = 'Penetapan Penomoran Ulang';
        }elseif($penomoran['jenis_permohonan']=="Penetapan Ulang Penomoran Telekomunikasi"){
        $status = 'Penetapan Penomoran Ulang';
        }

        $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*', 'v.*','w.*')
        ->leftjoin('vw_list_izin as v', 't.id_permohonan', '=', 'v.id_izin')
        ->leftjoin('vw_penomoran_kodeakses_additional_new as w', 't.id_izin', '=', 'w.id_izin')
        ->where('t.id', '=', $id_kodeakses)
        // ->where('w.group_permohonan','=',$status)
        ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first()->toArray();
        // dd($data);
        
        
        $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $data['id_permohonan'])
        ->where('status_evaluasi_bloknomor', '=', 1)->get()->toArray();
        // dd($penomoran_bloknomor,$data['id_permohonan']);
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        if($data['jenis_permohonan'] != 'Penetapan Ulang Penomoran Telekomunikasi'){
            $dataNib = Nib::where('nib',$nib)->first();
            $dataNib = $dataNib->toArray();
        }
        // dd($dataNib, $data);
        // $penomoran_list_count = DB::table('vw_penomoran_raw_additional')
        // ->where('id_izin','=',$data['id_permohonan'])->count();
        $penomoran_list_count = DB::table('vw_penomoran_raw_additional')
            ->where('id_izin', $data['id_permohonan'])
            ->count();
        // $penomoran_list_count = DB::table('vw_penomoran_raw_additional')
        //     ->select(DB::raw('COUNT(*) as aggregate'))
        //     ->where('id_izin', $data['id_permohonan'])
        //     ->value('aggregate');
        // dd($penomoran_list_count);
        $penomoran_kodeakses =
        DB::table('vw_penomoran_raw_additional')->where('vw_penomoran_raw_additional.id_izin','=',$data['id_permohonan'])
        // ->leftjoin('tb_trx_sk_penomoran', 'tb_trx_sk_penomoran.kode_akses','=','vw_penomoran_raw_additional.kode_akses')
        // ->leftjoin('tb_trx_sk_penomoran', function ($join) {
        // $join->on('tb_trx_sk_penomoran.kode_akses', '=', 'vw_penomoran_raw_additional.kode_akses')
        // ->on('tb_trx_sk_penomoran.id_izin', '=', 'vw_penomoran_raw_additional.id_izin');
        // })
        ->get()->toArray();
        // dd($dataNib);

        $penomoran_list = vw_penomoran_list::where('group_permohonan','=',$status);
        // $pdf = PDF::setOptions(['']);
        // dd($dataNib['jenis_pu'], $data['id_proyek'],$data['nib']);
        if($data['jenis_permohonan'] == 'Penetapan Ulang Penomoran Telekomunikasi'){
            
            $penomoran_ulang = DB::table('tb_trx_penomoran_penetapanulang')->select('tb_trx_penomoran_penetapanulang.*','vw_detail_loc.detail_loc')
                ->leftjoin('vw_detail_loc','vw_detail_loc.id','=','tb_trx_penomoran_penetapanulang.id_mst_kelurahan')
                ->where('id_izin','=',$id)->first();
                if ($penomoran_ulang) {
                    $penomoran_ulang = json_decode(json_encode($penomoran_ulang), true);
                }
            // $penomoran_ulang = $penomoran_ulang->toArray();
                // dd($penomoran_ulang);
            if(isset($penomoran_ulang['nib'])){
                // dd($data,$penomoran_ulang,$penomoran_list,$penomoran_list_count,$penomoran_kodeakses);
                    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran-nib',
                    ['data'=>$data,'datanib'=>$penomoran_ulang,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
                    );//->setPaper('a4', 'portrait');
            }else{
                    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran',
                    ['data'=>$data,'datanib'=>$penomoran_ulang,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
                    );//->setPaper('a4', 'portrait');
            }

        }elseif($data['jenis_permohonan'] != 'Penetapan Ulang Penomoran Telekomunikasi'){
            if($dataNib['jenis_pu'] == "NPT"){
                if($data['id_proyek'] == 'Blok Nomor'){
                    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran',
                    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_bloknomor'=>$penomoran_bloknomor]
                    );//->setPaper('a4', 'portrait');
                }else{
                    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran',
                    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
                    );//->setPaper('a4', 'portrait');
                }            
            }else{
                // dd($dataNib['nama_perseroan']);
                if($data['id_proyek'] == 'Blok Nomor'){
                    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran-nib-bn',
                    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,
                    'penomoran_bloknomor'=>$penomoran_bloknomor]);//->setPaper('a4', 'portrait');
                }else{
                    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran-nib',
                    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
                    );//->setPaper('a4', 'portrait');
                }
            }
        }
        
        return $pdf->stream();
        
    }

    public function cetakPenomoran($id,$id_kodeakses,Request $request){
        // dd($id,$id_kodeakses,$request->all());
        $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
        ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->where('t.id', '=', $id_kodeakses)
        // ->whereIn('t.status_permohonan', [$status_penomoran, 915])
        ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first();
        $status = '';
        $penomoran = $penomoran->toArray();
        if($penomoran['jenis_permohonan']=="Penetapan Nomor Baru"){
        $status = 'Penetapan Penomoran';
        }elseif($penomoran['jenis_permohonan']=="Penetapan Nomor Tambahan"){
        $status = 'Penetapan Penomoran';
        }elseif($penomoran['jenis_permohonan']=="Pengembalian Penomoran"){
        $status = 'Penetapan Penomoran Ulang';
        }elseif($penomoran['jenis_permohonan']=="Perubahan Penetapan"){
        $status = 'Penetapan Penomoran Ulang';
        }
        // dd($status, $penomoran, $penomoran['jenis_permohonan']);

        $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*', 'v.*','w.*')
        ->leftjoin('vw_list_izin as v', 't.id_permohonan', '=', 'v.id_izin')
        ->leftjoin('vw_penomoran_kodeakses_additional_new as w', 't.id_izin', '=', 'w.id_izin')
        ->where('t.id', '=', $id_kodeakses)
        // ->where('w.group_permohonan','=',$status)
        ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first()->toArray();
        // dd($data);
        
        
        $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $data['id_permohonan'])
        ->where('status_evaluasi_bloknomor', '=', 1)->get()->toArray();
        // dd($penomoran_bloknomor,$data['id_permohonan']);
        $date_reformat = new DateHelper();
        $nib = $data['nib'];
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        $penomoran_list_count = DB::table('vw_penomoran_raw_additional')->where('id_izin','=',$data['id_permohonan'])->count();
        // $penomoran_kodeakses =
        // DB::table('vw_penomoran_raw_additional')->where('vw_penomoran_raw_additional.id_izin','=',$data['id_permohonan'])
        // // ->leftjoin('tb_trx_sk_penomoran', 'tb_trx_sk_penomoran.kode_akses','=','vw_penomoran_raw_additional.kode_akses')
        // // ->leftjoin('tb_trx_sk_penomoran', function ($join) {
        // // $join->on('tb_trx_sk_penomoran.kode_akses', '=', 'vw_penomoran_raw_additional.kode_akses')
        // // ->on('tb_trx_sk_penomoran.id_izin', '=', 'vw_penomoran_raw_additional.id_izin');
        // // })
        // ->get()->toArray();
        $penomoran_kodeakses =
        DB::table('vw_penomoran_raw_additional')->where('vw_penomoran_raw_additional.id_izin','=',$data['id_permohonan'])
            ->leftjoin('tb_trx_sk_penomoran', function ($join) {
                        $join->on('tb_trx_sk_penomoran.kode_akses', '=', 'vw_penomoran_raw_additional.kode_akses')
                            ->on('tb_trx_sk_penomoran.id_izin', '=', 'vw_penomoran_raw_additional.id_izin');
                    })->get()->toArray();
        // dd($penomoran_kodeakses);

        $penomoran_list = vw_penomoran_list::where('group_permohonan','=',$status);
        // $pdf = PDF::setOptions(['']);
        // dd($penomoran_list_count, $penomoran_list);
        // dd($dataNib['jenis_pu'],$data);
        if($dataNib['jenis_pu'] == "NPT"){
            if($data['id_proyek'] == 'Blok Nomor'){
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran',
                ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_bloknomor'=>$penomoran_bloknomor]
                );//->setPaper('a4', 'portrait');
            }else{
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran',
                ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
                );//->setPaper('a4', 'portrait');
            }            
        }else{
            if($data['id_proyek'] == 'Blok Nomor'){
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran-nib-bn',
                ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,
                'penomoran_bloknomor'=>$penomoran_bloknomor]);//->setPaper('a4', 'portrait');
            }else{
                $pdf = PDF::loadView('layouts.backend.sk.cetak-penomoran-nib',
                ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
                );//->setPaper('a4', 'portrait');
            }
        }
        
        return $pdf->stream();
        
    }

    public function draftPenomoranPencabutan($id,Request $request){
    // dd($request->all());
    $date_reformat = new DateHelper();
    $penomoran_alokasi = DB::table('vw_penomoran_alokasi_new as t')->select('t.*','v.dasar_pencabutan', 'v.pertimbangan_pencabutan')
    ->leftjoin('tb_trx_penomoran_pencabutan as v', 't.id', '=', 'v.id_mst_kode_akses')
    ->where('t.id', '=', $id)
    // ->whereIn('t.status_permohonan',[$status_penomoran,915])
    ->first();
        // dd($penomoran_alokasi);
    // if ($penomoran_alokasi->jenis_pengguna == "Penyelenggara Telekomunikasi") {
    // $pdf = PDF::loadView(
    // 'layouts.backend.sk.draft-pencabutan-penomoran',
    // ['penomoran_alokasi' => $penomoran_alokasi, 'date_reformat' =>
    // $date_reformat]
    // ); //->setPaper('a4', 'portrait');
    // // dd($request->all());
    // } else {
    // // $pdf = PDF::loadView(
    // // 'layouts.backend.sk.draft-penomoran',
    // // ['data' => $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'penomoran_list' => $penomoran_list]
    // // ); //->setPaper('a4', 'portrait');
    // dd($penomoran_alokasi);
    // }
    $pdf = PDF::loadView(
    'layouts.backend.sk.draft-pencabutan-penomoran',
    ['penomoran_alokasi' => $penomoran_alokasi, 'date_reformat' =>
    $date_reformat]
    );
    return $pdf->stream();

    }

    public function draftpenomoranpenetapanulang($id,Request $request){
    dd($request);
    $date_reformat = new DateHelper();
    $penomoran_alokasi = DB::table('vw_penomoran_alokasi_new as t')->select('t.*','v.dasar_pencabutan', 'v.pertimbangan_pencabutan')
    ->leftjoin('tb_trx_penomoran_pencabutan as v', 't.id', '=', 'v.id_mst_kode_akses')
    ->where('t.id', '=', $id)
    // ->whereIn('t.status_permohonan',[$status_penomoran,915])
    ->first();
        // dd($penomoran_alokasi);
    // if ($penomoran_alokasi->jenis_pengguna == "Penyelenggara Telekomunikasi") {
    // $pdf = PDF::loadView(
    // 'layouts.backend.sk.draft-pencabutan-penomoran',
    // ['penomoran_alokasi' => $penomoran_alokasi, 'date_reformat' =>
    // $date_reformat]
    // ); //->setPaper('a4', 'portrait');
    // // dd($request->all());
    // } else {
    // // $pdf = PDF::loadView(
    // // 'layouts.backend.sk.draft-penomoran',
    // // ['data' => $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'penomoran_list' => $penomoran_list]
    // // ); //->setPaper('a4', 'portrait');
    // dd($penomoran_alokasi);
    // }
    $pdf = PDF::loadView(
    'layouts.backend.sk.draft-pencabutan-penomoran',
    ['penomoran_alokasi' => $penomoran_alokasi, 'date_reformat' =>
    $date_reformat]
    );
    return $pdf->stream();

    }


    public function draftPenomoran_pdf($id,$id_kodeakses,Request $request){
    // dd($request->all());
    $penomoran = Penomoran::from('tb_trx_kode_akses as t')->select('t.id as id_kode_akses', 't.*', 'v.*')
    ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')->where('t.id', '=', $id_kodeakses)
    // ->whereIn('t.status_permohonan', [$status_penomoran, 915])
    ->with('KodeIzin')->with('KodeAkses')->first();

    $penomoran = $penomoran->toArray();
    if($penomoran['jenis_permohonan']=="Penetapan Nomor Baru"){
    $status = 'Penetapan Penomoran';
    }elseif($penomoran['jenis_permohonan']=="Penetapan Nomor Tambahan"){
    $status = 'Penetapan Penomoran';
    }elseif($penomoran['jenis_permohonan']=="Pengembalian Penomoran"){
    $status = 'Penetapan Penomoran Ulang';
    }elseif($penomoran['jenis_permohonan']=="Perubahan Penetapan"){
    $status = 'Penetapan Penomoran Ulang';
    }

    $data = Penomoran::from('tb_trx_kode_akses as t')->select('t.*', 'v.*','w.*')
    ->leftjoin('vw_list_izin as v', 't.id_izin', '=', 'v.id_izin')
    ->leftjoin('vw_penomoran_kodeakses_additional_new as w', 't.id_izin', '=', 'w.id_izin')
    ->where('t.id', '=', $id_kodeakses)
    // ->where('w.group_permohonan','=',$status)
    ->with('KodeIzin')->with('KodeAkses')->with('KodeAkses.JenisKodeAkses')->first()->toArray();
    // dd($data);


    $penomoran_bloknomor = BlokNomor_List::where('id_izin', '=', $data['id_permohonan'])
    ->where('status_evaluasi_bloknomor', '=', 1)->get()->toArray();
    // dd($penomoran_bloknomor,$data['id_permohonan']);
    $date_reformat = new DateHelper();
    $nib = $data['nib'];
    $dataNib = Nib::where('nib',$nib)->first();
    $dataNib = $dataNib->toArray();

    $penomoran_list_count =
    DB::table('vw_penomoran_raw_additional')->where('id_izin','=',$data['id_permohonan'])->count();
    $penomoran_kodeakses =
    DB::table('vw_penomoran_raw_additional')->where('id_izin','=',$data['id_permohonan'])->get()->toArray();
    // dd($penomoran_kodeakses);

    $penomoran_list = vw_penomoran_list::where('group_permohonan','=',$status);
    // $pdf = PDF::setOptions(['']);
    // dd($penomoran_list_count, $penomoran_list);
    if($dataNib['jenis_pu'] == "NPT"){
    if($data['id_proyek'] == 'Blok Nomor'){
    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran',
    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_bloknomor'=>$penomoran_bloknomor]
    );//->setPaper('a4', 'portrait');
    }else{
    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran',
    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list]
    );//->setPaper('a4', 'portrait');
    }
    }else{
    if($data['id_proyek'] == 'Blok Nomor'){
    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran-nib-bn',
    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,
    'penomoran_bloknomor'=>$penomoran_bloknomor]);//->setPaper('a4', 'portrait');
    }else{
    $pdf = PDF::loadView('layouts.backend.sk.draft-penomoran-nib',
    ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'penomoran_list'=>$penomoran_list,'penomoran_list_count'=>$penomoran_list_count,'penomoran_kodeakses'=>$penomoran_kodeakses]
    );//->setPaper('a4', 'portrait');
    }
    }
    $pdf->render();
    $pdfContent = $pdf->output();

    // Log the PDF content
    Log::info('PDF Content: ' . $pdfContent);
    // dd($pdfContent);
    // Return a response with the PDF content
    return response()->json(['pdfContent' => $pdfContent]);

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

        $data = DB::table('vw_list_izin as i')
        ->select('i.nib', 'i.status_badan_hukum', 'i.id_izin', 'i.id_proyek', 'i.kbli', 'i.kbli_name',
        'i.nama_perseroan', 'i.full_kbli', 'i.jenis_izin', 'i.kd_izin', 'i.jenis_layanan', 'i.jenis_layanan_html',
        'i.kabupaten_name', 'i.no_izin', 'i.provinsi_name', 'i.nama_master_izin', 
        'vw_izinprinsip_derivative.tgl_izin_prinsip_init',
        'vw_izinprinsip_derivative.no_izin_prinsip', 
        'vw_izinprinsip_derivative.tgl_izin_prinsip_ext_init', 
        'vw_izinprinsip_derivative.no_izin_prinsip_ext', 'i.submitted_date')
        ->leftjoin('vw_izinprinsip_derivative','vw_izinprinsip_derivative.id_izin_prinsip','=','i.id_proyek')
        ->where('i.id_izin', '=', $id)
        ->first();
        $date_reformat = new DateHelper();
        $nib = $data->nib;
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
        // dd($filled_persyaratan);

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
        // dd($map_izin, $data, $dataNib);
        $pdf = PDF::loadView('layouts.backend.sk.draft-izin-prinsip-telsus', ['map_izin' => $map_izin, 'data' => $data, 'datanib' => $dataNib, 'date_reformat' => $date_reformat, 'nomor_sklo' => ''])->setPaper('legal', 'portrait');
        return $pdf->stream();
    }

    public function cetakIzinPrinsip($id_izin){
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
        return $pdf->stream();
    }



    public function draftIzinPenyelenggaraan($id,Request $request){
        $common = new CommonHelper;
        $izin = Izin::from('vw_list_izin as u')
        ->select('ip.no_izin_prinsip',
        'ip.no_izin_prinsip_ext',
        'ip.tgl_izin_prinsip_init',
        'ip.tgl_izin_prinsip_ext_init',
        'ip.no_izin_penyelenggaraan',
        'ip.no_sk_ulo',
        'ip.tgl_izin_prinsip_ulo',
        'u.*')
        // ->leftjoin('vw_izinprinsip_pathsk as ip','u.id_proyek','=','ip.id_izin_prinsip')
        ->leftjoin('vw_izinprinsip_derivative as ip','ip.id_izin_prinsip','=','u.id_proyek')
        
        ->where('u.id_izin', '=', $id)->first();
        // dd($izin);
        if ($izin == null) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $kd_izin = $izin['kd_izin'];
        
        $map_izin = array();
        $map_izin = DB::table('vw_pre_izin_telsus')->select('*')
        ->where('id_proyek', '=', $izin['id_proyek'])
        // ->where('kd_izin', '!=', $izin['kd_izin'])
        ->get();
        $ip_idproyek = DB::table('tb_trx_ulo')
        ->join('tb_oss_trx_izin as b', 'b.id_izin', '=', 'tb_trx_ulo.id_izin')
        ->select('b.id_proyek')
        ->where('tb_trx_ulo.id_izin','=',$id)
        ->first();
        $ip_idproyek_iterasi = DB::table('tb_oss_trx_izin')
        ->join('tb_trx_izin_prinsip as b', 'b.id_trx_izin', '=', 'tb_oss_trx_izin.id_izin')
        ->select('b.id_trx_izin')
        ->where('tb_oss_trx_izin.id_proyek','=',$ip_idproyek->id_proyek)
        ->where('b.iterasi_perpanjangan','=',1)
        ->first();
        $id_trxizinip_stat = 0;
        if (isset($ip_idproyek_iterasi->id_trx_izin)) {
        $id_trxizinip = $ip_idproyek_iterasi->id_trx_izin;
        $id_trxizinip_stat = 1;
        } else {
        $id_trxizinip = $ip_idproyek->id_proyek;
        $id_trxizinip_stat = 0;
        }
        $IzinPrinsip = TrxIzinPrinsip::where ('id_trx_izin', '=', $id_trxizinip)->first();
        // $filled_persyaratan = array();
        // dd($map_izin);
        
        // $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=', $kd_izin)->first();
        // $id_mst_izinlayanan = $mst_kode_izin->id;
        
        // $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        // if ($filled_persyaratan->count() > 0) {
        //     $filled_persyaratan = $filled_persyaratan->toArray();
        // }
        
        // $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($map_izin);

        // foreach ($map_izin as $key => $value) {
        //     // echo $value->persyaratan;
        //     // echo "<br>=============<br>";
        //     $map_izin[$key] = $value;
        //     foreach ($filled_persyaratan as $key2 => $value2) {
        //         if ($value->id == $value2->id_map_listpersyaratan) {
        //             $map_izin[$key]->form_isian = $value2->filled_document;
        //             $map_izin[$key]->nama_asli = $value2->nama_file_asli;
        //         }
        //     }
        // }
        // $map_izin = array();
        $data = array();
        $data = $izin;
        // dd($data['nama_perseroan']);
        // dd($map_izin);
        $date_reformat = new DateHelper();  
        $dataNib = array();
        $nokomitmen = DB::table('latest_izinprinsipno_0302')->select('izinprisipno')->first();
        $latest_nokomitmen = $nokomitmen->izinprisipno;
        // return view('layouts.backend.sk.draft-izin-penyelenggaraan-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        // dd($data);
        $pdf = PDF::loadView('layouts.backend.sk.draft-izin-penyelenggaraan-telsus',
        ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin, 'latest_nokomitmen'
        =>$latest_nokomitmen,'IzinPrinsip'=>$IzinPrinsip,'id_trxizinip_stat'=>$id_trxizinip_stat]
        )->setPaper('legal', 'portrait');
        return $pdf->stream();
    }

    public function draftIzinPencabutan($id, Request $request){
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        $noUrutAkhir = Ulo::max('nomor_sklo');
        if($noUrutAkhir) {
        $nomor_sklo = sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        }

        $data = DB::table('vw_list_izin as i')
        ->select('i.nib', 'i.status_badan_hukum', 'i.id_izin', 'i.id_proyek', 'i.kbli', 'i.kbli_name',
        'i.nama_perseroan', 'i.full_kbli', 'i.jenis_izin', 'i.kd_izin', 'i.jenis_layanan', 'i.jenis_layanan_html',
        'i.kabupaten_name', 'i.no_izin', 'i.provinsi_name', 'i.nama_master_izin',
        'vw_izinprinsip_derivative.tgl_izin_prinsip_init',
        'vw_izinprinsip_derivative.no_izin_prinsip',
        'vw_izinprinsip_derivative.tgl_izin_prinsip_ext_init',
        'vw_izinprinsip_derivative.no_izin_prinsip_ext',
        'vw_izinprinsip_derivative.no_izin_prinsip_cabut',
        'vw_izinprinsip_derivative.tgl_izin_prinsip_cabut',
        'i.submitted_date')
        ->leftjoin('vw_izinprinsip_derivative','vw_izinprinsip_derivative.id_izin_prinsip','=','i.id_proyek')
        ->where('i.id_izin', '=', $id)
        ->first();
        $date_reformat = new DateHelper();
        $nib = $data->nib;
        $dataNib = Nib::where('nib',$nib)->first();
        $dataNib = $dataNib->toArray();

        $izin = Izin::select('*')->where('id_izin', '=', $id)->first();
        if ($izin == null) {
            return abort(404);
        }

        $izin = $izin->toArray();
        $kd_izin = $izin['kd_izin'];
        
        // $data = array();
        // $nib = array();
        // $date_reformat = new DateHelper();  
        // $dataNib = array();
        // return view('layouts.backend.sk.draft-pencabutan-izin-prinsip-telsus', ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        $pdf = PDF::loadView('layouts.backend.sk.draft-pencabutan-izin-prinsip-telsus',
        ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat, 'nomor_sklo' => ''] )->setPaper('legal',
        'portrait');
        return $pdf->stream();
    }
    
    public function draftIzinPerpanjangan($id, Request $request){
        $datenow = Carbon::now();
        $common = new CommonHelper;

        $datenow = $datenow->year;
        $tengah = 'Tel.04.02';
        $noUrutAkhir = Ulo::max('nomor_sklo');
        if($noUrutAkhir) {
        $nomor_sklo = sprintf("%04s", abs($noUrutAkhir)). '/' . $tengah .'/' . $datenow;
        }

        $data = DB::table('vw_list_izin as i')
        ->select('i.nib', 'i.status_badan_hukum', 'i.id_izin', 'i.id_proyek', 'i.kbli', 'i.kbli_name',
        'i.nama_perseroan', 'i.full_kbli', 'i.jenis_izin', 'i.kd_izin', 'i.jenis_layanan', 'i.jenis_layanan_html',
        'i.kabupaten_name', 'i.no_izin', 'i.provinsi_name', 'i.nama_master_izin', 
        'vw_izinprinsip_derivative.tgl_izin_prinsip_init',
        'vw_izinprinsip_derivative.no_izin_prinsip', 
        'vw_izinprinsip_derivative.tgl_izin_prinsip_ext_init', 
        'vw_izinprinsip_derivative.no_izin_prinsip_ext', 
        'i.submitted_date')
        ->leftjoin('vw_izinprinsip_derivative','vw_izinprinsip_derivative.id_izin_prinsip','=','i.id_proyek')
        ->where('i.id_izin', '=', $id)
        ->first();
        $date_reformat = new DateHelper();
        $nib = $data->nib;
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


        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name')->where('kode_izin', '=',
        $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;

        $filled_persyaratan = DB::table('tb_trx_persyaratan')->select('*')->where('id_trx_izin', '=', $id)->get();
        if ($filled_persyaratan->count() > 0) {
        $filled_persyaratan = $filled_persyaratan->toArray();
        }

        $map_izin = $common->get_map_izin($id_mst_izinlayanan);
        // dd($filled_persyaratan);

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
        // return view('layouts.backend.sk.draft-izin-prinsip-telsus',        ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat,'map_izin' => $map_izin]);
        $pdf = PDF::loadView('layouts.backend.sk.draft-perpanjangan-izin-prinsip-telsus',
        ['data'=>$data,'datanib'=>$dataNib,'date_reformat'=>$date_reformat, 'nomor_sklo' => ''] )->setPaper('legal',
        'portrait');
        return $pdf->stream();
    }

    public function draftPenetapanKomitmen($id_izin){
        $data['rolloutplan'] = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->whereIn('id_map_listpersyaratan', [179,201,223,263,269,293,315,337,359,386])->pluck('filled_document')->first();
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
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name','short_name')->where('kode_izin', '=', $kd_izin)->first();
        $id_mst_izinlayanan = $mst_kode_izin->id;
        $id_master_izin = $izin['id_master_izin'];
        $map_izin_perubahan = $common->get_map_izin($id_mst_izinlayanan);
        $filled_perubahan = DB::table('tb_trx_persyaratan')->where('id_trx_izin', $id_izin)->get()->toArray();
        $nama_perseroan = $izin['nama_perseroan'];

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
        // $nama_perseroan = DB::table('tb_oss_trx_izin')
        // ->leftJoin('tb_oss_nib', 'tb_oss_trx_izin.oss_id', '=', 'tb_oss_nib.oss_id')->where('tb_oss_trx_izin.id_izin', $id_izin)->pluck('nama_perseroan')->first();

        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        // dd($data);

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
        $nama_perseroan = $izin['nama_perseroan'];
        $kd_izin = $izin['kd_izin'];
        $mst_kode_izin = DB::table('tb_mst_izinlayanan')->select('id', 'kode_izin', 'name', 'short_name')->where('kode_izin', '=', $kd_izin)->first();
        $short_name = $mst_kode_izin->short_name;
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

        // dd($mst_kode_izin);
        // $nama_perseroan = DB::table('tb_oss_trx_izin')
        // ->leftJoin('tb_oss_nib', 'tb_oss_trx_izin.oss_id', '=', 'tb_oss_nib.oss_id')->where('tb_oss_trx_izin.id_izin', $id_izin)->pluck('nama_perseroan')->first();

        $cities = DB::table('tb_mst_kabupaten')->select('id', 'name')->get();
        $komitmenSK = DB::table('tb_trx_komitmen_sk')
                ->where('tb_trx_komitmen_sk.id_izin','=',$idizin)
                ->where('tb_trx_komitmen_sk.jenis_sk','=','Penetapan')
                ->first();
        // dd($ulos);
        if ($id_master_izin == 1) {
            // $nokomitmen = DB::table('latest_izinkomitmenno_jasa')->select('izinkomitmenno')->first();
            // $latest_nokomitmen = $nokomitmen->izinkomitmenno;
            $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan-jasa', ['ulos'=>$ulos,'latest_nokomitmen'=>$komitmenSK->sk_no,'idizin'=>$idizin,'date_reformat'=>$date_reformat,'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' =>$map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }else{
            // $nokomitmen = DB::table('latest_izinkomitmenno_jaringan')->select('izinkomitmenno')->first();
            // $latest_nokomitmen = $nokomitmen->izinkomitmenno;
            $pdf = PDF::loadView('layouts.backend.sk.cetak-penetapan', ['ulos'=>$ulos,'latest_nokomitmen'=>$komitmenSK->sk_no,'date_reformat'=>$date_reformat,'idizin'=>$idizin,'nama_perseroan' => $nama_perseroan, 'data' => $data, 'cities' => $cities, 'map_izin_perubahan' =>$map_izin_perubahan, 'mst_kode_izin' => $mst_kode_izin]);
        }
        $put = file_put_contents($id_izin.'.pdf', $pdf);
        // return $pdf->download('SK-ULO-'.$id_izin.'-'.date('Y-m-d H:i:s').'.pdf');
        // dd($ulos);
        return $pdf->stream();
    }
}