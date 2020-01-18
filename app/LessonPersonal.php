<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonPersonal extends Model
{
    protected $table = 'lesson_personals';
    protected $fillable =  ['lesson_id', 'personal_id'];

    function lesson()
    {
        return $this->belongsTo("App\Lesson");
    }
    function personalBusines()
    {
        return $this->belongsTo("App\PersonalBusiness", 'personal_busines_id', 'id');
    }
}
