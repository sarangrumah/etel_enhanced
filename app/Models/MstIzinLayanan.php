<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstIzinLayanan extends Model
{
    protected $table = 'tb_mst_izinlayanan';


    // function syarat(){
    //     return $this->hasMany(syarat::class); 
    // }

    function izinoss(){
        return $this->belongsTo(Izin_oss::class);
    }
}

