<?php
    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $image = $request->file('image');
        $originalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $image->getClientOriginalName());
        $originalExtension = $image->getClientOriginalExtension();
        $originalSize = round($image->getSize() / 1024, 2);

        $filename = uniqid('preview_') . '.' . $originalExtension;
        $image->storeAs('previews', $filename, 'public');

        $fullStoragePath = storage_path('app/public/previews/' . $filename);

        session([
            'uploaded_path' => $fullStoragePath,
            'image_name' => $originalName,
            'image_type' => strtoupper($originalExtension),
            'image_size' => $originalSize . ' KB',
            'preview_url' => 'storage/previews/' . $filename,
        ]);

        return redirect()->route('home');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'format' => 'required|in:jpg,png,webp,gif',
        ]);

        $originalPath = session('uploaded_path');
        $originalName = pathinfo(session('image_name'), PATHINFO_FILENAME);
        $targetFormat = $request->input('format');

        if (!file_exists($originalPath)) {
            return back()->withErrors(['message' => 'Uploaded image file no longer exists. Please re-upload.']);
        }

        $manager = new ImageManager(new GdDriver());

        try {
            $image = $manager->read(file_get_contents($originalPath));
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Image conversion failed: ' . $e->getMessage()]);
        }

        $converted = match ($targetFormat) {
            'jpg' => $image->toJpeg(),
            'png' => $image->toPng(),
            'webp' => $image->toWebp(),
            'gif' => $image->toGif(),
        };

        $convertedName = $originalName . '_converted.' . $targetFormat;
        $filePath = 'converted/' . uniqid() . '_' . $convertedName;
        $binary = (string) $converted;

        Storage::disk('public')->put($filePath, $binary);

        // Log conversion
        DB::table('image_conversions')->insert([
            'created_at' => now(),
            'updated_at' => now()
        ]);

        session([
            'converted_name' => $convertedName,
            'converted_format' => strtoupper($targetFormat),
            'converted_size' => round(strlen($binary) / 1024, 2) . ' KB',
            'converted_path' => 'storage/' . $filePath,
        ]);

        return redirect()->route('image.download');
    }

    public function download()
    {
        return view('download');
    }

