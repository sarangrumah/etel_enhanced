<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class LogKodeAkses extends Model
{
    protected $table = 'tb_trx_kode_akses_log';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
