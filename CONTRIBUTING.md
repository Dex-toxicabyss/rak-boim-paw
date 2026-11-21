# Panduan Kontribusi — Rak Boim (`rak-boim-paw`)

Dokumen ini menjadi pedoman kolaborasi pengembangan aplikasi web **Rak Boim** (*Aplikasi Pengelolaan Gudang untuk Boim Laundry Berbasis Laravel*) oleh **Kelompok 07** (Program Studi Sistem Informasi, Universitas Telkom).

---

## 1. Struktur Tim & Pembagian Branch

Setiap anggota **wajib** bekerja menggunakan akun GitHub pribadi pada *branch* fitur masing-masing sebelum digabungkan (*Pull Request*) ke `main`. Jangan melakukan *push* langsung ke `main`.

| Anggota Tim | NIM | Branch Fitur | Cakupan Modul & Tanggung Jawab |
| :--- | :--- | :--- | :--- |
| **Muhammad Syahdan Al Rasyid** | `102042500067` | `feature/syahdan-racks` | Master ID Rak & Lemari (`racks`), hitung otomatis kapasitas beban rak, & UI responsif Bootstrap 5 |
| **Raffata Izacky Yuargya Aletama** | `102042500123` | `feature/raffata-auth-dashboard` | Autentikasi sesi (`/login`), Middleware `RoleCheck` (`pemilik` vs `staf`), Master User (`users`), & Dashboard Ringkas |
| **Muhamad Dyandra Putra** | `102042500152` | `feature/dyandra-storages` | Transaksi inti penataan rak (`laundry_storages`), status cucian, hitung biaya otomatis, pencarian 4 digit telp, & validasi |
| **Jefri Febriano Gunawan** | `102042530012` | `feature/jefri-reports` | Log serah terima rak & setrika (`storage_logs`), halaman Laporan periode tanggal, serta Export CSV & PDF |
| **Adhwa Nazaha Taqiya** | `102042530013` | `feature/adhwa-services` | Master Tarif Layanan (`service_categories`: Kiloan Reguler min. 2 kg, Express 4/8/24 Jam, PP, & 23 Item Satuan) |

---

## 2. Alur Kerja Git (Workflow)

1. **Clone & Sinkronisasi Awal**
   ```bash
   git clone https://github.com/syahdanalrasyid/rak-boim-paw.git
   cd rak-boim-paw
   composer install
   cp .env.example .env
   php artisan key:generate
   ```
2. **Pindah ke Branch Masing-Masing**
   ```bash
   git checkout -b feature/nama-modul-kamu
   ```
3. **Tarik Pembaruan Terbaru dari `main` Sebelum Mulai Coding**
   ```bash
   git checkout main
   git pull origin main
   git checkout feature/nama-modul-kamu
   git merge main
   ```
4. **Commit & Push ke Branch Fitur**
   ```bash
   git add <file-yang-diubah>
   git commit -m "feat(scope): deskripsi singkat perubahan"
   git push -u origin feature/nama-modul-kamu
   ```
5. **Buat Pull Request (PR)** di GitHub menuju `main` setelah fitur teruji berjalan tanpa error.

---

## 3. Aturan Commit (Target 10–12 Commit Rutin per Anggota)

* Setiap anggota menargetkan **10–12 commit bertahap** yang mencerminkan progres nyata (hindari menggabungkan seluruh kode dalam 1 kali *push* besar atau melakukan *commit* kosong).
* Gunakan format **Conventional Commits**:
  * `chore(db): add migration schema for <nama_tabel>`
  * `feat(model): define Eloquent model and relationships`
  * `chore(seeder): add Boim Laundry initial data`
  * `feat(validation): create FormRequest validation rules`
  * `feat(crud): implement read, search, filter, and sorting`
  * `feat(crud): implement create and store with auto-calculation`
  * `feat(crud): implement edit, update, and status transition`
  * `feat(crud): implement delete logic protected by role`
  * `feat(view): build responsive Blade index and form views`
  * `fix(security): apply role middleware protection and bug fixes`

---

## 4. Standar Kode & Pengujian Lokal

* **Proteksi Hak Akses:** Pastikan seluruh rute yang hanya boleh diakses oleh **Pemilik** (hapus arsip selesai, kelola user, CRUD data master, dan export laporan) terlindungi middleware `role:pemilik`.
* **Validasi Server-Side:** Gunakan kelas `FormRequest` di `app/Http/Requests/` untuk seluruh form input, termasuk aturan berat minimal `2 kg` untuk layanan kiloan.
* **Cek Sebelum Push:**
  ```bash
  php artisan migrate:fresh --seed
  php artisan route:list
  ```
* Jangan pernah mengunggah file `.env`, folder `/vendor`, atau folder `/node_modules` ke repositori.