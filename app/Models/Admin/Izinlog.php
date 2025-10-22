<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izinlog extends Model
{
    use HasFactory;
    protected $table = 'tb_oss_trx_izin_log';
    protected $guarded = ['id'];
}
