<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ImageConvertController extends Controller
{
    public function index()
    {
        return view('convert');
    }

    public function convertFile(Request $request)
    {
        ini_set('max_execution_time', 120); // increase execution time

        $request->validate([
            'image' => 'required|image|max:10240',
            'format' => 'required|in:jpg,png,webp,gif,bmp,tiff'
        ]);

        try {
            $uploaded = $request->file('image');
            $format = $request->input('format');

            $manager = new ImageManager(new GdDriver());
            $image = $manager->read($uploaded->getRealPath());

            $converted = match ($format) {
                'jpg' => (string) $image->toJpeg(),
                'png' => (string) $image->toPng(),
                'webp' => (string) $image->toWebp(),
                'gif' => (string) $image->toGif(),
                'bmp' => (string) $image->toPng(),   // fallback
                'tiff' => (string) $image->toPng(),  // fallback
            };

            $convertedName = uniqid('converted_') . '.' . $format;
            $filePath = 'converted/' . $convertedName;
            Storage::disk('public')->put($filePath, $converted);

            DB::table('image_conversions')->insert([
                'original_size' => $uploaded->getSize(), // in bytes
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'download' => asset('storage/' . $filePath)
            ]);
        } catch (\Exception $e) {
            Log::error('Image conversion failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Conversion failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
//     public function convertFile(Request $request)
//     {
//         ini_set('max_execution_time', 120); // Allow up to 2 mins

//         $request->validate([
//             'image' => 'required|image|max:10240',
//             'format' => 'required|in:jpg,png,webp,gif,bmp,tiff'
//         ]);

//         try {
//             $uploaded = $request->file('image');
//             $format = $request->input('format');

//             $manager = new ImageManager(new Driver());

//             $image = $manager->read($uploaded->getRealPath());

//             $converted = match ($format) {
//                 'jpg' => (string) $image->toJpeg(),
//                 'png' => (string) $image->toPng(),
//                 'webp' => (string) $image->toWebp(),
//                 'gif' => (string) $image->toGif(),
//                 'bmp', 'tiff' => (string) $image->toPng(), // fallback
//             };

//             $convertedName = uniqid('converted_') . '.' . $format;
//             $filePath = 'converted/' . $convertedName;

//             Storage::disk('public')->makeDirectory('converted'); // ensure folder exists
//             Storage::disk('public')->put($filePath, $converted);

//             DB::table('image_conversions')->insert([
//                 'created_at' => now(),
//                 'updated_at' => now()
//             ]);

//             return response()->json([
//                 'success' => true,
//                 'download' => asset('storage/' . $filePath)
//             ]);
//         } catch (\Exception $e) {
//             Log::error('Image conversion failed', ['error' => $e->getMessage()]);

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Conversion failed. Please try again later.'
//                 // Optional for dev: 'Conversion failed: ' . $e->getMessage()
//             ], 500);
//         }
//     }
// }
// public function convertFile(Request $request)
// {
//     ini_set('max_execution_time', 120); // Allow 2 minutes

//     $request->validate([
//         'image' => 'required|image|max:5120',
//         'format' => 'required|in:jpg,png,webp,gif,bmp,tiff'
//     ]);

//     $uploaded = $request->file('image');
//     $format = $request->input('format');

//     $manager = new ImageManager(new GdDriver());

//     try {
//         $image = $manager->read(file_get_contents($uploaded->getRealPath()));

//         $converted = match ($format) {
//             'jpg' => $image->toJpeg(),
//             'png' => $image->toPng(),
//             'webp' => $image->toWebp(),
//             'gif' => $image->toGif(),
//             'bmp' => $image->toBmp(),
//             'tiff' => $image->toTiff(),
//         };

//         $convertedName = uniqid('converted_') . '.' . $format;
//         $filePath = 'converted/' . $convertedName;

//         Storage::disk('public')->put($filePath, (string) $converted);

//         DB::table('image_conversions')->insert([
//             'created_at' => now(),
//             'updated_at' => now()
//         ]);

//         return response()->json([
//             'success' => true,
//             'download' => asset('storage/' . $filePath)
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Conversion failed: ' . $e->getMessage()
//         ], 500);
//     }
// }


//     public function convertFile(Request $request)
// {
//     $request->validate([
//         'image' => 'required|image|max:5120',
//         'format' => 'required|in:jpg,png,webp,gif,bmp,tiff'
//     ]);

//     $image = $request->file('image');
//     $targetFormat = $request->input('format');
//     $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

//     try {
//         $converted = match ($targetFormat) {
//             'jpg' => $manager->read($image)->toJpeg(),
//             'png' => $manager->read($image)->toPng(),
//             'webp' => $manager->read($image)->toWebp(),
//             'gif' => $manager->read($image)->toGif(),
//             'tiff' => $manager->read($image)->toTiff(),
//         };

//         $convertedName = uniqid('converted_') . '.' . $targetFormat;
//         $filePath = 'converted/' . $convertedName;
//         Storage::disk('public')->put($filePath, (string) $converted);

//         DB::table('image_conversions')->insert([
//             'created_at' => now(),
//             'updated_at' => now()
//         ]);

//         return response()->json([
//             'success' => true,
//             'download' => asset('storage/' . $filePath)
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Conversion failed: ' . $e->getMessage()
//         ], 500);
//     }
// }


