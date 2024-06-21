<?php

namespace App\Http\Controllers;

use App\Mail\UserMail;
use App\Models\Customers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    protected $mailtrapEmail, $oneTimePassword;

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
        $this->oneTimePassword = env('PASSWORD'); 
    }

    public function forms () {
        return view ('customer.fields', ['password' => $this->oneTimePassword]); 
    }

    public function register(Request $request) {
            $validated = $request->validate([
                "profile_picture" => 'image|mimes:jpeg,png,bmp,tiff|max:2048', 
                "email" => ['required', Rule::unique('customers', 'email')],
                'password' => [
                    'required',
                    'string',
                    'min:8',             
                    'regex:/[a-z]/',      
                    'regex:/[A-Z]/',      
                    'regex:/[0-9]/',     
                    'regex:/[@$!%*#?&]/', 
                ],
                "first_name" => ['required'],
                "last_name" => ['required'],
                "company" => ['required'],
                "position" => ['required'],
            ]); 

            $hashedPassword = Hash::make($validated['password']);
            $validated['password'] = $hashedPassword;
        
            $customer = new Customers();
            $customer->fill($validated);
        
            if ($request->hasFile('profile_picture')) {
                $request->validate([
                    "profile_picture" => 'mimes:jpeg,png,bmp,tiff|max:2048'
                ]); 
                $uploadedFile = $request->file('profile_picture');
                $imagePath = $uploadedFile->store('profile_picture', 'public'); 
                $customer->profile_picture = $imagePath;
            }
            $customer->save();
            Mail::to($this->mailtrapEmail)->send(new UserMail($validated['email']));
            $request->session()->put('email', $validated['email']);
            return view('authentication.login'); 
    } 

    public function process (Request $request) {
        $validated = $request->validate([
            "email" => ['required', 'email'], 
            "password" => 'required'
        ]); 

        //for reset password
        if ($validated['password'] === ($this->oneTimePassword)) {
            $request->session()->regenerate();
            return view('authentication.verify', ['email' => $validated['email']]);
        }

        //for superuser
        else if (auth()->attempt($validated)){
            $request->session()->regenerate();
            return view ('user.fields', ['password' => $this->oneTimePassword]); 
        }

        return back()->withErrors(['email' => 'The email and password do not match.'])->onlyInput('email'); 
    }


}

