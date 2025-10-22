<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penomoranlog extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_kode_akses_log';

    public function KodeIzin()
    {
        return $this->belongsTo(KodeIzin::class, 'status_permohonan', 'oss_kode');
    }
}
