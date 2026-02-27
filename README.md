# Archive Management System (MVC PHP 8+)

Sistem ini adalah kerangka **MVC sederhana** untuk archive/document management yang bisa dikembangkan menjadi sistem surat menyurat perusahaan.

## Fitur inti
- MVC native PHP (tanpa framework berat) untuk menjaga aplikasi tetap sederhana.
- RBAC (Role Based Access Control) berbasis permission + kontrol akses per-folder (`folder_permissions`).
- Sharing ala Google Drive (share folder/file ke user tertentu dengan hak akses read/create/update/delete).
- Audit trail aktivitas user (CREATE/READ/UPDATE/DELETE/LOGIN/LOGOUT).
- Manajemen user + aktif/nonaktif user.
- Manajemen folder arsip yang rapi (hierarki + path unik).
- Kategori surat + ringkasan pembahasan surat.
- Rekap penomoran surat dengan format pattern yang bisa dikustom.
- Daftar arsip dengan link preview PDF.
- DataTables + SweetAlert + Preline UI.

## Stack
- PHP >= 8.0 (direkomendasikan 8.4 sesuai kebutuhan Anda)
- MySQL 8+
- HTML + JavaScript
- Preline CSS (+ Tailwind runtime CDN)

## Struktur folder
```bash
app/
  Controllers/
  Core/
  Models/
  Services/
  Views/
config/
database/schema.sql
public/index.php
routes/web.php
```

## Cara jalankan lokal
1. Buat database dan tabel:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
2. Jalankan web server bawaan PHP:
   ```bash
   php -S 0.0.0.0:8000 -t public
   ```
3. Login awal:
   - Email: `admin@example.com`
   - Password: `password`

## Catatan pengembangan lanjutan
- Tambahkan upload file PDF + storage manager.
- Tambahkan generator nomor surat otomatis dari `format_pattern`.
- Tambahkan workflow approval surat + tanda tangan digital.
- Tambahkan REST API jika ingin mobile/web client terpisah.
