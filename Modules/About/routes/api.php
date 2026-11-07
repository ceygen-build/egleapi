<?php

use Illuminate\Support\Facades\Route;
use Modules\About\Http\Controllers\AboutController;

// Public route to fetch About configurations and timeline
Route::get('about', [AboutController::class, 'index']);
Route::get('about/timeline', [AboutController::class, 'indexTimeline']);

// Protected update routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('about', [AboutController::class, 'update']);
    Route::post('about/timeline', [AboutController::class, 'storeTimeline']);
    Route::put('about/timeline/{id}', [AboutController::class, 'updateTimeline']);
    Route::delete('about/timeline/{id}', [AboutController::class, 'destroyTimeline']);
});
