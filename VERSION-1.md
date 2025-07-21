## 🧠 Current Algorithm Flow (Legacy)

This is the current (initial) logic used for the PNGenius image conversion app. This flow will be kept as a reference as future upgrades introduce newer algorithms and a more refined architecture.

### 🔁 Step-by-Step Flow

1. **User Uploads Image**  
   The user selects an image file and submits the form via a `POST` request.

2. **Laravel Handles the Upload**  
   - Laravel validates the file.
   - Stores it in a designated temporary location.

3. **Analyze Image**  
   - `Intervention\Image` is used to extract metadata:
     - Image name
     - File size
     - MIME type
   - The app displays basic image info and a dropdown of formats to convert into.

4. **User Selects Format**  
   - The user selects the desired output format from the dropdown.
   - A "Convert" button becomes active.

5. **Convert Image**  
   - On click, Laravel converts the uploaded image into the selected format.
   - The new file is generated and stored.

6. **Fake Progress Bar**  
   - A fake loading animation is shown for a short duration.
   - This helps create a smooth UX while processing.

7. **Redirect to Summary/Download Page**  
   - After conversion, the user is redirected to a summary page.
   - File details and download link are shown.

8. **Download File**  
   - Converted image is stored in `storage/app/public`.
   - A direct download link is provided to the user.

---

> ✅ **Note:** This algorithm is the initial version and is planned to evolve as more advanced features (e.g., batch conversion, AI-based compression, etc.) are introduced.
