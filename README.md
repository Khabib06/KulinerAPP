# KulinerAPP

## Kuliner Sekitar Kampus UDINUS

KulinerAPP merupakan aplikasi berbasis web yang digunakan untuk mencari, menambahkan, memberikan ulasan, serta melakukan promosi tempat kuliner di sekitar Kampus Universitas Dian Nuswantoro (UDINUS).

Aplikasi ini dibuat untuk membantu mahasiswa dan masyarakat sekitar dalam menemukan tempat kuliner dengan informasi lokasi, deskripsi, foto, dan review dari pengguna.

Selain fitur utama pencarian kuliner, aplikasi ini juga memiliki sistem promosi berbayar menggunakan Payment Gateway Midtrans dan notifikasi otomatis menggunakan WhatsApp API.

---

# Fitur Aplikasi

## User

- Registrasi dan Login
- Melihat daftar tempat kuliner yang sudah disetujui admin
- Melihat lokasi tempat kuliner menggunakan peta interaktif
- Memilih lokasi melalui map secara otomatis
- Reverse Geocoding untuk mendapatkan alamat berdasarkan titik lokasi
- Menambahkan tempat kuliner baru
- Memberikan rating dan review
- Melakukan pembayaran promosi tempat kuliner
- Mendapatkan notifikasi pembayaran berhasil melalui WhatsApp

## Admin

- Login sebagai admin
- Dashboard statistik aplikasi
- Melihat jumlah tempat kuliner, user, review, dan pending tempat
- Melakukan approval tempat kuliner baru
- Menghapus tempat kuliner yang tidak sesuai
- Melihat riwayat pembayaran promosi
- Mengelola status promosi tempat kuliner

## Fitur Promosi

- Integrasi Payment Gateway Midtrans
- Sistem pembayaran menggunakan Midtrans Sandbox
- Status transaksi:
  - Pending
  - Paid
  - Failed

- Tempat yang berhasil melakukan pembayaran akan mendapatkan:
  - Badge ⭐ Promoted
  - Tampil sebagai tempat prioritas
  - Masa promosi aktif selama 30 hari

## Notifikasi WhatsApp

Sistem terintegrasi dengan WAHA API untuk mengirim notifikasi otomatis ketika:

- User menambahkan tempat baru
- Admin melakukan approval tempat
- Pembayaran promosi berhasil

---

# Teknologi yang Digunakan

## Backend

- PHP 8.2
- CodeIgniter 4
- MySQL

## Frontend

- HTML
- CSS
- Bootstrap 5
- JavaScript

## API dan Library

- Leaflet JS
- OpenStreetMap
- Nominatim Reverse Geocoding
- Midtrans Payment Gateway
- WAHA WhatsApp API
- Guzzle HTTP Client

---

# Arsitektur Sistem

Aplikasi menggunakan konsep MVC (Model View Controller) pada CodeIgniter 4.

## Model

Berfungsi untuk mengelola data dan komunikasi dengan database.

Contoh:

- PlaceModel
- PaymentModel
- UserModel
- ReviewModel

## View

Berfungsi untuk menampilkan tampilan antarmuka pengguna.

Contoh:

- Home
- Login
- Dashboard
- Payment
- Form Tambah Tempat

## Controller

Berfungsi sebagai penghubung antara Model dan View.

Contoh:

- Home Controller
- PlaceController
- PaymentController
- Dashboard Controller

---

# Struktur Project

KulinerAPP

├── app
│ ├── Controllers
│ ├── Models
│ ├── Views
│ └── Database
│
├── public
│
├── writable
│
├── composer.json
│
├── spark
│
├── .env.example
│
├── README.md
│
└── .gitignore

---

# Instalasi Project

# 1. Clone Repository

git clone URL_REPOSITORY

Masuk ke folder project:
cd KulinerAPP

# 2. Install Dependency

Jalankan:

composer install

# 3. Konfigurasi Environment

Copy file:

.env.example

menjadi:

.env

Kemudian sesuaikan konfigurasi:

- Database
- Midtrans Key
- WAHA API

# 4. Konfigurasi Database

Buat database MySQL:

kuliner_db

Kemudian jalankan:

php spark migrate --seed

# 5. Jalankan Aplikasi

Gunakan perintah:

php spark serve

Akses melalui:

http://localhost:8080

---

# Database

Database menggunakan MySQL dengan beberapa tabel utama:

- users
- places
- categories
- reviews
- payments

Tabel payments digunakan untuk menyimpan transaksi promosi:

- order_id
- package_name
- amount
- status pembayaran

---

# Integrasi Payment Gateway

Payment Gateway menggunakan Midtrans Sandbox.

Alur pembayaran:
User memilih promosi

↓

PaymentController membuat transaksi

↓

Midtrans menghasilkan Snap Token

↓

User melakukan pembayaran

↓

Status pembayaran diperbarui

↓

Tempat menjadi Promoted

↓

Notifikasi WhatsApp dikirim

---

# Integrasi Maps

Sistem menggunakan Leaflet dan OpenStreetMap.

Fitur lokasi:

- Menampilkan peta
- Menentukan titik lokasi
- Menyimpan latitude dan longitude
- Mengubah koordinat menjadi alamat menggunakan Reverse Geocoding

---

# Akun Demo

# Admin

Email: admin@example.com

Password:

admin123

# User

Email:

user@example.com

Password:

user123

---

# Screenshot Aplikasi

Tambahkan screenshot:

- Halaman Login
- Homepage
- Dashboard Admin
- Payment Midtrans
- Riwayat Pembayaran

---

# Video Demo

Link YouTube:

---

# Pengembang

KulinerAPP

Anggota Kelompok:
Muhammad Anjas Syahrazy  (A11.2024.15905)
Khabib Muhasyim          (A11.2024.15922)
Arya Saputra             (A11.2024.15930)

Program Studi Teknik Informatika
    Fakultas Ilmu Komputer
Universitas Dian Nuswantoro (UDINUS)
              2026
