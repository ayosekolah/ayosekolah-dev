<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $table = 'quiz_questions';

    protected $fillable = [
        'question',
        'file',
        'image',
        'rumus',
        'quiz_id'
    ];

    function quiz()
    {
        return $this->belongsTo("App\Quiz");
    }
    function quizQuestionAnswer()
    {
        return $this->hasMany("App\QuizQuestionAnswer", 'quiz_question_id', 'id');
    }
    function quizQuestionAnswerEi()
    {
        return $this->hasMany("App\QuizQuestionAnswer", 'quiz_question_id', 'id');
    }
}
