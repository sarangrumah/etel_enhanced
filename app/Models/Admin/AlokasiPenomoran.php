<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiPenomoran extends Model
{
    use HasFactory;
    protected $table = 'vw_alokasi_penomoran_rev';
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

}