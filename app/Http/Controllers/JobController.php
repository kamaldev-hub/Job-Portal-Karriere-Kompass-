<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Company;
use App\Http\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Job::class, 'job');
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::for('jobs.index');
        $jobs = Cache::remember('jobs', now()->addMinutes(10), function () {
            return Job::with(['company', 'category'])->latest()->paginate(10);
        });
        return view('jobs.index', compact('jobs', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::for('jobs.create');
        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('jobs.form', compact('companies', 'categories', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract',
            'salary' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $request->user()->jobs()->create($validated);
        Cache::forget('jobs');
        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    public function show(Job $job)
    {
        $breadcrumbs = Breadcrumbs::for('jobs.show', $job);
        $job->load(['company', 'category', 'user']);
        return view('jobs.show', compact('job', 'breadcrumbs'));
    }

    public function edit(Job $job)
    {
        $breadcrumbs = Breadcrumbs::for('jobs.edit', $job);
        $companies = Company::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('jobs.form', compact('job', 'companies', 'categories', 'breadcrumbs'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'type' => 'required|in:full-time,part-time,contract',
            'salary' => 'nullable|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $job->update($validated);
        Cache::forget('jobs');
        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        Cache::forget('jobs');
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }
}
