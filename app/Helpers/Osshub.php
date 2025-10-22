<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use App\Models\ApiLog;

class Osshub
{
    private function getToken($izin = 'jartel')
    {
        $username = "telsus";
        $password = "6863ed11edb115df58d7c9d1ebb2f190cc4166f4";
        if ($izin == 'jartel') {
            $username = "izinjartel";
            $password = "05b596176235051215e1e5de9bb9e4eb4e899785";
        } else if ($izin == 'jastel') {
            $username = "izinjasatel";
            $password = "91137c41a40c630238b5c1ed8491ee98ba5399e8";
        } else if ($izin == 'telsus') {
            $username = "telsus";
            $password = "6863ed11edb115df58d7c9d1ebb2f190cc4166f4";
        }

        $response = Http::withOptions(["verify"=>false])->post(env('OSSHUB_URL').'/api/v1/auth/login', [
            'username' => $username,
            'password' => $password,
        ]);
        $token = $response->body();
        $token = json_decode($token);
        return $token->access_token;
    }

    public function inqueryNIB($nib)
    {
        $token = $this->getToken();
        $token = 'Bearer '.$token;
        $url = env('OSSHUB_URL').'/api/v1/nib/'.$nib.'/1';
        // $url = 'https://oss.kominfo.go.id/api/v1/nib/'.$nib.'/1';
        $response = Http::withOptions(["verify"=>false])->withHeaders([
            'authorization' => $token
        ])->get($url);
        $message = $response->body();
        return json_decode($message);
    }

    public function fetchValet($id_ref)
    {
        $token = $this->getToken();
        $token = 'Bearer '.$token;
        $url = env('OSSHUB_URL').'/api/v1/valet/'. $id_ref;
        $response = Http::withOptions(["verify"=>false])->withHeaders([
            'authorization' => $token
        ])->get($url);
        $message = $response->body();
        return json_decode($message);
    }


    public function updatenib($nib){
        $nib = $this->inqueryNIB($nib);
        return $nib;
        // proses update here
    }

    public function updateIzin($data)
    {
        $token = $this->getToken();
        $token = 'Bearer ' . $token;
        $url = env('OSSHUB_URL') . '/api/v1/license-status';
        $response = Http::withOptions(["verify" => false])->withHeaders([
            'authorization' => $token,
        ])->withBody(json_encode(['IZINSTATUS' => $data]), 'application/json')->put($url);
        $message = $response->body();

        //LOGGING
        $log = ApiLog::create([
            'state' => 'send',
            'service' => '/license-status',
            'param' => json_encode(['IZINSTATUS' => $data]),
            'respon' => json_encode($message)
        ]);

        return json_decode($message);
    }

    public function sendIzinFinal($data)
    {
        $token = $this->getToken();
        $token = 'Bearer ' . $token;
        $url = env('OSSHUB_URL') . '/api/v1/license-final';
        $response = Http::withOptions(["verify" => false])->withHeaders([
            'authorization' => $token,
        ])->withBody(json_encode(['IZINFINAL' => $data]), 'application/json')->post($url);
        $message = $response->body();

        //LOGGING
        $log = ApiLog::create([
            'state' => 'send',
            'service' => '/license-final',
            'param' => json_encode(['IZINFINAL' => $data]),
            'respon' => json_encode($message)
        ]);

        return json_decode($message);
    }


    public function check_nib_exists($nib){ 

    }   

    public function check_oss_id_exists($oss_id){
        
    }

    public function check_proyek_exists($id_proyek){

    }


    // Set Remote Credential
    public function connect_to_osshub(){
        $token = $this->getToken();
        $token = 'Bearer '.$token;
        $url = env('OSSHUB_URL').'/api/v1/yanlik/remote-credential';
        $body['credential'] = array(
            "remote_url" => route('receive-nib'),
            "remote_passkey" => env('OSSHUB_PASSKEY'), 
            "commitment_check_url" => url('/'), 
            "sso_url" => route('sso_url'),
            "remote_fileds" => route('receive-fileds')
        );
        // echo json_encode($body);
        // die();
        $response = Http::withOptions(["verify"=>false])->withHeaders([
            'authorization' => $token,
        ])->withBody(json_encode($body), 'application/json')->post($url);
        $message = $response->body();
        
        return json_decode($message);
    }
}
