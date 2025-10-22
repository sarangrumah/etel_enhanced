<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;

class HakLabuhController extends Controller
{
   public $kode;
   public $message;
   public $data;

   public function index(Request $request){
      $authorization = $request->header('Authorization');
      if ($authorization == "Bearer 1xres23dfeff4oytr9aq01fmvu4dmk52njk5d7s7s7eqt") {
         $params = $request->all();
   
         if (isset($params['no_izin'])) {
            $data = DB::table('vw_list_izin')->select('no_izin', 'tgl_izin', 'nama_perseroan', 'jenis_layanan')
            ->where('no_izin', $params['no_izin'])
            ->first();
   
            if ($data) {
               $this->kode = 200;
               $this->message = 'Success';
               $this->data = $data;
            }else{
               $this->kode = '404';
               $this->message = 'Nomor izin not found';
            }
         }else{
            $this->kode = 400;
            $this->message = 'Bad Request';
            $this->data = 'no_izin required';
         }
      }else{
         $this->kode = 401;
         $this->message = 'Unauthorized';
      }

      $respon = [
         'code' => $this->kode,
         'message' => $this->message,
         'data' => $this->data
      ];

      return response()->json(array_filter($respon), $this->kode);
   }

   public function getToken(){
      $uri = "http://hls.postel.go.id/api/v1/auth/get_token";
      $params = [
         'username' => 'Telekomunikasi',
         'password' => 'dXcBXHSZgA5Zz7j3',
      ];
      $client = new Client();
      $response = $client->request('POST', $uri, [
         'form_params' => $params
      ]);
      $data = json_decode($response->getBody(), true);
      
      return $data['token'];
   }

   public function izinTerbit(Request $request){
      $req = $request->all();
      $token = $this->getToken();
      
      $uri = "http://hls.postel.go.id/api/v1/izin_terbit?nib=".$req['search'];
      $client = new Client();
      $response = $client->request('GET', $uri, [
         'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer ' . $token,
         ],
         'verify' => false,
      ]);
      $data = json_decode($response->getBody(), true);
      $return = $data;

      return response()->json($return, count($data['data'])>0?200:404);
   }
}
