<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizParticipant extends Model
{
    protected $table = 'quiz_participants';

    protected $fillable = [
        'student_id',
        'quiz_id',
        'start_date_time',
        'end_date_time',
        'true',
        'false'
    ];

    function quizParticipantAnswer()
    {
        return $this->hasMany("App\QuizParticipantAnswer", 'quiz_participant_id', 'id');
    }


    function quiz()
    {
        return $this->belongsTo("App\Quiz", "quiz_id", "id");
    }

    function student()
    {
        return $this->belongsTo("App\Personal", "student_id", "id");
    }
}
