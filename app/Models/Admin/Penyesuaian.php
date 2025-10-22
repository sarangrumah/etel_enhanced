<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyesuaian extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_penyesuaian_komitmen';
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';
}
