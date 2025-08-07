<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Job Portal')</title>
    <!-- Here you would link your CSS file -->
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <style>
        body { font-family: sans-serif; margin: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        nav { background: #f8f9fa; padding: 1rem; border-bottom: 1px solid #dee2e6; }
        nav a { margin-right: 15px; text-decoration: none; color: #333; }
        .content { padding: 20px 0; }
    </style>
</head>
<body>
    <nav>
        <div class="container">
            <a href="/">Home</a>
            <a href="/jobs">Jobs</a>
            <a href="/companies">Companies</a>
            <a href="/categories">Categories</a>
        </div>
    </nav>
    <main class="container content">
        @include('partials.breadcrumbs')
        @yield('content')
    </main>
    <!-- Here you would link your JS file -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
