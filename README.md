# Rak Boim — Aplikasi Pengelolaan Gudang Boim Laundry

Aplikasi web pengelolaan penyimpanan rak gudang belakang dan transaksi untuk **Boim Laundry (Mr. Boim Laundry)** berbasis **Laravel 11**, **MySQL**, dan **Bootstrap 5**. Dikembangkan oleh **Kelompok 07** untuk Tugas Besar mata kuliah Pengembangan Aplikasi Website, Program Studi S1 Sistem Informasi, Universitas Telkom Kampus Jakarta.

## Fitur Utama (10 Fitur Wajib)
1. **Autentikasi & Manajemen Sesi** (`/login`, `/logout`) untuk dua peran: `pemilik` dan `staf`.
2. **Proteksi Middleware Peran** (`RoleCheck`) yang memblokir akses lintas peran dengan HTTP `403`.
3. **CRUD 3 Data Master:** Master User, Master ID Rak & Lemari, dan Master Tarif Layanan (13 paket kiloan/express/PP + 23 item satuan).
4. **Transaksi Inti Penataan Rak:** Input Nama, No. Telp, Berat (Kg), ID Rak, dan transisi status (`tersimpan` -> `siap_diambil` -> `selesai`).
5. **Perhitungan Otomatis:** Menghitung `total_price` (minimal 2 kg untuk paket kiloan + Jemput-Antar PP Rp 10.000) serta `current_load_kg` pada setiap rak.
6. **Laporan & Export CSV / PDF** berdasarkan rentang tanggal (khusus Pemilik).
7. **Pencarian Cepat 4 Digit Terakhir No. Telp / Nama**, filter ID Rak & status, dan pengurutan (*sorting*).
8. **Validasi Server-Side** (`FormRequest`) dengan pesan kesalahan bahasa Indonesia yang jelas.
9. **Dashboard Ringkas** berisi 4 kartu KPI dan status okupansi rak secara *real-time*.
10. **Antarmuka Responsif** berbasis Bootstrap 5 yang rapi di layar laptop kasir maupun perangkat seluler.

## Cara Menjalankan di Localhost

```bash
# 1. Buat proyek Laravel 11 baru (jika belum ada skeleton Laravel di repo)
composer create-project laravel/laravel:^11.0 .

# 2. Salin seluruh isi paket kode Rak Boim ke folder proyek ini (timpa file yang sama)

# 3. Konfigurasi database MySQL di file .env
# DB_CONNECTION=mysql
# DB_DATABASE=rak_boim
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Jalankan migrasi dan seeder data awal Boim Laundry
php artisan migrate:fresh --seed

# 5. Jalankan server lokal
php artisan serve
```

## Akun Demo Seeder
- **Pemilik:** `pemilik@boimlaundry.test` / `password123`
- **Staf:** `staf@boimlaundry.test` / `password123`

## Tim Pengembang (Kelompok 07)
- Muhammad Syahdan Al Rasyid (`102042500067`) — `feature/syahdan-racks`
- Raffata Izacky Yuargya Aletama (`102042500123`) — `feature/raffata-auth-dashboard`
- Muhamad Dyandra Putra (`102042500152`) — `feature/dyandra-storages`
- Jefri Febriano Gunawan (`102042530012`) — `feature/jefri-reports`
- Adhwa Nazaha Taqiya (`102042530013`) — `feature/adhwa-services`
