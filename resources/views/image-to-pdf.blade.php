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
        <div class="max-w-4xl mx-auto flex justify-end mb-4">
            <button id="typeform-open" class="border border-green-600 text-green-600 px-4 py-2 rounded hover:bg-green-600 hover:text-white font-semibold">
                Share feedback
            </button>
        </div>
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

    <div class="bg-gray-100 py-6 text-center text-gray-600 text-lg font-medium">
        This page has
        <span id="file-count" class="text-gray-800 font-bold">0</span> files
        totaling
        <span id="total-size" class="text-gray-800 font-bold">0 MB</span>.
    </div>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-2 md:grid-cols-5 gap-8 text-sm">
            <div>
                <h4 class="text-green-400 font-bold text-lg mb-2">PNGenius</h4>
                <p class="text-gray-400">Build a modern and creative website with crealand</p>
                <div class="flex space-x-3 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white">G</a>
                    <a href="#" class="text-gray-400 hover:text-white">T</a>
                    <a href="#" class="text-gray-400 hover:text-white">I</a>
                    <a href="#" class="text-gray-400 hover:text-white">L</a>
                </div>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Product</h4>
                <ul class="space-y-1 text-gray-400">
                    <li><a href="#">Landingpage</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Pricing</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Services</h4>
                <ul class="space-y-1 text-gray-400">
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Design</a></li>
                    <li><a href="#">Themes</a></li>
                    <li><a href="#">UI Kit</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Company</h4>
                <ul class="space-y-1 text-gray-400">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">More</h4>
                <ul class="space-y-1 text-gray-400">
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">License</a></li>
                    <li><a href="#">Changelog</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <footer class="bg-gray-800 text-gray-300 py-4 text-center text-sm">
        <p>&copy; 2025 PNGenius. Built by <span class="text-green-400 font-semibold">10minal</span>.</p>
    </footer>

    <div id="typeform-modal" class="fixed inset-0 z-50 hidden">
        <div id="typeform-backdrop" class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-full max-w-3xl rounded-lg shadow-xl overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Stay in the loop</h3>
                    <button id="typeform-close" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
                </div>
                <div class="w-full h-[70vh]">
                    <iframe
                        src="https://gn65q2d504i.typeform.com/to/WH8tG6uP"
                        title="PNGenius Interest Form"
                        class="w-full h-full"
                        frameborder="0"
                        allow="camera; microphone; autoplay; encrypted-media;"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>

<script>
    const MAX_FILES = 10;
    const fileInput = document.getElementById('pdf-file');
    const uploadBtn = document.getElementById('pdf-upload-btn');
    const listEl = document.getElementById('pdf-list');
    const emptyEl = document.getElementById('pdf-empty');
    const statusEl = document.getElementById('pdf-status');
    const convertBtn = document.getElementById('pdf-convert');
    const downloadLink = document.getElementById('pdf-download');
    const fileCountEl = document.getElementById('file-count');
    const totalSizeEl = document.getElementById('total-size');
    const typeformModal = document.getElementById('typeform-modal');
    const typeformClose = document.getElementById('typeform-close');
    const typeformBackdrop = document.getElementById('typeform-backdrop');
    const typeformOpen = document.getElementById('typeform-open');
    const files = [];
    let typeformShown = false;
    let typeformTimer = null;

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

        updatePageStats();
    }

    function formatBytes(bytes) {
        if (bytes >= 1024 * 1024 * 1024) {
            return { value: bytes / (1024 * 1024 * 1024), suffix: 'GB' };
        }
        if (bytes >= 1024 * 1024) {
            return { value: bytes / (1024 * 1024), suffix: 'MB' };
        }
        if (bytes >= 1024) {
            return { value: bytes / 1024, suffix: 'KB' };
        }
        return { value: bytes, suffix: 'B' };
    }

    function updatePageStats() {
        const count = files.length;
        const totalBytes = files.reduce((sum, item) => sum + (item.file?.size || 0), 0);
        const display = formatBytes(totalBytes);

        fileCountEl.textContent = count.toLocaleString();
        totalSizeEl.textContent = display.value.toFixed(2) + ' ' + display.suffix;
    }

    convertBtn.onclick = () => {
        if (files.length === 0) {
            alert('Please add at least one image.');
            return;
        }

        scheduleTypeform();

        convertBtn.disabled = true;
        statusEl.textContent = 'Processing...';
        statusEl.className = 'text-sm font-medium text-blue-600';
        downloadLink.classList.add('hidden');

        const formData = new FormData();
        files.forEach(item => formData.append('images[]', item.file));

        fetch('{{ route('image.toPdf.convert', [], false) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
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

    function showTypeform() {
        if (!typeformModal) {
            return;
        }
        typeformModal.classList.remove('hidden');
    }

    function hideTypeform() {
        if (!typeformModal) {
            return;
        }
        typeformModal.classList.add('hidden');
    }

    function scheduleTypeform() {
        if (typeformShown || !typeformModal) {
            return;
        }
        typeformShown = true;
        typeformTimer = setTimeout(showTypeform, 3000);
    }

    if (typeformOpen) {
        typeformOpen.addEventListener('click', showTypeform);
    }
    if (typeformClose) {
        typeformClose.addEventListener('click', () => {
            if (typeformTimer) {
                clearTimeout(typeformTimer);
            }
            hideTypeform();
        });
    }
    if (typeformBackdrop) {
        typeformBackdrop.addEventListener('click', hideTypeform);
    }

    updatePageStats();
</script>
</body>
</html>
