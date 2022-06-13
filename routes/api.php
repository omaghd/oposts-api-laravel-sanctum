<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('auth', AuthController::class);

    Route::apiResources([
        'posts' => PostController::class,
    ], [
        'only' => ['index', 'show']
    ]);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResources([
            'posts' => PostController::class,
        ], [
            'except' => ['index', 'show']
        ]);

        // Posts
        Route::get('trashed/posts', [PostController::class, 'getTrashed']);
        Route::delete('permanently-delete/post/{id}', [PostController::class, 'permanentlyDelete']);
        Route::patch('restore/post/{id}', [PostController::class, 'restore']);
    });
});

