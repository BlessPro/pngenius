<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNGenius - Convert Image</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-800">
    <!-- Header -->
    <header class="bg-green-500 text-white">
        <div class="container mx-auto px-4 py-6 flex items-center justify-between">
            <div class="text-2xl font-bold">PNGenius</div>
            <nav class="space-x-4 hidden md:block">
                <a href="#" class="hover:underline">Home</a>
                <a href="#" class="hover:underline">Convert Image</a>
                <a href="#" class="hover:underline">Advanced Tools</a>
                <a href="#" class="hover:underline">Help</a>
            </nav>
            <button class="hidden md:inline-block px-4 py-1 border border-white rounded hover:bg-white hover:text-green-600 transition">Sign In</button>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-green-500 text-white py-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">From One Format to Another, Instantly!</h1>
        <p class="max-w-2xl mx-auto text-lg">Convert your images in seconds. Crisp quality, zero hassle. Convert your image files online. Amongst many others, we support PNG, JPG, GIF, WEBP and HEIC. You can use the options to control image resolution, quality and file size.</p>
    </section>

    <!-- Upload section -->
    <section class="bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-6">
                <button id="file-btn" class="bg-green-600 text-white px-6 py-3 rounded font-semibold hover:bg-green-700">➕ Add Image(s)</button>
                <input id="file-input" type="file" accept="image/*" multiple hidden>
            </div>
            <div id="file-list" class="space-y-4"></div>
            <div class="text-center mt-8">
                <button id="convert-all" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 disabled:opacity-50">Convert</button>
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

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
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
</body>
</html>
