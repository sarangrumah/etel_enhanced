<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tb_mst_question';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_name',
        'question_desc',
        'weight',
        'unsur',
        'category',
        'id_tb_mst_question_type',
        'question_text_1',
        'question_text_2',
        'question_text_3',
        'question_text_4',
        'expected_result',
        'min_result',
        'max_result',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function categoryName()
    {
        return $this->hasOne(QuestionType::class, 'id', 'id_tb_mst_question_type');
    }

    public function unsurType()
    {
        return $this->hasOne(Unsur::class, 'id', 'unsur');
    }
}
