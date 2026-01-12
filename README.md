# PNGenius - Simple and Smart Image Conversion for Creatives

PNGenius is a lightweight, efficient web app built for designers, photographers, and creatives who work with images. Whether you are converting logos for web use or resizing product photos, PNGenius makes it simple to upload, preview, convert, and download your images with ease and speed.

> We're building a beautiful space for creatives to convert images quickly and effortlessly.

### Documentation

- [View PNGenius v1 Algorithm Flow (Legacy)](./VERSION-1.md)
- [Upgrade Notes and Roadmap](./VERSION-2.md)

---

## Features

- Multi-Image Upload: Easily upload one or several images (up to 10 at a time).
- Format Conversion: Convert images into formats such as JPG, PNG, WebP, and GIF. BMP and TIFF are used when supported by the image driver, otherwise PNG is used.
- Image Analysis: Extract key file metadata (name, size, MIME type).
- AJAX-Powered Conversion: Enjoy seamless conversion with no page reload.
- Live Conversion Counter: View real-time stats on the number and size of files converted.
- Responsive UI: Optimized for both desktop and mobile experiences.
- Background Removal (Basic): Simple background removal that outputs PNG with transparency on the Remove BG page.
- Image to PDF: Combine multiple images into a single PDF with one page per image, sized to the image.
- Batch ZIP Download: Download multiple converted images as a single ZIP after conversion.

---

## Current Conversion Flow

1. Upload Images:
   Users drag and drop images or click to add files. Each image is listed with its file name, a dropdown for selecting the target format, a remove button, and a status (default: "Waiting"). If more than 10 files are added, the upload is blocked and a popup alert is shown.

2. Select Formats:
   For each image in the list, users select a desired output format (for example, JPG, PNG, WEBP). This information is saved client-side - no conversion occurs yet.

3. Convert Images:
   When the user clicks the Convert button, JavaScript loops through the list of images (that have not been converted and have a target format) and:
   - Updates the status to "Processing..."
   - Sends an AJAX POST request per file, including the file and the selected format.
   - The backend validates, temporarily stores the file, converts it using Intervention Image, and saves it to `storage/app/public/converted`.
   - The conversion is logged in the database (for the conversion counter) and the backend returns a JSON response with status, download URL, and converted file size.

4. Display Results:
   Each image's status is updated to "Finished" with a download button on success. On failure, the status shows "Failed" along with an optional error tooltip or retry prompt. When at least two files finish converting, a "Download ZIP" button appears for a bundled download.

5. User Interaction Continues:
   Users can add new images (while already converted ones remain in the list), download finished images at any time, or remove images from the list.

6. Real-Time Conversion Counter:
   A periodic AJAX GET request to `/conversion-count` provides live stats like, "We've already converted 2,551,238,187 files with a total size of 20,010 TB."

Note: This describes the current version; a new, upgraded algorithm is in development for even more powerful, AJAX-based multi-image processing.

---

## Image to PDF Flow

1. Upload Images:
   Users add up to 10 images. Each image becomes a page in the final PDF.

2. Create PDF:
   The backend converts each image to JPEG for embedding and builds a PDF where each page matches the original image size and orientation.

3. Download:
   The resulting PDF is stored in `storage/app/public/converted` and returned for download.

---

## Tech Stack

### Frontend (Client-Side)

| Tool | Role |
| --- | --- |
| Blade (Laravel) | Templating engine for the HTML UI |
| Tailwind CSS | Styling framework for responsive, utility-first design |
| JavaScript (Vanilla) | Handles UI interactivity, file uploads, and AJAX-based conversion requests |
| Fetch API | Manages AJAX communication with the backend (upload, convert, poll conversion count) |
| Custom Modal/Alert JS | Notifies the user when file limits (max 10) are exceeded |

---

### Backend (Server-Side)

| Tool | Role |
| --- | --- |
| Laravel (PHP) | Main web framework that handles routing, requests, validation, and responses |
| Intervention Image (Gd Driver) | Performs image manipulation tasks (resizing, format conversion, etc.) |
| Laravel Storage | Stores both uploaded and converted images in `public/` |
| Laravel Session | Manages temporary image information between upload and conversion |
| Eloquent ORM / DB | Stores conversion logs for real-time statistics |
| AJAX Route Endpoint | A dedicated controller method (`convertFile(Request $request)`) to manage conversions |

