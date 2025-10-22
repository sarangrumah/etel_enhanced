<?php

namespace App\Libraries;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Esign
{
    private $url;
    private $token;


    function __construct()
    {
        $this->url = env('ESIGN_URL');
        $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTAzLjEzNS4yMTQuMTYzOjgwODAvbG9naW4iLCJpYXQiOjE2NzcxMjE1NTksImV4cCI6MTY3OTc1MTM1OSwibmJmIjoxNjc3MTIxNTU5LCJqdGkiOiJxMkltZDI4RFNMR1ZBdG1tIiwic3ViIjozLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.-_w97sSF_fj8FHgLyNsG012eozoZZSKpkZcGeDN_pMA';
        $login = $this->login();
        if($login['status']==200){
            $this->token = $login['data']['token'];
        }
    }


    public function login()
    {
        $response = Http::post($this->url . '/login', [
            'username' => 'ppiapp2',
            'password' => 'd62c1c696625',
        ]);

        if ($response->status() != 200) {
            return false;
        } else {
            return $response->json();
        }
    }

    public function listCert($token = '')
    {
        if ($token == '') {
            $token = $this->token;
        }
        
        $response = Http::withToken($token)->post($this->url . '/listCert', [
            "username" => "197206131999032006"
        ]);
        $body = $response->json()["data"];
        $lastData = Arr::last($body);
        if ($response->status() != 200) {
            return false;
        } else {
            return $lastData;
        }
    }

    public function getToken()
    {
        $response = Http::withToken($this->token)->post($this->url . '/getToken', [
            "username" => "197206131999032006"
        ]);

        $msg = $response->json()["message"];
        $idkey = explode(",", $msg)[0];

        if ($response->status() != 200) {
            return false;
        } else {
            return $idkey;
        }
    }

    public function signPDF()
    {
            $token = $this->token;
        $data = [
            'idkeystore' => "12027",
            'username' => '197206131999032006',
            'passphrase' => 'ajuDigitalsign1234',
            'urx' => '519',
            'ury' => '128',
            'llx' => '387',
            'lly' => '232',
            'page' => '1',
            'reason' => 'Penerbitan ULO',
            'location' => 'Jakarta',
            'token' => $this->getToken()
        ];
        $response = Http::withToken($token)->attach(
            'imageSign',
            fopen(url(Storage::url('public/ttd.png')), 'r'),
            'ttd.png'
        )->attach(
            'pdf',
            fopen(url(Storage::url('public/sample.pdf')), 'r'),
            'fileasd.pdf'
        )->post($this->url . '/signPDF', $data);
        return $response;
        if ($response->status() != 200) {
            return $response->json();
        } else {
            return json_decode($response->body());
        }
    }

  

}
