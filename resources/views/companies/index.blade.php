@extends('layouts.app')

@section('title', 'All Companies')

@section('content')
    <h1>Companies</h1>
    @can('create', App\Models\Company::class)
        <a href="{{ route('companies.create') }}">Add a New Company</a>
    @endcan
    <hr>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @forelse ($companies as $company)
        <div>
            <h3><a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a></h3>
            <p>{{ $company->jobs_count }} {{ Str::plural('job', $company->jobs_count) }} posted.</p>
        </div>
        <br>
    @empty
        <p>No companies found.</p>
    @endforelse

    {{ $companies->links() }}
@endsection
