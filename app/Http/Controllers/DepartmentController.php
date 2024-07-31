<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function create() {
        $companies = Company::all();

        return view('add-department', [
            'companies' => $companies
        ]);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'company' => 'required|integer',
            'department' => 'required|string'
        ]);

        $department = new Department(); 
        $department->company_id = $validated['company'];
        $department->name = $validated['department'];
        $department->save(); 

        return back()->with('message', 'Your department has been created successfully.');
    }

    public function show ($id) {
        $department = Department::findOrFail($id); 
        $companies = Company::all();
        $departments = Department::where('company_id', $department->company_id)->get();

        return view('edit-department', [
            'department' => $department,
            'companies' => $companies,
            'departments' => $departments,
            ]); 
    }

    public function update (Request $request, Department $department) {

        $validated = $request->validate([
           'department' => 'required|string',
        ]);
        $department->name = $validated['department'];
        $department->update();

        return back()->with('message', 'Your department name has been updated successfully.');
    }


}
