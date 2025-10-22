<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responder extends Model
{
    public $timestamps = false;

    use HasFactory;
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb_mst_responder';
    protected $primaryKey = 'id_responder';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tb_mst_gender',
        'id_izin',
        'id_tb_mst_user_survey',
        'id_tb_mst_education',
        'id_tb_mst_occupation',
        'id_tb_oss_nib',
        'id_tb_mst_izinlayanan',
        'responder_name',
        'responder_age',
        'responder_jabatan',
        'occupation_other',
        'file_uploaded',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
