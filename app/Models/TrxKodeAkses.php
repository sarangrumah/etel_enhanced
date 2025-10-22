<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class TrxKodeAkses extends Model
{
    protected $table = 'tb_trx_kode_akses';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
