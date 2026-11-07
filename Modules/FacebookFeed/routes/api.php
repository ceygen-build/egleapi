<?php

use Illuminate\Support\Facades\Route;
use Modules\FacebookFeed\Http\Controllers\FacebookFeedController;

// Public route to fetch approved facebook feed photos
Route::get('facebook-feed/approved', [FacebookFeedController::class, 'approved']);

// Protected routes to moderate facebook feed photos
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('facebook-feed', [FacebookFeedController::class, 'index']);
    Route::put('facebook-feed/{id}', [FacebookFeedController::class, 'update']);
    Route::post('facebook-feed/sync', [FacebookFeedController::class, 'sync']);
});
