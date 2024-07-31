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
    protected $mailtrapEmail, $oneTimePassword;

    public function __construct()
    {
        $this->oneTimePassword = env('PASSWORD');
        $this->mailtrapEmail = env('EMAIL');
    }

    public function reset () {
        return view ('authentication.verify'); 
    }

    public function sendEmail (Request $request) {
        $validated = $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $token = Str::random(length:64);

        DB::table('password_reset_tokens')->insert([
            'email' => $validated['email'],
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(60),
        ]); 

        if (Auth::guard('user')->check()){
            $user = Auth::guard('user')->user();
            Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'reset_password', null, null, null, null, null, null, $token));
        }
        else {
            Mail::to($this->mailtrapEmail)->send(new UserMail($validated['email'], 'reset_password', null, null, null, null, null, null, $token));

        }

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

        if ($validated['password'] == ($this->oneTimePassword)) {
            return back()->withErrors([
                'password' => 'The password you entered cannot be the company-defined one-time password.',
            ]);
        }

        $user = User::where('email', $validated['email'])->first();
        $user->password = Hash::make($validated['password']);
        $user->save();

        DB::table('password_reset_tokens')->where(['token' => $validated['token']])->delete(); 

        if (Auth::guard('user')->check()){
            Auth::guard('user')->logout();
        }
        Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'password_changed'));
        return redirect()->intended('/')->with('message', 'Your password has been updated successfully.');
    }
}
