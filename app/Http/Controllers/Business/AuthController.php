<?php

namespace App\Http\Controllers\Business;

use App\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        return view('business.register');
    }

    /**
     * registerProcess
     *
     * @param Request $request
     * @return void
     */
    public function registerProcess(Request $request)
    {
        $this->validate($request, [
            'name'                 => 'required|min:4',
            'email'                => 'required|email|unique:business',
            'password'             => 'required|confirmed|min:6',
        ]);

        $business =  $request->all();
        $business['password'] = bcrypt($request->password);
        $business['image'] = "v1/images/defaults/avatar.png";
        $businessRemember = base64_encode($request->email);
        $business['remember_token'] = $businessRemember;
        $b = Business::create($business);

        $dataLogin = [
            'token' => $businessRemember
        ];

        $payload = [
            'user' => $business,
            'dataLogin' => $dataLogin
        ];

        Mail::send('business.email_verif', $payload, function ($message) use ($b) {

            $message
                ->from(env('MAIL_USERNAME'), 'Ayo Sekolah')
                ->to($b->email, 'Business Account')
                ->subject("Ayo Sekolah - Verifikasi Account");
        });

        return redirect('business/login')
            ->with(['success' => 'Register Succesfully, Please Confirm Email Verification']);
    }

    public function confirmEmail($token)
    {
        $check = Business::where('remember_token', $token)->first();

        if ($check) {
            $check->is_valid = 1;
            $check->update();

            return redirect('business/login')
                ->with(['success' => 'Confirmation Succesfully, Please Sign In']);
        } else {
            return redirect('business/login')
                ->with(['danger' => 'Confirmation Vailed, Please Register with Email is Valid']);
        }
    }

    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        return view('business.login');
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

        if (Auth::guard('busines')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $check = Auth::guard('busines')->user()->is_valid;
            if ($check == 0) {
                Auth::guard('busines')->logout();
                return redirect()->back()->with([
                    'error' => 'Account not Verified, Please Please Confirm Email Verification'
                ]);
            } else {
                return redirect()->intended('/business/dashboard');
            }
        } else {
            return redirect()->back()->with(['error' => 'Email or Password is Wrong']);
        }
    }

    public function logOut()
    {
        Auth::guard('busines')->logout();
        return redirect("business/login");
    }
}
