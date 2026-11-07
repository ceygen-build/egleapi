<?php

use Illuminate\Support\Facades\Route;
use Modules\Team\Http\Controllers\TeamController;

// Public route to fetch team members
Route::get('team', [TeamController::class, 'index']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('team', [TeamController::class, 'store']);
    Route::put('team/{id}', [TeamController::class, 'update']);
    Route::delete('team/{id}', [TeamController::class, 'destroy']);
});
