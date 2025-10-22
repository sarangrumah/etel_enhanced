<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb_mst_question_type';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quest_type_name',
        'quest_type_desc',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
