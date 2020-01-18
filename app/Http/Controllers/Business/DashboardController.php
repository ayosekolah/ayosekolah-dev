<?php

namespace App\Http\Controllers\Business;

use App\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.busines');
    }

    public function index()
    {
        return view("business.dashboard");
    }
    public function edit()
    {
        $business = Business::find(Auth::guard('busines')->user()->id);
        return view(
            "business.edit",
            \compact('business')
        );
    }
    public function update(Request $request)
    {
        $user = Business::find(Auth::guard('busines')->user()->id);
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
            'email'                => 'required|max:200|unique:business,email,' . Auth::guard('busines')->user()->id,
            'username'             => 'required|max:200|unique:business,username,' . Auth::guard('busines')->user()->id,
            'address'              => 'required|max:200',
        ]);

        if ($request->has('image')) {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/business',
                $request->file('image')
            );
            $user->image = $path;
        }

        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->fax = $request->fax;
        $user->username = $request->username;

        $user->update();

        return redirect()->back()->with("success", 'Profile Succesfully Update');
    }
}
