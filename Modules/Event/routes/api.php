<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Controllers\EventController;

// Public routes for guests
Route::get('events', [EventController::class, 'index']);
Route::post('event-registrations', [EventController::class, 'storeRegistration']);

// Protected CRUD routes for admin panel
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('events', [EventController::class, 'store']);
    Route::put('events/{id}', [EventController::class, 'update']);
    Route::delete('events/{id}', [EventController::class, 'destroy']);
    Route::get('event-registrations', [EventController::class, 'indexRegistrations']);
});
