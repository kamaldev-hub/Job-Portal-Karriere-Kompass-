@extends('layouts.app')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
    <h1>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div>
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
        </div>
        <br>
        <div>
            <label for="slug">Slug (optional, will be auto-generated)</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}">
        </div>
        <br>
        <button type="submit">Save Category</button>
    </form>
@endsection
