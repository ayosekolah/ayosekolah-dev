<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Business extends Authenticatable
{
    protected $table = "business";
    protected $guard = 'busines';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'remember_token'
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

    function clas()
    {
        return $this->hasMany("App\Clas", "busines_id", "id");
    }

    public function personalBusines()
    {
        return $this->hasMany('App\PersonalBusiness', 'busines_id', 'id');
    }
}
