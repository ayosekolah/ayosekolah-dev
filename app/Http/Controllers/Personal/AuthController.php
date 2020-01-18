<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register()
    {
        return view('personal.register');
    }

    public function registerProcess(Request $request)
    {
        $this->validate($request, [
            'name'                 => 'required|min:4',
            'email'                => 'required|email|unique:personals',
            'password'             => 'required|confirmed|min:6',
        ]);

        $personal =  $request->all();
        $personal['password'] = bcrypt($request->password);
        $personal['image'] = "v1/images/defaults/avatar.png";
        $personalRemember = base64_encode($request->email);
        $personal['remember_token'] = $personalRemember;
        $p = Personal::create($personal);

        $dataLogin = [
            'token' => $personalRemember
        ];

        $payload = [
            'user' => $personal,
            'dataLogin' => $dataLogin
        ];

        Mail::send('personal.email_verif', $payload, function ($message) use ($p) {

            $message
                ->from(env('MAIL_USERNAME'), 'Ayo Sekolah')
                ->to($p->email, 'Personal Account')
                ->subject("Ayo Sekolah - Verifikasi Account");
        });

        return redirect('personal/login')
            ->with([
                'success' => 'Register Succesfully, Please Confirm Email Verification'
            ]);
    }

    public function confirmEmail($token)
    {
        $check = Personal::where('remember_token', $token)->first();

        if ($check) {
            $check->is_valid = 1;
            $check->update();

            return redirect('personal/login')
                ->with([
                    'success' => 'Confirmation Succesfully, Please Sign In'
                ]);
        } else {
            return redirect('personal/login')
                ->with([
                    'danger' =>
                    'Confirmation Vailed, Please Register with Email is Valid'
                ]);
        }
    }

    public function login()
    {
        return view('personal.login');
    }
    /**
     * loginProcess
     *
     * @param Request $request
     * @return void
     */
    public function loginProcess(Request $request)
    {
        $this->validate($request, [
            'email'                => 'required|email',
            'password'             => 'required|min:6',
        ]);

        if (Auth::guard('personal')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $check = Auth::guard('personal')->user()->is_valid;
            if ($check == 0) {
                Auth::guard('personal')->logout();
                return redirect()->back()->with([
                    'error' => 'Account not Verified, Please Please Confirm Email Verification'
                ]);
            } else {
                return redirect()->intended('/personal/dashboard');
            }
        } else {
            return redirect()->back()->with(['error' => 'Email or Password is Wrong']);
        }
    }

    public function logOut()
    {
        Auth::guard('personal')->logout();
        return redirect("personal/login");
    }
}
