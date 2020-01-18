<?php

namespace App\Http\Controllers\Personal;

use App\Business;
use App\Clas;
use App\ClasPersonal;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\LessonPersonal;
use App\PersonalBusiness;
use App\Quiz;
use App\QuizClasses;
use App\QuizParticipant;
use App\QuizParticipantAnswer;
use App\QuizQuestionAnswer;
use App\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.personal');
    }

    /**
     * createQuizClas
     *
     * @return void
     */
    public function createQuizClas()
    {

        $busines = Business::with(['personalBusines'])->whereHas('personalBusines', function ($s) {
            return $s->where('personal_id', Auth::guard("personal")->user()->id)->where('type', 'teacher')
                ->where('is_approve', 1);
        })->get();

        return view('personal.teacher.createquiz', \compact('busines'));
    }

    public function showClasLesson($bId)
    {
        $clas = ClasPersonal::with(['clas', 'personalBusines'])
            ->whereHas('personalBusines', function ($pb)  use ($bId) {
                return $pb->where('type', 'teacher')
                    ->where(
                        'personal_id',
                        Auth::guard("personal")->user()->id
                    )
                    ->where('busines_id', $bId);
            })->get();

        $lesson = LessonPersonal::with(['lesson', 'personalBusines'])
            ->whereHas('personalBusines', function ($pb)  use ($bId) {
                return $pb->where('type', 'teacher')->where(
                    'personal_id',
                    Auth::guard("personal")->user()->id
                )->where('busines_id', $bId);
            })->get();

        return \response()->json(['clas' => $clas, 'lesson' => $lesson]);
    }


    /**
     * storeQuizClas
     *
     * @param Request $request
     * @return void
     */
    public function storeQuizClas(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'description' => 'required',
            'busines_id'  => 'required',
            'clas_id'     => 'required',
            'lesson_id'   => 'required',
            'image'       => 'required|image|mimes:jpeg,png,gif,jpg|max:5000',
        ]);
        $path = Storage::disk('local')->putFile(
            'public/v1/images/quiz',
            $request->file('image')
        );

        $data  = $request->except('_token', 'image');
        $data['image'] = $path;
        $data['teacher_id'] = Auth::guard('personal')->user()->id;

        $lesson = Lesson::find($request->lesson_id);
        $lessonName = 'c' . $lesson->name;
        $data['code'] = str_replace(' ', '', $lessonName . date('YmDHis'));
        $data['is_clas'] = 1;
        $data['clas_id'] = null;
        $dataQuiz = Quiz::create($data);

        foreach ($request->clas_id as $c) {
            QuizClasses::create([
                'quiz_id'   => $dataQuiz->id,
                'clas_id'   => $c
            ]);
        }
        return redirect('personal/teacher/quiz/class/edit/' . $dataQuiz->id);
    }

    /**
     * editQuizClas
     *
     * @param mixed $id
     * @return void
     */
    public function editQuizClas($id)
    {
        $quiz = Quiz::find($id);
        $questionsanswer = QuizQuestion::with(['quizQuestionAnswer' => function ($a) {
            return $a->where("answer", '!=', NULL)->orWhere('image', '!=', null);
        }])
            ->where('quiz_id', $id)
            ->paginate(6);

        $quizClass = QuizClasses::where('quiz_id', $id)->get();

        $clas = Clas::where('busines_id', $quiz->busines_id)->whereHas('personalClas', function ($s) {
            return $s->whereHas('personalBusines', function ($x) {
                return $x->where('personal_id', Auth::guard('personal')->user()->id);
            });
        })->get();

        return view('personal.teacher.editquiz', \compact(
            'quiz',
            'questionsanswer',
            'quizClass',
            'clas'
        ));
    }

    /**
     * saveQuestionAnswer
     *
     * @param Request $request
     * @param mixed $quiz_id
     * @return void
     */
    public function saveQuestionAnswer(Request $request, $quiz_id)
    {

        $ans = $request->answer;

        if (!$ans) {
            return redirect()->back();
        }

        $questions = $request->only(
            'question',
            'file',
            'rumus',
            'image'

        );
        if ($request->has('question_image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz_question',
                $request->file('question_image')
            );
            $questions['image'] = $path;
        }



        $questions['quiz_id'] = $quiz_id;

        $questions = QuizQuestion::create($questions);

        for ($i = 1; $i <= count($ans); $i++) {

            $questions->quizQuestionAnswer()->create([
                'answer' => $request->answer[$i],
                'is_true' => $i == $request->is_true ? 1 : 0,
                'image' => (isset($request->image_answer[$i]) == NULL) || (!is_null($request->answer[$i]) && $request->answer[$i] != "") ? NULL : uploadImage($request->image_answer[$i])
            ]);
        }

        return redirect()->back();
    }

    /**
     * deleteQuestionAnswer
     *
     * @param mixed $id
     * @return void
     */
    public function deleteQuestionAnswer($id)
    {
        $cek = QuizParticipantAnswer::where('quiz_question_id', $id)->count();

        if ($cek > 0) {
            return redirect()->back()->with('error', 'Can\'t Delete Question in Quiz Selected.');
        } else {

            $quizanswer = QuizQuestionAnswer::where('quiz_question_id', $id)
                ->get();
            foreach ($quizanswer as $item) {
                $quizanswer = QuizQuestionAnswer::where('id', $item->id)->first();
                if (isset($item->image) != NULL) {
                    Storage::disk('local')->delete($item->image);;
                }
                $quizanswer->delete();
            }


            $quizQuestion = QuizQuestion::find($id);
            if ($quizQuestion->image != NULL) {
                Storage::disk('local')->delete($quizQuestion->image);
                $quizQuestion->delete();
            }
            $quizQuestion->delete();
            return redirect()->back()->with('success', 'Succesfuly Created Quizs');
        }
    }


    /**
     * quizClas
     *
     * @param Request $request
     * @return void
     */
    public function quizClas(Request $request)
    {
        $businesId = $request->get('busines_id', '');
        $busines = Business::find($businesId);




        if ($businesId == "") {
            $checkAccount = PersonalBusiness::where('personal_id', Auth::guard('personal')->user()->id)
                ->where('is_approve', 1)
                ->count();
            if ($checkAccount > 0) {
                $quiz = Quiz::with(['quizQuestion', 'clas'])
                    ->OrderBy('id', 'DESC')
                    ->where('teacher_id', Auth::guard('personal')->user()->id)
                    ->where('is_clas', 1)
                    ->paginate(10);
            } else {
                $quiz = [];
            }
        } else {
            $checkAccount = PersonalBusiness::where('busines_id', $businesId)
                ->where('personal_id', Auth::guard('personal')->user()->id)
                ->where('is_approve', 1)
                ->count();
            if ($checkAccount > 0) {
                $quiz = Quiz::with(['quizQuestion', 'clas'])
                    ->OrderBy('id', 'DESC')
                    ->where('busines_id', $businesId)
                    ->where('teacher_id', Auth::guard('personal')->user()->id)
                    ->paginate(10);
            } else {
                $quiz = [];
            }
        }



        return view('personal.teacher.quiz', \compact(
            'quiz',
            'busines',
            'businesId'
        ));
    }

    /**
     * UpdateQuiz
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function UpdateQuiz(Request $request, $id)
    {


        $quiz = Quiz::find($id);

        $this->validate($request, [
            'code'             => 'required|max:200|unique:quizs,code,' . $id,
        ]);

        foreach ($request->clas_id as $c) {
            if ($QuizClasses = QuizClasses::where('quiz_id', $id)->first()) {
                $QuizClasses->delete();
            }
        }

        foreach ($request->clas_id as $c) {
            if (!$QuizClasses = QuizClasses::where('quiz_id', $id)->where('clas_id', $c)->first()) {
                $dataClas['clas_id'] = $c;
                $dataClas['quiz_id'] = $id;
                QuizClasses::create($dataClas);
            }
        }

        $data  = $request->except('_token', 'image', 'description', 'file_name', 'clas_id');

        if ($request->hasFile('image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz',
                $request->file('image')
            );
            $data['image'] = $path;
            Storage::disk('local')->delete($request->file_name);
        } else {
            $data['image'] = $request->file_name;
        }
        $data['is_active'] = isset($request->is_active) ? "1" : "0";
        $quiz->update($data);




        return redirect()->back()->with('success', 'Succesly Update Quiz');
    }
    /**
     * getDataPlayQuiz
     *
     * @return void
     */
    public function getDataPlayQuiz()
    {
        $i = 0;
        $q = QuizQuestion::where('quiz_id', 3)
            ->with(['quizQuestionAnswer'])
            ->get();
        $x = 10;
        return  $q->map(function ($quiz) use ($x) {

            $s = $quiz->quizQuestionAnswer->search(function ($item, $key) use ($x) {
                if ($item['is_true'] == 1) {
                    return $key;
                } else {
                    return 0;
                }
            });

            return [
                'q' => $quiz['question'],
                'options' =>  $quiz->quizQuestionAnswer->map(function ($employee, $keyz) {
                    return $employee['answer'];
                }),
                'correctIndex' => $s == false ? 0 : $s,
                'correctResponse' => 'Custom correct response.',
                'incorrectResponse' =>  'Custom incorrect response'
            ];
        });
    }


    public function playQuizbyClass(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        $questions = QuizQuestion::where('quiz_id', $id)
            ->with(['quizQuestionAnswer', 'quiz'])
            ->get();

        if ($request->get('participant_id') && $request->get('play') != 1) {
            $data['student_id'] = Auth::guard('personal')->user()->id;
            $data['quiz_id'] = $id;
            $data['start_date_time'] = Carbon::now();

            QuizParticipant::create($data);
            $last = QuizParticipant::OrderBy('id', 'DESC')->first();
            return redirect('/personal/student/quiz/class/answer/' . $id . '/?participant_id=' . $last->id . '&play=1');
        }

        return view('personal.student.play_quiz_by_class', \compact('questions', 'quiz'));
    }

    public function saveQuizbyClass(Request $request)
    {
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

        $qp->true  = $true;
        $qp->false  = $false;

        $qp->update();

        return redirect('personal/student/quiz/class/answer/previewscore/' . $request->get('participant_id'));
    }

    public function PreviewScore($pid)
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
            'personal.student.show_score_by_class',
            \compact('cekScore', 'istrue')
        );
    }
    public function activityScorebyClas()
    {
        $quizScore = QuizParticipant::where('student_id', Auth::guard('personal')->user()->id)
            ->with(['quiz'])
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('personal.student.show_activity_score', \compact('quizScore'));
    }

    public function createQuizGeneral()
    {

        $lesson = Lesson::where('is_business',  0)
            ->get();

        $clas = Clas::where('is_business',  0)
            ->where('busines_id', NULL)
            ->get();

        return view('personal.createquiz', \compact(
            'lesson',
            'clas'
        ));
    }

    public function storeQuizGeneral(Request $request)
    {
        $this->validate($request, [
            'title'        => 'required',
            'description' => 'required',
            'lesson_id'   => 'required',
            'image'      => 'required|image|mimes:jpeg,png,gif,jpg|max:5000', // max 5MB
        ]);
        $path = Storage::disk('local')->putFile(
            'public/v1/images/quiz',
            $request->file('image')
        );

        $lesson = Lesson::find($request->lesson_id);

        $lessonName = $lesson->name;

        $data  = $request->except('_token', 'image');
        $data['image'] = $path;
        $data['teacher_id'] = Auth::guard('personal')->user()->id;
        $data['is_active'] = 0;
        $data['code'] = str_replace(' ', '', $lessonName . date('YmDHis'));
        $data = Quiz::create($data);

        return redirect('personal/my_quiz/edit/' . $data->id);
    }

    public function editQuizGeneral($id)
    {
        $quiz = Quiz::find($id);
        $questionsanswer = QuizQuestion::with(['quizQuestionAnswer' => function ($a) {
            return $a->where("answer", '!=', NULL)->orWhere('image', '!=', null);
        }])
            ->where('quiz_id', $id)
            ->paginate(6);
        return view('personal.editquiz', \compact('quiz', 'questionsanswer'));
    }

    public function saveQuestionAnswerGeneral(Request $request, $quiz_id)
    {
        $ans = $request->answer;

        if (!$ans) {
            return redirect()->back();
        }

        $questions = $request->only(
            'question',
            'file',
            'rumus',
            'image'

        );
        if ($request->has('question_image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz_question',
                $request->file('question_image')
            );
            $questions['image'] = $path;
        }

        $questions['quiz_id'] = $quiz_id;

        $questions = QuizQuestion::create($questions);

        for ($i = 1; $i <= count($ans); $i++) {
            $questions->quizQuestionAnswer()->create([
                'answer' => $request->answer[$i],
                'is_true' => $i == $request->is_true ? 1 : 0,
                'image' => (isset($request->image_answer[$i]) == NULL) || (!is_null($request->answer[$i]) && $request->answer[$i] != "") ? NULL : uploadImage($request->image_answer[$i])
            ]);
        }

        return redirect()->back();
    }

    public function editQuestions($quiz_id, $question_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $question = QuizQuestion::where('quiz_id', '=', $quiz_id)->where('id', '=', $question_id)->firstOrFail();

        return view('personal.edit_question', compact('quiz', 'question'));
    }

    public function editQuestionsClas($quiz_id, $question_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $question = QuizQuestion::where('quiz_id', '=', $quiz_id)->where('id', '=', $question_id)->firstOrFail();

        return view('personal.teacher.edit_question', compact('quiz', 'question'));
    }

    public function updateQuestions(Request $request, $quiz_id, $question_id)
    {
        // return $request->all();
        $ans = $request->answer;

        if (!$ans) {
            return redirect()->back();
        }

        $questions = $request->only(
            'question',
            'file',
            'rumus',
            'image'

        );
        if ($request->has('question_image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz_question',
                $request->file('question_image')
            );
            $questions['image'] = $path;
        }

        // $questions['quiz_id'] = $quiz_id;

        $update_questions = QuizQuestion::findOrFail($question_id);
        $update = $update_questions->update($questions);

        //DELETE BEFORE UPDATE ANSWER
        $delete = $update_questions->quizQuestionAnswer()->whereNotIn('id', $request->answer_id)->get();

        foreach ($delete as $row) {
            if (isset($row->image) != NULL) {
                Storage::disk('local')->delete($row->image);;
            }

            $row->delete();
        }



        for ($i = 1; $i <= count($ans); $i++) {

            if (isset($request->answer_id[$i])) {
                $quizanswer = QuizQuestionAnswer::where('quiz_question_id', $question_id)
                    ->where('id', '=', $request->answer_id[$i])
                    ->first();
            } else {
                $quizanswer = null;
            }

            if (is_null($quizanswer)) {
                $insert = [
                    'is_true' => $i == $request->is_true ? 1 : 0,
                ];

                if ($request->hasFile('image_answer.' . $i)) {
                    $insert['answer'] = null;
                } else {
                    $insert['answer'] = $request->answer[$i];
                }

                if (!is_null($request->answer[$i]) && $request->answer[$i] != "") {
                    $insert['image'] = null;
                } else {
                    $insert['image'] = isset($request->image_answer[$i]) == NULL ? NULL : uploadImage($request->image_answer[$i]);
                }

                $update_questions->quizQuestionAnswer()->create($insert);
            } else {
                $insert = [
                    'is_true' => $i == $request->is_true ? 1 : 0,
                ];

                if ($request->hasFile('image_answer.' . $i)) {
                    $insert['answer'] = null;
                } else {
                    $insert['answer'] = $request->answer[$i];
                }

                if (!is_null($request->answer[$i]) && $request->answer[$i] != "") {
                    $insert['image'] = null;
                } else {
                    if ($request->hasFile('image_answer.' . $i)) {
                        $insert['image'] = uploadImage($request->image_answer[$i]);
                    }
                }

                $quizanswer->update($insert);
            }
        }

        return redirect()->back()->with('success', 'Succesfuly Updated Question');
    }
    public function updateQuestionsClas(Request $request, $quiz_id, $question_id)
    {
        // return $request->all();
        $ans = $request->answer;

        if (!$ans) {
            return redirect()->back();
        }

        $questions = $request->only(
            'question',
            'file',
            'rumus',
            'image'

        );
        if ($request->has('question_image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz_question',
                $request->file('question_image')
            );
            $questions['image'] = $path;
        }

        // $questions['quiz_id'] = $quiz_id;

        $update_questions = QuizQuestion::findOrFail($question_id);
        $update = $update_questions->update($questions);

        //DELETE BEFORE UPDATE ANSWER
        $delete = $update_questions->quizQuestionAnswer()->whereNotIn('id', $request->answer_id)->get();

        foreach ($delete as $row) {
            if (isset($row->image) != NULL) {
                Storage::disk('local')->delete($row->image);;
            }

            $row->delete();
        }



        for ($i = 1; $i <= count($ans); $i++) {

            if (isset($request->answer_id[$i])) {
                $quizanswer = QuizQuestionAnswer::where('quiz_question_id', $question_id)
                    ->where('id', '=', $request->answer_id[$i])
                    ->first();
            } else {
                $quizanswer = null;
            }

            if (is_null($quizanswer)) {
                $insert = [
                    'is_true' => $i == $request->is_true ? 1 : 0,
                ];

                if ($request->hasFile('image_answer.' . $i)) {
                    $insert['answer'] = null;
                } else {
                    $insert['answer'] = $request->answer[$i];
                }

                if (!is_null($request->answer[$i]) && $request->answer[$i] != "") {
                    $insert['image'] = null;
                } else {
                    $insert['image'] = isset($request->image_answer[$i]) == NULL ? NULL : uploadImage($request->image_answer[$i]);
                }

                $update_questions->quizQuestionAnswer()->create($insert);
            } else {
                $insert = [
                    'is_true' => $i == $request->is_true ? 1 : 0,
                ];

                if ($request->hasFile('image_answer.' . $i)) {
                    $insert['answer'] = null;
                } else {
                    $insert['answer'] = $request->answer[$i];
                }

                if (!is_null($request->answer[$i]) && $request->answer[$i] != "") {
                    $insert['image'] = null;
                } else {
                    if ($request->hasFile('image_answer.' . $i)) {
                        $insert['image'] = uploadImage($request->image_answer[$i]);
                    }
                }

                $quizanswer->update($insert);
            }
        }

        return redirect()->back()->with('success', 'Succesfuly Updated Question');
    }

    /**
     * deleteQuestionAnswerGeneral
     *
     * @param mixed $id
     * @return void
     */
    public function deleteQuestionAnswerGeneral($id)
    {
        $cek = QuizParticipantAnswer::where('quiz_question_id', $id)->count();

        if ($cek > 0) {
            return redirect()->back()->with('error', 'Can\'t Delete Question in Quiz Selected.');
        } else {

            $quizanswer = QuizQuestionAnswer::where('quiz_question_id', $id)
                ->get();
            foreach ($quizanswer as $item) {
                $quizanswer = QuizQuestionAnswer::where('id', $item->id)->first();
                if (isset($item->image) != NULL) {
                    Storage::disk('local')->delete($item->image);;
                }
                $quizanswer->delete();
            }


            $quizQuestion = QuizQuestion::find($id);
            if ($quizQuestion->image != NULL) {
                Storage::disk('local')->delete($quizQuestion->image);
                $quizQuestion->delete();
            }
            $quizQuestion->delete();
            return redirect()->back()->with('success', 'Succesfuly Deleted Quizs');
        }
    }

    /**
     * UpdateQuizGeneral
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function UpdateQuizGeneral(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        $this->validate($request, [
            'code'             => 'required|max:200|unique:quizs,code,' . $id,
        ]);

        $data  = $request->except('_token', 'image', 'description', 'file_name');

        if ($request->hasFile('image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz',
                $request->file('image')
            );
            $data['image'] = $path;
            Storage::disk('local')->delete($request->file_name);
        } else {
            $data['image'] = $request->file_name;
        }
        $data['is_active'] = isset($request->is_active) ? "1" : "0";
        $quiz->update($data);
        return redirect()->back()->with('success', 'Succesly Update Quiz');
    }
    /**
     * quizClasGeneral
     *
     * @param Request $request
     * @return void
     */
    public function quizClasGeneral(Request $request)
    {
        $quiz = Quiz::with(['quizQuestion', 'clas'])
            ->OrderBy('id', 'DESC')
            ->where('is_clas', 0)
            ->where('teacher_id', Auth::guard('personal')->user()->id)
            ->paginate(10);

        return view('personal.my_quiz', \compact('quiz'));
    }

    public function publishQuiz($id, $status)
    {
        $quiz = Quiz::find($id);

        $quiz->is_active = $status;
        $quiz->update();

        return $quiz;
    }

    /**
     * quizByClas
     *
     * @return void
     */
    public function quizByClas()
    {
        $clasBusines = PersonalBusiness::where('personal_id', Auth::guard('personal')->user()->id)
            ->where('type', 'teacher')
            ->pluck('busines_id');

        $quiz = Quiz::with(['quizQuestion', 'busines'])
            ->OrderBy('id', 'DESC')
            ->where('is_clas', 1)
            ->where('teacher_id', Auth::guard('personal')->user()->id)
            ->whereIn('busines_id', $clasBusines)
            ->paginate(10);

        return view(
            'personal.teacher.reportByClas',
            \compact('quiz')
        );
    }
}
