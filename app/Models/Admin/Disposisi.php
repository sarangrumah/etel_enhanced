<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'tb_trx_disposisi_evaluator';

    protected $fillable = [
        'id_izin', 'id_disposisi_user', 'catatan', 'created_by', 'updated_by','created_at','status_checklist_awal','is_active'
    ];
}
