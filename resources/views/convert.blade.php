<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Multi Image Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-800 min-h-screen">
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
        <div class="text-center mb-6">
            <button id="file-btn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold">ADD IMAGE(S)</button>
            <input id="file-input" type="file" accept="image/*" multiple hidden>
        </div>

        <div id="file-list" class="space-y-4 max-w-4xl mx-auto hidden"></div>

        <div class="text-center mt-10">
            <button id="convert-all" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 disabled:opacity-50">CONVERT</button>
        </div>
    </section>

    <script>
        const MAX_FILES = 10;
        const fileInput = document.getElementById('file-input');
        const fileBtn = document.getElementById('file-btn');
        const fileList = document.getElementById('file-list');
        const convertBtn = document.getElementById('convert-all');
        const files = [];

        fileBtn.onclick = () => fileInput.click();

        fileInput.onchange = () => {
            const newFiles = Array.from(fileInput.files);
            if ((files.length + newFiles.length) > MAX_FILES) {
                alert("You can only upload a maximum of 10 images.");
                return;
            }
            if (newFiles.length > 0) fileList.classList.remove('hidden');
            newFiles.forEach(addFileRow);
            fileInput.value = null;
        };

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
                if (files.length === 0) fileList.classList.add('hidden');
            };

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
        }
    </script>
</body>
</html>
