<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Izin_oss;
class Proyek extends Model
{
    protected $table = 'tb_oss_trx_proyek';
    protected $primaryKey = 'id';
    protected $guarded = [];
    //transaction bakalan dibatalin kalo ada error pas proses inserting ke db
    public $afterCommit = true; 

    public function perizinan()
    {
        return $this->hasMany(Izin_oss::class, 'id_proyek', 'id_proyek');
    }
}
