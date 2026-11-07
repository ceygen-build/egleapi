<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\FaqController;

// Public routes for guests
Route::get('faqs', [FaqController::class, 'index']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('faqs', [FaqController::class, 'store']);
    Route::put('faqs/{id}', [FaqController::class, 'update']);
    Route::delete('faqs/{id}', [FaqController::class, 'destroy']);
});
