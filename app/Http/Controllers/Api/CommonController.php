<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\checkuser_active;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;

class CommonController extends Controller
{

   public function get_offday(Request $req){
      // dd($req->kbli);
      $kbli = $req->kbli;
      // $id = $req->id;
      // dd($izin,$id);
      $jenis_layanan = DB::table('vw_offday')->select('*')
      // ->where('is_active', 1)
      // ->where('layanan_penomoran',1)
      // ->where('id_mst_kbli',1)
      // ->where('layanan_penomoran','=','1')
      ->get();
      // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
      // ->where('id_mst_kbli',$id)
      // // ->where('layanan_penomoran','=','1')
      // ->get();
      
      return response()->json($jenis_layanan);
   }

   
   public function get_hariliburnasional(Request $req){
      // dd($req->kbli);
      $response = Http::get('https://api-harilibur.vercel.app/api');
      $kbli = $req->kbli;
      // $id = $req->id;
      // dd($izin,$id);
      $jenis_layanan = DB::table('vw_offday')->select('*')
      // ->where('is_active', 1)
      // ->where('layanan_penomoran',1)
      // ->where('id_mst_kbli',1)
      // ->where('layanan_penomoran','=','1')
      ->get();
      // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
      // ->where('id_mst_kbli',$id)
      // // ->where('layanan_penomoran','=','1')
      // ->get();
      
      return response()->json($jenis_layanan);
   }
   
   public function getjenislayanan(Request $req){
      // dd($req->all());
      $izin = $req->izin;
      $id = $req->id;
      // dd($izin);
      if ($izin=='jasa') {
         $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
         ->where('id_mst_izin', 1)
         ->where('is_active', 1)
         ->where('id_mst_kbli',$id)
         // ->where('layanan_penomoran','=','1')
         ->get();
      } elseif ($izin=='jaringan') {
         $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
         ->where('id_mst_izin', 2)
         ->where('is_active', 1)
         ->where('id_mst_kbli',$id)
         // ->where('layanan_penomoran','=','1')
         ->get();
      } elseif ($izin=='telsus') {
      $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
      ->where('id_mst_izin', 3)
      ->where('is_active', 1)
      ->where('id_mst_kbli',$id)
      // ->where('layanan_penomoran','=','1')
      ->get();
      } 
   //    $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   //  ->where('id_mst_kbli',$id)
   // //  ->where('layanan_penomoran','=','1')
   //  ->get();
    
    return response()->json($jenis_layanan);
   }

   public function getjenislayanan_nomor(Request $req){
      // dd($req->kbli);
      $kbli = $req->kbli;
      // $id = $req->id;
      // dd($izin,$id);
      $jenis_layanan = DB::table('vw_penomoran_jenislayanan')->select('kode_izin','name')
      ->where('kbli', $kbli)
      // ->where('is_active', 1)
      // ->where('layanan_penomoran',1)
      // ->where('id_mst_kbli',1)
      // ->where('layanan_penomoran','=','1')
      ->get();
   //    $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   //  ->where('id_mst_kbli',$id)
   // //  ->where('layanan_penomoran','=','1')
   //  ->get();
    
    return response()->json($jenis_layanan);
   }

   public function getkbli_nomor(Request $req){
   // dd($req->all());
   $izin = $req->izin;
   $id = $req->id;
   // dd($izin,$id);
   if ($izin=='jasa') {
   $jenis_kbli = DB::table('vw_penomoran_kbli')->select('name','desc')
   ->where('id_mst_izin', 1)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   } elseif ($izin=='jaringan') {
   $jenis_kbli = DB::table('vw_penomoran_kbli')->select('name','desc')
   ->where('id_mst_izin', 2)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',2)
   // ->where('layanan_penomoran','=','1')
   ->get();
   } elseif ($izin=='telsus') {
   $jenis_kbli = DB::table('vw_penomoran_kbli')->select('name','desc')
   ->where('id_mst_izin', 3)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',3)
   // ->where('layanan_penomoran','=','1')
   ->get();
   }
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return response()->json($jenis_kbli);
   }

   public function getjeniskodeakses_nomor(Request $req){
   // dd($req->all());
   $izinlayanan = $req->izinlayanan;
   // $id = $req->id;
   // dd($izin,$id);
   $jenis_kodeakses = DB::table('vw_penomoran_jeniskodeakses')->select('short_name','full_name')
   ->where('kode_izin', $izinlayanan)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return response()->json($jenis_kodeakses);
   }

   public function getjeniskodeakses_nomor_excPLM(Request $req){
   // dd($req->all());
   $izinlayanan = $req->izinlayanan;
   // $id = $req->id;
   // dd($izin,$id);
   $jenis_kodeakses = DB::table('vw_penomoran_jeniskodeakses_excPLM')->select('short_name','full_name')
   ->where('kode_izin', $izinlayanan)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return response()->json($jenis_kodeakses);
   }

