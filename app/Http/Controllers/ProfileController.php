<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\Company;
use App\Models\Department;
use App\Models\Role; 
use Illuminate\Validation\Rule;

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

    public function show ($id) {
        $user = User::findOrFail($id);
        $companies = Company::all();
        $departments = Department::where('company_id', $user->company_id)->get();

        //if not from adish, customer role only
        if ($user->company_id != 1) {
            $roles = Role::where('id', 3)->get();
        }
        //if from adish, can be any role
        else {
            $roles = Role::all();
        }

        return view ('user.edit-profile', [
            'user' => $user,
            'companies' => $companies, 
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }

    public function update (Request $request, User $user) {
        $validated = $request->validate([
            "first_name" => 'required|string|min:2|max:30',
            "middle_name" => 'nullable|string|min:2|max:30',
            "last_name" => 'required|string|min:2|max:30',
            "profile_picture" => 'nullable|image|mimes:jpeg,png,bmp,tiff|max:2048',
        ]);

        if (Auth::guard('user')->check()){
            /** @var \App\Models\User $user **/
            $user = Auth::guard('user')->user();
            $user->fill($validated);

            if ($request->hasFile('profile_picture')) {
                $uploadedFile = $request->file('profile_picture');
                $imagePath = $uploadedFile->store('profile_picture', 'public'); 
                $user->profile_picture = $imagePath;
            }

            $user->update(); 
            return back()->with('message', 'Your profile has been updated successfully.'); 
        }
    }

    public function change (Request $request, User $user) {
        $validated = $request->validate([
            "first_name" => 'required|string|min:2|max:30',
            "middle_name" => 'nullable|string|min:2|max:30',
            "last_name" => 'required|string|min:2|max:30',
            "profile_picture" => 'nullable|image|mimes:jpeg,png,bmp,tiff|max:2048',
            "role_id" => 'required',
            "email" => 'required|email',
            "company_id" => 'required',
            "department_id" => 'required',
            "position" => 'required|string|min:5|max:30',
        ]);

        $user->fill($validated); 

        if ($request->hasFile('profile_picture')) {
            $uploadedFile = $request->file('profile_picture');
            $imagePath = $uploadedFile->store('profile_picture', 'public'); 
            $user->profile_picture = $imagePath;
        }
        
        $user->update(); 
        return back()->with('message', 'The user profile has been updated successfully.'); 
    }

    public function status (Request $request, User $user) {
        $validated = $request->validate([
            'type_id' => ['required', 'numeric', Rule::in([1, 2])]
        ]); 

        /** @var \App\Models\User $user **/
        $user->update($validated);

        return redirect()->back()->with('message', 'The user status has been updated successfully.');
    }
}

