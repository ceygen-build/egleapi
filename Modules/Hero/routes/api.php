<?php

use Illuminate\Support\Facades\Route;
use Modules\Hero\Http\Controllers\HeroController;

// Public route to fetch active slides for the homepage
Route::get('slides', [HeroController::class, 'index']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('slides', [HeroController::class, 'store']);
    Route::put('slides/{id}', [HeroController::class, 'update']);
    Route::delete('slides/{id}', [HeroController::class, 'destroy']);
});
