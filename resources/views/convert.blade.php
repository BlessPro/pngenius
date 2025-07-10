{{-- <!DOCTYPE html>
<html>
<head>
    <title>Image Converter</title>
</head>
<body>
    <h1>Upload Image</h1>

    <form action="{{ route('image.analyze') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required>
        <button type="submit">Analyze</button>
    </form>

    @if (session('preview_url'))
        <hr>
        <h2>Preview</h2>
        <img src="{{ asset(session('preview_url')) }}" width="300">
        <img src="{{ asset(session('preview_url')) }}" width="300">
        <p>Name: {{ session('image_name') }}</p>
        <p>Format: {{ session('image_type') }}</p>
        <p>Size: {{ session('image_size') }}</p>

        <form action="{{ route('image.convert') }}" method="POST">
            @csrf
            <label>Select format:</label>
            <select name="format" required>
                <option value="jpg">JPG</option>
                <option value="png">PNG</option>
                <option value="webp">WEBP</option>
                <option value="gif">GIF</option>
            </select>
            <button type="submit">Convert</button>
        </form>
    @endif

    <div id="conversion-count" class="text-sm text-center text-gray-600 mb-4">
    Loading conversion count...
</div>

</body>
<script>
    function fetchConversionCount() {
        fetch("{{ route('image.count') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById("conversion-count").textContent =
                    new Intl.NumberFormat().format(data.count) + " images converted so far 🎉";
            });
    }

    fetchConversionCount(); // Initial fetch
    setInterval(fetchConversionCount, 5000); // Poll every 5 seconds
</script>

</html> --}}




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Image Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-500 text-white">
    <!-- Header -->
    <header class="container mx-auto px-4 py-6 flex justify-between items-center">
        <h1 class="text-xl font-bold">PNGenius</h1>
        <nav class="space-x-6 hidden md:flex">
            <a href="#" class="hover:underline">Home</a>
            <a href="#" class="hover:underline">Convert Image</a>
            <a href="#" class="hover:underline">Advanced Tools</a>
            <a href="#" class="hover:underline">Help</a>
        </nav>
        <a href="#" class="bg-white text-green-500 px-4 py-2 rounded hover:bg-gray-100">Sign In</a>
    </header>

    <!-- Hero Section previous -->
    {{-- <section class="text-center px-4 py-12">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">From One Format to Another, Instantly!</h2>
        <p class="text-lg mb-8">Convert your images in seconds. Crisp quality, zero hassle.</p>
        <div class="bg-white text-gray-700 rounded-lg border-2 border-dashed border-green-300 p-8 max-w-2xl mx-auto">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="bg-green-100 text-green-600 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <label for="file-upload" class="cursor-pointer text-blue-600 font-semibold">Click here</label>
                <p class="text-sm">to upload your file or drag.<br>Supported Format: SVG, JPG, PNG, JPEG</p>
                <p class="text-xs text-blue-600"><a href="#" class="underline">Sign Up</a> to upload larger files (over 100MB)</p>
                <form id="upload-form" action="{{ route('image.analyze') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="file-upload" type="file" name="image" class="hidden" required>
                </form>
            </div>
        </div>
    </section> --}}

    
    <!-- Hero Section another old code-->
    {{-- <section class="text-center px-4 py-12">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">From One Format to Another, Instantly!</h2>
        <p class="text-lg mb-8">Convert your images in seconds. Crisp quality, zero hassle.</p>

        <div id="conversion-count" class="text-sm text-center text-white mb-6">
            Loading conversion count...
        </div>

        <form id="upload-form" action="{{ route('image.analyze') }}" method="POST" enctype="multipart/form-data" class="bg-white text-gray-700 rounded-lg border-2 border-dashed border-green-300 p-8 max-w-2xl mx-auto">
            @csrf
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="bg-green-100 text-green-600 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <label for="file-upload" class="cursor-pointer text-blue-600 font-semibold">Click here</label>
                <input id="file-upload" type="file" name="image" class="hidden" required>
                <p class="text-sm">to upload your file or drag.<br>Supported Format: SVG, JPG, PNG, JPEG</p>
                <p class="text-xs text-blue-600"><a href="#" class="underline">Sign Up</a> to upload larger files (over 100MB)</p>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Analyze</button>
            </div>
        </form>

        @if (session('preview_url'))
            <div class="bg-white text-gray-800 rounded-lg shadow-lg max-w-xl mx-auto mt-10 p-6"> --}}
                {{-- <h2 class="text-xl font-bold mb-4">Image Preview</h2> --}}
                {{-- <img src="{{ asset(session('preview_url')) }}" alt="Preview" class="w-full max-h-60 object-contain border rounded mb-4"> --}}
              {{-- <div class="text-sm mb-4 flex justify-between items-center">
    <div class="flex-1 text-left">
        <p><strong>Name:</strong> {{ session('image_name') }}</p>
        <p><strong>Format:</strong> {{ session('image_type') }}</p>
        <p><strong>Size:</strong> {{ session('image_size') }}</p>
    </div>
    <div class="ml-4">
        <img src="{{ asset(session('preview_url')) }}" alt="Preview" class="w-200 h-200 object-contain border rounded">
    </div>
</div>

                <form action="{{ route('image.convert') }}" method="POST" class="space-y-4">
                    @csrf
                    <label class="block text-sm font-medium">Select Format:</label>
                    <select name="format" required class="w-full border rounded p-2">
                        <option value="jpg">JPG</option>
                        <option value="png">PNG</option>
                        <option value="webp">WEBP</option>
                        <option value="gif">GIF</option>
                    </select>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Convert</button>
                </form>
            </div>
        @endif
    </section> --}}



    <!-- Hero Section -->
