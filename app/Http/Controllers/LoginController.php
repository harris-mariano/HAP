<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{

    public function index()
    {
        return view('authentication.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('user')->user();

            //for newly created and active accounts
            if ($user->is_new == true && $user->type_id == 1) {
                $request->session()->put('email', $request->email);
                return redirect()->route('view.reset');
            }

            //for old and active accounts
            else if ($user->is_new == false && $user->type_id == 1){
                return redirect()->intended('/dashboard/user');
            }

            //for inactive accounts
            else {
                return back()->withErrors(['email' => 'Your account is inactive. Please contact administrator for assistance.
                '])->onlyInput('email');
            }
        }
        else {
            return back()->withErrors(['email' => 'Invalid credentials. Make sure you are a registered user.'])->onlyInput('email');
        }
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->intended('/');
        $request->session()->forget('email');
    }

    public function loginWithGoogle () {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback () {
        try {
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();
            $domain = substr(strrchr($email, "@"), 1);

            if ($domain !== 'adish.com') {
                return back()->withErrors(['email' => 'Only users with company related email addresses are permitted to log in.']);
            }

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'first_name' => $googleUser->user['given_name'],
                    'last_name' => $googleUser->user['family_name'],
                    'email' => $googleUser->user['email'],
                    'profile_picture' => $googleUser->user['picture'],
                    'company_id' => 1, //default - adish
                    'department_id' => 1, //default - hrad
                    'role_id' => 3, //default - customer
                    'type_id' => 1, //default - active
                    'is_new' => false, //default - not new
                    'is_google_login' => true, //true
                    'position' => 'Employee', //default
                    'password' => bcrypt(Str::random(40)) //random
                ]);
            }

            if ($user->type_id != 1) {
                return back()->withErrors(['email' => 'Your account is inactive. Please contact administrator for assistance']);
            }

            Auth::guard('user')->login($user);
            return redirect('/dashboard/user');
        }
        catch (\Exception $e) {
            return back()->withErrors(['email' => 'Something went wrong with Google authentication']);
        }
    }
}
