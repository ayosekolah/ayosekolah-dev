<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestionAnswer extends Model
{
    protected $table = 'quiz_question_answers';

    protected $fillable = [
        'quiz_question_id',
        'answer',
        'file',
        'image',
        'rumus',
        'is_true',
    ];

    function question()
    {
        return $this->belongsTo("App\QuizQuestion", 'quiz_question_id', 'id');
    }
}
