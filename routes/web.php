<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageConvertController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Home Page: Upload + Preview + Convert
Route::get('/', [ImageConvertController::class, 'index'])->name('home');

// Analyze uploaded image
Route::post('/analyze', [ImageConvertController::class, 'analyze'])->name('image.analyze');

// Convert image to selected format
Route::post('/convert', [ImageConvertController::class, 'convert'])->name('image.convert');

Route::post('/convert-file', [ImageConvertController::class, 'convertFile'])->name('image.convertFile');

// Download converted image (with fake progress)
Route::get('/download', [ImageConvertController::class, 'download'])->name('image.download');

// Real-time conversion count for AJAX polling
Route::get('/conversion-count', function () {
    return response()->json([
        'count' => DB::table('image_conversions')->count()
    ]);
})->name('image.count');
// Route::get('/conversion-stats', function () {
//     $totalCount = DB::table('image_conversions')->count();
//     $totalSize = DB::table('image_conversions')->sum('original_size'); // in bytes

//     return response()->json([
//         'count' => $totalCount,
//         'total_size_mb' => round($totalSize / (1024 * 1024), 2)
//     ]);
// });
Route::get('/conversion-stats', function () {
    $totalCount = DB::table('image_conversions')->count();
    $totalSize = DB::table('image_conversions')->sum('original_size');

    Log::info('Stats Debug', [
        'count' => $totalCount,
        'total_size_bytes' => $totalSize,
                'total_size_mb' => round($totalSize / (1024 * 1024), 2)

    ]);

    return response()->json([
        'count' => $totalCount,
        'total_size_mb' => round($totalSize / (1024 * 1024), 2)
    ]);
});

