<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageConvertController;
use Illuminate\Support\Facades\DB;

// Home Page: Upload + Preview + Convert
Route::get('/', [ImageConvertController::class, 'index'])->name('home');

// Analyze uploaded image
Route::post('/analyze', [ImageConvertController::class, 'analyze'])->name('image.analyze');

// Convert image to selected format
Route::post('/convert', [ImageConvertController::class, 'convert'])->name('image.convert');

// Download converted image (with fake progress)
Route::get('/download', [ImageConvertController::class, 'download'])->name('image.download');

// Real-time conversion count for AJAX polling
Route::get('/conversion-count', function () {
    return response()->json([
        'count' => DB::table('image_conversions')->count()
    ]);
})->name('image.count');
