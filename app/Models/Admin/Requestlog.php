<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requestlog extends Model
{
    use HasFactory;
    protected $table = 'tb_oss_trx_izin_log';

    public function KodeIzin()
    {
        return $this->belongsTo(KodeIzin::class, 'status_checklist', 'oss_kode');
    }
}
