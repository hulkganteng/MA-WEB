# Website MA Ma'arif NU Assa'adah

Repositori ini memuat website resmi MA Ma'arif NU Assa'adah Bungah, Gresik. Aplikasi menyediakan halaman informasi publik dan panel administrasi untuk mengelola konten madrasah.

Aplikasi dibangun dengan Laravel 11, Tailwind CSS, Alpine.js, dan Vite. Dokumentasi ini menjelaskan cara menyiapkan lingkungan pengembangan, menjalankan aplikasi, menggunakan panel admin, dan melakukan deployment.

## Mulai cepat

Ikuti langkah berikut untuk menjalankan aplikasi di komputer lokal.

1. Kloning repositori dan masuk ke direktori proyek:

   ```bash
   git clone https://github.com/hulkganteng/MA-WEB.git
   cd MA-WEB
   ```

2. Pasang dependensi PHP dan JavaScript:

   ```bash
   composer install
   npm install
   ```

3. Siapkan konfigurasi aplikasi:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Jika menggunakan Windows PowerShell, salin file konfigurasi dengan perintah berikut:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

4. Siapkan database dan penyimpanan publik:

   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

5. Jalankan layanan pengembangan:

   ```bash
   composer dev
   ```

Aplikasi tersedia di `http://127.0.0.1:8000`. Panel admin dapat diakses melalui `http://127.0.0.1:8000/admin/login`.

## Fitur utama

Website mencakup kebutuhan publikasi informasi, layanan calon peserta didik, dan pengelolaan konten internal madrasah.

### Halaman publik

- Beranda dengan hero slider dan informasi utama madrasah.
- Berita, artikel, pengumuman, agenda, dan prestasi.
- Profil madrasah, sambutan kepala madrasah, dan struktur organisasi.
- Direktori guru dan tenaga kependidikan.
- Informasi program, kurikulum, kalender akademik, ekstrakurikuler, dan organisasi siswa.
- Galeri foto, video, fasilitas, unduhan, dan direktori alumni.
- Jadwal salat untuk wilayah Bungah, Gresik, beserta hitung mundur waktu salat berikutnya.
- Simulasi peminatan untuk membantu calon peserta didik mengenali program yang sesuai.
- Pencarian cepat melalui `Ctrl+K` atau `Cmd+K`.
- Pemutar audio untuk mars dan tilawah.
- Tautan cepat menuju WhatsApp, pendaftaran, jadwal salat, dan bagian atas halaman.

### Panel administrasi

Administrator dapat mengelola konten publik melalui panel berbasis hak akses. Editor teks mendukung format dokumen, tautan, gambar, video, tabel, dan penyuntingan sumber HTML.

Menu Pengaturan Website menyediakan pengelolaan identitas madrasah, kontak, metadata SEO, dan warna tampilan. Fitur warna hanya tersedia bagi Administrator dan Super Administrator yang memiliki izin `settings.manage`.

### Keamanan

Aplikasi menggunakan beberapa lapisan perlindungan berikut:

- Content Security Policy (CSP) untuk membatasi sumber skrip, gambar, formulir, dan frame.
- Validasi URL untuk video, tombol, peta, dan pengalihan internal.
- Sanitasi HTML melalui HTMLPurifier.
- Perlindungan Cross-Site Request Forgery (CSRF) pada formulir.
- Pembatasan jumlah permintaan pada login dan formulir publik.
- Pengelolaan akses berbasis role dan permission melalui Spatie Laravel Permission.
- Header keamanan, termasuk HTTP Strict Transport Security (HSTS) pada lingkungan produksi.

## Persyaratan sistem

Siapkan perangkat lunak berikut sebelum memasang aplikasi:

| Komponen | Versi minimum |
|---|---:|
| PHP | 8.2 |
| Composer | 2.x |
| Node.js | 18.x |
| npm | 9.x |
| Database | SQLite, MySQL 8, atau MariaDB yang kompatibel |

PHP harus menyediakan ekstensi `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, serta `gd` atau `imagick`.

## Konfigurasi lingkungan

Atur nilai pada file `.env` sesuai lingkungan yang digunakan. Contoh berikut menggunakan SQLite untuk pengembangan lokal:

```ini
APP_NAME="MA Ma'arif NU Assa'adah"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=sqlite
```

Buat file database SQLite jika file tersebut belum tersedia.

Linux atau macOS:

```bash
touch database/database.sqlite
```

Windows PowerShell:

```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
```

Untuk MySQL, ganti konfigurasi database pada `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ma_assaadah
DB_USERNAME=root
DB_PASSWORD=
```

Setelah mengubah koneksi, jalankan migrasi dan data awal:

```bash
php artisan migrate --seed
```

## Menjalankan aplikasi

Gunakan salah satu cara berikut sesuai kebutuhan pengembangan.

### Menjalankan seluruh layanan

Perintah ini menjalankan Laravel, Vite, queue worker, dan log viewer secara bersamaan:

```bash
composer dev
```

### Menjalankan layanan secara terpisah

Jalankan setiap perintah di terminal yang berbeda:

```bash
php artisan serve
```

```bash
npm run dev
```

### Membagikan pratinjau melalui VS Code

Bangun aset dan jalankan Laravel pada `0.0.0.0:8000`:

```bash
npm run preview:public
```

Kemudian buka panel **Ports** di VS Code, teruskan port `8000`, dan atur visibilitasnya menjadi **Public**.

URL publik dapat diakses oleh siapa pun yang memilikinya. Jangan gunakan data pribadi, kredensial produksi, atau `APP_DEBUG=true` saat membagikan pratinjau.

## Akun administrator awal

Seeder membuat akun Super Administrator berikut untuk lingkungan awal:

| Data | Nilai |
|---|---|
| URL | `http://127.0.0.1:8000/admin/login` |
| Email | `admin@ma-assaadah.sch.id` |
| Kata sandi | `password` |

