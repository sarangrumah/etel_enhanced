<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHoliday extends Model
{
    use HasFactory;

    protected $table = 'tb_mst_offday';


    protected $fillable = [
    'off_day',
    'kategori',
    'desc',
    'is_active',
    'created_by',
    'updated_by',
    
];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

}
