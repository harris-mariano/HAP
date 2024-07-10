<?php

namespace App\Http\Controllers;
use App\Models\User; 
use App\Models\Ticket; 
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

    
    public function dashboard () {
        $userId = Auth::guard('user')->id();

        $user = User::find($userId);
        $departmentId = $user->department->id; 
        $departmentName= $user->department->name;

        $userTickets = Ticket::where('employee_id', $userId)->count(); 

        $userNew= Ticket::where('employee_id', $userId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 1); 
                             })
                             ->count();
        $userInProgress = Ticket::where('employee_id', $userId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 2); 
                             })
                             ->count();
        $userResolved = Ticket::where('employee_id', $userId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 3); 
                             })
                             ->count();
        $userClosed = Ticket::where('employee_id', $userId)
                             ->whereHas('histories', function (Builder $query) {
                                 $query->where('status_id', 4); 
                             })
                             ->count();

        $userRequired = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 1)
                            ->count(); 
        $userLow = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 2)
                            ->count(); 
        $userMedium = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 3)
                            ->count(); 
        $userHigh = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 4)
                            ->count(); 

        $quarterOne = Ticket::where('employee_id', $userId)
                            ->whereMonth('created_at', '>=', 1)
                            ->whereMonth('created_at', '<=', 3)
                            ->count();

        $quarterTwo = Ticket::where('employee_id', $userId)
                            ->whereMonth('created_at', '>=', 4)
                            ->whereMonth('created_at', '<=', 6)
                            ->count();
        
        $quarterThree = Ticket::where('employee_id', $userId)
                            ->whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
        
        $quarterFour = Ticket::where('employee_id', $userId)
                            ->whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();
        
        $departmentOne = Ticket::where('department_id', $departmentId)
                            ->whereMonth('created_at', '>=', 1)
                            ->whereMonth('created_at', '<=', 3)
                            ->count();
        
        $departmentTwo = Ticket::where('department_id', $departmentId)
                            ->whereMonth('created_at', '>=', 4)
                            ->whereMonth('created_at', '<=', 6)
                            ->count();

        $departmentThree = Ticket::where('department_id', $departmentId)
                            ->whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
                            
        $departmentFour = Ticket::where('department_id', $departmentId)
                            ->whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();
        
        

        return view('user.dashboard', [
            'userTickets' => $userTickets,
            'userNew' => $userNew,
            'userInProgress' => $userInProgress,
            'userResolved' => $userResolved,
            'userClosed' => $userClosed,
            'userRequired' => $userRequired,
            'userLow' => $userLow, 
            'userMedium' => $userMedium,
            'userHigh' => $userHigh, 
            'quarterOne' => $quarterOne,
            'quarterTwo' => $quarterTwo,
            'quarterThree' => $quarterThree,
            'quarterFour' => $quarterFour, 
            'departmentName' => $departmentName,
            'departmentOne' => $departmentOne,
            'departmentTwo' => $departmentTwo,
            'departmentThree' => $departmentThree,
            'departmentFour' => $departmentFour]);
    }

    public function getUsers (Request $request) {
        $department = $request->input('department');
        $users = User::where('department', $department)->get();
        return response()->json($users);
    }
    
}
