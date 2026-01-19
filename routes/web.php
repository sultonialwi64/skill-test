<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Gunakan prefix 'api' agar URL tetap /api/posts, tapi mendukung Session
Route::prefix('api')->group(function () {
    
    // 4-1 & 4-4: Route Public
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{post}', [PostController::class, 'show']);

    // 4-2 sampai 4-7: Route yang butuh Login (Session)
    Route::middleware('auth')->group(function () {
        Route::get('/posts/create', [PostController::class, 'create']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
        Route::put('/posts/{post}', [PostController::class, 'update']);
        Route::delete('/posts/{post}', [PostController::class, 'destroy']);
    });
});