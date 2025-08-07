<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;

// The homepage will be the job listing page
Route::get('/', [JobController::class, 'index'])->name('home');

// Resource routes for Jobs, Companies, and Categories
Route::resource('jobs', JobController::class);
Route::resource('companies', CompanyController::class);
Route::resource('categories', CategoryController::class);

// A simple welcome route for testing if needed, though the root is now jobs
Route::get('/welcome', function () {
    return view('welcome');
});
