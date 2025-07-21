# 🧠 PNGenius — Simple & Smart Image Conversion for Creatives

PNGenius is a lightweight, efficient web app built for designers, developers, photographers, and all creatives who work with images. Whether you're converting a logo to WebP or resizing product photos, PNGenius helps you **upload, preview, convert**, and **download** images effortlessly.

> We’re building a nice and fast place for creatives to convert images with ease — no clutter, no fuss.

---

## ✨ Features

- 🎯 Upload and convert single or multiple images at once
- 🖼️ Convert to JPG, PNG, WEBP, GIF (TIFF, BMP coming soon)
- 🧠 Auto-detect image type and metadata
- 🚀 Real-time conversion with AJAX (no page reloads)
- 🔢 Live conversion counter in footer
- 📱 Responsive design for desktop & mobile
- ✅ Future-ready for cloud scaling (S3 support planned)

---

## 🔧 Tech Stack

### 🖼️ Frontend (Client-Side)

| Tool                  | Role                                                             |
|-----------------------|------------------------------------------------------------------|
| **Blade (Laravel)**   | Templating engine for the HTML UI                                |
| **Tailwind CSS**      | Styling framework for responsive, utility-first design           |
| **JavaScript (Vanilla)** | Handles UI interactivity, file uploads, and AJAX logic          |
| **Fetch API**         | AJAX communication with backend (upload, convert, poll count)    |
| **Custom Modal/Alert JS** | Alerts users when they exceed the file limit (max 10)         |

---

### 🧾 Backend (Server-Side)

| Tool                          | Role                                                                    |
|-------------------------------|-------------------------------------------------------------------------|
| **Laravel (PHP)**             | Main framework — handles routing, validation, file processing, etc.     |
| **Intervention Image (Gd)**   | Image manipulation: format conversion, resizing, metadata reading       |
| **Laravel Storage**           | Stores uploaded and converted images                                    |
| **Laravel Session**           | Tracks temporary image info per session                                 |
| **Eloquent ORM / DB**         | Logs conversions for stats + analytics                                  |
| **AJAX Endpoint**             | `/convert` controller handles per-file conversion requests              |

---

### 🗃️ Database

| Tool                  | Role                                                            |
|-----------------------|-----------------------------------------------------------------|
| **MySQL / MariaDB / SQLite** | Stores logs (filename, format, time, size, etc.)          |
| **image_conversions** table | Drives the real-time conversion counter on the footer     |

---

### 📁 File Storage

| Tool                          | Role                                                   |
|-------------------------------|--------------------------------------------------------|
| **Laravel Public Disk**       | Temporary store for uploaded and converted files       |
| **(Optional) AWS S3**         | Planned support for cloud storage at scale             |

---

### 🧪 Testing & Dev Tools

| Tool                        | Role                                                           |
|-----------------------------|----------------------------------------------------------------|
| **Laravel Valet / Sail / XAMPP / Homestead** | Local dev environment options             |
| **Browser DevTools**        | Debug frontend and AJAX logic                                  |
| **Postman (optional)**      | Manually test file endpoints and conversion logic              |

---

## 📁 Documentation

- [`algo-v1.md`](algo-v1.md) — Original conversion algorithm (single image, basic)
- [`algo-v2.md`](algo-v2.md) — Upgraded multi-image AJAX conversion system with real-time UI

---

## 📌 Future Enhancements

- ✂️ Cropping, resizing & compression level control
- 🔍 Live image previews (before/after)
- 🧼 Auto-cleanup queue for temporary files
- 🔐 User accounts with history tracking
- ☁️ Cloud sync (S3, GDrive optional)

---

## 🤝 Contributing

Feel free to fork and suggest improvements. Bug reports, UI ideas, and optimization suggestions are welcome.

---

## 🧑‍🎨 Made for Creatives, by Creatives.

---

