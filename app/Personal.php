<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Personal extends Authenticatable
{
    protected $guard = 'personal';

    protected $fillable = [
        "image",
        "name",
        "description",
        "username",
        "email",
        "password",
        "address",
        "phone",
        "fax",
        "social",
        "is_valid",
        "email_verified_at",
        "type",
        "busines_id",
        "remember_token",
        'birth_of_date'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
    public function clasPersonal()
    {
        return $this->hasMany("App\ClasPersonal", 'personal_id', 'id');
    }
    public function clasLesson()
    {
        return $this->hasMany("App\LessonPersonal", 'personal_id', 'id');
    }

    function personalBusines()
    {
        return $this->hasMany("App\PersonalBusiness", 'personal_id', "id");
    }
    function businesPersonal()
    {
        return $this->hasMany("App\PersonalBusiness", 'busines_id', "id");
    }
}
