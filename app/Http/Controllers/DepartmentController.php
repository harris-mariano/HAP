<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{   
    public function index () {
        $allDepartments = Department::orderBy('created_at', 'desc')
                    ->simplePaginate(10, ['*'], 'allDepartments');

        return view('departments.all-departments', ['allDepartments' => $allDepartments]);
    }
    public function create() {
        $companies = Company::all();

        return view('departments.add-department', [
            'companies' => $companies
        ]);
    }

    public function store (Request $request) {
        $messages = [
            'departments.*.name.min' => 'The department name must be at least 10 characters',
        ];
        
        $validated = $request->validate([
            'company' => 'required|integer|exists:companies,id',
            'departments.*.name' => 'required|string|min:10'
        ], $messages);

        $departments = $request->input('departments',[]);
        $passedDepartments = array_column($departments, 'name');
        $dbDepartments = Department::where('company_id', $validated['company'])->pluck('name')->toArray();
        $allDepartments = array_merge($passedDepartments,$dbDepartments);
        $uniqueDepartments = array_unique($allDepartments);

        if (count($uniqueDepartments) !== count($allDepartments)) {
            return back()->withErrors(['departments.*.name' => 'The department name has already been taken.']);
        }
        
        foreach ($request->input('departments') as $department) {
            Department::create([
                'name' => $department['name'],
                'company_id' => $validated['company'],
            ]);
        }

        return back()->with('message', 'Your department has been created successfully.');
    }

    public function show ($id) {
        $department = Department::findOrFail($id); 
        $companies = Company::all();
        $departments = Department::where('company_id', $department->company_id)->get();

        return view('departments.edit-department', [
            'department' => $department,
            'companies' => $companies,
            'departments' => $departments,
            ]); 
    }

    public function update (Request $request, Department $department) {

        $validated = $request->validate([
           'department' => 'required|string|min:10',
        ]);
        $department->name = $validated['department'];
        $department->update();

        return back()->with('message', 'Your department name has been updated successfully.');
    }


}
