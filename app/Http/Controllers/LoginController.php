<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:user')->except('logout');
        $this->middleware('guest:customer')->except('logout');
    }

    
    public function showUserLogin()
    {
        return view('authentication.login', ['url' => 'user']);
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard/user');
        }
        else {
            return back()->withErrors(['email' => 'Invalid credentials. Make sure you are a registered user.'])->onlyInput('email'); 
        }
    }

    public function showCustomerLogin()
    {
        return view('authentication.login');
    }

    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard/customer');
        }
        else {
            return back()->withErrors(['email' => 'Invalid credentials. Make sure you are a registered customer.'])->onlyInput('email'); 
        }
    }

    public function logout()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect()->intended('/login/user');
        }

        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            return redirect()->intended('/');
        }

        return redirect('/');
    }

}
