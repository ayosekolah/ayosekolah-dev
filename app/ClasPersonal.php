<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasPersonal extends Model
{
    protected $table = "class_personals";

    protected $fillable = ['is_aprroved', 'personal_busines_id', 'clas_id'];
    /**
     * clas
     *
     * @return void
     */
    function clas()
    {
        return  $this->belongsTo("App\Clas", "clas_id", "id");
    }
    /**
     * personal
     *
     * @return void
     */
    function personal()
    {
        return $this->belongsTo("App\Personal");
    }
    function teacher()
    {
        return $this->belongsTo("App\Personal", 'personal_id', 'id')->where('type', 'teacher');
    }
    function student()
    {
        return $this->belongsTo("App\Personal", 'personal_id', 'id')->where('type', 'student');
    }
    function personalBusines()
    {
        return $this->belongsTo("App\PersonalBusiness", 'personal_busines_id', 'id');
    }
}
