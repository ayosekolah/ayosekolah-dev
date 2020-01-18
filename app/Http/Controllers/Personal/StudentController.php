<?php

namespace App\Http\Controllers\Personal;

use App\ClasPersonal;
use App\Http\Controllers\Controller;
use App\Personal;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.personal');
    }
    public function quizClas()
    {
        $clas = ClasPersonal::whereHas('personalBusines', function ($p) {
            return $p->where('type', 'student')
                ->where('is_approve', 1)
                ->where('personal_id', Auth::guard("personal")->user()->id);
        })->with(['personalBusines' => function ($bp) {
            return $bp->with('personal');
        }])->first();

        if ($clas) {
            $quiz = Quiz::whereHas('quizClas', function ($p) use ($clas) {
                return $p->where('clas_id',  $clas->clas_id);
            })
                ->with('teacher', 'quizQuestion')
                ->where('is_active', 1)
                ->paginate(8);
        } else {
            $quiz = Quiz::where("clas_id", '')
                ->with('teacher', 'quizQuestion')
                ->where('is_active', 1)
                ->paginate(8);
        }


        return view('personal.student.quiz_by_class', \compact('quiz'));
    }
}
