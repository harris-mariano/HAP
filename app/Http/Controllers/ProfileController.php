<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\Customer; 
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class ProfileController extends Controller
{
    protected $mailtrapEmail; 

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
    }

    public function index () {
        return view ('profile');
    }

    public function update (Request $request, User $user, Customer $customer) {
        $validated = $request->validate([
            "first_name" => ['required'], 
            "middle_name" => ['nullable'],
            "last_name" => ['required'], 
            "profile_picture" => 'image|mimes:jpeg,png,bmp,tiff|max:2048',
        ]);

        if (Auth::guard('user')->check()){
            /** @var \App\Models\User $user **/
            $user = Auth::guard('user')->user();
            $user->fill($validated);

            if ($request->hasFile('profile_picture')) {
                $request->validate([
                    "profile_picture" => 'mimes:jpeg,png,bmp,tiff|max:2048'
                ]); 
                $uploadedFile = $request->file('profile_picture');
                $imagePath = $uploadedFile->store('profile_picture', 'public'); 
                $user->profile_picture = $imagePath;
            }

            $user->update(); 
            return back()->with('message', 'Your profile has been updated successfully.'); 
        }
        else if(Auth::guard('customer')->check()){
            /** @var \App\Models\Customer $customer **/
            $customer = Auth::guard('customer')->user();
            $customer->fill($validated); 

            if ($request->hasFile('profile_picture')) {
                $request->validate([
                    "profile_picture" => 'mimes:jpeg,png,bmp,tiff|max:2048'
                ]); 
                $uploadedFile = $request->file('profile_picture');
                $imagePath = $uploadedFile->store('profile_picture', 'public'); 
                $customer->profile_picture = $imagePath;
            }

            $customer->update();
            return back()->with('message', 'Your profile has been updated successfully.'); 
        }
    }

    public function reset () {

        if (Auth::guard('user')->check()){
            $user = Auth::guard('user')->user();

            Mail::to($this->mailtrapEmail)->send(new UserMail($user->first_name, 'reset_password'));
            return view ('authentication.verify', ['user' => $user]); 
        }
        else if(Auth::guard('customer')->check()){
            $customer = Auth::guard('customer')->user();

            Mail::to($this->mailtrapEmail)->send(new UserMail($customer->first_name, 'reset_password'));
            return view ('authentication.verify', ['customer' => $customer]); 
        }

    }
}

