# Panduan Kontribusi — Rak Boim (`rak-boim-paw`)

Dokumen ini menjadi pedoman kolaborasi pengembangan aplikasi web **Rak Boim** (*Aplikasi Pengelolaan Gudang untuk Boim Laundry Berbasis Laravel*) oleh **Kelompok 07** (Program Studi Sistem Informasi, Universitas Telkom).

## 1. Pembagian Branch Fitur

Setiap anggota bekerja menggunakan akun GitHub pribadi pada *branch* fitur masing-masing sebelum digabungkan melalui *Pull Request* ke `main`.

| Anggota Tim | NIM | Branch Fitur | Cakupan Modul |
| :--- | :--- | :--- | :--- |
| Muhammad Syahdan Al Rasyid | `102042500067` | `feature/syahdan-racks` | Master ID Rak, hitung beban rak, UI responsif |
| Raffata Izacky Yuargya Aletama | `102042500123` | `feature/raffata-auth-dashboard` | Auth, Middleware `RoleCheck`, Master User, Dashboard |
| Muhamad Dyandra Putra | `102042500152` | `feature/dyandra-storages` | Transaksi penataan rak, hitung biaya, cari 4 digit telp, validasi |
| Jefri Febriano Gunawan | `102042530012` | `feature/jefri-reports` | Log setrika/rak, Laporan periode tanggal, Export CSV & PDF |
| Adhwa Nazaha Taqiya | `102042530013` | `feature/adhwa-services` | Master Tarif Layanan & Seeder 36 item Boim Laundry |

## 2. Alur Kerja Git

```bash
git clone https://github.com/Dex-toxicabyss/rak-boim-paw.git
cd rak-boim-paw
git checkout -b feature/nama-modul-kamu
```

## 3. Format Commit (Target 10–12 Commit Rutin per Anggota)

Gunakan format Conventional Commits:
- `chore(db): add migration schema for <nama_tabel>`
- `feat(model): define Eloquent model and relationships`
- `feat(validation): create FormRequest validation rules`
- `feat(crud): implement controller logic and auto-calculation`
- `feat(view): build responsive Blade templates`
- `fix(security): enforce RoleCheck middleware`
