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
<body class="bg-gray-100 text-white">

    <!-- Header -->
    <header class="bg-green-500 container mx-auto px-4 py-6 flex justify-between items-center">
        <a href="/"><h1 class="text-xl font-bold">PNGenius</h1></a>
        <nav class="space-x-6 hidden md:flex">
            <a href="#" class="hover:underline">Home</a>
            <a href="#" class="hover:underline">Convert Image</a>
            <a href="#" class="hover:underline">Advanced Tools</a>
            <a href="#" class="hover:underline">Help</a>
        </nav>
        <a href="#" class="bg-white text-green-500 px-4 py-2 rounded hover:bg-gray-100">Sign In</a>
    </header>
    
  
    <!-- Centered Download Section -->
    <section class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-20">
        
        <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-xl text-center text-black">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Processing Image</h1>

            <div id="progress" class="text-gray-600 text-sm">Converting your image, please wait...</div>

            <div id="download-section" class="{{ session('converted_path') ? '' : 'hidden' }}">
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

        

        
    </section>
<div id="conversion-count" class="text-[25px] text-center text-black mb-6">
        Loading conversion count...
    </div>
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

    <!-- Optional JS (if needed for conversion count or later enhancements) -->
    <script>
        function fetchConversionCount() {
            fetch("{{ route('image.count') }}")
                .then(response => response.json())
                .then(data => {
                    const counter = document.getElementById("conversion-count");
                    if (counter) {
                        counter.textContent = new Intl.NumberFormat().format(data.count) + " images converted so far 🎉";
                    }
                });
        }

        // Optional if you're still displaying conversion count
        fetchConversionCount();
        setInterval(fetchConversionCount, 5000);
    </script>

</body>
</html>









{{-- <!DOCTYPE html>
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
</html> --}}
