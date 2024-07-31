<?php

namespace App\Http\Controllers;
use App\Models\User; 
use App\Models\Ticket; 
use App\Models\Company; 
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;
use App\Models\Department;
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

    public function index () {
        $allUsers = User::orderBy('created_at', 'desc')
        ->simplePaginate(10, ['*'], 'allUsers');

        $companies = Company::all();

        $allCompanies = Company::orderBy('created_at', 'desc')
        ->simplePaginate(10, ['*'], 'allCompanies');

        $allDepartments = Department::orderBy('created_at', 'desc')
        ->simplePaginate(10, ['*'], 'allDepartments');
        
        return view ('user.all-users', [
            'allUsers' => $allUsers, 
            'companies' => $companies, 
            'password' => $this->oneTimePassword, 
            'allCompanies' => $allCompanies,
            'allDepartments' => $allDepartments]); 
    }

    public function update (Request $request, User $user) {
        $validated = $request->validate([
            'type_id' => ['required', 'numeric', Rule::in([1, 2])]
        ]); 

        $user->type_id = $validated['type_id'];  
        $user->save();

        return redirect()->back()->with('message', 'The user status has been updated successfully.');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "profile_picture" => 'image|mimes:jpeg,png,bmp,tiff|max:2048', 
            "email" => ['required', Rule::unique('users', 'email')],
            'password' => ['required'], //already defined in view 
            "first_name" => ['required'],
            "last_name" => ['required'],
            "company" => ['required'],
            "department" => ['required'],
            "position" => ['required'],
            "superuser" => ['nullable', 'boolean']
        ]); 

        $hashedPassword = Hash::make($validated['password']);
        $validated['password'] = $hashedPassword;

        $role_id = $validated['company'] == 1 
        ? ($request->input('superuser') == '1' ? 1 : 2) 
        : 3;


        $user = new User();
        $user->type_id = 1; 
        $user->department_id = $validated['department']; 
        $user->company_id = $validated['company'];
        $user->role_id = $role_id;
        $user->fill($validated);
    
        if ($request->hasFile('profile_picture')) {
            $uploadedFile = $request->file('profile_picture');
            $imagePath = $uploadedFile->store('profile_picture', 'public'); 
            $user->profile_picture = $imagePath;
        }
        
        $user->save();
        Mail::to($this->mailtrapEmail)->send(new UserMail($validated['first_name'], 'registration'));
        $request->session()->put('email', $validated['email']);
        return redirect()->back()->with('message', 'The user has been successfully created.');
    } 

    
    public function dashboard () {
        $userId = Auth::guard('user')->id();

        $user = User::find($userId);
        $departmentId = $user->department->id; 
        $departmentName= $user->department->name;

        //for customer 
        $customerTickets = Ticket::where('user_id', $userId)->count(); 
        $customerNew= Ticket::where('user_id', $userId)
                            ->where('status_id', 1)
                            ->count();

        $customerInProgress = Ticket::where('user_id', $userId)
                            ->where('status_id', 2)
                            ->count();

        $customerResolved = Ticket::where('user_id', $userId)
                            ->where('status_id', 3)
                            ->count();

        $customerClosed = Ticket::where('user_id', $userId)
                            ->where('status_id', 4)
                            ->count();

        $customerRequired = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 1)
                            ->count(); 

        $customerLow = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 2)
                            ->count(); 

        $customerMedium = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 3)
                            ->count(); 

        $customerHigh = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 4)
                            ->count(); 

        $customerQuarterOne = Ticket::where('user_id', $userId)
                            ->whereMonth('created_at', '>=', 1)
                            ->whereMonth('created_at', '<=', 3)
                            ->count();

        $customerQuarterTwo = Ticket::where('user_id', $userId)
                            ->whereMonth('created_at', '>=', 4)
                            ->whereMonth('created_at', '<=', 6)
                            ->count();
        
        $customerQuarterThree = Ticket::where('user_id', $userId)
                            ->whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
        
        $customerQuarterFour = Ticket::where('user_id', $userId)
                            ->whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();

        $customerDepartmentOne = Ticket::whereMonth('created_at', '>=', 1)
                            ->whereMonth('created_at', '<=', 3)
                            ->count();
        
        $customerDepartmentTwo = Ticket::whereMonth('created_at', '>=', 4)
                            ->whereMonth('created_at', '<=', 6)
                            ->count();

        $customerDepartmentThree = Ticket::whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
                            
        $customerDepartmentFour = Ticket::whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();
        //for user 
        $userTickets = Ticket::where('employee_id', $userId)->count(); 

        $userNew= Ticket::where('employee_id', $userId)
                            ->where('status_id', 1)
                            ->count();
        $userInProgress = Ticket::where('employee_id', $userId)
                            ->where('status_id', 2)
                            ->count();
        $userResolved = Ticket::where('employee_id', $userId)
                            ->where('status_id', 3)
                            ->count();
        $userClosed = Ticket::where('employee_id', $userId)
                            ->where('status_id', 4)
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

        //for superuser
        $allTickets = Ticket::count(); 

        $allNew= Ticket::where('status_id', 1)->count();

        $allInProgress = Ticket::where('status_id', 2)->count();

        $allResolved = Ticket::where('status_id', 3) ->count();
                                               
        $allClosed = Ticket::where('status_id', 4)->count();

        $allRequired = Ticket::where('priority_id', 1) ->count(); 
    
        $allLow = Ticket::where('priority_id', 2)->count(); 
                            
        $allMedium = Ticket::where('priority_id', 3)->count(); 

        $allHigh = Ticket::where('priority_id', 4)->count(); 


        $hradOne = Ticket::where('department_id', 1)
                            ->whereMonth('created_at', '>=', 1)
                            ->whereMonth('created_at', '<=', 3)
                            ->count();

        $hradTwo = Ticket::where('department_id', 1)
                            ->whereMonth('created_at', '>=', 4)
                            ->whereMonth('created_at', '<=', 6)
                            ->count();
        
        $hradThree = Ticket::where('department_id', 1)
                            ->whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
        
        $hradFour = Ticket::where('department_id', 1)
                            ->whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();
        
        $bananaOne = Ticket::where('department_id', 2)
                            ->whereMonth('created_at', '>=', 1)
                            ->whereMonth('created_at', '<=', 3)
                            ->count();
        
        $bananaTwo = Ticket::where('department_id', 2)
                            ->whereMonth('created_at', '>=', 4)
                            ->whereMonth('created_at', '<=', 6)
                            ->count();

        $bananaThree = Ticket::where('department_id', 2)
                            ->whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
                            
        $bananaFour = Ticket::where('department_id', 2)
                            ->whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();

        
        $isSuperuser = $user->isSuperUser();
        $isUser = $user->isUser();

        if ($isSuperuser) {
            return view('user.dashboard', [
                'userTickets' => $allTickets,
                'userNew' => $allNew,
                'userInProgress' => $allInProgress,
                'userResolved' => $allResolved,
                'userClosed' => $allClosed,
                'userRequired' => $allRequired,
                'userLow' => $allLow, 
                'userMedium' => $allMedium,
                'userHigh' => $allHigh, 
                'quarterOne' => $hradOne,
                'quarterTwo' => $hradTwo,
                'quarterThree' => $hradThree,
                'quarterFour' => $hradFour, 
                'departmentName1' => 'HRAD',
                'departmentName2' => 'Team Banana',
                'departmentOne' => $bananaOne,
                'departmentTwo' => $bananaTwo,
                'departmentThree' => $bananaThree,
                'departmentFour' => $bananaFour]);
        }
        elseif ($isUser) {
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
                'departmentName1' => 'My',
                'departmentName2' => $departmentName,
                'departmentOne' => $departmentOne,
                'departmentTwo' => $departmentTwo,
                'departmentThree' => $departmentThree,
                'departmentFour' => $departmentFour]);
        }
        else {
            return view('user.dashboard', [
                'userTickets' => $customerTickets,
                'userNew' => $customerNew,
                'userInProgress' => $customerInProgress,
                'userResolved' => $customerResolved,
                'userClosed' => $customerClosed,
                'userRequired' => $customerRequired,
                'userLow' => $customerLow, 
                'userMedium' => $customerMedium,
                'userHigh' => $customerHigh, 
                'quarterOne' => $customerQuarterOne,
                'quarterTwo' => $customerQuarterTwo,
                'quarterThree' => $customerQuarterThree,
                'quarterFour' => $customerQuarterFour, 
                'departmentName1' => 'My',
                'departmentName2' => 'All',
                'departmentOne' => $customerDepartmentOne,
                'departmentTwo' => $customerDepartmentTwo,
                'departmentThree' => $customerDepartmentThree,
                'departmentFour' => $customerDepartmentFour]);
        }

    }

    public function getUsers (Request $request) {
        $department = $request->input('department');
        $users = User::where('department_id', $department)
                ->where('role_id', '!=', 1) //exclude superuser
                ->get();
        return response()->json($users);
    }

    public function getDepartments (Request $request) {
        $company = $request->input('company');
        $departments = Department::where('company_id', $company)->get();
        return response()->json($departments);
    }

    
}
