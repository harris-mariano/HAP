<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{   
    protected $mailtrapEmail, $oneTimePassword;

    public function __construct()
    {

        $this->oneTimePassword = env('PASSWORD');
        $this->mailtrapEmail = env('EMAIL');
    }

    
    public function index()
    {
        return view('authentication.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('user')->user();

            //for newly created accounts
            if ($request->password == ($this->oneTimePassword) && $user->type_id == 1) {
                return redirect()->route('view.reset');
            }

            //for old accounts
            else if ($request->password !== ($this->oneTimePassword) && $user->type_id == 1){
                return redirect()->intended('/dashboard/user');
            }

            //for inactive accounts
            else {
                return back()->withErrors(['email' => 'Your account is inactive. Please contact administrator for assistance. 
                '])->onlyInput('email'); 
            }
        }
        else {
            return back()->withErrors(['email' => 'Invalid credentials. Make sure you are a registered user or customer.'])->onlyInput('email'); 
        }
    }

    public function logout()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect()->intended('/');
        }

        return redirect('/');
    }

}
