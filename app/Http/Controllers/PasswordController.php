<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class PasswordController extends Controller
{
    protected $mailtrapEmail;

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
    }

    public function index () {
        return view ('authentication.verify'); 
    }

    public function sendEmail (Request $request) {
        $validated = $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $user = User::where('email', $validated['email'])->first();
        //does not exist
        if (!$user) {
            return back()->withErrors(['email' => 'The selected email is invalid'])->onlyInput('email');
        }
        //inactive account
        if ($user->type_id == 2) {
            return back()->withErrors(['email' => 'Your account is inactive. Please contact administrator for assistance. 
            '])->onlyInput('email'); 
        }
        //for authenticated user 
        if (Auth::guard('user')->check()) {
            $authUser = Auth::guard('user')->user();
            if ($authUser->email !== $validated['email']) {
                return back()->withErrors(['email' => 'This email is not associated with this authenticated user.'])->onlyInput('email');
            }
        } else {
            //for newly created accounts
            if ($request->session()->has('email')) {
                $sessionEmail = $request->session()->get('email');
                if ($sessionEmail !== $validated['email']) {
                    return back()->withErrors(['email' => 'This email is not associated with the email provided in login.'])->onlyInput('email');
                }
                $request->session()->forget('email');
            }
        }
        //success and forgot password 
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $validated['email'],
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(60),
        ]);
        $request->session()->forget('email');
        Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'reset_password', null, null, null, null, null, null, null, $token));
        return view ('authentication.confirmation'); 
    }

    public function resetPassword ($token) {
        $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$resetToken || Carbon::parse($resetToken->expires_at)->isPast()) {

            return view('authentication.expired');
        }

        $email = $resetToken->email;
        return view('authentication.reset', [
            'token' => $token, 
            'email' => $email]);
    }

    public function resetUserPassword(Request $request) {
        $validated = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed', 
                'regex:/[a-z]/', 
                'regex:/[A-Z]/', 
                'regex:/[0-9]/', 
                'regex:/[@$!%*#?&]/', 
            ],
        ]);

        $resetToken = DB::table('password_reset_tokens')
        ->where('token', $validated['token'])
        ->where('email', $validated['email'])
        ->first();

        if (!$resetToken || Carbon::parse($resetToken->expires_at)->isPast()) {
            return view('authentication.expired');
        }

        $user = User::where('email', $validated['email'])->first();

        //check old password
        if (Hash::check($validated['password'], $user->password)) {
            return redirect()->back()->withErrors(['password' => 'The new password cannot be the same as the old password.']);
        }
        $user->password = Hash::make($validated['password']);
        $user->is_new = false; //to handle newly created accounts
        $user->save();

        DB::table('password_reset_tokens')->where(['token' => $validated['token']])->delete(); 

        if (Auth::guard('user')->check()){
            Auth::guard('user')->logout();
        }

        Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'password_changed'));
        return redirect()->intended('/')->with('message', 'Your password has been updated successfully.');
    }
}
