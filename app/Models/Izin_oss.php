<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPenomoran;
class Izin_oss extends Model
{
    protected $table = 'tb_oss_trx_izin';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function penomoran()
    {
        return $this->hasMany(JenisPenomoran::class, 'kode_izin', 'kd_izin');
    }
}
