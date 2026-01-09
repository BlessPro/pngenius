<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageConvertController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Home Page: Upload + Preview + Convert
Route::get('/', [ImageConvertController::class, 'index'])->name('home');

// Background removal page
Route::get('/remove-bg', [ImageConvertController::class, 'removeBg'])->name('image.removeBg');

// Image to PDF page
Route::get('/image-to-pdf', [ImageConvertController::class, 'imageToPdf'])->name('image.toPdf');

// Analyze uploaded image
Route::post('/analyze', [ImageConvertController::class, 'analyze'])->name('image.analyze');

// Convert image to selected format
Route::post('/convert', [ImageConvertController::class, 'convert'])->name('image.convert');

Route::post('/convert-file', [ImageConvertController::class, 'convertFile'])->name('image.convertFile');

// Download a ZIP of converted images
Route::post('/download-zip', [ImageConvertController::class, 'downloadZip'])->name('image.downloadZip');

// Convert multiple images into a PDF
Route::post('/image-to-pdf/convert', [ImageConvertController::class, 'convertToPdf'])->name('image.toPdf.convert');

// Download converted image (with fake progress)
Route::get('/download', [ImageConvertController::class, 'download'])->name('image.download');

// Real-time conversion count for AJAX polling
Route::get('/conversion-count', function () {
    if (! Schema::hasTable('image_conversions')) {
        return response()->json([
            'count' => 0,
        ]);
    }

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
    if (! Schema::hasTable('image_conversions')) {
        return response()->json([
            'count' => 0,
            'total_size_mb' => 0,
        ]);
    }

    $totalCount = DB::table('image_conversions')->count();
    $totalSize = DB::table('image_conversions')->sum('original_size') ?? 0;

    return response()->json([
        'count' => $totalCount,
        'total_size_mb' => round($totalSize / (1024 * 1024), 2)
    ]);
})->name('image.stats');
