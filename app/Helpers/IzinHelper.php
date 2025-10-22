<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Admin\Izin;
use App\Models\Admin\Penomoran;

class IzinHelper
{
    public static function countIzin($status,$id_master_izin){
        $izin = Izin::where('status_checklist','=',$status)->where('jenis_perizinan','<>','K03')->where('id_master_izin_parent','=',$id_master_izin)->get()->count();
        return $izin;
    }

    public static function countPenomoran($status = 20){
        $penomoran = Penomoran::where('status_permohonan',$status)->with('KodeIzin')->with('KodeAkses')->get()->count();
        return $penomoran;
    }
}