---

### Database

| Tool | Role |
| --- | --- |
| PostgreSQL / SQLite | Stores conversion logs (timestamp, file size, etc.) for analytics and real-time stats |
| image_conversions Table | Dedicated table used for tracking conversion counts shown in the UI footer |

---

### File Storage

| Tool | Role |
| --- | --- |
| Local Disk (Laravel Public) | Temporarily stores uploaded and converted images |
| Optional S3 / Cloud Storage | Future support for scalable, cloud-based storage |

Optional cleanup: set `PNGENIUS_CLEANUP_DAYS` to a positive integer to remove converted files older than that many days during new conversions.

---

### Testing and Dev Tools

| Tool | Role |
| --- | --- |
| Laravel Valet / Sail / XAMPP / Homestead | Options for local development environments |
| Browser DevTools | For inspecting AJAX requests and debugging UI logic |
| Postman (optional) | To manually test API endpoints if needed |

---

## Local Setup (PostgreSQL)

1. Install PostgreSQL and enable the PHP pgsql extension.
2. Create a database (for example, `pngenius`).
3. Copy `.env.example` to `.env` and set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
4. Run migrations: `php artisan migrate`.
5. (Optional) Create the storage link: `php artisan storage:link`.
6. Start the app: `composer run dev` (serves on port 9001 by default).

Example psql commands:
```
CREATE DATABASE pngenius;
CREATE USER pngenius_user WITH PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE pngenius TO pngenius_user;
```

---

## Docker (Compose)

1. Copy `.env.example` to `.env` and set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` (Docker will use these values).
2. If you do not already have an `APP_KEY`, generate one locally (`php artisan key:generate`) or set it in `.env`.
3. Build and start the containers:
   ```
   docker compose up --build
   ```
4. If migrations fail because the database is still starting, run:
   ```
   docker compose exec app php artisan migrate
   ```
5. Visit the app at `http://localhost:9001` (override with `APP_PORT` in `.env`).

Note: The container serves on port 8000, mapped to 9001 by default.

---

## Documentation

For more in-depth details, refer to:
- [v1 Algorithm Flow](./VERSION-1.md)
- [v2 Upgrade Notes](./VERSION-2.md)
- [Changelog](./CHANGELOG.md)

---

## Future Enhancements

- Additional image editing tools (crop, resize, compression levels)
- Batch conversion improvements and thumbnail previews
- Auto-cleanup routines for temporary files
- Optional user accounts with personal conversion histories
- Cloud storage integration via S3

---

## Powered By Laravel

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework" ><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. Development should be an enjoyable and creative experience. Laravel takes the pain out of development by easing common tasks in many web projects, such as:

- Simple, fast routing engine
- Powerful dependency injection container
- Multiple back-ends for session and cache storage
- Expressive, intuitive database ORM
- Database agnostic schema migrations
- Robust background job processing
- Real-time event broadcasting

Laravel is accessible, powerful, and provides the tools necessary for building large, robust applications.

---

## Learning Laravel

Laravel comes with extensive and thorough documentation and a comprehensive video tutorial library. You may also try the Laravel Bootcamp to build a modern Laravel application from scratch. For video tutorials, check out Laracasts.

---

## Laravel Sponsors

We extend our thanks to these sponsors for funding Laravel development. To learn about sponsorship, visit the Laravel Partners program.

### Premium Partners

- Vehikl
- Tighten Co.
- Kirschbaum Development Group
- 64 Robots
- Curotec
- DevSquad
- Redberry
- Active Logic

---

## Contributing

Thank you for considering contributing to PNGenius. For guidance on how to contribute, please see our contribution guidelines or refer to the Laravel documentation for tips.

---

## Code of Conduct

To ensure a welcoming community, please review and abide by our Code of Conduct as well as Laravel's Code of Conduct.

---

## Security Vulnerabilities

If you discover a security vulnerability within PNGenius or have concerns regarding Laravel integration, please email us at acesquare52@gmail.com or bless53doe3@gmail.com. All issues will be promptly addressed.

---

## License

The PNGenius project is open-sourced software licensed under the MIT license.
