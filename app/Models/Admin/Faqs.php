<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    use HasFactory;
    
    protected $table = 'tb_mst_faq';
    
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'type', 'category', 'password', 'question', 'answer', 'download_link', 'is_active', 'created_date', 'created_by','updated_by','updated_date'
    ];
}
