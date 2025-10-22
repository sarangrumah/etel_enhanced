<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeIzin extends Model
{
    use HasFactory;
    protected $table = 'tb_oss_mst_kodestatusizin';
    protected $guarded = ['id'];
}
