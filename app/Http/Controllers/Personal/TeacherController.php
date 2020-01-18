<?php

namespace App\Http\Controllers\Personal;

use App\ClasPersonal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
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
     * getDataClas
     *
     * @return void
     */
    public function getDataClas()
    {
        $query = ClasPersonal::where('personal_id', Auth::guard('personal')->user()->id)->where('clas_id', '!=', NULL)
            ->with(['clas', 'student'])
            ->get();

        return datatables()->of($query)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->addColumn('action', 'personal.teacher.action')
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * showClass
     *
     * @return void
     */
    public function showClass()
    {
        return view('personal.teacher.classes');
    }

    public function getDataStudent($clas_id)
    {
        $query = ClasPersonal::where('clas_id', $clas_id)
            ->whereHas('student', function ($s) {
                return $s->where('type', "student");
            })
            ->with('student')
            ->get();

        return datatables()->of($query)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->make(true);
    }

    public function showStudent($id)
    {
        return view('personal.teacher.student', \compact("id"));
    }
}
