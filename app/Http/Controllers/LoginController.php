<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    }

}
