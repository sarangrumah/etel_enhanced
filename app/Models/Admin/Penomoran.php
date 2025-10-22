<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penomoran extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_kode_akses';
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    public function KodeIzin()
    {
        return $this->belongsTo(KodeIzin::class, 'status_permohonan', 'oss_kode');
    }

    public function KodeAkses(){
        return $this->belongsTo(TabelKodeAkses::class, 'id_mst_kode_akses', 'id');
    }

    public function JenisKodeAkses(){
        return $this->belongsTo(TabelMasterJenisKodeAkses::class, 'id_mst_jeniskodeakses', 'id');
    }
}
