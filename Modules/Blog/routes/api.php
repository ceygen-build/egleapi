<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\BlogPageController;

// Public routes
Route::get('blogs', [BlogController::class, 'index']);
Route::get('blog-pages', [BlogPageController::class, 'index']);
Route::get('blog-pages/{slug}', [BlogPageController::class, 'show']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('blogs', [BlogController::class, 'store']);
    Route::put('blogs/{id}', [BlogController::class, 'update']);
    Route::delete('blogs/{id}', [BlogController::class, 'destroy']);

    Route::put('blog-pages/{slug}', [BlogPageController::class, 'update']);
});