   public function getkodeakses_nomor(Request $req){
   // dd($req->jenis_kodeakses);
   $jenis_kodeakses = $req->jenis_kodeakses;
   // $id = $req->id;
   // dd($jenis_kodeakses);
   $kodeakses = DB::table('vw_penomoran_kodeakses')->select('kode_akses','id')
   ->where('short_name','=', $jenis_kodeakses)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return response()->json($kodeakses);
   }

   public function getkodeakses_nomor_npt(Request $req){
   // dd($req->jenis_kodeakses);
   $jenis_kodeakses = $req->jenis_kodeakses;
   // $id = $req->id;
   // dd($jenis_kodeakses);
   $kodeakses = DB::table('vw_penomoran_kodeakses_npt')->select('kode_akses','id')
   ->where('short_name','=', $jenis_kodeakses)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return response()->json($kodeakses);
   }

   public function getkodeakses_nomor_re(Request $req){
   // dd($req->all());
   $jenis_kodeakses = $req->jenis_kodeakses;
   // $id = $req->id;
   // dd($jenis_kodeakses);
   $kodeakses = DB::table('vw_penomoran_kodeakses_aktif')->select('kode_akses','id')
   ->where('short_name','=', $jenis_kodeakses)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return Response()->json($kodeakses);
   }

   public function getkodeakses_nomor_re_npt(Request $req){
   // dd($req->all());
   $jenis_kodeakses = $req->jenis_kodeakses;
   // $id = $req->id;
   // dd($jenis_kodeakses);
   $kodeakses = DB::table('vw_penomoran_kodeakses_aktif_npt')->select('kode_akses','id')
   ->where('short_name','=', $jenis_kodeakses)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return Response()->json($kodeakses);
   }

   public function getskinfo_nomor_re($kodeakses,Request $req){
   $_kodeakses = $req->kodeakses;
   // $id = $req->id;
   // dd($jenis_kodeakses);
   $kodeakses = DB::table('vw_penomoran_kodeakses_aktif_all')->select('tanggal_penetapan','nomor_penetapan')
   ->where('id','=', $_kodeakses)
   // ->where('is_active', 1)
   // ->where('layanan_penomoran',1)
   // ->where('id_mst_kbli',1)
   // ->where('layanan_penomoran','=','1')
   ->get();
   // dd($kodeakses);
   // $jenis_layanan = DB::table('tb_mst_izinlayanan')->select('id','name')
   // ->where('id_mst_kbli',$id)
   // // ->where('layanan_penomoran','=','1')
   // ->get();

   return Response()->json($kodeakses);
   }

   public function updatebloknomor(Request $request) {
   // Validate and sanitize the input as needed
   $value = $request->input('kode_wilayah_');
   dd($request->all());
   // $extraInfo = $request->input('extra_info');

   // Perform database update or insert using $value and $extraInfo

   return \response()->json(['success' => true]);
   }

   

   public function getulo($id)
   {
      $izin_prinsip = DB::table('tb_trx_izin_prinsip')
         ->select('*')
         ->where('id_trx_izin', $id)
         ->first();

      return response()->json($izin_prinsip);
   }

   public function checkusersactive(Request $request){
      
       $username = $request->input('username');
       $password = $request->input('password');

       // Perform authentication logic here using the provided credentials

       // For example, check if the credentials are valid
       if ($this->validateCredentials($username, $password)) {
       // Authentication successful
       return response()->json(['authenticated' => true]);
       }

       // Authentication failed
       return response()->json(['authenticated' => false]);
      
   }

   public function checkusersactive_email($username, Request $request){
   // $checkuser_active = checkuser_active::where('email','=',$username)
   // ->where('password','=',$password)->first();
   // $valid_user=$checkuser_active->count();

   $checkuser_exists = checkuser_active::where('email','=',$username)->exists();
   return response()->json($checkuser_exists);

   }

   public function validateCredentials($username, $password){
   $checkuser_active = checkuser_active::where('email','=',$username)
   ->where('password','=',$password)->get();
   $valid_user=$checkuser_active->count();
      if (count($checkuser_active)>0){
         return true;
      }
   // $checkuser_exists = checkuser_active::where('email','=',$username)->exists();
   // dd($checkuser_exists);
   return false;

   }
   public function getKabupaten(Request $req)
    {
        $getKabupaten = DB::table('tb_mst_kabupaten')->select('id', 'name')->where(['id_mst_provinsi' => $req->provinsi])->get();
        if ($getKabupaten) {
            return response()->json([
                'pesan' => 'Suksess',
                'data' => $getKabupaten,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Error'
            ]);
        }
    }
}