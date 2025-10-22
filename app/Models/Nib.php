<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nib extends Model
{
    protected $table = 'tb_oss_nib';
    protected $primaryKey = 'id';
    protected $guarded = [];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
