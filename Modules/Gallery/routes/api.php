<?php

use Illuminate\Support\Facades\Route;
use Modules\Gallery\Http\Controllers\GalleryController;

// Public routes for guests
Route::get('gallery', [GalleryController::class, 'index']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('gallery', [GalleryController::class, 'store']);
    Route::put('gallery/{id}', [GalleryController::class, 'update']);
    Route::delete('gallery/{id}', [GalleryController::class, 'destroy']);
});
