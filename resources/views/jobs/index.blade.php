@extends('layouts.app')

@section('title', 'All Jobs')

@section('content')
    <h1>Job Listings</h1>
    @can('create', App\Models\Job::class)
        <a href="{{ route('jobs.create') }}">Post a New Job</a>
    @endcan
    <hr>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @forelse ($jobs as $job)
        <div>
            <h3><a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a></h3>
            <p>
                <a href="{{ route('companies.show', $job->company) }}">{{ $job->company->name }}</a> | {{ $job->location }}
            </p>
            <p><small>Category: <a href="{{ route('categories.show', $job->category) }}">{{ $job->category->name }}</a></small></p>
        </div>
        <br>
    @empty
        <p>No jobs found.</p>
    @endforelse

    {{ $jobs->links() }}
@endsection
