<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostCategoriesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('auth', AuthController::class);

    Route::apiResources([
        'posts'      => PostController::class,
        'categories' => CategoryController::class,
        'tags'       => TagController::class,
    ], [
        'only' => ['index', 'show']
    ]);

    Route::apiResource('comments', CommentController::class)
        ->only('index', 'show', 'store');

    // Get a single post's categories
    Route::get('post/{id}/categories', [PostCategoriesController::class, 'index']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResources([
            'posts'      => PostController::class,
            'categories' => CategoryController::class,
            'tags'       => TagController::class,
        ], [
            'except' => ['index', 'show']
        ]);

        // Posts
        Route::get('trashed/posts', [PostController::class, 'getTrashed']);
        Route::delete('permanently-delete/post/{id}', [PostController::class, 'permanentlyDelete']);
        Route::patch('restore/post/{id}', [PostController::class, 'restore']);

        // Comments
        Route::prefix('comments')->group(function () {
            Route::delete('{id}', [CommentController::class, 'destroy']);
            Route::patch('{id}/approve', [CommentController::class, 'approve']);
            Route::patch('{id}/disapprove', [CommentController::class, 'disapprove']);
        });

        // Attach a category to a post
        Route::patch('post/{postId}/category/{categoryId}', [PostCategoriesController::class, 'attach']);
        // Detach a category to a post
        Route::delete('post/{postId}/category/{categoryId}', [PostCategoriesController::class, 'detach']);
    });
});

