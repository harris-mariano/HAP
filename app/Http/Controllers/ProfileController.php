<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
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
        return view ('user.profile');
    }

    public function update (Request $request, User $user) {
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
    }
}

