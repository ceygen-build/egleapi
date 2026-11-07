<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\ContactController;
use Modules\Contact\Http\Controllers\RegionalHubController;

// Public routes
Route::get('contact-details', [ContactController::class, 'showDetails']);
Route::get('contact-page', [ContactController::class, 'showPage']);
Route::get('regional-hubs', [RegionalHubController::class, 'index']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('contact-details', [ContactController::class, 'updateDetails']);
    Route::put('contact-page', [ContactController::class, 'updatePage']);
    Route::post('contact-page', [ContactController::class, 'updatePage']);
    Route::post('regional-hubs', [RegionalHubController::class, 'store']);
    Route::put('regional-hubs/{id}', [RegionalHubController::class, 'update']);
    Route::delete('regional-hubs/{id}', [RegionalHubController::class, 'destroy']);
});

