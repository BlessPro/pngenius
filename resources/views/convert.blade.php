<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Multi Image Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-[#F9F9F9] text-gray-800 min-h-screen">
    <!-- Header -->
    <header class="bg-green-600 text-white py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl font-bold">PNGenius</h1>
            <nav class="space-x-4 hidden md:block">
                <a href="#" class="hover:underline">Home</a>
                <a href="#" class="hover:underline">Convert Image</a>
                <a href="#" class="hover:underline">Advanced Tools</a>
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
    <div class="text-center mt-5">
        <button id="convert-all" class="bg-green-600 text-white px-6 py-2 hover:bg-green-700 disabled:opacity-50">CONVERT</button>
    </div>
</div>
    </section>
    <!-- Feature Section -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
            <div>
                <div class="text-green-600 text-3xl mb-2">🔒</div>
                <h3 class="font-bold text-lg">Multi-Format Support</h3>
                <p class="text-sm text-gray-600">Convert a wide range of file types documents, images, audio, and video to and from popular formats.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">📤</div>
                <h3 class="font-bold text-lg">Fast & Easy Upload</h3>
                <p class="text-sm text-gray-600">Drag-and-drop or click-to-upload with clear file size limits and progress indicators.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">🌟</div>
                <h3 class="font-bold text-lg">High-Quality Conversion</h3>
                <p class="text-sm text-gray-600">Maintain original quality with options for resolution or compression adjustments.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">📂</div>
                <h3 class="font-bold text-lg">Batch Conversion</h3>
                <p class="text-sm text-gray-600">Convert multiple files at once to save time and streamline workflows.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">❌</div>
                <h3 class="font-bold text-lg">No Software Installation</h3>
                <p class="text-sm text-gray-600">Fully web-based with no downloads required, accessible from any device or browser.</p>
            </div>
            <div>
                <div class="text-green-600 text-3xl mb-2">🔐</div>
                <h3 class="font-bold text-lg">Secure & Private</h3>
                <p class="text-sm text-gray-600">All files are encrypted during transfer and deleted from servers after conversion to protect user privacy.</p>
            </div>
        </div>
    </section>

<div class="bg-gray-100 py-6 text-center text-gray-600 text-lg font-medium">
    We've already converted
    <span id="file-count" class="text-gray-800 font-bold">0</span> files
    with a total size of
    <span id="total-size" class="text-gray-800 font-bold">0 GB</span>.
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
    <!-- for the file counting -->


<script>
    function animateCount(el, start, end, duration = 3000) {
        let startTime = null;

        function update(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = timestamp - startTime;
            const value = Math.floor(start + (end - start) * (progress / duration));

            el.textContent = value.toLocaleString();
            if (progress < duration) {
                requestAnimationFrame(update);
            } else {
                el.textContent = end.toLocaleString();
            }
        }

        requestAnimationFrame(update);
    }

    function animateDecimal(el, start, end, suffix = 'MB', duration = 3000) {
        let startTime = null;

        function update(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = timestamp - startTime;
            const value = start + (end - start) * (progress / duration);

            el.textContent = value.toFixed(2) + ' ' + suffix;
            if (progress < duration) {
                requestAnimationFrame(update);
            } else {
                el.textContent = end.toFixed(2) + ' ' + suffix;
            }
        }

        requestAnimationFrame(update);
    }
    // update to refreshe every few seconds
setInterval(() => {
    fetch('/conversion-stats')
        .then(res => res.json())
        .then(data => {
            const countEl = document.getElementById('file-count');
            const sizeEl = document.getElementById('total-size');

            countEl.textContent = data.count.toLocaleString();

            const sizeInMB = data.total_size_mb;
            const displayValue = sizeInMB >= 1024
                ? { value: sizeInMB / 1024, suffix: 'GB' }
                : { value: sizeInMB, suffix: 'MB' };

            sizeEl.textContent = displayValue.value.toFixed(2) + ' ' + displayValue.suffix;
        });
}, 3000); // runs every 5 seconds
</script>


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
    const files = [];

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
        };
    });

    function addFileRow(file) {
        const id = Date.now() + Math.random();
        files.push({ file, id, converted: false });

        const div = document.createElement('div');
        div.className = "bg-white border px-4 py-3 rounded shadow flex flex-col md:flex-row md:items-center md:justify-between gap-4";
        div.dataset.id = id;

        div.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="text-gray-700">📄</span>
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
                <button class="bg-green-600 text-white px-3 py-1 rounded hidden download-btn">Download</button>
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
        };

        fileList.classList.remove('hidden');
        fileList.appendChild(div);
    }

    convertBtn.onclick = () => {
        convertBtn.disabled = true;
        files.forEach(({ file, id, converted }) => {
            if (converted) return;

            const div = document.querySelector(`[data-id='${id}']`);
            const status = div.querySelector(".status");
            const format = div.querySelector(".format-select").value;
            const downloadBtn = div.querySelector(".download-btn");

            const formData = new FormData();
            formData.append("image", file);
            formData.append("format", format);

            status.textContent = "Processing...";
            status.className = "status text-sm font-medium text-blue-600";

            fetch("/convert-file", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    status.textContent = "Complete";
                    status.className = "status text-sm font-medium text-green-600";

                    downloadBtn.href = data.download;
                    downloadBtn.classList.remove("hidden");
                    downloadBtn.setAttribute("download", "");
                    files.find(f => f.id === id).converted = true;
                } else {
                    status.textContent = "Failed";
                    status.className = "status text-sm font-medium text-red-600";
                }
            })
            .catch(() => {
                status.textContent = "Failed";
                status.className = "status text-sm font-medium text-red-600";
            })
            .finally(() => {
                convertBtn.disabled = false;
            });
        });
    };
</script>

</body>
</html>
