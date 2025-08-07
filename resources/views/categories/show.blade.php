@extends('layouts.app')

@section('title', 'Jobs in ' . $category->name)

@section('content')
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <h1>Jobs in: {{ $category->name }}</h1>
    <hr>

    @can('update', $category)
        <a href="{{ route('categories.edit', $category) }}">Edit Category</a>
    @endcan
    @can('delete', $category)
        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete Category</button>
        </form>
    @endcan
    <hr>

    @forelse ($jobs as $job)
        <div>
            <h3><a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a></h3>
            <p><a href="{{ route('companies.show', $job->company) }}">{{ $job->company->name }}</a> | {{ $job->location }}</p>
        </div>
        <br>
    @empty
        <p>No jobs found in this category.</p>
    @endforelse

    {{ $jobs->links() }}
    <hr>
    <a href="{{ route('categories.index') }}">Back to Categories</a>
@endsection
