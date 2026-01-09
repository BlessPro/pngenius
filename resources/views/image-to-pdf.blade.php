<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Image to PDF</title>
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
                <a href="{{ route('image.removeBg') }}" class="hover:underline">Remove BG</a>
                <a href="{{ route('image.toPdf') }}" class="hover:underline font-semibold">Image to PDF</a>
                <a href="#" class="hover:underline">Help</a>
                <button class="border border-white rounded px-4 py-1 hover:bg-white hover:text-green-600">Sign In</button>
            </nav>
        </div>
    </header>

    <section class="bg-green-500 text-white py-14 text-center px-4">
        <h2 class="text-3xl font-bold mb-4">Turn Images into a PDF</h2>
        <p class="max-w-2xl mx-auto">
            Each image becomes its own PDF page sized to the image. Orientation and fit are automatic.
        </p>
    </section>

    <section class="container mx-auto py-12 px-4">
        <div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Upload Images</h3>
                        <p class="text-sm text-gray-500">Up to 10 images, 10MB each.</p>
                    </div>
                    <button id="pdf-upload-btn" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 font-semibold">ADD IMAGE(S)</button>
                    <input id="pdf-file" type="file" accept="image/*" multiple hidden>
                </div>

                <div id="pdf-empty" class="border border-dashed rounded p-6 text-center text-gray-500">
                    No images added yet.
                </div>

                <div id="pdf-list" class="space-y-3 hidden"></div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div class="text-sm text-gray-600">
                        Output: one PDF with each image on its own page.
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="pdf-status" class="text-sm font-medium text-gray-600">Waiting</span>
                        <button id="pdf-convert" class="bg-green-600 text-white px-6 py-2 hover:bg-green-700 disabled:opacity-50">CREATE PDF</button>
                        <a id="pdf-download" class="bg-blue-600 text-white px-4 py-2 rounded hidden" href="#" download>Download</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    const MAX_FILES = 10;
    const fileInput = document.getElementById('pdf-file');
    const uploadBtn = document.getElementById('pdf-upload-btn');
    const listEl = document.getElementById('pdf-list');
    const emptyEl = document.getElementById('pdf-empty');
    const statusEl = document.getElementById('pdf-status');
    const convertBtn = document.getElementById('pdf-convert');
    const downloadLink = document.getElementById('pdf-download');
    const files = [];

    uploadBtn.onclick = () => fileInput.click();

    fileInput.onchange = () => {
        const newFiles = Array.from(fileInput.files);
        if ((files.length + newFiles.length) > MAX_FILES) {
            alert('You can only upload a maximum of 10 images.');
            fileInput.value = null;
            return;
        }

        newFiles.forEach(addFileRow);
        fileInput.value = null;
    };

    function addFileRow(file) {
        const id = Date.now() + Math.random();
        files.push({ id, file });

        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        const row = document.createElement('div');
        row.className = 'bg-gray-50 border rounded px-4 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3';
        row.dataset.id = id;

        row.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="text-gray-700">IMG</span>
                <span class="font-medium">${file.name}</span>
                <span class="text-sm text-gray-500">(${sizeMb} MB)</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">Page size matches image</span>
                <button class="text-red-500 font-bold remove">&times;</button>
            </div>
        `;

        row.querySelector('.remove').onclick = () => {
            const index = files.findIndex(item => item.id === id);
            if (index !== -1) {
                files.splice(index, 1);
            }
            row.remove();
            syncEmptyState();
        };

        listEl.appendChild(row);
        syncEmptyState();
    }

    function syncEmptyState() {
        if (files.length === 0) {
            listEl.classList.add('hidden');
            emptyEl.classList.remove('hidden');
        } else {
            listEl.classList.remove('hidden');
            emptyEl.classList.add('hidden');
        }
    }

    convertBtn.onclick = () => {
        if (files.length === 0) {
            alert('Please add at least one image.');
            return;
        }

        convertBtn.disabled = true;
        statusEl.textContent = 'Processing...';
        statusEl.className = 'text-sm font-medium text-blue-600';
        downloadLink.classList.add('hidden');

        const formData = new FormData();
        files.forEach(item => formData.append('images[]', item.file));

        fetch('{{ route('image.toPdf.convert') }}', {
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
                if (data.file_name) {
                    downloadLink.setAttribute('download', data.file_name);
                } else {
                    downloadLink.setAttribute('download', '');
                }
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
            convertBtn.disabled = false;
        });
    };
</script>
</body>
</html>
