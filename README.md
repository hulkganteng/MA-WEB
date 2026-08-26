# 🏫 Website Resmi MA Ma'arif NU Assa'adah Bungah Gresik
> **Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren**  
> *Yayasan Pondok Pesantren Qomaruddin — Sampurnan, Bungah, Gresik, Jawa Timur*

Website resmi **MA Ma'arif NU Assa'adah (MADAH)** yang modern, interaktif, cepat, dan aman. Dibangun menggunakan **Laravel 11**, **Tailwind CSS**, **Alpine.js**, dan **Lucide Icons** dengan sistem proteksi keamanan tingkat tinggi serta **Rich HTML Editor** untuk kemudahan pengelolaan konten madrasah.

---

## 📋 Daftar Isi
1. [Fitur Utama Website](#-fitur-utama-website)
2. [Fitur Keamanan & Proteksi Anti-Judol](#-fitur-keamanan--proteksi-anti-judol)
3. [Fitur Editor Teks HTML Admin](#-fitur-editor-teks-html-admin)
4. [Persyaratan Sistem](#-persyaratan-sistem)
5. [Panduan Instalasi & Menjalankan](#-panduan-instalasi--menjalankan)
6. [Akun Administrator Default](#-akun-administrator-default)
7. [Panduan Penggunaan Panel Admin](#-panduan-penggunaan-panel-admin)
8. [Perintah Artisan yang Berguna](#-perintah-artisan-yang-berguna)
9. [Struktur Direktori](#-struktur-direktori)

---

## ✨ Fitur Utama Website

### 🌐 Halaman Publik (Frontend)
- **🕌 Live Jadwal Sholat Bungah Gresik:** Hisab waktu sholat otomatis untuk wilayah Bungah, Gresik (+2 menit ihtiyat Kemenag) dengan hitung mundur (*countdown*) waktu sholat berikutnya serta konversi kalender Hijriyah live.
- **✨ Simulasi Peminatan Santri Baru (SPMB Quiz):** Kuis interaktif 4 langkah untuk membantu calon santri menemukan jurusan yang cocok (MIPA Riset, IPS Entrepreneur, Keagamaan Turats, atau Tahfidzul Qur'an 30 Juz) lengkap dengan animasi selebrasi.
- **🔍 Global Command Palette (`Ctrl+K` / `Cmd+K`):** Pintasan pencarian cepat untuk melompat langsung ke halaman profil, agenda, berita, guru, unduhan dokumen, atau SPMB.
- **🎵 Mars & Tilawah Santri Audio Hub:** Pemutar audio mini terapung (*floating player*) untuk mendengarkan Mars LP Ma'arif NU, Mars Santri MA Assa'adah, dan murottal Al-Qur'an.
- **🖼️ Hero Slider Interaktif & Modal Preview:** Banner bergerak otomatis dengan visual responsive dan tombol aksi cepat.
- **📰 Portal Berita & Khazanah Artikel Islam:** Artikel dan berita madrasah dengan kategori, tag, pencarian, dan artikel terkait.
- **👥 Direktori Lengkap Madrasah:**
  - Profil & Sambutan Kepala Madrasah
  - Direktori Guru & Tenaga Kependidikan
  - Sarana & Prasarana Fasilitas
  - Ekstrakurikuler & Organisasi Siswa (OSIM, IPNU, IPPNU, MPK)
  - Galeri Foto Kegiatan & Galeri Video Dokumentasi YouTube
  - Prestasi Santri & Madrasah
  - Kalender Akademik & Kurikulum Terintegrasi Pesantren
- **🎓 Pusat Alumni & Registrasi Online:** Direktori alumni IKBAL MADAH dan form registrasi alumni baru dengan sistem verifikasi admin.
- **📥 Pusat Unduhan:** Brosur, formulir, dan dokumen SPMB.
- **💬 Tombol Aksi Terapung (Floating Action Hub):** Akses cepat WhatsApp Hotline Madrasah, Daftar SPMB Online (Lynk.id), Jadwal Sholat, dan Scroll-to-Top dengan *progress ring indicator*.

---

## 🛡️ Fitur Keamanan & Proteksi Anti-Judol

Website ini telah diaudit dan diperkuat dengan standar keamanan web modern:

1. **Content-Security-Policy (CSP) Lengkap:**
   - Membatasi sumber skrip, style, dan gambar hanya dari domain sendiri dan CDN terpercaya.
   - `frame-src` dikunci **hanya untuk YouTube dan Vimeo**. Frame/iframe dari situs luar (termasuk link judol) otomatis **diblokir total** oleh browser.
   - `form-action` dan `frame-ancestors` dikunci ke `'self'` untuk mencegah clickjacking dan form redirection.
2. **Pencegahan Open Redirect:**
   - Middleware `HandleRedirects` memvalidasi bahwa link tujuan redirect **hanya boleh berupa path relatif (`/path`) atau URL domain sendiri**.
   - Upaya redirect ke domain asing/judol akan otomatis diblokir dan dicatat di log sistem.
3. **Validasi URL Input Terpusat (`UrlSanitizer` & Safe Rules):**
   - `SafeVideoUrl`: URL video hanya diizinkan dari YouTube / Vimeo.
   - `SafeButtonUrl`: Mencegah injeksi `javascript:`, `data:`, atau `vbscript:` pada tombol banner/slider.
   - `SafeMapsUrl`: Embed peta hanya diizinkan dari domain resmi Google Maps.
4. **Sanitasi Konten HTML (HTMLPurifier):**
   - Seluruh konten artikel, berita, halaman, dan sambutan dibersihkan menggunakan `mews/purifier` dengan pembatasan URI scheme (`http`, `https`, `mailto`, `tel`) dan penambahan otomatis `rel="noopener noreferrer"`.
5. **Keamanan Tambahan:**
   - Rate limiting pada form publik (`throttle:5,1`) dan login admin (`throttle:6,1`).
   - CSRF Protection pada setiap request form.
   - Penghapusan header `Server` dan `X-Powered-By` untuk mencegah eksposur informasi server.
   - HSTS (HTTP Strict Transport Security) otomatis aktif di environment *production*.

---

## 📝 Fitur Editor Teks HTML Admin

Setiap form input teks panjang di Admin Panel (Berita, Artikel, Halaman Statis, Pengumuman, Sambutan Kepala, Kurikulum, Program, Fasilitas, dan Organisasi) telah dilengkapi dengan **Rich HTML Editor** berbasis Quill:

- **Format Teks:** Heading (H1-H6), Bold, Italic, Underline, Strikethrough, Subscript, Superscript.
- **Warna & Highlight:** Pewarnaan teks dan penandaan background.
- **Struktur Dokumen:** Daftar berpoin (Bullet List), Daftar bernomor (Numbered List), Kutipan (Blockquote), Blok Kode (Code Block), dan Tabel.
- **Media:** Sisip Link, Gambar, dan Video.
- **Perataan:** Rata kiri, tengah, kanan, dan rata kanan-kiri (justify).
- **Mode Kode HTML (Toggle Source):** Tombol *"Lihat / Edit HTML Source"* memungkinkan admin mengedit tag HTML mentah secara langsung dengan tampilan syntax gelap.
- **Live Counter:** Menampilkan jumlah kata dan karakter secara otomatis saat mengetik.

---

## 💻 Persyaratan Sistem

Pastikan server atau komputer pengembangan Anda memenuhi syarat berikut:

- **PHP:** Versi `>= 8.2` (dengan ekstensi `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`/`imagick`)
- **Composer:** Versi `>= 2.0`
- **Node.js & NPM:** Node.js `>= 18.x` & NPM `>= 9.x`
- **Database:** SQLite (default) atau MySQL / MariaDB `>= 8.0`

---

## 🚀 Panduan Instalasi & Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan proyek dari awal:

### 1. Clone Repositori
```bash
git clone https://github.com/username/MA-Assadah-WEB-New.git
cd MA-Assadah-WEB-New
```

### 2. Install Dependensi PHP & JavaScript
```bash
# Install package PHP via Composer
composer install

# Install package Frontend via NPM
npm install
```

### 3. Konfigurasi Environment File
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi dasar:
```ini
APP_NAME="MA Ma'arif NU Assa'adah"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost:8000

# Konfigurasi Database (Gunakan SQLite untuk kemudahan atau MySQL)
DB_CONNECTION=sqlite
# Jika MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=ma_assaadah
# DB_USERNAME=root
# DB_PASSWORD=
```

### 4. Generate Application Key & Siapkan Database
```bash
# Generate key aplikasi
php artisan key:generate

# Jika menggunakan SQLite, buat file database kosong:
# Di Windows PowerShell:
New-Item -ItemType File -Path database\database.sqlite -Force
# Di Linux/macOS:
# touch database/database.sqlite

# Jalankan migrasi tabel dan data awal (seeder)
php artisan migrate --seed

# Buat symbolic link untuk media storage
php artisan storage:link
```

### 5. Menjalankan Server Pengembangan (Development Mode)

Buka **dua terminal terpisah**:

**Terminal 1 — Server Laravel:**
```bash
php artisan serve
```
*(Aplikasi akan berjalan di `http://127.0.0.1:8000`)*

**Terminal 2 — Vite Asset Compiler:**
```bash
npm run dev
```

> **Tip:** Anda juga dapat menjalankan seluruh service sekaligus (server, vite, queue, logs) dengan perintah:
> ```bash
> composer dev
> ```

### 6. Build Aset untuk Production
Saat siap di-deploy ke server live / hosting:
```bash
npm run build
```

---

## 🔑 Akun Administrator Default

Setelah menjalankan `php artisan migrate --seed`, akun super administrator default siap digunakan:

- **URL Login Admin:** `http://localhost:8000/admin/login`
- **Email:** `admin@ma-assaadah.sch.id`
- **Password:** `password`

> **PENTING:** Segera ubah password administrator Anda setelah pertama kali login melalui menu **Akun** (`/admin/akun`) demi keamanan website Anda.

---

## 🎛️ Panduan Penggunaan Panel Admin

Setelah login ke panel admin (`/admin`), Anda dapat mengelola seluruh konten website melalui menu-menu berikut:

| Menu Admin | URL Route | Fungsi & Kegunaan |
|---|---|---|
| **Dashboard** | `/admin` | Ringkasan statistik berita, agenda, pengumuman, dan log aktivitas admin. |
| **Hero Slider** | `/admin/hero-slider` | Kelola gambar banner bergerak, teks judul, tombol link, dan urutan tampilan slider homepage. |
| **Berita & Artikel** | `/admin/konten` | Tulis, edit, filter, atau hapus artikel dan berita madrasah dengan Rich HTML Editor & SEO meta. |
| **Halaman Statis** | `/admin/halaman` | Buat halaman mandiri khusus dengan slug kustom (misal: `/syarat-pendaftaran`). |
| **Profil Madrasah** | `/admin/profil` | Edit teks Tentang Madrasah, Sejarah, Visi Misi, dan Struktur Organisasi Pimpinan. |
| **Sambutan Kepala** | `/admin/profil/sambutan-kepala` | Edit foto, nama, jabatan, dan teks pidato sambutan kepala madrasah. |
| **Guru & Tendik** | `/admin/guru-tendik` | Kelola direktori pendidik, NIP/NUPTK, jabatan, mapel, dan foto guru. |
| **Pengumuman** | `/admin/pengumuman` | Publikasikan surat edaran atau pengumuman resmi lengkap dengan lampiran PDF/DOCX. |
| **Agenda Kegiatan** | `/admin/agenda` | Jadwalkan acara, tanggal, waktu, lokasi, dan gambar agenda madrasah. |
| **Prestasi Santri** | `/admin/prestasi` | Catat kejuaraan santri (tingkat Kabupaten, Provinsi, Nasional, Internasional). |
| **Galeri Foto & Video**| `/admin/galeri/foto` & `/video` | Unggah album dokumentasi foto atau embed video dokumentasi YouTube. |
| **Program & Jurusan** | `/admin/program` | Kelola profil jurusan peminatan santri (MIPA, IPS, Keagamaan, Tahfidz). |
| **Kurikulum** | `/admin/kurikulum` | Unggah silabus, dokumen kurikulum, dan penjelasan capaian pembelajaran. |
| **Fasilitas & Sarpras**| `/admin/fasilitas-sarpras` | Kelola daftar sarana prasarana, lab, asrama, dan fasilitas belajar. |
| **Ekstrakurikuler** | `/admin/ekstrakurikuler` | Kelola jadwal latihan, profil, dan capaian ekstrakurikuler santri. |
| **Organisasi Siswa** | `/admin/organisasi-siswa` | Profil pengurus, struktur, dan program kerja OSIM / IPNU / IPPNU. |
| **Kelola Alumni** | `/admin/alumni` | Verifikasi pendaftaran alumni baru dan kelola testimoni alumni yang tampil. |
| **Pengaturan Website** | `/admin/pengaturan` | Ubah nama situs, tagline, kontak WhatsApp, email, alamat, jam operasional, dan Google Maps URL. |

---

## 🛠️ Perintah Artisan yang Berguna

Berikut kumpulan perintah CLI Laravel yang sering digunakan dalam pemeliharaan website:

```bash
# Bersihkan seluruh cache aplikasi (Konfigurasi, Route, View)
php artisan optimize:clear

# Cache konfigurasi dan route untuk performa maksimal di production
php artisan optimize

# Bersihkan cache HTMLPurifier secara manual jika ada perubahan definisi HTML
php artisan cache:clear

# Cek daftar route yang terdaftar
php artisan route:list

# Menjalankan background queue worker (untuk notifikasi/email)
php artisan queue:work
```

---

## 📁 Struktur Direktori

```
MA-Assadah-WEB-New/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Controller panel admin (Posts, Pages, Settings, dll.)
│   │   │   ├── Auth/          # Controller autentikasi login/logout admin
│   │   │   └── Public/        # Controller halaman publik (Home, Berita, Guru, dll.)
│   │   └── Middleware/
│   │       ├── HandleRedirects.php # Proteksi Open Redirect & Router
│   │       └── SecurityHeaders.php # HTTP Security Headers & Content Security Policy (CSP)
│   ├── Models/                # Eloquent Models (Post, Page, Teacher, Event, dll.)
│   ├── Rules/                 # Custom Validation Rules (SafeVideoUrl, SafeButtonUrl, SafeMapsUrl)
│   └── Support/               # Helper & Sanitizer (UrlSanitizer, Permissions)
├── config/
│   └── purifier.php           # Konfigurasi sanitasi HTMLPurifier Anti-Judol
├── database/
│   ├── migrations/            # Struktur skema tabel database
│   └── seeders/               # Data awal madrasah & akun admin
├── public/                    # Entry point index.php & compiled storage assets
├── resources/
│   ├── css/                   # Tailwind CSS styling & custom utility rules
│   ├── js/                    # Alpine.js stores, Lucide icons, & Islamic Hub scripts
│   └── views/
│       ├── admin/             # View Blade panel admin
│       ├── components/        # Reusable Blade components (Rich Editor, Layout, Toast, dll.)
│       └── public/            # View Blade halaman publik madrasah
└── routes/
    ├── admin.php              # Route panel admin (dilindungi middleware auth & permission)
    └── web.php                # Route halaman publik madrasah
```

---

## 📄 Lisensi & Hak Cipta

© 2026 **MA Ma'arif NU Assa'adah Bungah Gresik**. Seluruh hak cipta dilindungi undang-undang.  
Dikembangkan untuk mendukung digitalisasi dan keterbukaan informasi pendidikan madrasah berkarakter pesantren.
