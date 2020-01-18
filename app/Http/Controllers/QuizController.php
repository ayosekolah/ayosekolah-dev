<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function indexQuiz()
    {
        $quiz = Quiz::with(['quizQuestion', 'clas'])
            ->OrderBy('id', 'DESC')
            ->where('clas_id', NULL)
            ->where('teacher_id', Auth::guard('personal')->user()->id)
            ->paginate(10);

        return view('home.quiz.index_report', \compact('quiz'));
    }

    public function reportData($id)
    {
        $parti = QuizParticipant::with(['quiz', 'student'])
            ->where('true', '!=', NULL)
            ->where('quiz_id', $id)->get();
        return datatables()->of($parti)
            ->editColumn('created_at', function ($parti) {
                return date("D, d/m/Y", strtotime($parti->created_at));
            })
            ->addColumn('avatar', function ($parti) {
                return '<div class="avatar avatar-sm"><img src="' . getImg($parti->student->image) . '" class="rounded-circle" alt=""></div>';
            })
            ->addColumn('score', function ($parti) {
                $sc = ($parti->true / ($parti->true + $parti->false)) * 100;
                if ($sc > 75) {
                    return "<span class='badge badge-success tx-18 p-1'>" . $sc . "</span>";
                } else {
                    return "<span class='badge badge-warning  tx-18 p-1'>" . $sc . "</span>";
                }
            })
            ->rawColumns(['avatar', 'score'])
            ->make(true);
    }
    public function report($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            \abort(404);
        }
        return view('home.quiz.report', \compact('id', 'quiz'));
    }
}
