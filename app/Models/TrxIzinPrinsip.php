<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxIzinPrinsip extends Model
{
    use HasFactory;

    protected $table = 'tb_trx_izin_prinsip';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
