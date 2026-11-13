# SIM-Gudang Laundry — Sistem Informasi Penataan Penyimpanan Gudang Laundry

Aplikasi berbasis web untuk mengelola penataan lokasi penyimpanan bundel cucian pelanggan pada lemari dan rak gudang belakang di **Mr. Boim Laundry**. Sistem ini dibangun menggunakan **Laravel (arsitektur MVC)** dan **MySQL** untuk memenuhi Tugas Besar Mata Kuliah **Pengembangan Aplikasi Web (PLO02-CLO03 & PLO08-CLO04)**, Fakultas Rekayasa Industri, Telkom University.

---

## Latar Belakang & Solusi Studi Kasus

Pada operasional **Mr. Boim Laundry**, pencatatan transaksi kasir di meja depan belum terhubung dengan lokasi penempatan bundel cucian di ruang penyimpanan belakang. Sistem ini menyelesaikan kendala tersebut melalui:
1. **Pencatatan Lokasi ID Rak:** Mengikat data **Nama Pelanggan**, **Nomor Telepon** (pencarian cepat 4 digit terakhir), **Berat Cucian (Kg)**, dan **ID Rak Lemari** secara terstruktur.
2. **Otorisasi Role Middleware (`Kasir` vs `Manajemen`):**
   - **Kasir (`kasir`):** Menginput data cucian masuk rak (*Create*), melihat & mencari lokasi ID Rak (*Read*), serta mengedit data cucian atau memindahkan ID Rak (*Update*).
   - **Manajemen (`manajemen`):** Menerima laporan daftar penyimpanan (*Read*), mengelola akun pengguna, dan memiliki wewenang eksklusif untuk menghapus data cucian selesai (*Delete*).
3. **Kalkulasi Beban Rak Otomatis:** Setiap penambahan, pemindahan rak, maupun penghapusan data cucian otomatis menghitung ulang beban berat (`current_load_kg`) dan status kapasitas pada tabel `racks`.

---

## Pembagian Fitur & Tim Pengembang (5 Anggota)

| No | Nama Mahasiswa | NIM | Fitur Tanggung Jawab (CRUD, View, Validasi, & API) | Branch Git |
| :- | :--- | :--- | :--- | :--- |
| 1 | **Raffata Izacky Yuargya Aletama** | `102042500123` | **Fitur 1:** Manajemen User, Autentikasi (`Login` & `Register`), & Role Middleware (`kasir`/`manajemen`) | `feature/raffata-users-auth` |
| 2 | ** `` | **Fitur 2 (Inti):** Penataan Penyimpanan Cucian (`laundry_storages`: Nama, Berat, No. Telp, ID Rak) | `feature/alvin-storages` |
| 3 | ** | `` | **Fitur 3:** Master ID Rak & Lemari Gudang (`racks`: Kode Rak, Nomor Lemari, Kolom, Kapasitas Kg) | `feature/anggota3-racks` |
| 4 | ** | `` | **Fitur 4:** Master Tarif Layanan Kiloan, Express (4/8/24 Jam), & 23 Item Satuan (`service_categories`) | `feature/anggota4-categories` |
| 5 | ** | `` | **Fitur 5:** Log Serah Terima Rak & Rekap Produksi Setrika (`storage_logs`) | `feature/anggota5-logs` |

---

## Daftar Endpoint REST API (`GET` Method)

Seluruh endpoint mengembalikan format respons JSON standar (`status`, `success`, `message`, `data`):

| Fitur | Endpoint All Data (`GET`) | Endpoint Specific Data (`GET`) | Controller |
| :--- | :--- | :--- | :--- |
| Fitur 1 (Users) | `GET /api/users` | `GET /api/users/{id}` | `Api\UserApiController` |
| Fitur 2 (Storages) | `GET /api/laundry-storages` | `GET /api/laundry-storages/{id}` | `Api\LaundryStorageApiController` |
| Fitur 3 (Racks) | `GET /api/racks` | `GET /api/racks/{id}` | `Api\RackApiController` |
| Fitur 4 (Categories) | `GET /api/service-categories` | `GET /api/service-categories/{id}` | `Api\ServiceCategoryApiController` |
| Fitur 5 (Logs) | `GET /api/storage-logs` | `GET /api/storage-logs/{id}` | `Api\StorageLogApiController` |

---

## Panduan Instalasi Lokal

1. **Clone repository:**
   ```bash
   git clone [https://github.com/](https://github.com/)<username-github-kamu>/sim-gudang-laundry-paw.git
   cd sim-gudang-laundry-paw