Ubah kata sandi tersebut melalui menu **Akun** segera setelah login pertama, terutama sebelum aplikasi dapat diakses melalui jaringan publik.

## Panel administrasi

Panel admin tersedia di `/admin`. Menu yang terlihat menyesuaikan permission akun yang sedang digunakan.

| Menu | URL | Kegunaan |
|---|---|---|
| Dashboard | `/admin` | Menampilkan ringkasan konten dan aktivitas. |
| Hero Slider | `/admin/hero-slider` | Mengelola banner, teks, tautan, dan urutan slider. |
| Berita dan Artikel | `/admin/konten` | Mengelola berita dan artikel beserta metadata SEO. |
| Halaman Statis | `/admin/halaman` | Mengelola halaman informasi dengan slug khusus. |
| Profil Madrasah | `/admin/profil` | Mengelola profil, sejarah, visi dan misi, serta struktur organisasi. |
| Guru dan Tendik | `/admin/guru-tendik` | Mengelola data pendidik dan tenaga kependidikan. |
| Pengumuman | `/admin/pengumuman` | Menerbitkan pengumuman dan lampirannya. |
| Agenda | `/admin/agenda` | Mengelola jadwal kegiatan madrasah. |
| Prestasi | `/admin/prestasi` | Mencatat prestasi peserta didik dan madrasah. |
| Galeri | `/admin/galeri/foto` | Mengelola album foto dan video. |
| Program dan Kurikulum | `/admin/program` | Mengelola program pendidikan dan informasi kurikulum. |
| Fasilitas | `/admin/fasilitas-sarpras` | Mengelola sarana dan prasarana. |
| Kegiatan Siswa | `/admin/ekstrakurikuler` | Mengelola ekstrakurikuler dan organisasi siswa. |
| Alumni | `/admin/alumni` | Memverifikasi pendaftaran dan mengelola data alumni. |
| Pengaturan Website | `/admin/pengaturan` | Mengelola identitas, kontak, SEO, dan warna website. |

## Pengaturan warna website

Administrator dapat menyesuaikan warna utama, aksen, dan sekunder tanpa mengubah kode sumber.

1. Masuk ke panel admin.
2. Buka **Pengaturan Website**.
3. Pilih warna pada bagian **Warna website**.
4. Periksa kombinasi warna melalui pratinjau.
5. Klik **Simpan pengaturan**.

Perubahan berlaku pada seluruh halaman publik. Tombol **Gunakan warna bawaan** mengembalikan pilihan ke palet resmi sebelum pengaturan disimpan.

## Pengujian dan pemeriksaan kode

Jalankan pemeriksaan berikut sebelum menggabungkan perubahan:

```bash
php artisan test
```

```bash
./vendor/bin/pint --test
```

```bash
npm run build
```

Pada Windows PowerShell, jalankan Pint dengan perintah berikut:

```powershell
vendor\bin\pint.bat --test
```

## Deployment produksi

Lakukan deployment dari salinan repositori yang bersih dan gunakan konfigurasi khusus produksi.

1. Pasang dependensi dan bangun aset:

   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   npm run build
   ```

2. Atur konfigurasi produksi pada `.env`:

   ```ini
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-anda.com
   ```

3. Jalankan migrasi dan buat tautan penyimpanan:

   ```bash
   php artisan migrate --force
   php artisan storage:link
   ```

4. Bangun cache aplikasi:

   ```bash
   php artisan optimize
   ```

5. Arahkan document root web server ke direktori `public/`.

6. Jalankan queue worker dengan process manager seperti Supervisor jika fitur antrean digunakan:

   ```bash
   php artisan queue:work --tries=3
   ```

7. Aktifkan HTTPS dan ubah kata sandi administrator awal.

Direktori `storage/` dan `bootstrap/cache/` harus dapat ditulis oleh proses web server. Pantau log pada `storage/logs/` saat memeriksa masalah aplikasi.

## Perintah pemeliharaan

Gunakan perintah berikut untuk tugas pemeliharaan umum:

```bash
# Hapus cache aplikasi.
php artisan optimize:clear

# Bangun cache konfigurasi, route, event, dan view.
php artisan optimize

# Tampilkan daftar route.
php artisan route:list

# Jalankan queue worker.
php artisan queue:work
```

## Struktur direktori

Struktur utama proyek mengikuti konvensi Laravel:

```text
app/
├── Http/Controllers/     # Controller halaman publik, autentikasi, dan admin
├── Models/               # Model Eloquent
├── Rules/                # Aturan validasi khusus
└── Support/              # Permission dan utilitas aplikasi
config/                   # Konfigurasi aplikasi dan paket
database/
├── migrations/           # Definisi skema database
└── seeders/              # Data awal dan akun administrator
resources/
├── css/                  # Stylesheet dan token tampilan
├── js/                   # Alpine.js, ikon, dan skrip interaktif
└── views/                # Blade untuk halaman publik dan panel admin
routes/
├── web.php               # Route publik dan autentikasi
└── admin.php             # Route panel admin
tests/                    # Pengujian otomatis
```

## Lisensi dan hak cipta

Hak cipta © 2026 MA Ma'arif NU Assa'adah Bungah, Gresik. Penggunaan dan distribusi kode mengikuti kebijakan pemilik proyek.
