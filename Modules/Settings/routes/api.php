<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingsController;

// Public route to fetch current active logo and settings
Route::get('settings', [SettingsController::class, 'index']);

// Protected route to update settings configurations
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('settings', [SettingsController::class, 'store']);
});
