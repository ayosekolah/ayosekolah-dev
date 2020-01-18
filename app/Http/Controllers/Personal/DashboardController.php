<?php

namespace App\Http\Controllers\Personal;

use App\ClasPersonal;
use App\Curriculum;
use App\Http\Controllers\Controller;
use App\Personal;
use App\PersonalBusiness;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.personal');
    }
    public function index()
    {
        $busines  = PersonalBusiness::with('busines')->where('personal_id', Auth::guard('personal')->user()->id)
            ->get();
        $quiz = Quiz::OrderBy('id', 'DESC')
            ->with(['lesson', 'teacherAll'])
            ->where('clas_id', '!=', NULL)
            ->where('is_active', 1)
            ->paginate(10);

        return view(
            "personal.dashboard",
            \compact('quiz', 'busines')
        );
    }

    /**
     * edit
     *
     * @return void
     */
    public function edit()
    {
        $personal = Personal::find(Auth::guard('personal')->user()->id);
        return view(
            "personal.edit",
            \compact('personal')
        );
    }

    /**
     * update
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $user = Personal::find(Auth::guard('personal')->user()->id);
        if ($request->old_password != "" || $request->new_password != "" || $request->confirm_password != "") {
            $this->validate($request, [
                'old_password'     => 'required',
                'new_password'     => 'required|min:6|different:old_password',
                'confirm_password' => 'required|same:new_password',
            ]);

            if (!\Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'You have entered wrong password');
            } else {
                $user->password = bcrypt($request->new_password);
            }
        }

        $this->validate($request, [
            'name'                 => 'required|min:4',
            'email'                => 'required|max:200|unique:personals,email,' . Auth::guard('personal')->user()->id,
            'username'             => 'required|max:200|unique:personals,username,' . Auth::guard('personal')->user()->id,
            'address'              => 'required|max:200',
            'birth_of_date'        => 'required'
        ]);

        if ($request->has('image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/personal',
                $request->file('image')
            );
            $user->image = $path;
        }

        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->fax = $request->fax;
        $user->username = $request->username;
        $user->birth_of_date = date('Y-m-d', strtotime($request->birth_of_date));

        $user->update();

        return redirect()->back()->with("success", 'Profile Succesfully Update');
    }

    public function getPersonalByBusines(Request $request, $businesID)
    {
        $clasID = $request->clas_id;
        if ($clasID != '') {
            $query = PersonalBusiness::with(['personal', 'clasPersonal' => function ($clas) {
                return $clas->with(['clas']);
            }])
                ->whereHas('clasPersonal', function ($cp) use ($clasID) {
                    return $cp->where('clas_id', $clasID);
                })
                ->where('busines_id', $businesID)
                ->where('type', 'student')
                ->get();;
        } else {
            $query = PersonalBusiness::with(['personal', 'clasPersonal' => function ($clas) {
                return $clas->with(['clas']);
            }])->where('busines_id', $businesID)
                ->where('type', 'student')
                ->get();
        }



        return datatables()->of($query)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->make(true);
    }

    public function getQuizByBusines(Request $request, $businesID)
    {
        $clasID = $request->clas_id;
        if ($clasID != '') {
            $query = Quiz::where('teacher_id', Auth::guard('personal')->user()->id)
                ->where('busines_id', $businesID)
                ->with(['quizClas'])
                ->whereHas('quizClas', function ($p) use ($clasID) {
                    return $p->where('clas_id', $clasID);
                })
                ->where('teacher_id', Auth::guard('personal')->user()->id)
                ->get();
        } else {
            $query = Quiz::where('teacher_id', Auth::guard('personal')->user()->id)
                ->with(['quizClas'])
                ->where('busines_id', $businesID)
                ->where('is_clas', 1)
                ->where('teacher_id', Auth::guard('personal')->user()->id)
                ->get();
        }


        return datatables()->of($query)
            ->editColumn('title', function ($query) {
                return  "<a href='" . url('personal/teacher/quiz/class/edit/' . $query->id) . "'>" . $query->title . "</a>";
            })
            ->rawColumns(['title'])
            ->make(true);
    }

    public function quizStudent($businesID, $clasID)
    {
        $query = Quiz::where('busines_id', $businesID)
            ->whereHas('quizClas', function ($z) use ($clasID) {
                return $z->where('clas_id', $clasID);
            })
            ->get();

        return datatables()->of($query)
            ->editColumn('play', function ($query) {
                return  "<a class='btn bg-purple tx-white btn-xs' href='" . url('/personal/student/quiz/class/answer/' . $query->id) . "'>Play</a>";
            })
            ->rawColumns(['play'])
            ->make(true);
    }

    public function ClasBusines($businesID)
    {
        $query = ClasPersonal::with(['clas'])
            ->where('personal_busines_id', $businesID)
            ->get();

        return datatables()->of($query)
            ->editColumn('name', function ($query) use ($businesID) {
                return  "<a href='" . url('personal/busines/detail/' . $businesID . '/' . $query->clas_id) . "'>" . $query->clas->name . "</a>";
            })
            ->rawColumns(['name'])
            ->make(true);
    }

    public function getCurriculum(Request $request, $businesID)
    {
        $businesID = $request->busines_id;

        $clasID = $request->clas_id;


        $query = Curriculum::with(['lesson', 'teacher', 'busines'])
            ->OrderBy("id", 'DESC')
            ->where("busines_id", $businesID);

        if ($clasID != "") {
            $query->where('clas_id', 'like', '%' . $clasID . '%');
        }
        $query = $query->get();

        return datatables()->of($query)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->editColumn('title', function ($query) {
                return "<a target='_blank' href='" . Storage::url($query->file) . "'>" . $query->title . "</a>";
            })
            ->editColumn('sizes', function ($query) {
                return formatBytes($query->size);
            })
            ->addColumn('action', 'personal.curriculum.action')
            ->rawColumns(['action', 'title'])
            ->make(true);
    }

    public function detailBusines($id, $clasID = '')
    {
        $busines = PersonalBusiness::find($id);
        $clas = ClasPersonal::with(['clas'])
            ->where('personal_busines_id', $id)
            ->get();

        if (!$busines) {
            \abort(404);
        }

        if ($busines->type == 'teacher') {
            return view('personal.teacher.detailbusines', \compact(
                'busines',
                'clas',
                'clasID'
            ));
        } else if ($busines->type == 'student') {
            return view('personal.student.detailbusines', \compact(
                'busines',
                'clas',
                'clasID'
            ));
        }
    }
}
