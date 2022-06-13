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
    ], ['only' => ['index', 'show']]);

    Route::apiResource('comments', CommentController::class)
        ->only('index', 'show', 'store');

    Route::prefix('post/{id}')->group(function () {
        Route::get('categories', [PostCategoriesController::class, 'index']);
        Route::get('tags', [PostTagsController::class, 'index']);
    });

    Route::get('category/{id}/posts', [CategoryPostsController::class, 'index']);

    Route::get('tag/{id}/posts', [TagPostsController::class, 'index']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResources([
            'posts'      => PostController::class,
            'categories' => CategoryController::class,
            'tags'       => TagController::class,
        ], ['except' => ['index', 'show']]);

        Route::controller(PostController::class)->group(function () {
            Route::get('trashed/posts', 'getTrashed');
            Route::delete('permanently-delete/post/{id}', 'permanentlyDelete');
            Route::patch('restore/post/{id}', 'restore');
        });

        Route::prefix('comments')
            ->controller(CommentController::class)
            ->group(function () {
                Route::delete('{id}', 'destroy');
                Route::patch('{id}/approve', 'approve');
                Route::patch('{id}/disapprove', 'disapprove');
            });

        Route::prefix('post/{postId}')->group(function () {
            Route::prefix('category')
                ->controller(PostCategoriesController::class)
                ->group(function () {
                    Route::patch('{categoryId}', 'attach');
                    Route::delete('{categoryId}', 'detach');
                });

            Route::prefix('tag')
                ->controller(PostTagsController::class)
                ->group(function () {
                    Route::patch('{tagId}', 'attach');
                    Route::delete('{tagId}', 'detach');
                });
        });

        Route::prefix('category/{categoryId}')
            ->controller(CategoryPostsController::class)
            ->group(function () {
                Route::patch('post/{postId}', 'attach');
                Route::delete('post/{postId}', 'detach');
            });

        Route::prefix('tag/{tagId}')
            ->controller(TagPostsController::class)
            ->group(function () {
                Route::patch('post/{postId}', 'attach');
                Route::delete('post/{postId}', 'detach');
            });
    });
});

