@extends('layouts.app')

@section('title', $job->title)

@section('content')
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <h1>{{ $job->title }}</h1>
    <h3><a href="{{ route('companies.show', $job->company) }}">{{ $job->company->name }}</a></h3>
    <p><strong>Location:</strong> {{ $job->location }}</p>
    <p><strong>Type:</strong> {{ ucfirst($job->type) }}</p>
    <p><strong>Salary:</strong> {{ $job->salary ?? 'Not specified' }}</p>
    <p><strong>Category:</strong> <a href="{{ route('categories.show', $job->category) }}">{{ $job->category->name }}</a></p>
    <hr>
    <h2>Job Description</h2>
    <div>{!! nl2br(e($job->description)) !!}</div>
    <hr>
    <a href="{{ route('jobs.index') }}">Back to Listings</a>
    @can('update', $job)
        <a href="{{ route('jobs.edit', $job) }}">Edit Job</a>
    @endcan
    @can('delete', $job)
        <form action="{{ route('jobs.destroy', $job) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete Job</button>
        </form>
    @endcan
@endsection
