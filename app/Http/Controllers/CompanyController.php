<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    public function index()
    {
        $companies = Cache::remember('companies', now()->addMinutes(10), function () {
            return Company::withCount('jobs')->latest()->paginate(10);
        });
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            $validated['logo'] = Storage::url($path);
        }

        $validated['user_id'] = $request->user()->id;

        Company::create($validated);

        Cache::forget('companies');

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        $company->load(['jobs.category']);
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.form', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::delete(str_replace('/storage', 'public', $company->logo));
            }
            $path = $request->file('logo')->store('public/logos');
            $validated['logo'] = Storage::url($path);
        }

        $company->update($validated);

        Cache::forget('companies');

        return redirect()->route('companies.show', $company)->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::delete(str_replace('/storage', 'public', $company->logo));
        }

        $company->delete();

        Cache::forget('companies');

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
