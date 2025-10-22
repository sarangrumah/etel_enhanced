<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meetBimtek extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_req_bimtek_invited';
    protected $guarded = [];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
