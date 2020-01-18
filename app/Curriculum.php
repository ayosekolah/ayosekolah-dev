<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'file',
        'size',
        'ekstensi',
        'mime',
        'busines_id',
        'clas_id', 'teacher_id',
        'lesson_id'
    ];

    public function lesson()
    {
        return $this->belongsTo("App\Lesson", "lesson_id", "id");
    }
    public function teacher()
    {
        return $this->belongsTo("App\Personal", "teacher_id", "id");
    }
    public function busines()
    {
        return $this->belongsTo("App\Business", "busines_id", "id");
    }
}
