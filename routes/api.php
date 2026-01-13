<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\ApiQuizController;

// API routes with Bearer token authentication
Route::middleware('api.auth')->group(function () {
    // Posts routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    
    // Questions routes
    Route::get('/questions/random', [QuestionController::class, 'getRandom']);
    Route::post('/quiz/submit', [QuizController::class, 'quizSubmitHandle'])->name('quiz.submit');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
});
