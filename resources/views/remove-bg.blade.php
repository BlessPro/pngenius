<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Remove Background</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endif
</head>
<body class="bg-[#F9F9F9] text-gray-800 min-h-screen">
    <header class="bg-green-600 text-white py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl font-bold">PNGenius</h1>
            <nav class="space-x-4 hidden md:block">
                <a href="{{ route('home') }}" class="hover:underline">Convert Image</a>
                <a href="{{ route('image.removeBg') }}" class="hover:underline font-semibold">Remove BG</a>
                <a href="{{ route('image.toPdf') }}" class="hover:underline">Image to PDF</a>
                <a href="#" class="hover:underline">Help</a>
                <button class="border border-white rounded px-4 py-1 hover:bg-white hover:text-green-600">Sign In</button>
            </nav>
        </div>
    </header>

    <section class="bg-green-500 text-white py-14 text-center px-4">
        <h2 class="text-3xl font-bold mb-4">Remove Image Background</h2>
        <p class="max-w-xl mx-auto">
            Upload a photo or graphic and get a transparent PNG in seconds.
        </p>
    </section>

    <section class="container mx-auto py-12 px-4">
        <div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Upload Image</h3>
                    <button id="bg-upload-btn" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 font-semibold">ADD IMAGE</button>
                    <input id="bg-file" type="file" accept="image/*" hidden>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded p-3 bg-gray-50">
                        <p class="text-sm text-gray-500 mb-2">Original Preview</p>
                        <img id="bg-preview" src="" alt="Original preview" class="w-full h-64 object-contain bg-white hidden">
                        <div id="bg-preview-empty" class="text-gray-400 text-sm h-64 flex items-center justify-center">
                            No image selected.
                        </div>
                    </div>
                    <div class="border rounded p-3 bg-gray-50">
                        <p class="text-sm text-gray-500 mb-2">Result Preview</p>
                        <img id="bg-result" src="" alt="Result preview" class="w-full h-64 object-contain bg-white hidden">
                        <div id="bg-result-empty" class="text-gray-400 text-sm h-64 flex items-center justify-center">
                            Result will appear here.
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="text-sm text-gray-600">
                        Output format: PNG with transparency.
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="bg-status" class="text-sm font-medium text-gray-600">Waiting</span>
                        <button id="bg-remove-btn" class="bg-green-600 text-white px-6 py-2 hover:bg-green-700 disabled:opacity-50">REMOVE BG</button>
                        <a id="bg-download" class="bg-blue-600 text-white px-4 py-2 rounded hidden" href="#" download>Download</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    const fileInput = document.getElementById('bg-file');
    const uploadBtn = document.getElementById('bg-upload-btn');
    const removeBtn = document.getElementById('bg-remove-btn');
    const statusEl = document.getElementById('bg-status');
    const preview = document.getElementById('bg-preview');
    const previewEmpty = document.getElementById('bg-preview-empty');
    const result = document.getElementById('bg-result');
    const resultEmpty = document.getElementById('bg-result-empty');
    const downloadLink = document.getElementById('bg-download');
    let currentFile = null;

    uploadBtn.onclick = () => fileInput.click();

    fileInput.onchange = () => {
        const file = fileInput.files[0];
        if (!file) {
            return;
        }

        currentFile = file;
        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.remove('hidden');
        previewEmpty.classList.add('hidden');

        statusEl.textContent = 'Waiting';
        statusEl.className = 'text-sm font-medium text-gray-600';
        downloadLink.classList.add('hidden');
        result.classList.add('hidden');
        resultEmpty.classList.remove('hidden');
    };

    removeBtn.onclick = () => {
        if (!currentFile) {
            alert('Please select an image first.');
            return;
        }

        removeBtn.disabled = true;
        statusEl.textContent = 'Processing...';
        statusEl.className = 'text-sm font-medium text-blue-600';

        const formData = new FormData();
        formData.append('image', currentFile);
        formData.append('format', 'png');
        formData.append('remove_bg', '1');

        fetch('{{ route('image.convertFile') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                statusEl.textContent = 'Complete';
                statusEl.className = 'text-sm font-medium text-green-600';
                downloadLink.href = data.download;
                downloadLink.classList.remove('hidden');
                downloadLink.setAttribute('download', '');
                result.src = data.download;
                result.classList.remove('hidden');
                resultEmpty.classList.add('hidden');
            } else {
                statusEl.textContent = data.message ? `Failed: ${data.message}` : 'Failed';
                statusEl.className = 'text-sm font-medium text-red-600';
            }
        })
        .catch(() => {
            statusEl.textContent = 'Failed';
            statusEl.className = 'text-sm font-medium text-red-600';
        })
        .finally(() => {
            removeBtn.disabled = false;
        });
    };
</script>
</body>
</html>
