<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class OSSInternalAction
{
    public function checkNIB($oss_id)
    {
        return $oss_id;
    }

    public function saveNIB($nib, $oss_id = null)
    {
        return $oss_id;
    }

    public function updateNIB($nib, $oss_id = null)
    {
        return $oss_id;
    }

    public function insertIzin($izin, $id_izin = null)
    {
        return $id_izin;
    }

    public function updateIzin($izin, $id_izin = null)
    {
        return $id_izin;
    }

    public function mapingIzin($icomingIzin){
        return $icomingIzin;
    }
}
