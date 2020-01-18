<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizs';
    protected $fillable = [
        'title',
        'description',
        'clas_id',
        'lesson_id',
        'image',
        'durations',
        'teacher_id',
        'is_active',
        'busines_id',
        'file',
        'code',
        'is_clas'
    ];

    function quizQuestion()
    {
        return $this->hasMany("App\QuizQuestion", "quiz_id", 'id');
    }
    function lesson()
    {
        return $this->belongsTo("App\Lesson", "lesson_id", "id");
    }
    function quizParticipant()
    {
        return $this->hasMany("App\QuizParticipant", "quiz_id", 'id');
    }
    function quizParticipantAnswer()
    {
        return $this->hasOne("App\QuizParticipantAnswer", "quiz_id", 'id');
    }
    function clas()
    {
        return $this->belongsTo("App\Clas", "clas_id", 'id');
    }

    function teacher()
    {
        return $this->belongsTo("App\Personal", 'teacher_id', "id");
    }
    function teacherAll()
    {
        return $this->belongsTo("App\Personal", 'teacher_id', "id");
    }

    function busines()
    {
        return $this->belongsTo("App\Business", 'busines_id', "id");
    }

    function quizClas()
    {
        return $this->hasMany("App\QuizClasses", 'quiz_id', 'id');
    }
}
