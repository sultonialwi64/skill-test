<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Endpoint publik
Route::get('/posts', [PostController::class, 'index']);      // Link: /api/posts
Route::get('/posts/{id}', [PostController::class, 'show']);   // Link: /api/posts/{id}

// Endpoint yang butuh login
Route::middleware('auth:web')->group(function () {
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});