<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['name', 'color', 'is_business'];

    function lessonBusines()
    {
        return $this->hasMany("App\LessonBusines");
    }

    function personalHas()
    {
        return $this->belongsToMany('App\Personal');
    }
}
