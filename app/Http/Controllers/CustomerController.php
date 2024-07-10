<?php

namespace App\Http\Controllers;

use App\Mail\UserMail;
use App\Models\Customer;
use App\Models\Article;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

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
        
            $customer = new Customer();
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


    public function dashboard () {
        $customerId = Auth::guard('customer')->id();

        $customerTickets = Ticket::where('customer_id', $customerId)->count(); 
        $customerNew= Ticket::where('customer_id', $customerId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 1); 
                             })
                             ->count();
        $customerInProgress = Ticket::where('customer_id', $customerId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 2); 
                             })
                             ->count();
        $customerResolved = Ticket::where('customer_id', $customerId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 3); 
                             })
                             ->count();
        $customerClosed = Ticket::where('customer_id', $customerId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 4); 
                             })
                             ->count();

        $articles = Article::simplePaginate(15);

        return view('customer.dashboard', [
            'customerTickets' => $customerTickets,
            'customerNew' => $customerNew,
            'customerInProgress' => $customerInProgress,
            'customerResolved' => $customerResolved,
            'customerClosed' => $customerClosed, 
            'articles' => $articles]);
    }
}

