<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reqBimtek extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_req_bimtek';
    protected $guarded = [];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
