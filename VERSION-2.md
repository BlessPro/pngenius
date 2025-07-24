# 🔁 PNGenius v2 — Multi-Image AJAX Conversion Flow

This document outlines the updated image conversion algorithm for PNGenius, supporting batch uploads and AJAX-based conversion.

---

## 📸 STEP 1: User Uploads Image(s)

- User clicks **Add Files** or drags and drops images into the upload area.
- Each file added is managed by a JavaScript object list with:
  - File name
  - “Convert to” dropdown
  - ❌ Remove button
  - Status label (default: `Waiting`)
- If total selected files exceed **10**, block the upload and display a popup alert.

---

## 🛠 STEP 2: User Selects Formats

- For each uploaded file, the user selects a desired output format (e.g., JPG, PNG, WEBP).
- The selected format is saved with the file in JS memory.
- **No conversion occurs yet** — this is just preparation.

---

## 🚀 STEP 3: User Clicks “Convert”

- JavaScript loops through each uploaded image that:
  - Is not already converted
  - Has a format selected

For each file:

- Update status: `Processing...`
- Send an **AJAX POST** request with:
  - Image file
  - Target format

---

### 🧠 Backend Processing (Laravel)

- Validate image and format
- Temporarily store image
- Use `Intervention\Image` to convert it
- Save converted image to: `storage/app/public/converted`
- Log the conversion (for footer stats)
- Return a JSON response:
  ```json
  {
    "status": "success",
    "download_url": "...",
    "converted_size": "..."
  }
