<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstKBLI extends Model
{
    protected $table = 'tb_mst_kbli';
    
    function izin()
    {
        return $this->hasMany(MstIzinLayanan::class, 'id_mst_kbli', 'id');
    }
}

