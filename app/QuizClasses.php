<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizClasses extends Model
{
    protected $table = 'quizclasses';

    protected $fillable = [
        'quiz_id',
        'clas_id'
    ];
}
