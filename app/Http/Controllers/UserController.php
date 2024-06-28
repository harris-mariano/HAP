<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{   
    protected $mailtrapEmail, $oneTimePassword;

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
        $this->oneTimePassword = env('PASSWORD');
    }

    public function forms () {
        return view ('user.fields', ['password' => $this->oneTimePassword]); 
    }

    public function register(Request $request) {
        $validated = $request->validate([
            "profile_picture" => 'image|mimes:jpeg,png,bmp,tiff|max:2048', 
            "email" => ['required', Rule::unique('users', 'email')],
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
            "department" => ['required'],
            "position" => ['required'],
        ]); 

        $hashedPassword = Hash::make($validated['password']);
        $validated['password'] = $hashedPassword;
    
        $user = new User();
        $user->fill($validated);
    
        if ($request->hasFile('profile_picture')) {
            $request->validate([
                "profile_picture" => 'mimes:jpeg,png,bmp,tiff|max:2048'
            ]); 
            $uploadedFile = $request->file('profile_picture');
            $imagePath = $uploadedFile->store('profile_picture', 'public'); 
            $user->profile_picture = $imagePath;
        }
        
        $user->save();
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
            return view('authentication.verify', ['email' => $validated['email'], ]);
        }

        //for superuser
        else if (auth()->attempt($validated)){
            $request->session()->regenerate();
            return view ('user.fields', ['password' => $this->oneTimePassword]); 
        }

        return back()->withErrors(['email' => 'The email and password do not match.'])->onlyInput('email'); 
    }

    public function view () {
        $user = Auth::user();

        return view('authentication.verify', ['user' => $user]); 
    }

    public function dashboard () {

        return view('user.dashboard', [
            'name' => 'Kali Landicho', 
            'position' => 'Human Resource Officer',
            'company' => 'adish International Corporation', 
            'allTickets' => '20',
            'openTickets' => '5',
            'inProgressTickets' => '5',
            'resolvedTickets' => '5',
            'closedTickets' => '5'
        ]);
    }


}
