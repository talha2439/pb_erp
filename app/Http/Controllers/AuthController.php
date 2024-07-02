<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view("Auth.login");
    }
    public function forget_password()
    {
        return view("Auth.forget_password");
    }
    public function profile_settings($id = null)
    {
        try {
            $id =   decrypt($id);
            $data['user'] = User::find($id);
            return view("Auth.profile_setting", $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function verify(Request $request)
    {
        try {
            $checkEmail  = User::where('email', $request->email)->first();
            $type        = $request->query('type');
            if ($checkEmail)  {
                if ($type == 'forgetpassword') {
                    $token = md5(time());
                    $checkToken   = DB::table('password_reset_tokens')->where('email', $request->email)->count();
                    if($checkToken > 0) {
                        return response()->json(['exists' => true]);
                    }
                    $storePassword = DB::table('password_reset_tokens')->insert([
                        'email' => $checkEmail->email,
                        'token' => $token,
                    ]);
                    $messageSent  =  Mail::send('email_templates.forgetpassword', ['user' => $checkEmail , 'token' => $token], function ($message)  use ($checkEmail) {
                        $message->to($checkEmail->email, $checkEmail->name)->subject('Reset Password');
                        $message->from(env("MAIL_FROM_ADDRESS"), env('MAIL_FROM_NAME'));
                    });
                    if ($messageSent) {
                        return response()->json(['success' => true]);
                    } else {
                        return response()->json(['error' => true]);
                    }
                }
            } else {
                return response()->json(['invalid' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function authenticate(Request $request)
    {
        $credientals  = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credientals)) {

            if (empty(Auth::user()->email_verified_at)) {
                return redirect()->back()->with('error', 'Your account is not verified..! Please verify your email');
            }
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }
    public function password_reset_view(Request $request)
    {
        try {
            $data['email']  =  decrypt($request->query('email'));
            $data['token']  =  $request->query('token');
            $checkEmail  = User::where(['email' => $data['email']])->first();
            $checkToken  = DB::table('password_reset_tokens')->where(['token' => $data['token'] , 'email' => $data['email']])->first();
            if($checkToken){
            if ($checkEmail) {
                return view('Auth.password_reset', $data)->with('success', 'Verification successful .  You can now reset your password!');
            } else {
                return redirect(route('login'))->with('error', 'Failed to verify your password!');
            }
          }
          else{
            return redirect(route('auth.login'))->with('error', 'Invalid or expired token!');
          }
        } catch (\Exception $e) {
            return redirect(route('auth.login'))->with('error', $e->getMessage());
        }
    }
    public function password_reset(Request $request)
    {
        try {
            $userData = User::where('email', $request->email)->first();
            if ($userData) {
                $userData->update(['password' => Hash::make($request->password) , 'password_txt' => $request->password]);
                DB::table('password_reset_tokens')->where(['email' => $request->email , 'token' => $request->token])->delete();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