<section class="text-center px-4 py-12">
    <h2 class="text-3xl md:text-4xl font-bold mb-4">From One Format to Another, Instantly!</h2>
    <p class="text-lg mb-8">Convert your images in seconds. Crisp quality, zero hassle.</p>

    <div id="conversion-count" class="text-sm text-center text-white mb-6">
        Loading conversion count...
    </div>

    {{-- Side-by-side container --}}
    <div class="flex flex-col md:flex-row md:space-x-6 items-start justify-center max-w-6xl mx-auto">
        {{-- Upload Form (Left) --}}
        <form id="upload-form" 
              action="{{ route('image.analyze') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="bg-white text-gray-700 rounded-lg border-2 border-dashed border-green-300 p-8 w-full md:w-1/2">
            @csrf
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="bg-green-100 text-green-600 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <label for="file-upload" class="cursor-pointer text-blue-600 font-semibold">Click here</label>
                <input id="file-upload" type="file" name="image" class="hidden" required>
                <p class="text-sm">to upload your file or drag.<br>Supported Format: SVG, JPG, PNG, JPEG</p>
                <p class="text-xs text-blue-600"><a href="#" class="underline">Sign Up</a> to upload larger files (over 100MB)</p>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Analyze</button>
            </div>
        </form>

        {{-- Convert Form with Preview (Right) --}}
        @if (session('preview_url'))
        <div class="bg-white text-gray-800 rounded-lg shadow-lg p-6 w-full md:w-1/2 mt-8 md:mt-0">
            <div class="text-sm mb-4 flex justify-between items-center">
                <div class="flex-1 text-left">
                    <p><strong>Name:</strong> {{ session('image_name') }}</p>
                    <p><strong>Format:</strong> {{ session('image_type') }}</p>
                    <p><strong>Size:</strong> {{ session('image_size') }}</p>
                </div>
                <div class="ml-4">
                    <img src="{{ asset(session('preview_url')) }}" alt="Preview" class="w-[100px] h-[100px] object-contain border rounded">
                </div>
            </div>

            <form action="{{ route('image.convert') }}" method="POST" class="space-y-4">
                @csrf
                <label class="block text-sm font-medium">Select Format:</label>
                <select name="format" required class="w-full border rounded p-2">
                    <option value="jpg">JPG</option>
                    <option value="png">PNG</option>
                    <option value="webp">WEBP</option>
                    <option value="gif">GIF</option>
                </select>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Convert</button>
            </form>
        </div>
        @endif
    </div>
