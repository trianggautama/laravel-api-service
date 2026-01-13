<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/regenerate-api-key', [ProfileController::class, 'regenerateApiKey'])->name('profile.regenerate-api-key');
    
    // Posts routes
    Route::resource('posts', PostController::class);
    
    // User quiz results routes
    Route::get('/quiz-results', [ProfileController::class, 'quizResults'])->name('user.quiz-results');
    Route::get('/quiz-results/{id}', [ProfileController::class, 'quizResultDetail'])->name('user.quiz-results.show');
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        
        // Questions CRUD routes
        Route::resource('questions', QuestionController::class);
        
        // Quiz Results routes
        Route::get('/quiz-results', [AdminController::class, 'quizResults'])->name('quiz-results.index');
        Route::get('/quiz-results/{id}', [AdminController::class, 'quizResultDetail'])->name('quiz-results.show');
    });
});
