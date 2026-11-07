<?php

use Illuminate\Support\Facades\Route;
use Modules\Inquiry\Http\Controllers\InquiryController;

// Public route to submit an inquiry
Route::post('inquiries', [InquiryController::class, 'store']);

// Protected routes to manage inquiries
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('inquiries', [InquiryController::class, 'index']);
    Route::put('inquiries/{id}', [InquiryController::class, 'update']);
    Route::post('inquiries/{id}/reply', [InquiryController::class, 'reply']);
    Route::delete('inquiries/{id}', [InquiryController::class, 'destroy']);
});