</section>

    <!-- Features Section -->
    <section class="bg-white text-gray-800 py-12 px-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-green-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405M4 4v16h16V4H4z"></path></svg>
                </div>
                <h3 class="font-bold mb-2">Multi-Format Support</h3>
                <p>Convert a wide range of file types including images, audio, and video.</p>
            </div>
            <div>
                <div class="text-green-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h3v4H3v4h18v-4h-3v-4h3V6H3v4z"></path></svg>
                </div>
                <h3 class="font-bold mb-2">Fast & Easy Upload</h3>
                <p>Drag-and-drop or click-to-upload with clear limits and progress indicators.</p>
            </div>
            <div>
                <div class="text-green-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-bold mb-2">High-Quality Conversion</h3>
                <p>Maintain quality with resolution and compression options.</p>
            </div>
            <div>
                <div class="text-green-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2h-5m0 0V2m0 2a2 2 0 012 2v2a2 2 0 01-2 2h-4m4 0V8"></path></svg>
                </div>
                <h3 class="font-bold mb-2">Batch Conversion</h3>
                <p>Convert multiple files at once and streamline your workflow.</p>
            </div>
            <div>
                <div class="text-green-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
                <h3 class="font-bold mb-2">No Software Installation</h3>
                <p>Fully web-based. No downloads needed. Accessible from any device.</p>
            </div>
            <div>
                <div class="text-green-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 4h.01M6.938 4.938a9 9 0 1110.125 0"></path></svg>
                </div>
                <h3 class="font-bold mb-2">Secure & Private</h3>
                <p>All transfers are encrypted. Files are deleted after conversion.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-sm">
            <div>
                <h4 class="text-white font-bold mb-2">PNGenius</h4>
                <p>Build a modern and creative image conversion tool.</p>
                <div class="flex mt-4 space-x-3">
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/facebook--v1.png"/></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/twitter--v1.png"/></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/instagram-new.png"/></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/linkedin.png"/></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-bold mb-2">Product</h4>
                <ul class="space-y-1">
                    <li><a href="#" class="hover:underline">Landingpage</a></li>
                    <li><a href="#" class="hover:underline">Features</a></li>
                    <li><a href="#" class="hover:underline">Documentation</a></li>
                    <li><a href="#" class="hover:underline">Pricing</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-2">Company</h4>
                <ul class="space-y-1">
                    <li><a href="#" class="hover:underline">About</a></li>
                    <li><a href="#" class="hover:underline">Terms</a></li>
                    <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                    <li><a href="#" class="hover:underline">Careers</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-2">More</h4>
                <ul class="space-y-1">
                    <li><a href="#" class="hover:underline">Documentation</a></li>
                    <li><a href="#" class="hover:underline">License</a></li>
                    <li><a href="#" class="hover:underline">Changelog</a></li>
                </ul>
            </div>
        </div>
    </footer>
    
    <script>
        function fetchConversionCount() {
            fetch("{{ route('image.count') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("conversion-count").textContent =
                        new Intl.NumberFormat().format(data.count) + " images converted so far 🎉";
                });
        }

        fetchConversionCount();
        setInterval(fetchConversionCount, 5000);
    </script>
