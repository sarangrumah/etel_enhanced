<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
class SK_Penomoran extends Model
{
    protected $table = 'tb_trx_sk_penomoran';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}