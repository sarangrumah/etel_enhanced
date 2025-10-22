<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatankoordinator extends Model
{
    use HasFactory;
    protected $table = 'tb_evaluasi_catatan_koordinator';
    protected $guarded = [];
}
