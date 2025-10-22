<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb_mst_survey';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_name',
        'survey_desc',
        'jenis_perizinan',
        'category',
        'period_start',
        'period_end',
        'expected_result',
        'is_related_izin',
        'is_survey_initiator',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
