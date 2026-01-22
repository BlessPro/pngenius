<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Multi Image Converter</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endif
</head>
<body class="bg-[#F9F9F9] text-gray-800 min-h-screen">
    <!-- Header -->
    <header class="bg-green-600 text-white py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl font-bold">PNGenius</h1>
            <nav class="space-x-4 hidden md:block">
                <a href="{{ route('home') }}" class="hover:underline font-semibold">Convert Image</a>
                <a href="{{ route('image.removeBg') }}" class="hover:underline">Remove BG</a>
                <a href="{{ route('image.toPdf') }}" class="hover:underline">Image to PDF</a>
                <a href="#" class="hover:underline">Help</a>
                <button class="border border-white rounded px-4 py-1 hover:bg-white hover:text-green-600">Sign In</button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-green-500 text-white py-16 text-center px-4">
        <h2 class="text-3xl font-bold mb-4">From One Format to Another, Instantly!</h2>
        <p class="max-w-xl mx-auto">
            Convert your images in seconds. Crisp quality, zero hassle.<br>
            Supports PNG, JPG, GIF, WEBP, and more.
        </p>
    </section>

    <!-- Upload Section -->
    <section class="container mx-auto py-12 px-4">


        <!-- This shows ONLY on load or when no image is added -->
<div id="initial-upload" class="text-center mb-6">
    <button id="file-btn-initial" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 font-semibold">ADD IMAGE(S)</button>
    <input id="file-input" type="file" accept="image/*" multiple hidden>
</div>
        <div id="file-list" class="space-y-4 max-w-4xl mx-auto hidden"></div>

<!-- This shows ONLY after image is added -->
<div id="action-buttons" class="flex justify-between items-center mb-6 max-w-4xl mx-auto hidden">
    <div class="text-center mt-5">
        <button id="file-btn" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 font-semibold">ADD IMAGE(S)</button>
        <input id="file-input-dup" type="file" accept="image/*" multiple hidden>
    </div>
    <div class="text-center mt-5 flex flex-col items-center gap-3">
        <button id="convert-all" class="bg-green-600 text-white px-6 py-2 hover:bg-green-700 disabled:opacity-50">CONVERT</button>
        <div id="zip-container" class="hidden">
            <button id="download-zip" class="bg-blue-600 text-white px-6 py-2 hover:bg-blue-700 disabled:opacity-50">DOWNLOAD ZIP</button>
        </div>
    </div>
</div>
    </section>
    <!-- Feature Section -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            <div>
                <div class="text-green-600 text-3xl mb-2">01</div>
                <h3 class="font-bold text-lg">Multi-Format Support</h3>
                <p class="text-sm text-gray-600">Convert a wide range of file types documents, images, audio, and video to and from popular formats.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">02</div>
                <h3 class="font-bold text-lg">Fast & Easy Upload</h3>
                <p class="text-sm text-gray-600">Drag-and-drop or click-to-upload with clear file size limits and progress indicators.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">03</div>
                <h3 class="font-bold text-lg">High-Quality Conversion</h3>
                <p class="text-sm text-gray-600">Maintain original quality with options for resolution or compression adjustments.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">04</div>
                <h3 class="font-bold text-lg">Batch Conversion</h3>
                <p class="text-sm text-gray-600">Convert multiple files at once to save time and streamline workflows.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">05</div>
                <h3 class="font-bold text-lg">No Software Installation</h3>
                <p class="text-sm text-gray-600">Fully web-based with no downloads required, accessible from any device or browser.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">06</div>
                <h3 class="font-bold text-lg">Secure & Private</h3>
                <p class="text-sm text-gray-600">All files are encrypted during transfer and deleted from servers after conversion to protect user privacy.</p>
            </div>
        </div>
    </section>

<div class="bg-gray-100 py-6 text-center text-gray-600 text-lg font-medium">
    This page has
    <span id="file-count" class="text-gray-800 font-bold">0</span> files
    totaling
    <span id="total-size" class="text-gray-800 font-bold">0 MB</span>.
</div>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 ">
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


<footer class="bg-gray-800 text-gray-300 py-4  text-center text-sm">
    <p>&copy; 2025 PNGenius. Built by <span class="text-green-400 font-semibold">10minal</span>.</p>
