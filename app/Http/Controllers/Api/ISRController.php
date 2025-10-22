<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ISRController extends Controller
{
   public function getToken(){
      $uri = 'https://middleware.ditfrek.postel.go.id/middleware_sdppi/get_token';
      $params = [
         'query' => [
            'username' => 'telecomunication',
            'password' => 'tele324'
         ]
      ];
      $client = new Client(['verify' => false]);
      $response = $client->get( $uri, $params);
      $data = json_decode($response->getBody(), true);
      
      return $data['tokens'];
   }

   public function getISR(Request $request){
      $req = $request->all();

      $token = $this->getToken();
      
      $uri = "https://middleware.ditfrek.postel.go.id/middleware_sdppi/isr_telecomunication/index?search=" . $req['search'];
      $client = new Client();
      $response = $client->request('GET', $uri, [
         'headers' => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer '. $token,
         ],
         'verify' => false,
      ]);
      $data = json_decode($response->getBody(), true);
      $return = $data;

      return response()->json($return, count($data['data'])>0?200:404);
   }

   public function viewISR($id){
      try {
         $token = $this->getToken();
         
         $uri = "https://middleware.ditfrek.postel.go.id/middleware_sdppi/isr_telecomunication/download?application_number=" . $id;
         $client = new Client();
         $response = $client->request('GET', $uri, [
            'headers' => [
               'Content-Type' => 'application/x-www-form-urlencoded',
               'Authorization' => 'Bearer '. $token,
            ],
            'verify' => false,
            'stream' => true,
         ]);
   
         $data = $response->getStatusCode();
         
         if ($data == 200) {
            header('Content-type: application/pdf');
            echo $response->getBody()->getContents();
         }
      } catch (\Throwable $th) {
         abort(404);
      }

   }
}
