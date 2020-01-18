<?php

namespace App\Http\Controllers;

use App\Clas;
use App\Lesson;
use App\Personal;
use App\Quiz;
use App\QuizParticipant;
use App\QuizParticipantAnswer;
use App\QuizQuestion;
use App\QuizQuestionAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * index
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $request->session()->forget('guest');
        $quiz = Quiz::OrderBy('id', 'DESC')
            ->with(['lesson', 'teacherAll'])
            ->where('is_clas', 0)
            ->where('is_active', 1)
            ->take(10)
            ->get();

        $populerQuiz =  Quiz::withCount('quizParticipant')
            ->orderBy('quiz_participant_count', 'desc')
            ->where('is_clas', 0)
            ->where('is_active', 1)
            ->take(10)
            ->get();

        $lessonGeneral = Lesson::where('is_business', 0)->get();

        return view('home.index', \compact('quiz', 'populerQuiz', 'lessonGeneral'));
    }

    /**
     * indexbyJoin
     *
     * @param Request $request
     * @return void
     */
    public function indexbyJoin(Request $request)
    {
        $request->session()->forget('guest');
        return view('home.index_by_pin');
    }

    /**
     * detailQuiz
     *
     * @param mixed $id
     * @param Request $request
     * @return void
     */
    public function detailQuiz($code, Request $request)
    {
        $request->session()->forget('guest');
        $quiz =  Quiz::with(['lesson'])
            ->where('code', $code)
            ->where('is_active', 1)
            ->first();
        if (!$quiz) {
            return redirect()->back()->with('error', 'Code not valid');
        }
        return view('home.detail_quiz', \compact('quiz'));
    }

    /**
     * playQuizGeneral
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function playQuizGeneral(Request $request, $id)
    {

        if ($request->get('play') != 1) {
            if (Auth::guard('personal')->check() || Auth::guard('busines')->check()) {
                $data['student_id'] =  isset(Auth::guard('busines')->user()->id) ?: Auth::guard('personal')->user()->id;
            } else {
                if ($request->session()->exists('guest')) {

                    $data['student_id'] = $request->session()->get('guest');
                } else {
                    $data['student_id'] =  $this->registerGuest($request);
                    $data['student_id'] = $request->session()->get('guest');
                }
            }
            $data['start_date_time'] = Carbon::now();
            $data['quiz_id'] = $id;
            $quiz = Quiz::find($id);

            if (!$quiz) {
                abort(404);
            }
            $last = QuizParticipant::create($data);
            return redirect('/play_quiz/' . $id . '/?participant_id=' . $last->id . '&play=1');
        }

        $quiz = Quiz::where('id', $id)->where('is_active', 1)->first();
        if (!$quiz) {
            abort(404);
        }
        $questions = QuizQuestion::where('quiz_id', $id)
            ->with(['quizQuestionAnswer', 'quiz'])
            ->get();

        return view('home.play_quiz_general', \compact('questions', 'quiz'));
    }

    /**
     * registerGuest
     *
     * @param mixed $request
     * @return void
     */
    public function registerGuest($request)
    {
        $data['image']    = 'v1/images/defaults/placeholder.jpg';
        $data['username'] = $request->get('username');
        $data['name'] = $request->get('username') . "-" . Carbon::now()->format('Y-m');
        $data['email']    = $request->get('username') . '@' . Carbon::now()->format('ymdihs') . '.guest';
        $data['password'] =  bcrypt("guest");
        $data['type']     = 'default';

        $create =  Personal::create($data);
        $request->session()->put('guest', $create->id);
    }

    /**
     * savequizClasGeneral
     *
     * @param Request $request
     * @return void
     */
    public function savequizClasGeneral(Request $request)
    {
        $this->validate($request, [
            'quiz_id' => 'required'
        ]);

        $true = 0;
        $false = 0;

        foreach ($request->question as $question_index => $ques) {
            foreach ($request->answer[$question_index] as  $index_a => $s) {
                $ceking = QuizQuestionAnswer::where('quiz_question_id', $ques)->where('id', $s)->first();
                if ($ceking->is_true == 1) {
                    $data['is_true'] = 1;
                    $true = $true + 1;
                } else {
                    $data['is_true'] = 0;
                    $false = $false + 1;
                }
                $data['quiz_question_id'] = $ques;
                $data['quiz_id'] = $request->get('quiz_id');
                $data['quiz_participant_id'] = $request->get('participant_id');
                $data['quiz_question_answer_id'] = $s;

                QuizParticipantAnswer::create($data);
            }
        }

        $qp = QuizParticipant::find($request->get('participant_id'));

        $qp->end_date_time = Carbon::now();
        $qp->true  = $true;
        $qp->false  = $false;

        $qp->update();

        return redirect('quiz/general/questionanswer/previewscore/' . $request->get('participant_id'));
    }

    /**
     * PreviewScoreGeneral
     *
     * @param mixed $pid
     * @return void
     */
    public function PreviewScoreGeneral($pid)
    {
        $cekScore = QuizParticipant::with(['quiz' => function ($x) {
            return $x->with(['teacherAll']);
        }])->where('id', $pid)->first();

        $istrue = QuizParticipantAnswer::where('quiz_participant_id', $pid)
            ->with(['quizQuestionAnswerEi', 'question' => function ($q) {
                return $q->with(['quizQuestionAnswerEi' => function ($x) {
                    return $x->where('is_true', 1);
                }]);
            }])
            ->get();
        return view(
            'home.preview_score',
            \compact('cekScore', 'istrue')
        );
    }

    public function detailLesson($id)
    {
        $listClas = Quiz::select('clas_id', \DB::raw('COUNT(clas_id) as amount'))
            ->where('lesson_id', $id)
            ->with('clas')
            ->groupBy('clas_id')
            ->take(15)
            ->get();

        $lesson = Lesson::where('id', $id)->pluck('name')->first();

        return view('home.listquizbylesson', \compact('listClas', 'lesson'));
    }
}
