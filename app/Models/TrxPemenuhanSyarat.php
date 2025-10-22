<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrxPemenuhanSyarat extends Model
{
    protected $table = 'tb_trx_pemenuhan_syarat';
    protected $fillable = ['trx_izin_id', 'uraian', 'jenis_isian', 'isian_pemohon'];
    // function kbli()
    // {
    //     return $this->hasMany(MstKBLI::class, 'id_mst_izin', 'id');
    // }
}
