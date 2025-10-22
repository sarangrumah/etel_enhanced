<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionMap extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb_map_question';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tb_mst_survey',
        'id_tb_mst_question',
        'order',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
