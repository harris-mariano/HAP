<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class ContactController extends Controller
{
    protected $mailtrapEmail; 

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
    }

    public function index () {
        return view('components.contact');
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'name' => 'required|min:10|max:30',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]); 

        Mail::to($this->mailtrapEmail)->send(new UserMail($validated['name'], 'new_message', $validated['email'], $validated['message'], null, null, null, null, null, null));

        return back()->with('message', 'We have received your message successfully. Thank you for your input!');
    }
    
}
