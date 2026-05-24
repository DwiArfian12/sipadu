<p align="center">
    <img src="https://img.shields.io/badge/Laravel-10.x-red?style=for-the-badge&logo=laravel" alt="Laravel 10.x">
    <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php" alt="PHP 8.1+">
    <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS 3.x">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

<h1 align="center">📊 SIPADU UNY</h1>
<h3 align="center">Sistem Informasi Pusat Data - Universitas Negeri Yogyakarta</h3>

<p align="center">
    Aplikasi manajemen data dinamis berbasis web yang memungkinkan pembuatan jenis data kustom, 
    pengelolaan record data, impor/ekspor data, serta integrasi crawling dan API.
</p>

---

## 📋 Daftar Isi

- [Tentang Aplikasi](#-tentang-aplikasi)
- [Fitur Utama](#-fitur-utama)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Role Pengguna](#-role-pengguna)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Database](#-struktur-database)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [API Endpoints](#-api-endpoints)
- [Crawling & Integrasi API](#-crawling--integrasi-api)
- [Impor & Ekspor Data](#-impor--ekspor-data)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Aplikasi

**SIPADU UNY** (Sistem Informasi Pusat Data Universitas Negeri Yogyakarta) adalah aplikasi manajemen data yang fleksibel dan dinamis. Aplikasi ini memungkinkan institusi untuk mendefinisikan **jenis data kustom** (seperti Berita, Mahasiswa, Dosen, Penelitian, dll.) beserta field-fieldnya secara dinamis tanpa perlu mengubah kode program.

Dengan pendekatan **Entity-Attribute-Value (EAV)** yang diimplementasikan secara modern, SIPADU memberikan fleksibilitas penuh dalam pengelolaan data dengan fitur:

- ✅ **Dynamic Data Types** — Buat jenis data baru kapan saja
- ✅ **Custom Fields** — Tentukan field dengan berbagai tipe data
- ✅ **Multi-level Access** — Superadmin dan Admin Data dengan hak akses berbeda
- ✅ **Import/Export** — Impor data dari Excel, ekspor ke CSV/Excel
- ✅ **Crawling & API** — Integrasi dengan sumber data eksternal
- ✅ **Search & Filter** — Pencarian dan penyaringan data yang powerful

---

## ✨ Fitur Utama

### 🔷 Manajemen Jenis Data (Data Types)
- Membuat, mengedit, dan menghapus jenis data secara dinamis
- Setiap jenis data memiliki slug unik untuk identifikasi
- Deskripsi untuk dokumentasi setiap jenis data

### 🔷 Manajemen Field (Data Fields)
- Menambahkan field kustom ke setiap jenis data
- Mendukung berbagai tipe field:
  - `text` — Teks pendek
  - `textarea` — Teks panjang
  - `number` — Angka
  - `email` — Alamat email
  - `url` — URL/Link
  - `date` — Tanggal
  - `dropdown` — Pilihan (dengan opsi kustom)
  - `image` — Upload gambar
  - `file` — Upload file
- Konfigurasi per field:
  - **Required** — Wajib diisi
  - **Searchable** — Dapat dicari
  - **Filterable** — Dapat difilter
  - **Sortable** — Dapat diurutkan
  - **Show in Table** — Ditampilkan di tabel
  - **Order** — Urutan tampilan

### 🔷 Manajemen Record Data
- CRUD lengkap untuk data record
- Validasi dinamis berdasarkan konfigurasi field
- Upload file/gambar dengan penyimpanan di storage
- Sorting multi-kolom
- Pagination dengan jumlah per halaman yang dapat diatur
- Pencarian global pada field yang searchable
- Filter per field yang filterable

### 🔷 Manajemen Pengguna
- Dua role pengguna: **Superadmin** dan **Admin Data**
- Assign jenis data tertentu ke Admin Data
- Profil pengguna dengan NIP dan nomor telepon

### 🔷 Impor & Ekspor Data
- **Ekspor ke CSV** — Download data dengan format CSV (UTF-8 BOM untuk kompatibilitas Excel)
- **Template Excel** — Download template dengan format XLSX
  - Header dengan styling (bold, warna hijau)
  - Data validation dropdown untuk field bertipe dropdown
  - Contoh data pada baris ketiga
  - Baris petunjuk (instruction row)
- **Impor dari Excel** — Upload file XLSX/XLS/CSV
  - Validasi data per baris
  - Konversi tanggal Excel otomatis
  - Validasi dropdown, email, URL, dan number
  - Laporan error detail per baris

### 🔷 Crawling & API Integration
- Antarmuka untuk crawling data dari website eksternal
- Integrasi dengan API eksternal
- Field mapping dari JSON response
- Penjadwalan otomatis (rencana pengembangan)

---

## 🏗 Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    Browser (Tailwind CSS)                     │
├─────────────────────────────────────────────────────────────┤
│                   Laravel 10.x Application                    │
├─────────────────────────────────────────────────────────────┤
│   Controllers          │    Models           │   Views       │
│   (Superadmin/Admin)   │    (Eloquent ORM)   │   (Blade)     │
├─────────────────────────────────────────────────────────────┤
│   Exports/Imports      │    Traits           │   Middleware  │
│   (PhpSpreadsheet)     │    (HandlesImport)  │   (Auth)      │
├─────────────────────────────────────────────────────────────┤
│                    MySQL Database                             │
└─────────────────────────────────────────────────────────────┘
```

### Pola Desain: EAV (Entity-Attribute-Value)

SIPADU menggunakan pola EAV untuk menyimpan data dengan struktur dinamis:

- **`data_types`** — Entity (entitas): menyimpan definisi jenis data
- **`data_fields`** — Attribute (atribut): menyimpan definisi field
- **`data_records`** — Entity instance: menyimpan record data
- **`data_record_values`** — Value (nilai): menyimpan nilai field per record

---

## 👥 Role Pengguna

### 👑 Superadmin
- Akses penuh ke seluruh fitur
- Membuat/mengedit/menghapus jenis data
- Mengelola field dari setiap jenis data
- Melihat semua data record dari semua jenis data
- Mengelola pengguna (CRUD)
- Assign jenis data ke Admin Data
- Akses ke Crawling & API untuk semua jenis data

### 👤 Admin Data
- Melihat data dari jenis data yang di-assign
- Membuat, mengedit, dan menghapus record data (pada jenis data yang di-assign)
- Melihat (read-only) data dari jenis data yang tidak di-assign
- Akses ke Crawling & API untuk jenis data yang di-assign

---

## 🛠 Teknologi yang Digunakan

| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **PHP** | ^8.1 | Bahasa pemrograman backend |
| **Laravel** | ^10.10 | Framework PHP |
| **MySQL** | - | Database relasional |
| **Tailwind CSS** | ^3.1 | Framework CSS utility-first |
| **Alpine.js** | ^3.4 | Interaktivitas frontend ringan |
| **Font Awesome** | 6.4 | Ikon |
| **PhpSpreadsheet** | ^5.7 | Impor/Ekspor Excel |
| **Laravel Breeze** | ^1.29 | Autentikasi (Blade stack) |
| **Laravel Sanctum** | ^3.3 | API token authentication |
| **Vite** | ^5.0 | Build tool frontend |

---

## 💾 Struktur Database

### Tabel Utama

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Data pengguna (name, email, nip, phone, role) |
| `data_types` | Definisi jenis data (name, slug, description) |
| `data_fields` | Definisi field per jenis data (label, name, type, options, dll.) |
| `data_records` | Record data per jenis data |
| `data_record_values` | Nilai field per record data |
| `data_type_user` | Pivot table relasi jenis data dengan user |

### Entity Relationship Diagram

```
users ──── data_type_user ──── data_types ──── data_fields
  │                              │
  └──────────────────────────────┘
                                 │
                         data_records ──── data_record_values ──── data_fields
```

### Detail Field `data_fields`

| Field | Tipe | Deskripsi |
|-------|------|-----------|
| `label` | string | Label tampilan field |
| `name` | string | Nama internal field (slug) |
| `type` | enum | `text`, `number`, `textarea`, `date`, `image`, `file`, `dropdown`, `email`, `url` |
| `options` | json | Opsi untuk dropdown |
| `required` | boolean | Wajib diisi |
| `is_searchable` | boolean | Dapat dicari |
| `is_filterable` | boolean | Dapat difilter |
| `is_sortable` | boolean | Dapat diurutkan |
| `show_in_table` | boolean | Tampil di tabel |
| `order` | integer | Urutan field |

---

## 📋 Persyaratan Sistem

Sebelum memulai instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

- **PHP** >= 8.1
- **Composer** (versi terbaru)
- **Node.js** >= 16.x & **NPM**
- **MySQL** >= 5.7 atau **MariaDB** >= 10.3
- **Web Server** (Apache / Nginx) atau **Laravel Valet** / **Laravel Sail**
- **Ekstensi PHP**: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD (untuk image processing)

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/DwiArfian12/sipadu.git
cd sipadu
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies Frontend

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
cp .env.example .env
```

Kemudian edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME=SIPADU_UNY
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipadu_uny
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database MySQL dengan nama yang sesuai dengan konfigurasi `.env` Anda:

```sql
CREATE DATABASE sipadu_uny CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Jalankan Migrasi

```bash
php artisan migrate
```

### 8. (Opsional) Buat Symlink Storage

```bash
php artisan storage:link
```

### 9. Build Frontend Assets

```bash
npm run build
```

### 10. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## ⚙️ Konfigurasi

### Konfigurasi Database (.env)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipadu_uny
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Konfigurasi Mail (Opsional)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Konfigurasi Storage

File yang diupload (gambar/file) disimpan di `storage/app/public/uploads/`. Pastikan symlink storage sudah dibuat:

```bash
php artisan storage:link
```

---

## 📖 Penggunaan

### 👑 Superadmin

#### Dashboard
Setelah login sebagai Superadmin, Anda akan melihat dashboard dengan statistik:
- Total jenis data
- Total record data
- Total pengguna
- Daftar jenis data terbaru

#### Manajemen Jenis Data
1. Buka menu **Jenis Data** di sidebar
2. Klik **Tambah Jenis Data** untuk membuat jenis data baru
3. Isi nama, slug (otomatis), dan deskripsi
4. Assign admin yang memiliki akses ke jenis data ini
5. Setelah jenis data dibuat, klik **Field** untuk mengelola field

#### Manajemen Field
1. Pilih jenis data, lalu klik **Field**
2. Klik **Tambah Field** untuk menambahkan field baru
3. Konfigurasi:
   - **Label**: Nama tampilan field
   - **Nama Field**: Nama internal (otomatis dari label)
   - **Tipe**: Pilih tipe data
   - **Opsi**: Untuk tipe dropdown, masukkan opsi (pisahkan dengan koma atau baris baru)
   - Atur opsi lainnya (required, searchable, dll.)

#### Manajemen Data Record
1. Pilih jenis data dari sidebar (di bagian **Daftar Jenis Data**)
2. Lihat data dalam tabel dengan fitur:
   - 🔍 **Search**: Cari data di semua field yang searchable
   - 🎯 **Filter**: Filter per field yang filterable
   - 🔼 **Sort**: Klik header kolom untuk mengurutkan
   - 📄 **Pagination**: Atur jumlah data per halaman
3. Klik **Tambah Data** untuk menambahkan record baru
4. Klik **Edit** atau **Hapus** pada record yang ada

#### Manajemen Pengguna
1. Buka menu **Manajemen Pengguna**
2. Klik **Tambah Pengguna** untuk membuat pengguna baru
3. Isi data pengguna (nama, email, NIP, telepon, role, password)
4. Untuk role **Admin Data**, assign jenis data yang dapat diakses
5. Edit atau hapus pengguna yang sudah ada

### 👤 Admin Data

#### Dashboard
Setelah login sebagai Admin Data, Anda akan melihat:
- Kartu statistik untuk setiap jenis data yang di-assign
- Jumlah record per jenis data
- Akses cepat ke data record dan Crawling & API

#### Manajemen Data Record
- Sama seperti Superadmin, tetapi hanya untuk jenis data yang di-assign
- Dapat melihat (read-only) data dari jenis data yang tidak di-assign

---

## 🌐 API Endpoints

SIPADU menyediakan endpoint API dasar menggunakan Laravel Sanctum:

| Method | Endpoint | Deskripsi | Auth |
|--------|----------|-----------|------|
| GET | `/api/user` | Mendapatkan data user yang sedang login | Sanctum |

> **Catatan**: Pengembangan API endpoints lebih lanjut dapat ditambahkan sesuai kebutuhan.

---

## 🕷 Crawling & Integrasi API

SIPADU menyediakan antarmuka untuk integrasi data dari sumber eksternal:

### Manual Crawling
- Masukkan URL target website
- Pilih jenis data tujuan
- Tentukan CSS/XPath selector untuk mengambil data
- Jalankan crawling

### API Integration
- Masukkan API endpoint URL
- Pilih method (GET/POST)
- Masukkan API Key jika diperlukan
- Pilih jenis data tujuan
- Mapping field dari JSON response ke field jenis data
- Fetch data

> **Catatan**: Fitur crawling dan API saat ini masih dalam tahap antarmuka pengguna. Logika backend untuk eksekusi crawling dan fetch API akan diimplementasikan pada pengembangan selanjutnya.

---

## 📥 Impor & Ekspor Data

### Ekspor ke CSV
1. Buka halaman data record suatu jenis data
2. Tambahkan parameter `?export=excel` pada URL, atau klik tombol **Export**
3. File CSV akan di-download dengan format:
   - UTF-8 BOM (kompatibel dengan Excel)
   - Header: No, [field labels], Dibuat Oleh, Tanggal Dibuat
   - Data per record

### Download Template Excel
1. Buka halaman data record suatu jenis data
2. Klik tombol **Download Template**
3. File XLSX akan di-download dengan:
   - Header dengan styling (bold, background hijau)
   - Data validation dropdown untuk field dropdown
   - Contoh data pada baris ketiga
   - Baris petunjuk (instruction row)

### Impor dari Excel
1. Buka halaman data record suatu jenis data
2. Klik tombol **Import**
3. Upload file XLSX/XLS/CSV (maks. 10MB)
4. Sistem akan:
   - Mencocokkan header dengan field yang ada
   - Memvalidasi setiap baris data
   - Mengkonversi tanggal Excel otomatis
   - Menampilkan laporan hasil import

---

## 🔧 Troubleshooting

### Error: "Target class [controller] does not exist"
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "Base table or view not found"
```bash
php artisan migrate
```

### Error: "The file failed to upload"
Pastikan folder `storage/app/public/uploads` dapat ditulis:
```bash
chmod -R 775 storage/app/public/uploads
```

### Error: "Call to undefined function ..."
Pastikan ekstensi PHP yang diperlukan sudah diinstal:
```bash
php -m | grep -E "bcmath|ctype|fileinfo|json|mbstring|openssl|pdo|xml|gd"
```

### Error: 403 Forbidden saat akses data
Pastikan user Anda (Admin Data) telah di-assign ke jenis data yang ingin diakses. Hubungi Superadmin.

### Error: "Class not found" setelah update
```bash
composer dump-autoload
php artisan optimize
```

### Error: Storage link tidak muncul
```bash
php artisan storage:link
```

---

## 🤝 Kontribusi

Kami menyambut kontribusi dari semua pihak! Untuk berkontribusi:

1. **Fork** repository ini
2. Buat **branch** baru (`git checkout -b fitur-baru`)
3. **Commit** perubahan Anda (`git commit -m 'Menambahkan fitur baru'`)
4. **Push** ke branch (`git push origin fitur-baru`)
5. Buat **Pull Request**

### Panduan Kontribusi
- Ikuti standar coding PSR-12
- Gunakan fitur Laravel yang sudah ada (Eloquent, Blade, dll.)
- Tambahkan komentar pada kode yang kompleks
- Update dokumentasi jika diperlukan
- Pastikan tidak ada error sebelum submit PR

---

## 📄 Lisensi

**SIPADU UNY** adalah aplikasi open-source yang dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
    Dibangun dengan ❤️ untuk Universitas Negeri Yogyakarta
    <br>
    Copyright © 2026 - Dwi Arfian
</p>
