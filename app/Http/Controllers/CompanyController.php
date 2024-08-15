<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|unique:companies',
        ]);

        $company = new Company(); 
        $company->fill($validated);
        $company->save(); 

        return back()->with('message', 'Your company has been created successfully.');
    }

    public function update (Request $request, Company $company) {

        $validated = $request->validate([
           'company' => 'required|string',
        ]);
        $company->name = $validated['company'];
        $company->update();

        return back()->with('message', 'Your company name has been updated successfully.');
    }

}
