<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ImageConvertController extends Controller
{
    private const SUPPORTED_FORMATS = ['jpg', 'png', 'webp', 'gif', 'bmp', 'tiff'];

    public function index()
    {
        return view('convert');
    }

    public function removeBg()
    {
        return view('remove-bg');
    }

    public function imageToPdf()
    {
        return view('image-to-pdf');
    }

    public function convertToPdf(Request $request)
    {
        ini_set('max_execution_time', 120);

        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|max:10240',
        ]);

        try {
            $uploads = $request->file('images', []);
            $pages = [];

            foreach ($uploads as $uploaded) {
                $image = $this->readImageFromUpload($uploaded);
                $gd = $image->core()->native();

                if (! $gd) {
                    throw new \RuntimeException('Unable to decode image for PDF.');
                }

                $width = imagesx($gd);
                $height = imagesy($gd);

                ob_start();
                imagejpeg($gd, null, 85);
                $jpegData = ob_get_clean();

                if ($jpegData === false) {
                    throw new \RuntimeException('Unable to encode image for PDF.');
                }

                $pages[] = [
                    'width' => $width,
                    'height' => $height,
                    'data' => $jpegData,
                ];

                $this->logConversionSize($uploaded);
            }

            $pdfBinary = $this->buildPdfFromImages($pages);

            $pdfName = 'pngenius_' . Str::uuid()->toString() . '.pdf';
            $filePath = 'converted/' . $pdfName;

            $disk = Storage::disk('public');
            $disk->makeDirectory('converted');
            $disk->put($filePath, $pdfBinary);

            $this->cleanupIfConfigured();

            return response()->json([
                'success' => true,
                'download' => asset('storage/' . $filePath),
                'file_name' => $pdfName,
            ]);
        } catch (\Throwable $e) {
            Log::error('PDF conversion failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'PDF conversion failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $uploaded = $request->file('image');
        $dimensions = @getimagesize($uploaded->getRealPath());

        return response()->json([
            'success' => true,
            'name' => $uploaded->getClientOriginalName(),
            'size_bytes' => $uploaded->getSize() ?? 0,
            'mime_type' => $uploaded->getMimeType(),
            'width' => $dimensions ? $dimensions[0] : null,
            'height' => $dimensions ? $dimensions[1] : null,
        ]);
    }

    public function convert(Request $request)
    {
        ini_set('max_execution_time', 120);

        $request->validate([
            'image' => 'required|image|max:10240',
            'format' => ['required', Rule::in(self::SUPPORTED_FORMATS)],
            'remove_bg' => 'nullable|boolean',
        ]);

        try {
            $uploaded = $request->file('image');
            $format = $request->input('format');
            $removeBg = $this->parseRemoveBg($request->input('remove_bg'));

            $result = $this->convertUploadedFile($uploaded, $format, $removeBg);

            $request->session()->put([
                'converted_path' => 'storage/' . $result['file_path'],
                'converted_name' => $result['file_name'],
                'converted_format' => strtoupper($result['format']),
                'converted_size' => $this->formatBytes($result['size_bytes']),
            ]);

            $this->logConversionSize($uploaded);
            $this->cleanupIfConfigured();

            return redirect()->route('image.download');
        } catch (\Throwable $e) {
            Log::error('Image conversion failed', ['error' => $e->getMessage()]);

            return back()->withErrors(['image' => 'Conversion failed. Please try again.']);
        }
    }

    public function convertFile(Request $request)
    {
        ini_set('max_execution_time', 120); // increase execution time

        $request->validate([
            'image' => 'required|image|max:10240',
            'format' => ['required', Rule::in(self::SUPPORTED_FORMATS)],
            'remove_bg' => 'nullable|boolean',
        ]);

        try {
            $uploaded = $request->file('image');
            $format = $request->input('format');
            $removeBg = $this->parseRemoveBg($request->input('remove_bg'));

            $result = $this->convertUploadedFile($uploaded, $format, $removeBg);

            $this->logConversionSize($uploaded);
            $this->cleanupIfConfigured();

            return response()->json([
                'success' => true,
                'download' => asset('storage/' . $result['file_path']),
                'file_name' => $result['file_name'],
                'file_path' => $result['file_path'],
                'format' => $result['format'],
                'size_bytes' => $result['size_bytes'],
            ]);
        } catch (\Exception $e) {
            Log::error('Image conversion failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Conversion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function download(Request $request)
    {
        if (! $request->session()->has('converted_path')) {
            return redirect()->route('home');
        }

        return view('download');
    }

    public function downloadZip(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:2|max:10',
            'files.*' => 'string',
        ]);

        try {
            $disk = Storage::disk('public');
            $disk->makeDirectory('converted');

            $zipName = 'pngenius_' . Str::uuid()->toString() . '.zip';
            $zipRelativePath = 'converted/' . $zipName;
            $zipPath = $disk->path($zipRelativePath);

            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Unable to create ZIP file.');
            }

            $fileNames = array_values(array_unique($request->input('files', [])));

            foreach ($fileNames as $fileName) {
                $safeName = basename($fileName);
                if ($safeName !== $fileName || $safeName === '') {
                    throw new \RuntimeException('Invalid file name provided.');
                }

                $relativePath = 'converted/' . $safeName;
                if (! $disk->exists($relativePath)) {
                    throw new \RuntimeException('Missing file: ' . $safeName);
                }

                $zip->addFile($disk->path($relativePath), $safeName);
            }

            $zip->close();

            $this->cleanupIfConfigured();

            return response()->json([
                'success' => true,
                'download' => asset('storage/' . $zipRelativePath),
                'file_name' => $zipName,
            ]);
        } catch (\Throwable $e) {
            Log::error('ZIP download failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'ZIP creation failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function convertUploadedFile($uploaded, string $format, bool $removeBg = false): array
    {
        $image = $this->readImageFromUpload($uploaded);

        $actualFormat = $format;

        if ($removeBg) {
            $gd = $image->core()->native();
            $this->applyBasicBackgroundRemoval($gd);
            $actualFormat = 'png';
        }

        try {
            $converted = match ($actualFormat) {
                'jpg' => (string) $image->toJpeg(),
                'png' => (string) $image->toPng(),
                'webp' => (string) $image->toWebp(),
                'gif' => (string) $image->toGif(),
                'bmp' => (string) $image->toBmp(),
                'tiff' => (string) $image->toTiff(),
            };
        } catch (\Throwable $e) {
            if (in_array($actualFormat, ['bmp', 'tiff'], true)) {
                $actualFormat = 'png';
                $converted = (string) $image->toPng();
            } else {
                throw $e;
            }
        }

        $convertedName = Str::uuid()->toString() . '.' . $actualFormat;
        $filePath = 'converted/' . $convertedName;

        $disk = Storage::disk('public');
        $disk->makeDirectory('converted');
        $disk->put($filePath, $converted);

        return [
            'file_path' => $filePath,
            'file_name' => $convertedName,
            'size_bytes' => strlen($converted),
            'format' => $actualFormat,
        ];
    }

    private function logConversionSize($uploaded): void
    {
        try {
            DB::table('image_conversions')->insert([
                'original_size' => $uploaded->getSize() ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Conversion size tracking failed', ['error' => $e->getMessage()]);
        }
    }

    private function cleanupIfConfigured(): void
    {
        $cleanupDays = (int) config('pngenius.cleanup_days', 0);
        if ($cleanupDays <= 0) {
            return;
        }

        try {
            $disk = Storage::disk('public');
            $cutoff = now()->subDays($cleanupDays)->getTimestamp();

            foreach ($disk->files('converted') as $path) {
                if ($disk->lastModified($path) < $cutoff) {
                    $disk->delete($path);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Cleanup failed', ['error' => $e->getMessage()]);
        }
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1024 * 1024) {
            return number_format($bytes / (1024 * 1024), 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    private function parseRemoveBg($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    private function readImageFromUpload($uploaded)
    {
        $manager = new ImageManager(new GdDriver());
        $path = $uploaded->getRealPath() ?: $uploaded->getPathname();
        if (! $path || ! is_readable($path)) {
            throw new \RuntimeException('Uploaded file is not readable.');
        }

        try {
            return $manager->read($path);
        } catch (\Throwable $e) {
            $contents = @file_get_contents($path);
            if ($contents === false) {
                throw $e;
            }

            return $manager->read($contents);
        }
    }

    private function buildPdfFromImages(array $pages): string
    {
        $objects = [];
        $addObject = function (string $body) use (&$objects): int {
            $objects[] = $body;
            return count($objects);
        };
        $setObject = function (int $id, string $body) use (&$objects): void {
            $objects[$id - 1] = $body;
        };

        $pagesId = $addObject('<< /Type /Pages /Kids [] /Count 0 >>');
        $pageIds = [];
        $imageIndex = 1;

        foreach ($pages as $page) {
            $width = (int) $page['width'];
            $height = (int) $page['height'];
            $data = $page['data'];
            $length = strlen($data);

            $imageId = $addObject(
                "<< /Type /XObject /Subtype /Image /Width $width /Height $height " .
                "/ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length $length >>\n" .
                "stream\n" . $data . "\nendstream"
            );

            $content = "q $width 0 0 $height 0 0 cm /Im$imageIndex Do Q";
            $contentId = $addObject(
                "<< /Length " . strlen($content) . " >>\nstream\n" . $content . "\nendstream"
            );

            $pageIds[] = $addObject(
                "<< /Type /Page /Parent $pagesId 0 R " .
                "/Resources << /XObject << /Im$imageIndex $imageId 0 R >> /ProcSet [/PDF /ImageC] >> " .
                "/MediaBox [0 0 $width $height] /Contents $contentId 0 R >>"
            );

            $imageIndex += 1;
        }

        $kids = implode(' ', array_map(fn ($id) => $id . ' 0 R', $pageIds));
        $setObject($pagesId, "<< /Type /Pages /Kids [ $kids ] /Count " . count($pageIds) . " >>");

        $catalogId = $addObject("<< /Type /Catalog /Pages $pagesId 0 R >>");

        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $index => $body) {
            $objId = $index + 1;
            $offsets[$objId] = strlen($pdf);
            $pdf .= $objId . " 0 obj\n" . $body . "\nendobj\n";
        }

        $xrefPos = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root $catalogId 0 R >>\n";
        $pdf .= "startxref\n$xrefPos\n%%EOF";

        return $pdf;
    }

    private function applyBasicBackgroundRemoval($gd): void
    {
        if (! function_exists('imagecolorat')) {
            throw new \RuntimeException('GD is missing required image functions.');
        }

        if (function_exists('imagepalettetotruecolor')) {
            @imagepalettetotruecolor($gd);
        }

        imagealphablending($gd, false);
        imagesavealpha($gd, true);

        $width = imagesx($gd);
        $height = imagesy($gd);

        $samples = [
            $this->colorAt($gd, 0, 0),
            $this->colorAt($gd, $width - 1, 0),
            $this->colorAt($gd, 0, $height - 1),
            $this->colorAt($gd, $width - 1, $height - 1),
        ];

        $bg = [
            'red' => (int) round(array_sum(array_column($samples, 'red')) / count($samples)),
            'green' => (int) round(array_sum(array_column($samples, 'green')) / count($samples)),
            'blue' => (int) round(array_sum(array_column($samples, 'blue')) / count($samples)),
        ];

        $threshold = 30 * 3;
        $transparent = imagecolorallocatealpha($gd, 0, 0, 0, 127);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = $this->colorAt($gd, $x, $y);
                $distance = abs($color['red'] - $bg['red'])
                    + abs($color['green'] - $bg['green'])
                    + abs($color['blue'] - $bg['blue']);

                if ($distance <= $threshold) {
                    imagesetpixel($gd, $x, $y, $transparent);
                }
            }
        }
    }

    private function colorAt($gd, int $x, int $y): array
    {
        $index = imagecolorat($gd, $x, $y);
        return imagecolorsforindex($gd, $index);
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
