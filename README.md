# 📋 Dokumentasi Sistem Taskify (Takify)

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  </a>
  <a href="https://alpinejs.dev" target="_blank">
    <img src="https://img.shields.io/badge/AlpineJS-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  </a>
  <a href="https://www.mysql.com" target="_blank">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  </a>
  <a href="https://tailwindcss.com" target="_blank">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
  </a>
    <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank">
    <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  </a>
  <a href="https://vitejs.dev" target="_blank">
    <img src="https://img.shields.io/badge/Vite-B73BFE?style=for-the-badge&logo=vite&logoColor=FFD62E" alt="Vite">
  </a>
</p>



## 📖 Daftar Isi
1. [Deskripsi Umum](#deskripsi-umum)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Fitur Utama](#fitur-utama)
4. [Struktur Direktori](#struktur-direktori)
5. [Model Data](#model-data)
6. [Routing](#routing)
7. [Instalasi dan Konfigurasi](#instalasi-dan-konfigurasi)
8. [Perintah yang Tersedia](#perintah-yang-tersedia)
9. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
10. [Lisensi](#lisensi)

## 📝 Deskripsi Umum

Taskify adalah aplikasi manajemen tugas berbasis web yang memungkinkan pengguna untuk mengelola tugas harian, kolaborasi dengan tim, melihat kalender, dan menganalisis produktivitas mereka. Aplikasi ini dibangun menggunakan framework Laravel dengan antarmuka modern menggunakan Tailwind CSS dan Alpine.js.

## 🏗️ Arsitektur Sistem

Aplikasi ini mengikuti pola arsitektur MVC (Model-View-Controller) standar Laravel:

- **Model**: Mewakili struktur data dan logika bisnis aplikasi
- **View**: Bertanggung jawab atas presentasi data kepada pengguna
- **Controller**: Mengatur alur antara Model dan View serta menangani permintaan dari pengguna

Arsitektur aplikasi terdiri dari komponen-komponen berikut:
- Database MYSQL untuk penyimpanan data
- Laravel sebagai backend framework
- Blade templating engine untuk tampilan
- Tailwind CSS untuk styling
- Alpine.js untuk interaktivitas frontend

## ⭐ Fitur Utama

### 1. 📊 Dashboard
Menampilkan ringkasan aktivitas pengguna termasuk:
- Statistik jumlah tugas total, sedang berjalan, dan selesai
- Grafik analitik produktivitas
- Daftar tugas terbaru
- Kalender mini
- Riwayat aktivitas

### 2. ✅ Manajemen Tugas
Fitur-fitur manajemen tugas:
- Membuat, membaca, memperbarui, dan menghapus tugas
- Menandai tugas sebagai selesai
- Mengatur prioritas tugas (rendah, sedang, tinggi)
- Menetapkan tenggat waktu dan waktu
- Mengatur status tugas (pending, in progress, completed)
- Filter tugas berdasarkan status

### 3. 📅 Kalender
Menyediakan tampilan kalender untuk melihat tugas berdasarkan tanggal:
- Navigasi bulanan
- Tampilan tugas pada setiap tanggal
- Tugas mendatang

### 4. 👥 Manajemen Tim
Memungkinkan pengguna untuk:
- Menambah, mengedit, dan menghapus anggota tim
- Melihat detail kontak anggota tim
- Mengelola peran anggota tim

### 5. 👤 Profil Pengguna
Fitur pengaturan akun:
- Mengubah informasi profil
- Memperbarui foto profil
- Menghapus akun

## 📁 Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/           # Kontroler autentikasi
│   │   ├── CalendarController.php
│   │   ├── DashboardController.php
│   │   ├── ProfileController.php
│   │   ├── TaskController.php
│   │   └── TeamController.php
│   └── Requests/           # Validasi form
├── Models/
│   ├── Activity.php
│   ├── Task.php
│   ├── TeamMember.php
│   └── User.php
├── Policies/               # Aturan otorisasi
└── View/Components/        # Komponen tampilan kustom

database/
├── factories/              # Factory untuk testing
├── migrations/             # Migrasi database
└── seeders/                # Data awal

public/                     # File publik yang dapat diakses langsung

resources/
├── css/                    # File CSS kustom
├── js/                     # File JavaScript
├── views/                  # Template Blade
│   ├── analytics/          # Halaman analitik
│   ├── auth/               # Halaman autentikasi
│   ├── calendar/           # Halaman kalender
│   ├── components/         # Komponen Blade
│   ├── errors/             # Halaman error
│   ├── layouts/            # Layout utama
│   ├── profile/            # Halaman profil
│   ├── tasks/              # Halaman tugas
│   ├── team/               # Halaman tim
│   ├── dashboard.blade.php
│   └── welcome.blade.php
└── Template.html           # Template desain

routes/
├── auth.php                # Routing autentikasi
├── console.php             # Perintah console
└── web.php                 # Routing web utama
```

## 🗃️ Model Data

### 1. 👤 User
Representasi pengguna sistem:
- `id`: Primary key
- `name`: Nama pengguna
- `email`: Email pengguna
- `password`: Password terenkripsi
- `profile_photo_path`: Path foto profil
- Relasi: tasks, teamMembers, activities

### 2. ✅ Task
Representasi tugas:
- `id`: Primary key
- `user_id`: Foreign key ke User
- `title`: Judul tugas
- `description`: Deskripsi tugas
- `status`: Status tugas (pending, in_progress, completed)
- `priority`: Prioritas tugas (low, medium, high)
- `due_date`: Tanggal jatuh tempo
- `due_time`: Waktu jatuh tempo
- `is_completed`: Status penyelesaian boolean
- Relasi: user, teamMembers

### 3. 👥 TeamMember
Representasi anggota tim:
- `id`: Primary key
- `user_id`: Foreign key ke User
- `name`: Nama anggota tim
- `email`: Email anggota tim
- `role`: Peran dalam tim
- `phone`: Nomor telepon
- `avatar`: Foto profil
- Relasi: user, tasks

### 4. 📝 Activity
Log aktivitas pengguna:
- `id`: Primary key
- `user_id`: Foreign key ke User
- `type`: Jenis aktivitas
- `description`: Deskripsi aktivitas
- Relasi: user

## 🔗 Routing

### Rute Autentikasi
- `/login`: Form login
- `/register`: Form registrasi
- `/forgot-password`: Reset password
- `/reset-password`: Form reset password

### Rute Aplikasi
- `/dashboard`: Halaman dashboard pengguna
- `/tasks`: Daftar tugas (GET, POST)
- `/tasks/{task}`: Detail tugas (GET, PUT, DELETE)
- `/tasks/{task}/toggle-complete`: Toggle status tugas
- `/team`: Daftar anggota tim (GET, POST)
- `/team/{team}`: Detail anggota tim (GET, PUT, DELETE)
- `/calendar`: Tampilan kalender
- `/analytics`: Halaman analitik
- `/profile`: Pengaturan profil pengguna

## ⚙️ Instalasi dan Konfigurasi

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js dan NPM
- MYSQL (untuk database development)

### Langkah Instalasi

1. Clone repository:
```bash
git clone https://github.com/Taskify-SIA/taskify-laravel.git
cd tos-project
```

2. Install dependensi PHP:
```bash
composer install
```

3. Salin file konfigurasi environment:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Install dependensi JavaScript:
```bash
npm install
```

6. Jalankan migrasi database:
```bash
php artisan migrate --seed
```

7. Build aset frontend:
```bash
npm run build
```

### Konfigurasi Lingkungan
- Database: MYSQL digunakan secara default
- Mail: Konfigurasi SMTP untuk fitur reset password
- Queue: Konfigurasi worker queue jika diperlukan

## 🛠️ Perintah yang Tersedia

### Perintah Development
- `composer run setup`: Setup awal proyek
- `composer run dev`: Menjalankan server development dengan semua layanan
- `composer run test`: Menjalankan test suite
- `npm run dev`: Menjalankan Vite development server

### Perintah Artisan
- `php artisan serve`: Menjalankan development server
- `php artisan migrate`: Menjalankan migrasi database
- `php artisan db:seed`: Menjalankan seeder database
- `php artisan tinker`: Interaktif shell untuk Laravel

### Kredensial Login
- Email : alif@gmail.com
- Password : password

## 💻 Teknologi yang Digunakan

### Backend
- **Laravel 12.x**: Framework PHP yang menyediakan struktur MVC dan berbagai fitur seperti routing, ORM, dan autentikasi
- **PHP 8.2+**: Bahasa pemrograman server-side
- **MYSQL**: Database untuk lingkungan development

### Frontend
- **Tailwind CSS**: Framework CSS utility-first untuk styling
- **Alpine.js**: Framework JavaScript ringan untuk interaktivitas
- **Vite**: Build tool untuk pengembangan frontend
- **Phosphor Icons**: Library ikon vektor

### Testing
- **PestPHP**: Framework testing yang elegan untuk PHP
- **PHPUnit**: Framework testing unit standar untuk PHP

### Tooling
- **Composer**: Package manager untuk PHP
- **NPM**: Package manager untuk JavaScript
- **Laravel Pint**: Code formatter untuk PHP

## 📄 Lisensi

Lisensi lengkap dapat dilihat di file [LICENSE](LICENSE) yang disertakan dalam proyek ini.

[MIT License](LICENSE)

Copyright (c) 2025 Taskify
