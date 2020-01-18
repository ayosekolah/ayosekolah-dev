<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\LessonBusines;
use App\LessonPersonal;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonBusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.busines');
    }
    /**
     * getData
     *
     * @return void
     */
    public function getData()
    {
        $query = LessonBusines::whereHas('lesson', function ($l) {
            return $l->where("is_business", 1);
        })
            ->with(['lesson'])
            ->orderBy("id", 'DESC')
            ->where('busines_id', Auth::guard("busines")->user()->id)
            ->get();

        return datatables()->of($query)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->addColumn('action', function ($query) {
                $idLesson = $query->lesson;
                $id = $query->id;
                return view('business.lesson_business.action', compact('idLesson', 'id'));
            })


            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return view("business.lesson_business.index");
    }
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('business.lesson_business.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $data = $request->only("name", "color");
        $data['is_business'] = 1;
        $lesson = Lesson::create($data);
        $lesson->lessonBusines()->create([
            'busines_id' => Auth::guard("busines")->user()->id
        ]);

        return redirect('business/lesson_business')
            ->with("success", "Successfully Insert New Lesson");
    }
    /**
     * edit
     *
     * @param mixed $id
     * @return void
     */
    public function edit($id)
    {
        $lesbi = LessonBusines::with("lesson")->where('id', $id)->first();

        if (!$lesbi) {
            \abort(404);
        }

        return view('business.lesson_business.edit', \compact(
            "lesbi"
        ));
    }
    /**
     * update
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $lesbi = LessonBusines::find($id);
        $data = $request->only("name", "color");
        $les = $lesbi->lesson()->update($data);

        return redirect('business/lesson_business')
            ->with("success", "Successfully Update Selected Lesson");
    }
    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $lesbi = LessonBusines::find($id);

        if (!$lesbi) {
            \abort(404);
        }

        if (Quiz::where('lesson_id', $lesbi->lesson_id)->first()) {
            return redirect('business/lesson_business')
                ->with("danger", "Can't Delete Selected Lesson");
        }

        $lesbi->delete();
        $lesbi->lesson()->delete();

        return redirect('business/lesson_business')
            ->with("success", "Successfully Delete Selected Lesson");
    }

    /**
     * showLesson
     *
     * @param Request $request
     * @param mixed $lessonID
     * @return void
     */
    public function showLesson(Request $request, $lessonID)
    {

        $type = $request->get('type');

        if ($request->ajax()) {

            $personal = LessonPersonal::whereHas('personalBusines', function ($z) use ($type) {
                if ($type == 'teacher' || $type == 'student') {
                    return $z->where('type', $type);
                }
            })->with(['personalBusines' => function ($ps) {
                return $ps->with('personal');
            }])->where('lesson_id', $lessonID)
                ->get();

            return datatables()->of($personal)
                ->editColumn('created_at', function ($personal) {
                    return date("D, d/m/Y", strtotime($personal->created_at));
                })

                ->addColumn('action', function ($personal) {
                    $editUrl = $personal->personalBusines->personal_id;
                    return view('business.lesson_business.action_personal', compact('editUrl'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('business.lesson_business.show_personal');
    }
}