</body>
</html>
{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Image Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-500 text-white">
    <!-- Header -->
    <header class="container mx-auto px-4 py-6 flex justify-between items-center">
        <h1 class="text-xl font-bold">PNGenius</h1>
        <nav class="space-x-6 hidden md:flex">
            <a href="#" class="hover:underline">Home</a>
            <a href="#" class="hover:underline">Convert Image</a>
            <a href="#" class="hover:underline">Advanced Tools</a>
            <a href="#" class="hover:underline">Help</a>
        </nav>
        <a href="#" class="bg-white text-green-500 px-4 py-2 rounded hover:bg-gray-100">Sign In</a>
    </header>

    <!-- Hero Section -->
    <section class="text-center px-4 py-12">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">From One Format to Another, Instantly!</h2>
        <p class="text-lg mb-8">Convert your images in seconds. Crisp quality, zero hassle.</p>

        <div id="conversion-count" class="text-sm text-center text-white mb-6">
            Loading conversion count...
        </div>

        <form id="upload-form" action="{{ route('image.analyze') }}" method="POST" enctype="multipart/form-data" class="bg-white text-gray-700 rounded-lg border-2 border-dashed border-green-300 p-8 max-w-2xl mx-auto">
            @csrf
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="bg-green-100 text-green-600 p-4 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <label for="file-upload" class="cursor-pointer text-blue-600 font-semibold">Click here</label>
                <input id="file-upload" type="file" name="image" class="hidden" required>
                <p class="text-sm">to upload your file or drag.<br>Supported Format: SVG, JPG, PNG, JPEG</p>
                <p class="text-xs text-blue-600"><a href="#" class="underline">Sign Up</a> to upload larger files (over 100MB)</p>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Analyze</button>
            </div>
        </form>

        @if (session('preview_url'))
            <div class="bg-white text-gray-800 rounded-lg shadow-lg max-w-xl mx-auto mt-10 p-6">
                <h2 class="text-xl font-bold mb-4">Image Preview</h2>
                <img src="{{ asset(session('preview_url')) }}" alt="Preview" class="w-full max-h-60 object-contain border rounded mb-4">
                <div class="text-sm mb-4">
                    <p><strong>Name:</strong> {{ session('image_name') }}</p>
                    <p><strong>Format:</strong> {{ session('image_type') }}</p>
                    <p><strong>Size:</strong> {{ session('image_size') }}</p>
                </div>
                <form action="{{ route('image.convert') }}" method="POST" class="space-y-4">
                    @csrf
                    <label class="block text-sm font-medium">Select Format:</label>
                    <select name="format" required class="w-full border rounded p-2">
                        <option value="jpg">JPG</option>
                        <option value="png">PNG</option>
                        <option value="webp">WEBP</option>
                        <option value="gif">GIF</option>
                    </select>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Convert</button>
                </form>
            </div>
        @endif
    </section>

    <script>
        function fetchConversionCount() {
            fetch("{{ route('image.count') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("conversion-count").textContent =
                        new Intl.NumberFormat().format(data.count) + " images converted so far 🎉";
                });
        }

        fetchConversionCount();
        setInterval(fetchConversionCount, 5000);
    </script>
</body>
</html> --}}
{{-- 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Convert Image</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Convert Your Image</h1>

        <div id="conversion-count" class="text-sm text-center text-gray-600 mb-4">
            Loading conversion count...
        </div>

        <form action="{{ route('image.analyze') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="image" required class="w-full border rounded p-2">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Analyze</button>
        </form>

        @if (session('preview_url'))
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Preview</h2>
                <img src="{{ asset(session('preview_url')) }}" class="w-full max-h-60 object-contain border mb-4 rounded" alt="Image Preview">
                <div class="text-sm text-gray-700">
                    <p><strong>Name:</strong> {{ session('image_name') }}</p>
                    <p><strong>Format:</strong> {{ session('image_type') }}</p>
                    <p><strong>Size:</strong> {{ session('image_size') }}</p>
                </div>

                <form action="{{ route('image.convert') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <label class="block text-sm font-medium">Select Format:</label>
                    <select name="format" required class="w-full border rounded p-2">
                        <option value="jpg">JPG</option>
                        <option value="png">PNG</option>
                        <option value="webp">WEBP</option>
                        <option value="gif">GIF</option>
                    </select>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Convert</button>
                </form>
            </div>
        @endif
    </div>

    <script>
        function fetchConversionCount() {
            fetch("{{ route('image.count') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("conversion-count").textContent =
                        new Intl.NumberFormat().format(data.count) + " images converted so far 🎉";
                });
        }

        fetchConversionCount();
        setInterval(fetchConversionCount, 5000);
    </script>
</body>
</html> --}}
