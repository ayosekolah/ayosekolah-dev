<?php

namespace App\Http\Controllers\Personal;

use App\Business;
use App\Clas;
use App\ClasPersonal;
use App\LessonPersonal;
use App\Http\Controllers\Controller;
use App\LessonBusines;
use App\Personal;
use App\PersonalBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.personal');
    }

    public function join()
    {
        $pb = PersonalBusiness::where('personal_id', Auth::guard('personal')->user()->id)
            ->pluck('busines_id');

        $business = Business::whereNotIn('id', $pb)->orderBy("id", "DESC")
            ->paginate(8);

        return view('personal.list_join', \compact(
            'business'
        ));
    }

    public function joinRegister($type, $busines_id)
    {
        if (Auth::guard('personal')->user()->type == "teacher" || Auth::guard('personal')->user()->type == "student") {
            return redirect()->back()->with('success', 'You is Joiin');
        } else {
            if ($type == "teacher") {
                $lesson = LessonBusines::with('lesson')
                    ->where('busines_id', $busines_id)
                    ->get();
                $clas = Clas::where('busines_id',  $busines_id)
                    ->get();

                return view('personal.form_regiser', \compact(
                    'lesson',
                    'clas',
                    'busines_id'
                ));
            } else if ($type == "student") {

                $clas = Clas::where('busines_id',  $busines_id)
                    ->get();

                return view('personal.form_register_student', \compact(
                    'clas',
                    'busines_id'
                ));
            }
        }
    }

    public function joinProccess(Request $request)
    {
        $cekbusiness = Business::find($request->busines_id);

        if (!$cekbusiness) {
            return redirect()->back()->with('error', 'Not Match your code');
        }
        $type = $request->type;
        if ($type == "teacher") {

            $personal = Personal::find(Auth::guard('personal')->user()->id);

            if ($request->has('images')) {
                $path = Storage::disk('local')->putFile(
                    'public/v1/images/personal',
                    $request->file('images')
                );
                $image = $path;
            } else {
                $image = $request->imageOld;
            }

            $personal->update([
                'image'         => $image,
                'address'       => $request->address,
                'birth_of_date' => date('Y-m-d', strtotime($request->birth_of_date)),
                'phone'         => $request->phone,
            ]);

            PersonalBusiness::create([
                'personal_id' => $personal->id,
                'busines_id'  => $cekbusiness->id,
                'is_approve'  => 0,
                'type'        => 'teacher'
            ]);

            return redirect("personal/dashboard")->with([
                'success'  =>
                'Your Successfully Join, Waiting Aprrove by Business with type Teacher'
            ]);
        } else if ($type == "student") {
            $personal = Personal::find(Auth::guard('personal')->user()->id);

            if ($request->has('images')) {
                $path = Storage::disk('local')->putFile(
                    'public/v1/images/personal',
                    $request->file('images')
                );
                $image = $path;
            } else {
                $image = $request->imageOld;
            }

            PersonalBusiness::create([
                'personal_id' => $personal->id,
                'busines_id' => $cekbusiness->id,
                'is_approve' => 0,
                'type' => 'student'
            ]);

            $personal->update([
                'image'         => $image,
                'address'       => $request->address,
                'birth_of_date' => date('Y-m-d', strtotime($request->birth_of_date)),
                'phone'         => $request->phone,
            ]);

            return redirect("personal/dashboard")->with([
                'success'  =>
                'Your Successfully Join, Waiting Aprrove by Business with type Student'
            ]);
        } else { }
    }
}
