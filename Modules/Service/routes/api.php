<?php

use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\ServiceController;

// Public route to fetch services & service features
Route::get('services', [ServiceController::class, 'index']);
Route::get('service-features', [ServiceController::class, 'indexFeatures']);
Route::get('service-pages', [ServiceController::class, 'indexServicePages']);
Route::get('service-pages/{slug}', [ServiceController::class, 'showServicePage']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('services', [ServiceController::class, 'store']);
    Route::put('services/{id}', [ServiceController::class, 'update']);
    Route::delete('services/{id}', [ServiceController::class, 'destroy']);

    Route::post('service-features', [ServiceController::class, 'storeFeature']);
    Route::put('service-features/{id}', [ServiceController::class, 'updateFeature']);
    Route::delete('service-features/{id}', [ServiceController::class, 'destroyFeature']);

    Route::put('service-pages/{slug}', [ServiceController::class, 'updateServicePage']);
});
