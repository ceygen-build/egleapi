<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\AnalyticsController;

// Public tracking endpoint (lightweight, non-blocking)
Route::post('track-visitor', [AnalyticsController::class, 'track']);

// Protected admin routes for analytics dashboard
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('visitors/analytics', [AnalyticsController::class, 'getAnalytics']);
    Route::get('visitors/logs', [AnalyticsController::class, 'getLogs']);
    Route::delete('visitors/logs', [AnalyticsController::class, 'clearLogs']);
});
