<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libraries\Esign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EsignTestController extends Controller
{

    public function index()
    {
        $Esign = new Esign;
        $signed = $Esign->signPDF();

        $path       = public_path("asd");
        dd($signed);
        $contents   = base64_decode($signed['data']);

        //store file temporarily
        file_put_contents($path, $contents);

        //download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);
      
    }

    public function test(Request $request){
        // $path = Storage::putFile(
        //     'public/imagesasdasd',
        //     $request->file('imageSign'),
        // );
        return $request->all();
    }
}
