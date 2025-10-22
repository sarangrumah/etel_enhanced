<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulolog extends Model
{
    use HasFactory;
    protected $table = 'tb_trx_ulo_log';
    // public $timestamps = false;
    const CREATED_AT = 'created_date';
	const UPDATED_AT = 'updated_date';
	protected $guarded = ['id'];

    public function KodeIzin()
    {
        return $this->belongsTo(KodeIzin::class, 'status_ulo', 'oss_kode');
    }
}
