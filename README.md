# 🍜 Aplikasi Review Makanan - Dashboard Admin & User

Aplikasi berbasis web untuk memberikan informasi dan review makanan lokal. Dilengkapi dengan dashboard admin untuk manajemen konten dan dashboard user untuk eksplorasi kuliner dengan antarmuka yang modern (Glassmorphism design).

## 🌟 Fitur Unggulan

### 🛡️ Keamanan & Autentikasi
*   **Multi-Role System**: Pemisahan akses antara Admin (Manajemen) dan User (Penjelajah).
*   **Secure Session**: Proteksi halaman dari akses ilegal melalui URL langsung.
*   **Encrypted Flow**: Alur login dan registrasi yang divalidasi secara sistematis.

### 👨‍💻 Modul Admin (Back-End)
*   **Advanced CRUD**: Kelola data kuliner (Tambah, Edit, Hapus) dengan antarmuka dua kolom yang efisien.
*   **Smart Image Handling**:
    *   **Auto-Cleanup**: Menghapus file gambar lama dari server secara otomatis saat data diperbarui atau dihapus.
    *   **Live Image Preview**: Melihat hasil upload foto sebelum data disimpan.
*   **Automated Maps Generator**: Generate Iframe Google Maps secara otomatis hanya dengan memasukkan nama tempat dan alamat.
*   **Modern Dashboard**: Tabel responsif dengan notifikasi interaktif menggunakan SweetAlert2.

### 📱 Modul User (Front-End)
*   **Discovery Feed**: Tampilan kartu (Card-based) yang estetik untuk eksplorasi menu makanan.
*   **Detail Interaction**: Halaman detail yang mencakup deskripsi mendalam dan lokasi peta interaktif.
*   **Responsive Experience**: UI yang adaptif di berbagai ukuran layar (Mobile, Tablet, Desktop).

### 🛠️ Integrasi Teknologi
*   **SweetAlert2**: Notifikasi pop-up modern untuk setiap aksi (Hapus, Berhasil Update, dll).
*   **Google Maps Embed API**: Lokasi akurat tanpa perlu keluar dari aplikasi.
*   **Glassmorphism UI**: Penggunaan efek blur, transparansi, dan font Poppins untuk kesan premium.

## 🛠️ Teknologi yang Digunakan

*   **Bahasa Pemrograman**: PHP 8.x
*   **Database**: MySQL / MariaDB
*   **Frontend**: Bootstrap 5, CSS3, SweetAlert2 (Notifikasi)
*   **Lainnya**: Google Maps API, Unsplash (Assets)

## 📦 Instalasi

1.  Clone repository ini:
    ```bash
    git clone [https://github.com/username/review-makanan.git](https://github.com/Novaastar/review-makanan.git)
    ```
2.  Pindahkan folder ke direktori `htdocs` (Laragon).
3.  Impor database:
    *   Buka `phpMyAdmin`.
    *   Buat database baru bernama `db_makanan`.
    *   Impor file `.sql` yang tersedia di folder `database/`.
4.  Konfigurasi koneksi:
    *   Buka file `config/koneksi.php`.
    *   Sesuaikan `host`, `user`, `pass`, dan `db_name`.
5.  Akses di browser: `localhost/review-makanan`.

## 🧪 Tabel Pengujian (UAT)

Berikut adalah hasil pengujian fitur-fitur utama aplikasi:

| ID | Fitur | Skenario Pengujian | Hasil yang Diharapkan | Status |
|:---|:---|:---|:---|:---:|
| 01 | Register | Mendaftar akun baru sebagai user | Data tersimpan di database dan dialihkan ke login | Pass |
| 02 | Login | Masuk dengan akun admin/user | Masuk ke dashboard sesuai role masing-masing | Pass |
| 03 | Proteksi Halaman | Mengakses `/admin` tanpa login admin | Sistem menolak akses dan kembali ke halaman login | Pass |
| 04 | Tambah Menu | Admin menambah data makanan & upload foto | Data muncul di dashboard admin dan user | Pass |
| 05 | Edit Menu | Admin mengubah detail & peta lokasi | Perubahan tersimpan dan preview peta terupdate | Pass |
| 06 | Hapus Menu | Admin menekan tombol hapus | Muncul konfirmasi SweetAlert2 dan data terhapus | Pass |
| 07 | Preview Maps | Mengisi nama & lokasi di form | Iframe memunculkan lokasi peta secara otomatis | Pass |
| 08 | Detail User | Klik tombol detail pada menu makanan | Menampilkan deskripsi lengkap & peta lokasi | Pass |

## 📸 Tampilan UI
*   **Login/Register**: Glassmorphism Transparan.
*   **Dashboard**: Card-based layout dengan efek hover.
*   **Admin**: Tabel responsif dengan aksi cepat.

---
Dikembangkan dengan ❤️ oleh **[Dianda Naufal Rahmanda - 365]** - 2026
