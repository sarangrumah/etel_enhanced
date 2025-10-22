<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxUlo extends Model
{
    use HasFactory;

    protected $table = 'tb_trx_ulo';
    protected $guarded = [];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
