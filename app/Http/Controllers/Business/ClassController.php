<?php

namespace App\Http\Controllers\Business;

use App\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use App\Clas;
use App\ClasPersonal;
use App\Lesson;
use App\Personal;
use Illuminate\Support\Facades\Auth;
use App\PersonalBusiness;
use App\Quiz;
use PersonalBusines;

class ClassController extends Controller
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
        $query = Clas::OrderBy("id", 'DESC')
            ->where("busines_id", Auth::guard("busines")->user()->id)
            ->get();

        return datatables()->of($query)
            ->editColumn('created_at', function ($query) {
                return date("D, d/m/Y", strtotime($query->created_at));
            })
            ->addColumn('action', 'business.clas.action')
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
        return view('business.clas.index');
    }
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('business.clas.create');
    }
    public function edit(Request $request, $id)
    {
        $clas = Clas::find($id);

        return view('business.clas.edit', \compact(
            'clas'
        ));
    }
    public function update(Request $request, $id)
    {
        $clas = Clas::find($id);
        $data = $request->only("name");
        $clas->update($data);
        return redirect("business/clas")
            ->with("success", "Successfully Updated Deleted Class Grade");
    }
    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20|min:2'
        ]);
        $data = $request->only("name");
        $data['busines_id'] = Auth::guard("busines")->user()->id;
        $save = Clas::create($data);
        if ($save) {
            return redirect("business/clas")
                ->with("success", "Successfully Inserted New Class Grade");
        }
    }
    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $grade = Clas::find($id);
        if (!$grade) {
            \abort(404);
        }
        if (Quiz::where('clas_id', $id)->first()) {
            return redirect("business/clas")
                ->with("success", "Can't  Deleted Class Grade");
        } else {
            $grade->delete();
            return redirect("business/clas")
                ->with("success", "Succesfully Deleted Class Grade");
        }
    }
    /**
     * getPersonal
     *
     * @return void
     */
    public function getPersonal()
    {

        $pb = PersonalBusiness::where('busines_id', Auth::guard('busines')->user()->id)
            ->pluck('personal_id');

        $personal = Personal::whereNotIn('id', $pb)
            ->where('is_valid', 1)
            ->orderBy("id", "DESC")->get();

        return datatables()->of($personal)
            ->editColumn('created_at', function ($personal) {
                return date("D, d/m/Y", strtotime($personal->created_at));
            })
            ->addColumn('action', 'business.action_invite')
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * invite
     *
     * @param Request $request
     * @return void
     */
    public function invite(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('type');
        if ($request->get('type') == 'student' || $request->get('type') == 'teacher') {

            $personal = Personal::where('id', $id)->first();
            $clas = Clas::where('busines_id',  Auth::guard('busines')->user()->id)
                ->get();
            $lesson = Lesson::whereHas('lessonBusines', function ($l) {
                return $l->where('busines_id',  Auth::guard('busines')->user()->id);
            })
                ->get();

            return view('business.form_invite', \compact(
                'type',
                'personal',
                'clas',
                'lesson'
            ));
        } else {
            return view('business.list_personal');
        }
    }
    /**
     * inviteProccess
     *
     * @param Request $request
     * @return void
     */
    public function inviteProccess(Request $request)
    {
        $type = $request->type;
        $personalId = $request->id_personal;
        $businesId = Auth::guard('busines')->user()->id;
        PersonalBusiness::create([
            'personal_id' => $personalId,
            'busines_id' => $businesId,
            'is_approve' => 1,
            'type' => $type
        ]);

        $pb = PersonalBusiness::OrderBy('id', 'desc')->first();
        $personal = PersonalBusiness::find($pb->id);

        if ($type == 'student') {
            $personal->clasHas()->detach();

            $personal->clasHas()->sync($request->clas_id);

            ClasPersonal::where('personal_busines_id', $pb->id)->update([
                'is_aprroved' => 1
            ]);
        } else {;
            $personal->lessonHas()->detach();
            $personal->clasHas()->detach();

            $personal->lessonHas()->sync($request->lesson_id);
            $personal->clasHas()->sync($request->clas_id);

            ClasPersonal::where('personal_busines_id', $pb->id)->update([
                'is_aprroved' => 1
            ]);

            PersonalBusiness::where('id', $pb)->update([
                'is_approve' => 1
            ]);
        }

        return redirect('business/clas_personal/index/' . $type . '?approve=1')
            ->with("success", "Successfully Invited");
    }

    public function showPersonal(Request $request, $clasID)
    {
        if ($request->ajax()) {
            $type = $request->get('type');

            $personal = ClasPersonal::whereHas('personalBusines', function ($z) use ($type) {
                if ($type == 'teacher' || $type == 'student') {
                    return $z->where('type', $type)->where('is_approve', 1);
                } else {
                    return $z->where('is_approve', 1);
                }
            })->with(['personalBusines' => function ($ps) {
                return $ps->with('personal');
            }])->where('clas_id', $clasID)
                ->get();

            return datatables()->of($personal)
                ->editColumn('created_at', function ($personal) {
                    return date("D, d/m/Y", strtotime($personal->created_at));
                })

                ->addColumn('action', function ($personal) {
                    $editUrl = $personal->personalBusines->personal_id;
                    return view('business.clas.action_student', compact('editUrl'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('business.clas.show_personal');
    }
}
