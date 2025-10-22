<?php

namespace App\Http\Controllers\Admin;

use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;


use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Penanggungjawab;


class InstansiPemerintah
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // API ALAMAT

    public function getKabupaten(Request $req)
    {
        // dd($req);
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
    public function getKecamatan(Request $req)
    {
        $getKecamatan = DB::table('tb_mst_kecamatan')->select('id', 'name')->where(['id_mst_kabupaten' => $req->kabupaten])->get();
        if ($getKecamatan) {
            return response()->json([
                'pesan' => 'Suksess',
                'data' => $getKecamatan,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Error'
            ]);
        }
    }
    public function getKelurahan(Request $req)
    {
        $getKelurahan = DB::table('tb_mst_kelurahan')->select('id', 'name')->where(['id_mst_kecamatan' => $req->kecamatan])->get();
        if ($getKelurahan) {
            return response()->json([
                'pesan' => 'Suksess',
                'data' => $getKelurahan,
            ]);
        } else {
            return response()->json([
                'pesan' => 'Error'
            ]);
        }
    }
}