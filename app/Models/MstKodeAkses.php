<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MstKodeAkses extends Model
{
    protected $table = 'tb_mst_kode_akses';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
