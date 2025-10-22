<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    
    protected $table = 'tb_mst_user_bo';
    
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'nama', 'email', 'password', 'username', 'id_mst_jobposition', 'is_active'
    ];
}
