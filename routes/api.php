<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicDataController;
use App\Http\Controllers\AdminDataController;

Route::get('/public-data', [PublicDataController::class, 'index']);
Route::post('/estimates', [App\Http\Controllers\EstimateRequestController::class, 'store']);
Route::get('/how-it-works', [App\Http\Controllers\HowItWorksController::class, 'index']);
Route::get('/industries', [App\Http\Controllers\IndustryController::class, 'index']);
Route::get('/testimonials', [App\Http\Controllers\TestimonialController::class, 'index']);
Route::post('/public/testimonials', [App\Http\Controllers\TestimonialController::class, 'submitPublicFeedback']);
Route::post('/public-testimonials', [App\Http\Controllers\TestimonialController::class, 'submitPublicFeedback']);
Route::post('/testimonials/public', [App\Http\Controllers\TestimonialController::class, 'submitPublicFeedback']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload-pdf', function (Request $request) {
    $request->validate([
        'file' => [
            'required',
            'file',
            'mimes:pdf',
            'mimetypes:application/pdf,application/x-pdf',
            'max:10240', // 10MB
        ],
    ], [
        'file.required' => 'Please select a PDF resume file to upload.',
        'file.file' => 'The uploaded file is invalid.',
        'file.mimes' => 'Only PDF files (.pdf) are allowed for resumes.',
        'file.mimetypes' => 'Only valid PDF documents (.pdf) are accepted.',
        'file.max' => 'The resume size must not exceed 10MB.',
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = 'cv_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('uploads/resumes');
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }
        $file->move($targetDir, $fileName);
        return response()->json([
            'status' => 'success',
            'url' => asset('uploads/resumes/' . $fileName),
            'filename' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
        ]);
    }

    return response()->json(['status' => 'error', 'message' => 'No file uploaded'], 400);
});

Route::post('/upload', function (Request $request) {
    $request->validate([
        'file' => 'required|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:10240',
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('uploads');
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }
        $file->move($targetDir, $fileName);
        return response()->json([
            'status' => 'success',
            'url' => asset('uploads/' . $fileName),
        ]);
    }

    return response()->json(['status' => 'error', 'message' => 'No file uploaded'], 400);
})->middleware('auth:sanctum');

Route::post('/upload-video', function (Request $request) {
    $request->validate([
        'file' => 'required|file|mimes:mp4,webm,ogg,mov,m4v|max:10240', // Max 10MB (10240 KB)
    ]);

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = 'video_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('uploads/videos');
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }
        $file->move($targetDir, $fileName);
        return response()->json([
            'status' => 'success',
            'url' => asset('uploads/videos/' . $fileName),
        ]);
    }

    return response()->json(['status' => 'error', 'message' => 'No file uploaded'], 400);
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin-data', [AdminDataController::class, 'index']);
    
    Route::post('/industries', [App\Http\Controllers\IndustryController::class, 'store']);
    Route::put('/industries/{id}', [App\Http\Controllers\IndustryController::class, 'update']);
    Route::delete('/industries/{id}', [App\Http\Controllers\IndustryController::class, 'destroy']);

    Route::post('/how-it-works', [App\Http\Controllers\HowItWorksController::class, 'store']);
    Route::put('/how-it-works/{id}', [App\Http\Controllers\HowItWorksController::class, 'update']);
    Route::delete('/how-it-works/{id}', [App\Http\Controllers\HowItWorksController::class, 'destroy']);

    Route::get('/estimates', [App\Http\Controllers\EstimateRequestController::class, 'index']);
    Route::put('/estimates/{id}', [App\Http\Controllers\EstimateRequestController::class, 'update']);
    Route::delete('/estimates/{id}', [App\Http\Controllers\EstimateRequestController::class, 'destroy']);

    Route::post('/testimonials', [App\Http\Controllers\TestimonialController::class, 'store']);
    Route::put('/testimonials/{id}', [App\Http\Controllers\TestimonialController::class, 'update']);
    Route::delete('/testimonials/{id}', [App\Http\Controllers\TestimonialController::class, 'destroy']);
});

