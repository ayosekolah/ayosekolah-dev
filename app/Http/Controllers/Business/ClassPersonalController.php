<?php

namespace App\Http\Controllers\Business;

use App\Clas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClasPersonal;
use App\Lesson;
use App\LessonBusines;
use App\Personal;
use App\PersonalBusiness;
use Illuminate\Support\Facades\Auth;

class ClassPersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.busines', ['except' => ['isDelete']]);
    }
    /**
     * getData
     *
     * @param mixed $type
     * @return void
     */
    public function getData2(Request $request, $type)
    {
        $ap = $request->get('approve');

        if ($ap == 0) {
            $query = ClasPersonal::whereHas(
                "personal",
                function ($c) use ($type) {
                    return $c->where("type", $type)
                        ->where("busines_id", Auth::guard("busines")->user()->id);
                }
            );

            if ($type == "teacher") {
                $query->where('is_aprroved', 0)
                    ->with(['personal', 'clas'])
                    ->get();
            } else if ($type == "student") {
                $query->where('is_aprroved', 0)
                    ->with(['personal', 'clas'])
                    ->get();
            }

            return datatables()->of($query)
                ->editColumn('created_at', function ($query) {
                    return date("D, d/m/Y", strtotime($query->created_at));
                })
                ->addColumn('is_approved_yes', function ($query) {
                    return $query->is_aprroved == 1 ? "<span class='badge badge-success'>Yes</span>" : "<span class='badge badge-danger'>No</span>";
                })
                ->addColumn('clas.name', function ($query) {
                    return "Not Selected";
                })
                ->addColumn('action', 'business.clas_personal.action', 'is_approved_yes')
                ->rawColumns(['action', 'is_approved_yes'])
                ->make(true);
        } else if ($ap == 1) {
            $query = ClasPersonal::whereHas(
                "clas",
                function ($c) {
                    return $c->where("busines_id", Auth::guard("busines")->user()->id);
                }
            )->whereHas(
                "personal",
                function ($c) use ($type) {
                    return $c->where("type", $type)
                        ->where("busines_id", Auth::guard("busines")->user()->id);
                }
            )
                ->where('is_aprroved', 1)
                ->with(['personal', 'clas'])
                ->get();

            return datatables()->of($query)
                ->editColumn('created_at', function ($query) {
                    return date("D, d/m/Y", strtotime($query->created_at));
                })
                ->addColumn('is_approved_yes', function ($query) {
                    return $query->is_aprroved == 1 ? "<span class='badge badge-success'>Yes</span>" : "<span class='badge badge-danger'>No</span>";
                })
                ->addColumn('action', 'business.clas_personal.action', 'is_approved_yes')
                ->rawColumns(['action', 'is_approved_yes'])
                ->make(true);
        }
    }
    /**
     * getData
     *
     * @param Request $request
     * @param mixed $type
     * @return void
     */
    public function getData(Request $request, $type)
    {
        $ap = $request->get('approve');

        if ($ap == 0) {
            $aD = [$ap, 2];
        } elseif ($ap == 1) {
            $aD = [$ap];
        }



        $personal = Personal::whereHas('personalBusines', function ($p) use ($type, $aD) {
            return $p->where('busines_id',  Auth::guard("busines")->user()->id)
                ->where('type', $type)
                ->whereIn('is_approve', $aD);
        })->with(['personalBusines' => function ($pb) {
            return $pb->with(['clasPersonal' => function ($c) {
                return $c->with(['clas']);
            }]);
        }])
            ->get();

        return datatables()->of($personal)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->addColumn('is_approved_yes', function ($query) {
                if ($query->personalBusines[0]->is_approve == 1) {
                    return "<span class='badge badge-success'>Approved</span>";
                } else  if ($query->personalBusines[0]->is_approve == 2) {
                    return "<span class='badge badge-danger'>Deleted/Canceled</span>";
                } else {
                    return "<span class='badge badge-warning'>Waiting</span>";
                }
            })
            ->addColumn('class_count', function ($query) {
                return count($query->personalBusines[0]->clasPersonal);
            })

            ->addColumn('action', function ($query) {
                $id = $query->id;
                $approve = $query->personalBusines[0]->is_approve;
                return view('business.clas_personal.action', compact('id', 'approve'));
            })

            ->addColumn('business.clas_personal.action', 'is_approved_yes')
            ->rawColumns(['is_approved_yes', 'action'])
            ->make(true);
    }

    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)

    {
        $ap = $request->get('approve');

        return view('business.clas_personal.index', compact('ap'));
    }
    /**
     * isAprroved
     *
     * @param mixed $id
     * @return void
     */
    public function is_approved($id, Request $request)
    {
        $redirect = $request->get('redirect_url', '');

        $personal = Personal::where('id', $id)->with(['personalBusines' => function ($l) {
            return $l->with(['clasPersonal' => function ($lp) {
                return $lp->with(['clas']);
            }, 'lessonPersonal' => function ($lp) {
                return $lp->with(['lesson']);
            }])->where('busines_id',  Auth::guard('busines')->user()->id);
        }])->whereHas('personalBusines', function ($pb) use ($id) {
            return $pb->where('busines_id',  Auth::guard('busines')->user()->id)->where('personal_id', $id);
        })
            ->first();

        if ($personal->personalBusines[0]->type == "teacher") {
            $lesson = Lesson::whereHas('lessonBusines', function ($l) {
                return $l->where('busines_id',  Auth::guard('busines')->user()->id);
            })
                ->get();

            $clas = Clas::where('busines_id',  Auth::guard('busines')->user()->id)
                ->get();

            return view(
                'business.clas_personal.is_approve_teacher',
                \compact(
                    'personal',
                    'lesson',
                    'clas',
                    'redirect'
                )
            );
        } else if ($personal->personalBusines[0]->type == "student") {

            $personal = Personal::where('id', $id)->with(['personalBusines' => function ($l) {
                return $l->with(['clasPersonal' => function ($lp) {
                    return $lp->with(['clas']);
                }]);
            }])->whereHas('personalBusines', function ($pb) use ($id) {
                return $pb->where('busines_id',  Auth::guard('busines')->user()->id)
                    ->where('personal_id', $id);
            })->first();

            $clas = Clas::where('busines_id',  Auth::guard('busines')->user()->id)
                ->get();

            return view(
                'business.clas_personal.is_approve_student',
                \compact(
                    'personal',
                    'clas',
                    'redirect'
                )
            );
        } else {
            \abort(404);
        }
    }

    /**
     * proccessAprpove
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function proccessAprpove(Request $request, $id)
    {
        $redirect = $request->get('redirect_url');

        $pb = $request->personal_busines_id;
        $personal = PersonalBusiness::find($pb);

        if ($request->type == "teacher") {
            $personal->lessonHas()->detach();
            $personal->clasHas()->detach();

            $personal->lessonHas()->sync($request->lesson_id);
            $personal->clasHas()->sync($request->clas_id);

            ClasPersonal::where('personal_busines_id', $pb)->update([
                'is_aprroved' => isset($request->is_approve) ?: 0
            ]);

            PersonalBusiness::where('id', $pb)->update([
                'is_approve' => isset($request->is_approve) ?: 0
            ]);

            if ($redirect != '') {
                $rU = $redirect;
            } else {
                $rU = 'business/clas_personal/index/teacher?approve=1';
            }

            return redirect($rU)
                ->with("success", "Successfully Selected in Clas and Lesson");
        } else if ($request->type == "student") {

            $checking = ClasPersonal::where('personal_busines_id', $pb)->count();

            if ($checking == 0) {
                $personal->clasHas()->sync($request->clas_id);

                ClasPersonal::where('personal_busines_id', $pb)->update([
                    'is_aprroved' => isset($request->is_approve)
                ]);
            } else {
                $personal->clasHas()->detach();
                $personal->clasHas()->sync($request->clas_id);

                ClasPersonal::where('personal_busines_id', $pb)->update([
                    'is_aprroved' => isset($request->is_approve)
                ]);
            }

            PersonalBusiness::where('id', $pb)->update([
                'is_approve' => isset($request->is_approve) ?: 0
            ]);
            if ($redirect != '') {
                $rU = $redirect;
            } else {
                $rU = 'business/clas_personal/index/student?approve=1';
            }
            return redirect($rU)
                ->with("success", "Successfully Selected in Clas");
        }
    }

    public function isDelete(Request $request, $id)
    {
        if ($request->from == "client") {
            $pbID = PersonalBusiness::where('id', $id)->where('personal_id', $request->pID)->first();

            $pbID->delete();
            $pbID->clasPersonal()->delete();
            $pbID->lessonPersonal()->delete();

            return redirect('personal/dashboard')
                ->with("success", "Successfully Leave a Business");
        } else {
            $pbID = PersonalBusiness::where('personal_id', $id)
                ->where('busines_id', Auth::guard('busines')->user()->id)
                ->first();
            $pbID->delete();
            $pbID->clasPersonal()->delete();
            $pbID->lessonPersonal()->delete();
            return back()
                ->with("success", "Successfully Deleted in Business");
        }
    }
}
