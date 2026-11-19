<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeAuth;

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/user', function () {
    $users = User::paginate(5);

    return view('user', compact('users'));
})->name('user_index');

// Add user from the modal
Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

Route::put('/users/{user}', [UserController::class, 'update'])
    ->middleware('auth')
    ->name('users.update');

Route::get('/students', [StudentController::class, 'index'])
    ->name('students');

Route::post('/students', [StudentController::class, 'store'])
    ->name('students.store');

Route::put('/students/{student}', [StudentController::class, 'update'])
    ->middleware('auth')
    ->name('students.update');

Route::delete('/students/{student}', [StudentController::class, 'destroy'])
     ->middleware('auth')
    ->name('students.destroy');

Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store');
Route::put('/schools/{id}', [SchoolController::class, 'update'])->middleware('auth')->name('schools.update');
Route::delete('/schools/{id}', [SchoolController::class, 'destroy'])->middleware('auth')->name('schools.destroy');

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login/success', [LoginController::class, 'login'])
    ->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
Route::get('/dashboard', [HomeAuth::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/react-demo', function () {
    return view('react-demo');
})->name('react-demo');
