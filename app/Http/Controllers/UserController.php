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
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{   
    protected $mailtrapEmail;

    public function __construct()
    {
        $this->mailtrapEmail = env('EMAIL');
    }

    public function index () {
        $allUsers = User::orderBy('created_at', 'desc')
        ->simplePaginate(10, ['*'], 'allUsers');
                    
        return view ('user.all-users', [
            'allUsers' => $allUsers]); 
    }

    public function create () {
        //random password
        $password = Str::random(12);

        $companies = Company::all();
        $departments = Department::where('company_id', old('company_id'))
                    ->get();

        return view ('user.create-user', [
            'password' => $password, 
            'companies' => $companies, 
            'departments' => $departments]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "profile_picture" => 'nullable|image|mimes:jpeg,png,bmp,tiff|max:2048', 
            "email" => ['required', Rule::unique('users', 'email')],
            'password' => 'required',
            "first_name" => 'required|string|min:2|max:30',
            "middle_name" => 'nullable|string|min:2|max:30',
            "last_name" => 'required|string|min:2|max:30',
            "company_id" => 'required',
            "department_id" => 'required',
            "position" => 'required|string|min:5|max:30',
            "superuser" => 'nullable|boolean'
        ]); 

        $hashedPassword = Hash::make($validated['password']);
        $validated['password'] = $hashedPassword;

        $role_id = $validated['company_id'] == 1 
        ? ($request->input('superuser') == '1' ? 1 : 2) 
        : 3;

        $user = new User();
        $user->type_id = 1; //active
        $user->role_id = $role_id;
        $user->is_new = true; //newly created account
        $user->fill($validated);
    
        if ($request->hasFile('profile_picture')) {
            $uploadedFile = $request->file('profile_picture');
            $imagePath = $uploadedFile->store('profile_picture', 'public'); 
            $user->profile_picture = $imagePath;
        }
        
        $user->save();
        Mail::to($this->mailtrapEmail)->send(new UserMail($validated['first_name'], 'registration'));
        // $request->session()->put('email', $validated['email']);
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

        $customerLow = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 1)
                            ->count(); 

        $customerMedium = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 2)
                            ->count(); 

        $customerHigh = Ticket::where('user_id', $userId)
                            -> where ('priority_id', 3)
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
        $customerDepartment = [];
        $customerSeries = [];
        $customerSeries = [
            [
                'name' => "My Tickets",
                'data' => [$customerQuarterOne, $customerQuarterTwo, $customerQuarterThree, $customerQuarterFour],
                'color' => '#E88504'
            ]
        ];
        $customerDepartment[] = [
            'name' => " All Tickets",
            'data' => [$customerDepartmentOne, $customerDepartmentTwo, $customerDepartmentThree, $customerDepartmentFour],
            'color' => '#9CA3AF',
        ]; 
                    
        $customerDepartmentData = array_merge($customerSeries, $customerDepartment);
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
                        
        $userLow = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 1)
                            ->count(); 
        $userMedium = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 2)
                            ->count(); 
        $userHigh = Ticket::where('employee_id', $userId)
                            -> where ('priority_id', 3)
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
        
        $departmentSeries = [];
        $employeeSeries = [];
        $employeeSeries = [
            [
                'name' => "My Tickets",
                'data' => [$quarterOne, $quarterTwo, $quarterThree, $quarterFour],
               'color' => '#E88504'
            ]
        ];
        $departmentSeries[] = [
            'name' => $departmentName ." Tickets",
            'data' => [$departmentOne, $departmentTwo, $departmentThree, $departmentFour],
            'color' => '#9CA3AF',
            ]; 

        $userDepartment = array_merge($employeeSeries, $departmentSeries);

        //for superuser
        $allTickets = Ticket::count(); 

        $allNew= Ticket::where('status_id', 1)->count();

        $allInProgress = Ticket::where('status_id', 2)->count();

        $allResolved = Ticket::where('status_id', 3) ->count();
                                               
        $allClosed = Ticket::where('status_id', 4)->count();

        $allLow = Ticket::where('priority_id', 1)->count(); 
                            
        $allMedium = Ticket::where('priority_id', 2)->count(); 

        $allHigh = Ticket::where('priority_id', 3)->count(); 
        
        $departments = Department::where('company_id', 1)
        ->get(); 
        $colorPattern = ['#E88504', '#9CA3AF'];
        
        $departmentData = [];

        foreach($departments as $index => $department) {
            $quarterOne = Ticket::where('department_id', $department->id)
                        ->whereMonth('created_at', '>=', 1)
                        ->whereMonth('created_at', '<=', 3)
                        ->count();
            $quarterTwo = Ticket::where('department_id', $department->id)
                        ->whereMonth('created_at', '>=', 4)
                        ->whereMonth('created_at', '<=', 6)
                        ->count();
            $quarterThree = Ticket::where('department_id', $department->id)
                            ->whereMonth('created_at', '>=', 7)
                            ->whereMonth('created_at', '<=', 9)
                            ->count();
            $quarterFour = Ticket::where('department_id', $department->id)
                            ->whereMonth('created_at', '>=', 10)
                            ->whereMonth('created_at', '<=', 12)
                            ->count();
            
            $departmentData[] = [
                'name' => $department->name ." Tickets",
                'data' => [$quarterOne, $quarterTwo, $quarterThree, $quarterFour],
                'color' => $colorPattern[$index % 2],
                ]; 
        }
        $isSuperuser = $user->isSuperUser();
        $isUser = $user->isUser();

        if ($isSuperuser) {
            return view('user.dashboard', [
                'userTickets' => $allTickets,
                'userNew' => $allNew,
                'userInProgress' => $allInProgress,
                'userResolved' => $allResolved,
                'userClosed' => $allClosed,
                'userLow' => $allLow, 
                'userMedium' => $allMedium,
                'userHigh' => $allHigh, 
                'departmentData' => $departmentData]); 
        }
        elseif ($isUser) {
            return view('user.dashboard', [
                'userTickets' => $userTickets,
                'userNew' => $userNew,
                'userInProgress' => $userInProgress,
                'userResolved' => $userResolved,
                'userClosed' => $userClosed,
                'userLow' => $userLow, 
                'userMedium' => $userMedium,
                'userHigh' => $userHigh, 
                'departmentData' => $userDepartment]);
        }
        else {
            return view('user.dashboard', [
                'userTickets' => $customerTickets,
                'userNew' => $customerNew,
                'userInProgress' => $customerInProgress,
                'userResolved' => $customerResolved,
                'userClosed' => $customerClosed,
                'userLow' => $customerLow, 
                'userMedium' => $customerMedium,
                'userHigh' => $customerHigh, 
                'departmentData' => $customerDepartmentData]);
        }

    }

    public function getUsers (Request $request) {
        $department = $request->input('department');
        $users = User::where('department_id', $department)
                ->where('type_id', '=', 1) //active account
                ->where('is_new', '=', false) //not newly created account
                ->get();
        return response()->json($users);
    }

    public function getDepartments (Request $request) {
        $company = $request->input('company');
        $departments = Department::where('company_id', $company)->get();
        return response()->json($departments);
    }

}
