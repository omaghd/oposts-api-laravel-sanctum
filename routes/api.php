<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryPostsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostCategoriesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TagPostsController;
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
    // Get a single post's tags
    Route::get('post/{id}/tags', [PostTagsController::class, 'index']);

    // Get a single category's posts
    Route::get('category/{id}/posts', [CategoryPostsController::class, 'index']);
    // Get a single category's posts
    Route::get('tag/{id}/posts', [TagPostsController::class, 'index']);

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
        // Attach a tag to a post
        Route::patch('post/{postId}/tag/{tagId}', [PostTagsController::class, 'attach']);

        // Detach a category from a post
        Route::delete('post/{postId}/category/{categoryId}', [PostCategoriesController::class, 'detach']);
        // Detach a tag from a post
        Route::delete('post/{postId}/tag/{tagId}', [PostTagsController::class, 'detach']);

        // Attach a post to a category
        Route::patch('category/{categoryId}/post/{postId}', [CategoryPostsController::class, 'attach']);
        // Attach a post to a tag
        Route::patch('tag/{tagId}/post/{postId}', [TagPostsController::class, 'attach']);

        // Detach a post from a category
        Route::delete('category/{categoryId}/post/{postId}', [CategoryPostsController::class, 'detach']);
        // Detach a post from a tag
        Route::delete('tag/{tagId}/post/{postId}', [TagPostsController::class, 'detach']);
    });
});

