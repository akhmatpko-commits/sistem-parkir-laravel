# Sistem Parkir - Laravel

Aplikasi web untuk membantu pengelolaan parkir kendaraan. Sistem menyediakan pengelolaan data kendaraan, tarif, area parkir, transaksi masuk dan keluar, pembayaran, laporan, serta pencatatan aktivitas.

## Teknologi

Berdasarkan konfigurasi proyek:
- PHP `^8.3`
- Laravel `^13.0`
- Composer
- Node.js dan NPM
- Vite dan Tailwind CSS
- Database: SQLite sebagai konfigurasi bawaan pada `.env.example`; konfigurasi dapat disesuaikan ke MySQL melalui `.env`.

## Hak Akses

| Role | Fitur utama |
|---|---|
| Admin | Dashboard admin, kelola akun Admin/Petugas, CRUD kendaraan, tarif, area parkir, operasional transaksi, dan log aktivitas |
| Owner | Dashboard owner, melihat transaksi dan laporan |
| Petugas | Dashboard petugas, operasional kendaraan masuk/keluar, melihat transaksi, dan mencetak struk |

## Fitur Aplikasi

- Login dan logout.
- Dashboard berdasarkan role.
- Pengelolaan akun pengguna oleh Admin.
- CRUD data kendaraan.
- CRUD tarif parkir.
- CRUD area parkir.
- Pencatatan kendaraan masuk.
- Proses kendaraan keluar (checkout).
- Perhitungan biaya parkir dan proses pembayaran.
- Daftar dan detail transaksi.
- Cetak/lihat struk pembayaran.
- Laporan transaksi.
- Log aktivitas khusus Admin.
- Pembatasan halaman berdasarkan role melalui middleware.

## Persyaratan

- PHP 8.3 atau versi yang memenuhi `composer.json`.
- Composer.
- Node.js dan NPM.
- SQLite atau MySQL.
- Web browser.

## Cara Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/akhmatpko-commits/sistem-parkir-laravel.git
   cd sistem-parkir-laravel
   ```

2. Install dependency:

   ```bash
   composer install
   npm install
   ```

3. Buat file environment.

   Windows PowerShell:
   ```powershell
   Copy-Item .env.example .env
   ```

   Linux/macOS/Git Bash:
   ```bash
   cp .env.example .env
   ```

4. Buat application key:

   ```bash
   php artisan key:generate
   ```

5. Siapkan database.

   Untuk SQLite, pastikan file `database/database.sqlite` tersedia dan `.env` menggunakan `DB_CONNECTION=sqlite`.

   Untuk MySQL, buat database terlebih dahulu lalu sesuaikan konfigurasi berikut pada `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Jalankan migration dan seeder:

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

   Seeder yang dipanggil oleh `DatabaseSeeder`: `KendaraanSeeder`, `TarifSeeder`, dan `UserSeeder`. Periksa file `UserSeeder` untuk mengetahui akun awal yang dibuat.

7. Build aset frontend:

   ```bash
   npm run build
   ```

## Menjalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Kemudian buka http://127.0.0.1:8000 pada browser.

Untuk pengembangan frontend, jalankan:

```bash
npm run dev
```

## Alur Penggunaan Singkat

1. Login menggunakan akun yang tersedia.
2. Admin menyiapkan data pengguna, kendaraan, tarif, dan area parkir.
3. Admin atau Petugas mencatat kendaraan masuk.
4. Saat kendaraan keluar, Admin atau Petugas memproses checkout.
5. Sistem memproses biaya parkir dan pembayaran.
6. Struk transaksi dapat dibuka/cetak.
7. Owner dan Admin dapat melihat laporan transaksi.

## Pengujian

Jalankan pengujian otomatis dengan:

```bash
php artisan test
```

Pengujian manual yang disarankan:
- Login/logout setiap role.
- Pastikan Admin, Owner, dan Petugas hanya dapat mengakses halaman sesuai haknya.
- Tambah, ubah, dan hapus data kendaraan, tarif, area, dan pengguna.
- Uji transaksi kendaraan masuk dan keluar.
- Uji perhitungan biaya dan pembayaran.
- Periksa struk pembayaran.
- Uji filter laporan berdasarkan waktu/periode.
- Pastikan log aktivitas hanya dapat dibuka Admin.

Catat hasil setiap pengujian berdasarkan hasil tes yang benar-benar dilakukan.

## Struktur Folder Penting

| Lokasi | Kegunaan |
|---|---|
| `app/Models` | Model data |
| `app/Http/Controllers` | Logika aplikasi |
| `app/Http/Middleware` | Pembatasan akses |
| `database/migrations` | Struktur tabel |
| `database/seeders` | Data awal |
| `resources/views` | Tampilan Blade |
| `routes/web.php` | Route aplikasi |
| `tests` | Pengujian otomatis |

## Keamanan dan Catatan

- Jangan pernah mengunggah file `.env`, password, token, atau kredensial database.
- Folder `vendor` dan `node_modules` tidak perlu dimasukkan ke repository.
- Jangan mengunggah data pribadi atau data transaksi asli.
- README ini menjelaskan fitur berdasarkan route dan konfigurasi proyek. Status berhasil/gagal setiap fitur harus mengikuti hasil pengujian aplikasi.

## Lisensi

Lisensi proyek belum ditentukan. Tambahkan file `LICENSE` jika ingin menetapkan ketentuan penggunaan dan distribusi.
