@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
    <h1>Job Categories</h1>
    @can('create', App\Models\Category::class)
        <a href="{{ route('categories.create') }}">Add a New Category</a>
    @endcan
    <hr>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <ul>
    @forelse ($categories as $category)
        <li>
            <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
            ({{ $category->jobs_count }} {{ Str::plural('job', $category->jobs_count) }})
        </li>
    @empty
        <li>No categories found.</li>
    @endforelse
    </ul>

    {{ $categories->links() }}
@endsection
