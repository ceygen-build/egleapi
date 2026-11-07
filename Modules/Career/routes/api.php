<?php

use Illuminate\Support\Facades\Route;
use Modules\Career\Http\Controllers\CareerController;

// Public routes for guests
Route::get('vacancies', [CareerController::class, 'index']);
Route::get('career-options', [CareerController::class, 'indexOptions']);
Route::get('career-page', [CareerController::class, 'showPage']);
Route::post('job-applications', [CareerController::class, 'storeApplication']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('career-page', [CareerController::class, 'updatePage']);
    Route::post('vacancies', [CareerController::class, 'store']);
    Route::put('vacancies/{id}', [CareerController::class, 'update']);
    Route::delete('vacancies/{id}', [CareerController::class, 'destroy']);
    Route::get('job-applications', [CareerController::class, 'indexApplications']);
    Route::delete('job-applications/{id}', [CareerController::class, 'destroyApplication']);
    Route::post('career-options', [CareerController::class, 'storeOption']);
    Route::put('career-options/{id}', [CareerController::class, 'updateOption']);
    Route::delete('career-options/{id}', [CareerController::class, 'destroyOption']);
});
