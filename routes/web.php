<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/storage/{path}', function ($path) {
    // 1. Check direct filename in public/uploads/
    $filename = basename($path);
    $publicUploadPath = public_path('uploads/' . $filename);
    if (file_exists($publicUploadPath)) {
        return response()->file($publicUploadPath);
    }

    // 2. Check full path in storage/app/public/
    $storageAppPath = storage_path('app/public/' . $path);
    if (file_exists($storageAppPath)) {
        return response()->file($storageAppPath);
    }

    // 3. Check direct file in public/
    $directPublicPath = public_path($path);
    if (file_exists($directPublicPath)) {
        return response()->file($directPublicPath);
    }

    abort(404);
})->where('path', '.*');