</footer>
    <script>
    const MAX_FILES = 10;
    const fileInput = document.getElementById('file-input');
    const fileInputDup = document.getElementById('file-input-dup');
    const fileBtn = document.getElementById('file-btn');
    const fileBtnInitial = document.getElementById('file-btn-initial');
    const fileList = document.getElementById('file-list');
    const convertBtn = document.getElementById('convert-all');
    const initialUpload = document.getElementById('initial-upload');
    const actionButtons = document.getElementById('action-buttons');
    const zipContainer = document.getElementById('zip-container');
    const zipBtn = document.getElementById('download-zip');
    const fileCountEl = document.getElementById('file-count');
    const totalSizeEl = document.getElementById('total-size');
    const typeformModal = document.getElementById('typeform-modal');
    const typeformClose = document.getElementById('typeform-close');
    const files = [];
    let typeformShown = false;
    let typeformTimer = null;

    // Handlers for both file buttons
    fileBtn.onclick = () => fileInputDup.click();
    fileBtnInitial.onclick = () => fileInput.click();

    [fileInput, fileInputDup].forEach(input => {
        input.onchange = () => {
            const newFiles = Array.from(input.files);
            if ((files.length + newFiles.length) > MAX_FILES) {
                alert("You can only upload a maximum of 10 images.");
                return;
            }
            newFiles.forEach(addFileRow);
            input.value = null;

            // Toggle buttons
            initialUpload.classList.add('hidden');
            actionButtons.classList.remove('hidden');
            updateZipVisibility();
        };
    });

    function updateZipVisibility() {
        const readyCount = files.filter(item => item.converted && item.file_name).length;
        if (readyCount >= 2) {
            zipContainer.classList.remove('hidden');
        } else {
            zipContainer.classList.add('hidden');
        }
        updateZipState(readyCount);
    }

    function updateZipState(readyCount = null) {
        const count = readyCount === null
            ? files.filter(item => item.converted && item.file_name).length
            : readyCount;
        zipBtn.disabled = count < 2;
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


    function addFileRow(file) {
        const id = Date.now() + Math.random();
        files.push({ file, id, converted: false, file_name: null });

        const div = document.createElement('div');
        div.className = "bg-white border px-4 py-3 rounded shadow flex flex-col md:flex-row md:items-center md:justify-between gap-4";
        div.dataset.id = id;

        div.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="text-gray-700">IMG</span>
                <span class="font-medium">${file.name}</span>
            </div>
            <div class="flex items-center gap-4 flex-wrap">
                <select class="format-select border px-2 py-1 rounded">
                    <option value="jpg">JPG</option>
                    <option value="png">PNG</option>
                    <option value="webp">WEBP</option>
                    <option value="gif">GIF</option>
                    <option value="bmp">BMP</option>
                    <option value="tiff">TIFF</option>
                </select>
                <span class="status text-sm font-medium text-yellow-600">Waiting</span>
                <a class="bg-green-600 text-white px-3 py-1 rounded hidden download-btn" href="#">Download</a>
                <button class="text-red-500 font-bold remove">&times;</button>
            </div>
        `;

        div.querySelector(".remove").onclick = () => {
            const index = files.findIndex(f => f.id === id);
            if (index !== -1) files.splice(index, 1);
            div.remove();

            if (files.length === 0) {
                fileList.classList.add('hidden');
                actionButtons.classList.add('hidden');
                initialUpload.classList.remove('hidden');
            }

            updateZipVisibility();
            updatePageStats();
        };

        fileList.classList.remove('hidden');
        fileList.appendChild(div);
        updateZipVisibility();
        updatePageStats();
    }

    convertBtn.onclick = () => {
        convertBtn.disabled = true;
        let pending = 0;

        if (!typeformShown && files.length > 0) {
            typeformShown = true;
            typeformTimer = setTimeout(() => {
                typeformModal.classList.remove('hidden');
            }, 3000);
        }

        files.forEach(({ file, id, converted }) => {
            if (converted) return;
            pending += 1;

            const div = document.querySelector(`[data-id='${id}']`);
            const status = div.querySelector(".status");
            const format = div.querySelector(".format-select").value;
            const downloadBtn = div.querySelector(".download-btn");

            const formData = new FormData();
            formData.append("image", file);
            formData.append("format", format);

            status.textContent = "Processing...";
            status.className = "status text-sm font-medium text-blue-600";

            fetch('{{ route('image.convertFile', [], false) }}', {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.format && data.format !== format) {
                        status.textContent = `Complete (saved as ${data.format.toUpperCase()})`;
                    } else {
                        status.textContent = "Complete";
                    }
                    status.className = "status text-sm font-medium text-green-600";

                    downloadBtn.href = data.download;
                    downloadBtn.classList.remove("hidden");
                    downloadBtn.setAttribute("download", "");
                    const fileEntry = files.find(f => f.id === id);
                    if (fileEntry) {
                        fileEntry.converted = true;
                        fileEntry.file_name = data.file_name || null;
                    }
                } else {
                    status.textContent = data.message ? `Failed: ${data.message}` : "Failed";
                    status.className = "status text-sm font-medium text-red-600";
                }
            })
            .catch(() => {
                status.textContent = "Failed";
                status.className = "status text-sm font-medium text-red-600";
            })
            .finally(() => {
                pending -= 1;
                if (pending <= 0) {
                    convertBtn.disabled = false;
                }
                updateZipVisibility();
            });
        });

        if (pending === 0) {
            convertBtn.disabled = false;
        }
        updateZipVisibility();
    };

    typeformClose.onclick = () => {
        if (typeformTimer) {
            clearTimeout(typeformTimer);
        }
        typeformModal.classList.add('hidden');
    };

    zipBtn.onclick = () => {
        const readyFiles = files
            .filter(item => item.converted && item.file_name)
            .map(item => item.file_name);

        if (readyFiles.length < 2) {
            alert('Convert at least two images before downloading a ZIP.');
            return;
        }

        const originalLabel = zipBtn.textContent;
        zipBtn.disabled = true;
        zipBtn.textContent = 'BUILDING ZIP...';

        const formData = new FormData();
        readyFiles.forEach(fileName => formData.append('files[]', fileName));

        fetch('{{ route('image.downloadZip', [], false) }}', {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const link = document.createElement('a');
                link.href = data.download;
                link.setAttribute('download', data.file_name || '');
                document.body.appendChild(link);
                link.click();
                link.remove();
            } else {
                alert(data.message ? `ZIP failed: ${data.message}` : 'ZIP creation failed.');
            }
        })
        .catch(() => {
            alert('ZIP creation failed.');
        })
        .finally(() => {
            zipBtn.disabled = false;
            zipBtn.textContent = originalLabel;
            updateZipVisibility();
        });
    };

    updatePageStats();
</script>

    <div id="typeform-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
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

</body>
</html>
