# Sistem Informasi Perpustakaan Arcadia

> Sistem peminjaman buku berbasis web dengan konsep Drive-Thru Library

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue?style=flat-square&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 📖 Deskripsi

**Perpustakaan Arcadia** adalah sistem informasi perpustakaan modern yang memungkinkan peminjam untuk memesan buku secara online dan mengambilnya melalui jalur drive-thru. Sistem ini mempermudah proses peminjaman dan pengembalian buku dengan mengurangi waktu tunggu dan meningkatkan efisiensi layanan perpustakaan.

### Fitur Utama

#### Untuk Peminjam:
- **Registrasi & Login** - Daftar akun dan login dengan aman
- **Browse Buku** - Lihat katalog buku yang tersedia dengan pagination
- **Keranjang Peminjaman** - Tambah/hapus buku ke keranjang sebelum pesan
- **Pemesanan Online** - Pesan buku yang ingin dipinjam secara online
- **Kode Pinjam Unik** - Dapatkan kode pinjam untuk pengambilan buku
- **Riwayat Peminjaman** - Lihat status dan history peminjaman (DIPROSES, DISETUJUI, DITOLAK, SELESAI)
- **Drive-Thru Ready** - Sistem dirancang untuk pengambilan dan pengembalian via drive-thru

#### 👨‍💼 Untuk Admin:
- **Login Admin** - Akses panel admin dengan autentikasi terpisah
- **Dashboard Statistik** - Monitoring real-time peminjaman dan buku
- **Approve/Reject Peminjaman** - Review dan setujui/tolak pemesanan peminjaman
- **Manajemen Buku dalam Pemesanan** - Hapus buku dari daftar jika tidak tersedia
- **Konfirmasi Pengembalian** - Tandai buku yang sudah dikembalikan
- **CRUD Buku** - Tambah, edit, hapus data buku perpustakaan
- **Search & Filter** - Cari peminjaman atau buku dengan mudah

---

## Teknologi yang Digunakan

- **Backend Framework**: Laravel 12.x
- **Frontend**: Blade Template Engine + TailwindCSS 3.x
- **Database**: MySQL
- **Icons**: Font Awesome 6.4.0
- **Authentication**: Laravel Multi-Guard Authentication (Admin & Peminjam)
- **Session Management**: Laravel Session Driver

---

## 📋 Prasyarat

Pastikan sudah terinstall:
- PHP >= 8.3
- Composer
- MySQL/MariaDB
- Node.js & NPM (optional, untuk asset compilation)

---

## ⚙️ Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/perpustakaan-arcadia.git
cd perpustakaan-arcadia
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_arcadia
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder
```bash
php artisan migrate:fresh --seed
```

**Data seeder meliputi:**
- 1 akun admin (username: `admin`, password: `admin123`)
- 10 buku sample data

### 6. Jalankan Server
```bash
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

---

## Akun Default

### Admin
- **Username**: `admin`
- **Password**: `admin123`
- **URL Login**: `http://127.0.0.1:8000/admin/login`

### Peminjam
Registrasi akun baru di: `http://127.0.0.1:8000/register`

---

## 📁 Struktur Database

### Tabel Utama:

#### `admins`
- id_admin (PK)
- nama_admin
- user_admin
- pass_admin
- timestamps

#### `peminjams`
- id_peminjam (PK)
- nama_peminjam
- tgl_daftar
- user_peminjam
- pass_peminjam
- foto_peminjam (nullable)
- status_peminjam (boolean)
- timestamps

#### `bukus`
- id_buku (PK)
- judul_buku
- tgl_terbit
- nama_pengarang
- nama_penerbit
- timestamps

#### `peminjamans`
- id_peminjaman (PK)
- kode_pinjam (unique)
- id_peminjam (FK)
- id_admin (FK, nullable)
- tgl_pesan
- tgl_ambil (nullable)
- tgl_wajibkembali (nullable)
- tgl_kembali (nullable)
- status_pinjam (enum: DIPROSES, DISETUJUI, DITOLAK, SELESAI)
- timestamps

#### `detil_peminjamans`
- id (PK)
- id_peminjaman (FK)
- id_buku (FK)
- timestamps

---

## 🔄 Flow Sistem

### Alur Peminjaman:

```
1. Peminjam registrasi/login
   ↓
2. Browse katalog buku → Tambah ke keranjang
   ↓
3. Submit pemesanan peminjaman
   ↓
4. Status: DIPROSES (menunggu approval admin)
   ↓
5. Admin review → Approve/Reject
   ↓
6a. Jika DITOLAK → Proses selesai
6b. Jika DISETUJUI → Peminjam ambil buku via drive-thru
   ↓
7. Peminjam kembalikan buku
   ↓
8. Admin konfirmasi pengembalian
   ↓
9. Status: SELESAI
```

---

## 🎨 Tema & Design

- **Peminjam**: Blue theme (#3B82F6)
- **Admin**: Gold/Cream theme (#D7C097)
- **Responsive Design**: Mobile-friendly
- **Modern UI**: Clean, minimalist dengan Tailwind CSS

---

## 📸 Screenshots

### Dashboard Peminjam
![Dashboard Peminjam](screenshots/peminjam-dashboard.png)

### Admin Panel
![Admin Dashboard](screenshots/admin-dashboard.png)

### Manajemen Peminjaman
![Manajemen Peminjaman](screenshots/admin-peminjaman.png)

---

## Keamanan

- ✅ CSRF Protection (Laravel built-in)
- ✅ Password Hashing (bcrypt)
- ✅ Multi-Guard Authentication
- ✅ Input Validation
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ XSS Protection (Blade escaping)

---

## 📝 TODO / Future Enhancements

- [ ] Email notification untuk peminjam
- [ ] QR Code untuk kode pinjam
- [ ] Denda keterlambatan pengembalian
- [ ] Laporan statistik PDF
- [ ] Booking buku (reserve)
- [ ] Rating & review buku
- [ ] Multi-role admin (Super Admin, Staff)
- [ ] API REST untuk mobile app

---

## Developer

**Nama**: Hasan Fadhlurrahman  
**NIM**: 187231071
**Instansi**: Sistem Informasi - Universitas Airlangga

---

## Acknowledgments

- Laravel Framework
- TailwindCSS
- Font Awesome

---

## Support

Untuk pertanyaan atau issue, silakan buat issue di repository atau hubungi:
- Email: [hasan.fadlurrahman@gmail.com]
- GitHub: [@hasanfadh](https://github.com/username)

---

**Jika project ini membantu, berikan star di GitHub!**

---

Made with ❤️ by Hasan Fadhlurrahman | © 2025 Perpustakaan Arcadia