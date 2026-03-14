<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ─── Guest routes (register & login) ────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ─── Auth-protected routes ──────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [WorkoutController::class, 'dashboard'])
        ->name('dashboard');

    // Workouts
    Route::get('/workouts', [WorkoutController::class, 'index'])
        ->name('workouts.index');

    Route::get('/workouts/{exercise}', [WorkoutController::class, 'show'])
        ->name('workouts.show');

    Route::post('/workouts/{exercise}/complete', [WorkoutController::class, 'complete'])
        ->name('workouts.complete');

    // History
    Route::get('/history', [WorkoutController::class, 'history'])
        ->name('workouts.history');
});
