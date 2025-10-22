<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelKodeAkses extends Model
{
    use HasFactory;

    protected $table = 'tb_trx_kode_akses_alokasi';

    public function JenisKodeAkses(){
        return $this->belongsTo(TabelMasterJenisKodeAkses::class, 'id_mst_jenis_kode_akses', 'id');
    }
}