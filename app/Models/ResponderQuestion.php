<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponderQuestion extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb_mst_rq';
    
    protected $primaryKey = 'id_trx';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tb_map_sq',
        'id_tb_oss_trx_izin',
        'id_tb_mst_responder',
        'survey_answer',
        'survey_result',
        'is_saved',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
