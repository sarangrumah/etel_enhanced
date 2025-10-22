<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izinoss extends Model
{
    use HasFactory;
    protected $table = 'tb_oss_trx_izin';
    protected $fillable = [
        'oss_id','id_izin','jenis_izin','kd_izin','kd_daerah','status_checklist','id_proyek','id_produk','submitted_at'
    ];
}