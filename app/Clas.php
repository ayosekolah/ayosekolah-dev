<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    /**
     * $table
     *
     * @var string
     */
    protected $table = 'class';

    protected $fillable = [
        'name',
        'busines_id',
        'is_business',
    ];

    function quiz()
    {
        return $this->hasMany("App\Quiz", "clas_id", "id");
    }
    function personalClas()
    {
        return $this->hasMany("App\ClasPersonal", 'clas_id', 'id');
    }
}
