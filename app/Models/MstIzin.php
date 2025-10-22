<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstIzin extends Model
{
    protected $table = 'tb_mst_izin';

    function kbli()
    {
        return $this->hasMany(MstKBLI::class, 'id_mst_izin', 'id');
    }
}
