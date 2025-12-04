# Simple PHP CRUD - Products

## Deskripsi
Aplikasi backend sederhana CRUD untuk entitas `products`. Fitur: Create, Read, Update, Delete; file upload (image jpg/png <2MB); validasi dasar; PDO prepared statements.

## Requirement
- PHP 8.x
- MySQL / MariaDB
- PDO extension enabled

## Setup
1. Import database:
   - `mysql -u root -p < schema.sql` (atau gunakan phpMyAdmin)
2. Sesuaikan koneksi DB di `src/Config.php`.
3. Jalankan built-in server:
   - `php -S localhost:8000 -t public`
4. Akses: `http://localhost:8000/index.php`

## Struktur folder
- `public/` — file web (index, create, edit...)
- `src/` — konfigurasi, class, repository
- `public/uploads/` — tempat menyimpan gambar upload

## Class utama
- `Database` — wrapper koneksi PDO.
- `Product` — entity sederhana.
- `ProductRepository` — operasi DB (CRUD) menggunakan PDO prepared statements.

## Uji singkat
1. Buka `create.php`, tambahkan product + gambar.
2. Lihat daftar di `index.php`.
3. Edit product, coba ganti/biarkan gambar.
4. Hapus product.

