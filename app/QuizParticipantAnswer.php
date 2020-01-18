<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizParticipantAnswer extends Model
{
    protected $table = 'quiz_participant_answers';
    protected $fillable = [
        'quiz_id',
        'quiz_question_id',
        'quiz_participant_id',
        'quiz_question_answer_id',
        'is_true'
    ];

    function quiz()
    {
        return $this->belongsTo("App\Quiz", 'quiz_id', 'id');
    }
    function quizParticipant()
    {
        return $this->belongsTo("App\QuizParticipant", 'quiz_participant_id', 'id');
    }

    function question()
    {
        return $this->belongsTo("App\QuizQuestion", 'quiz_question_id', 'id');
    }

    function quizQuestionAnswerEi()
    {
        return $this->belongsTo("App\QuizQuestionAnswer", 'quiz_question_answer_id', 'id');
    }
}
