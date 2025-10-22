<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisiulo extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_disposisi_evaluator_ulo';
    
	protected $guarded = ['id'];
}
