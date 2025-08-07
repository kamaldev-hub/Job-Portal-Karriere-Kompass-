@extends('layouts.app')

@section('title', isset($job) ? 'Edit Job' : 'Create Job')

@section('content')
    <h1>{{ isset($job) ? 'Edit Job' : 'Create Job' }}</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($job) ? route('jobs.update', $job) : route('jobs.store') }}" method="POST">
        @csrf
        @if(isset($job))
            @method('PUT')
        @endif

        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $job->title ?? '') }}" required>
        </div>
        <br>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" required>{{ old('description', $job->description ?? '') }}</textarea>
        </div>
        <br>
        <div>
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="{{ old('location', $job->location ?? '') }}" required>
        </div>
        <br>
        <div>
            <label for="type">Job Type</label>
            <select id="type" name="type">
                <option value="full-time" @selected(old('type', $job->type ?? '') == 'full-time')>Full-time</option>
                <option value="part-time" @selected(old('type', $job->type ?? '') == 'part-time')>Part-time</option>
                <option value="contract" @selected(old('type', $job->type ?? '') == 'contract')>Contract</option>
            </select>
        </div>
        <br>
        <div>
            <label for="salary">Salary</label>
            <input type="text" id="salary" name="salary" value="{{ old('salary', $job->salary ?? '') }}">
        </div>
        <br>
        <div>
            <label for="company_id">Company</label>
            <select id="company_id" name="company_id" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" @selected(old('company_id', $job->company_id ?? '') == $company->id)>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                 @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <br>
        <button type="submit">Save Job</button>
    </form>
@endsection
