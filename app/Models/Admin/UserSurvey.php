<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSurvey extends Model
{
    use HasFactory;
    
    protected $table = 'tb_mst_user_survey';
    
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'id_izin', 'code', 'jenis_perizinan', 'is_active', 'created_by', 'updated_by'
    ];
}
