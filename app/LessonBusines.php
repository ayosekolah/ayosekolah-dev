<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonBusines extends Model
{
    protected $table = 'lessonbusiness';

    protected $fillable = ['busines_id', 'lesson_id', 'color'];

    function lesson()
    {
        return $this->belongsTo("App\Lesson", "lesson_id", "id");
    }
}
