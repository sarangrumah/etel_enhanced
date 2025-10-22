<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterIP extends Model
{
    protected $table = 'tb_trx_regisip';
    protected $primaryKey = 'id';
    protected $guarded = [];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
