@extends('layouts.app')

@section('title', isset($company) ? 'Edit Company' : 'Create Company')

@section('content')
    <h1>{{ isset($company) ? 'Edit Company' : 'Create Company' }}</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($company) ? route('companies.update', $company) : route('companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($company))
            @method('PUT')
        @endif

        <div>
            <label for="name">Company Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $company->name ?? '') }}" required>
        </div>
        <br>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description', $company->description ?? '') }}</textarea>
        </div>
        <br>
        <div>
            <label for="website">Website</label>
            <input type="url" id="website" name="website" value="{{ old('website', $company->website ?? '') }}">
        </div>
        <br>
        <div>
            <label for="logo">Company Logo</label>
            <input type="file" id="logo" name="logo">
            @if(isset($company) && $company->logo)
                <p>Current logo:</p>
                <img src="{{ $company->logo }}" alt="Current Logo" style="max-width: 100px;">
            @endif
        </div>
        <br>
        <button type="submit">Save Company</button>
    </form>
@endsection
