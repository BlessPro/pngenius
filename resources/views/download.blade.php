<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Download</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.getElementById('progress').style.display = 'none';
                document.getElementById('download-section').style.display = 'block';
            }, 2000);
        });
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-xl text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Processing Image</h1>

        <div id="progress" class="text-gray-600 text-sm">Converting your image, please wait...</div>

        <div id="download-section" class="hidden">
            <h2 class="text-lg font-semibold text-green-600 mb-4">Done!</h2>
            <p><strong>File Name:</strong> {{ session('converted_name') }}</p>
            <p><strong>Format:</strong> {{ session('converted_format') }}</p>
            <p><strong>Size:</strong> {{ session('converted_size') }}</p>
            <a href="{{ asset(session('converted_path')) }}" download
               class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
               Download File
            </a>
        </div>
    </div>
</body>
</html>
