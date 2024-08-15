<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Company;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function create() {
        $companies = Company::all();

        return view('departments.add-department', [
            'companies' => $companies
        ]);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            'company' => 'required|integer|exists:companies,id',
            'departments.*.name' => 'required|string'
        ]);

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
           'department' => 'required|string',
        ]);
        $department->name = $validated['department'];
        $department->update();

        return back()->with('message', 'Your department name has been updated successfully.');
    }


}
