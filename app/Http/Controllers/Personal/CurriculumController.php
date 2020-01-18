<?php

namespace App\Http\Controllers\Personal;

use App\Clas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Curriculum;
use App\Lesson;
use App\LessonPersonal;
use App\PersonalBusiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    /**
     * getCurriculum
     *
     * @param Request $request
     * @return void
     */
    public function getCurriculum(Request $request)
    {
        $businesID = $request->busines_id;


        $query = Curriculum::with(['lesson', 'teacher', 'busines'])->OrderBy("id", 'DESC');

        if ($businesID != "") {
            $query =  $query->where("busines_id", $businesID);
        } else {
            $authLogin = PersonalBusiness::where('personal_id', Auth::guard('personal')->user()->id)
                ->where('type', 'teacher')
                ->pluck('busines_id');
            $query =  $query->whereIn("busines_id", $authLogin);
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

    public function index()
    {
        return \view('personal.curriculum.index');
    }
    public function create()
    {
        $busines = PersonalBusiness::with(['busines'])->where('personal_id', Auth::guard('personal')->user()->id)
            ->where('type', 'teacher')
            ->get();

        return view('personal.curriculum.create', \compact('busines'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      => 'required|max:100',
            'busines_id' => 'required',
            'clas_id'    => 'required',
            'lesson_id'  => 'required',
            'filenya'    => 'required|mimes:doc,docx,pdf,txt,png,jpg|max:80000',
        ]);

        $file = $request->file('filenya');

        $data = $request->all();

        $path = Storage::disk('local')->putFile(
            'public/v1/file/',
            $request->file('filenya')
        );

        $data['file'] = $path;
        $data['size'] = $file->getSize();
        $data['mime'] = $file->getMimeType();
        $data['ekstensi'] = $file->getClientOriginalExtension();
        $data['clas_id'] = \json_encode($request->clas_id, true);

        $data['teacher_id'] = Auth::guard('personal')->user()->id;
        Curriculum::create($data);

        return redirect('personal/curriculum/')
            ->with("success", "Successfully Insert Curriculum");
    }

    public function delete($id)
    {
        $curriculum = Curriculum::find($id);
        if (!$curriculum) {
            \abort(404);
        }
        if ($curriculum->file != "") {
            Storage::disk('local')->delete($curriculum->file);
        }

        $curriculum->delete();

        return redirect('personal/curriculum/')
            ->with("success", "Successfully Deleted Curriculum");
    }

    public function edit($id)
    {
        $curriculum = Curriculum::find($id);
        if (!$curriculum) {
            \abort(404);
        }

        $clasID = Curriculum::where('id', $id)->pluck('clas_id');
        $clasIDs = json_decode($clasID, true);
        $old = ["\"", "[", "]"];
        $new = '';
        $clasID = str_replace($old, $new, $clasIDs);



        $clas = Clas::where('busines_id', $curriculum->busines_id)->get();

        $lesson =  LessonPersonal::with(['lesson', 'personalBusines'])
            ->whereHas('personalBusines', function ($pb)  use ($curriculum) {
                return $pb->where('type', 'teacher')->where('busines_id', $curriculum->busines_id);
            })->get();

        return view('personal.curriculum.edit', \compact(
            'curriculum',
            'clas',
            'clasID',
            'lesson'
        ));
    }

    public function update(Request $request, $id)
    {
        $curriculum = Curriculum::find($id);

        $this->validate($request, [
            'title'      => 'required|max:100',
            'clas_id'    => 'required',
            'lesson_id'  => 'required',
            'filenya'    => 'required|mimes:doc,docx,pdf,txt,png,jpg|max:80000',
        ]);

        $data = $request->all();

        if ($request->hasFile('filenya')) {
            $file = $request->file('filenya');
            $path = Storage::disk('local')->putFile(
                'public/v1/file/',
                $request->file('filenya')
            );

            $data['file'] = $path;
            $data['size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
            $data['ekstensi'] = $file->getClientOriginalExtension();

            Storage::disk('local')->delete($curriculum->file);
        }

        $data['clas_id'] = \json_encode($request->clas_id, true);
        $curriculum->update($data);

        return redirect('personal/curriculum/')
            ->with("success", "Successfully Update Curriculum");
    }
}
