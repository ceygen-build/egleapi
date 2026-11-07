<?php

use Illuminate\Support\Facades\Route;
use Modules\Partner\Http\Controllers\PartnerController;

// Public route to fetch partners list
Route::get('partners', [PartnerController::class, 'index']);

// Protected routes to manage partners
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('partners', [PartnerController::class, 'store']);
    Route::match(['put', 'post'], 'partners/{id}', [PartnerController::class, 'update']);
    Route::delete('partners/{id}', [PartnerController::class, 'destroy']);
});
