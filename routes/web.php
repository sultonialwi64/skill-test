<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Grouping agar URL tetap /api/posts tapi mendukung Session & Cookie
Route::prefix('api')->group(function () {
    
    // Public routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);

    // Routes yang butuh login (Gunakan middleware 'auth' bukan 'auth:sanctum')
    Route::middleware('auth')->group(function () {
        Route::get('/posts/create', [PostController::class, 'create']); // 4-2
        Route::post('/posts', [PostController::class, 'store']);        // 4-3
        Route::get('/posts/{post}/edit', [PostController::class, 'edit']); // 4-5
        Route::put('/posts/{post}', [PostController::class, 'update']);  // 4-6
        Route::delete('/posts/{post}', [PostController::class, 'destroy']); // 4-7
    });
});