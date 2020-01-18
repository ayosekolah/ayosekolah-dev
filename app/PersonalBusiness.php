<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalBusiness extends Model
{
    protected $table = 'personal_business';

    protected $fillable = ['personal_id', 'busines_id', 'type', 'is_approve'];

    function busines()
    {
        return $this->belongsTo("App\Business", 'busines_id', 'id');
    }
    function clasPersonal()
    {
        return $this->hasMany("App\ClasPersonal", 'personal_busines_id', 'id');
    }
    function lessonPersonal()
    {
        return $this->hasMany("App\LessonPersonal", 'personal_busines_id', 'id');
    }

    public function lessonHas()
    {
        return $this->belongsToMany(
            'App\Lesson',
            'lesson_personals',
            'personal_busines_id',
            'lesson_id'
        );
    }
    public function clasHas()
    {
        return $this->belongsToMany(
            'App\Clas',
            'class_personals',
            'personal_busines_id',
            'clas_id'
        );
    }
    public function personal()
    {
        return $this->belongsTo("App\Personal", 'personal_id', 'id');
    }
}
