@extends('layouts.app')

@section('title', $company->name)

@section('content')
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if($company->logo)
        <img src="{{ $company->logo }}" alt="{{ $company->name }} Logo" style="max-width: 150px;">
    @endif

    <h1>{{ $company->name }}</h1>
    <p><strong>Website:</strong> <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
    <hr>
    <h2>About the Company</h2>
    <div>{!! nl2br(e($company->description)) !!}</div>
    <hr>
    <h2>Jobs at this Company</h2>
    @forelse ($company->jobs as $job)
        <div>
            <h3><a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a></h3>
            <p>{{ $job->location }} | <small>Category: <a href="{{ route('categories.show', $job->category) }}">{{ $job->category->name }}</a></small></p>
        </div>
    @empty
        <p>No jobs posted by this company yet.</p>
    @endforelse
    <hr>
    <a href="{{ route('companies.index') }}">Back to Companies</a>
    @can('update', $company)
        <a href="{{ route('companies.edit', $company) }}">Edit Company</a>
    @endcan
    @can('delete', $company)
        <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete Company</button>
        </form>
    @endcan
@endsection
