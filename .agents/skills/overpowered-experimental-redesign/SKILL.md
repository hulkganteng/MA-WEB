---
name: overpowered-experimental-redesign
description: >-
  Use this skill when the user requests redesigning, renovating, modernizing,
  or overhauling web layouts, components, animations, and features to be
  experimental, cutting-edge, overpowered, and pixel-perfect while maintaining
  full functionality, domain identity, zero regressions, and passing all tests.
---

# Overpowered Experimental Redesign

## 1. Tujuan
Skill ini mengarahkan Antigravity untuk melakukan redesign/renovasi UI dan rekayasa fitur dengan kualitas eksekusi setingkat **Senior Principal Design Engineer & Creative Technologist**:
- **Detail Sangat Tinggi**: Komponen dirancang dengan presisi piksel (*pixel-perfect*), micro-interactions yang halus, dan tipografi harmonis.
- **Eksperimental & Modern Terkini**: Menolak tata letak generik/bootstrap usang; mengadopsi Bento Grid, Glassmorphism bertingkat, SVG dinamis, dan transisi kinetik.
- **Overpowered & Functional**: Tidak hanya memoles visual, tetapi juga secara proaktif merekayasa fitur tematik yang benar-benar berfungsi (kalkulator peminatan, mesin sholat astronomis, kalender Hijriah, command palette `Ctrl+K`, pencarian instan client-side).
- **Zero Regressions & Good Excellence**: Menjamin 100% lulus seluruh test suite, mempertahankan invariant tes, dan memastikan seluruh tautan route valid.

---

## 2. Kapan Skill Ini Aktif
Aktifkan skill ini ketika permintaan pengguna mengandung indikasi:
- "redesign", "renovasi", "modernisasi", "overhaul", "upgrade tampilan", "rombak"
- Permintaan membuat komponen, animasi, atau fitur baru yang "wow", "niche", "cutting-edge", "eksperimental", atau "overpower"
- Perbaikan UI/UX yang menuntut standar "pixel-perfect", "modern", atau "premium"

---

## 3. Standar Stack Animasi & Interaktivitas

### A. Untuk Proyek React / Next.js: Framer Motion Wajib
Jika proyek berbasis React/Next.js, gunakan **Framer Motion** sebagai library animasi utama:
1. **Import minimal & tepat guna**: Gunakan `motion` dari `framer-motion` hanya pada elemen yang dianimasikan.
2. **AnimatePresence untuk unmount**: Setiap modal, toast, drawer, dan accordion wajib dibungkus `AnimatePresence` dengan exit animation yang bersih.
3. **Variants, bukan inline berulang**: Definisikan `variants` (`initial`, `animate`, `exit`) sekali per komponen.
4. **Stagger untuk grup elemen**: Gunakan `staggerChildren` pada parent variant agar list/grid muncul berurutan secara natural.
5. **Layout animation**: Gunakan prop `layout` atau `layoutId` untuk transisi posisi/ukuran otomatis.
6. **Scroll-based reveal**: Gunakan `useScroll` + `useTransform` atau `whileInView={{ once: true }}`.
7. **Physics naturalistik**: Gunakan `type: "spring", stiffness: 300, damping: 20` untuk interaksi premium; gunakan `type: "tween"` dengan bezier kurva custom untuk modal/dropdown.
8. **Reduced motion wajib**: Hormati preferensi OS dengan `useReducedMotion()`.
9. **Performa 60fps**: Animasikan hanya `transform` dan `opacity` yang diakselerasi GPU.

### B. Untuk Proyek Laravel (Blade) / Vue / Svelte / Vanilla: Alpine.js & CSS Hardware-Accelerated
Jika proyek berbasis Laravel Blade + Tailwind CSS:
1. **Alpine.js Reactive Stores**: Bangun mesin interaktivitas di store global Alpine (`Alpine.store(...)`) untuk state modal, kalkulator, pemutar audio, dan countdown.
2. **Tailwind Extended Animations**: Deklarasikan keyframe khusus di `tailwind.config.js` (`float`, `shimmer`, `marquee`, `pulse-slow`, `glow`).
3. **Hardware Acceleration**: Gunakan `transform-gpu`, `will-change: transform`, serta manipulasi `opacity` dan `translate` untuk menjaga fluiditas 60fps.
4. **Accessible Micro-interactions**: Gunakan transisi Alpine `x-transition:enter` dan `x-transition:leave` dengan durasi 150ms–300ms bernuansa elastis.

---

## 4. Pola Arsitektur Desain "Overpowered & Experimental"

### 1. Hover Effects Gaya "Unifiers of Japan / Dynamic Depth"
Karakter: Hover yang mengungkap detail gambar/overlay dengan transisi kedalaman halus dan spotlight effect.

```html
<!-- Contoh Pola Blade + Tailwind: Interactive Depth Card -->
<div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 shadow-soft transition-all duration-500 hover:-translate-y-1.5 hover:border-primary-500/40 hover:shadow-lift">
    <div class="relative aspect-video overflow-hidden rounded-2xl bg-slate-900">
        <img src="..." class="size-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
    </div>
    <div class="mt-4">
        <h3 class="text-base font-bold text-slate-900 group-hover:text-primary-700 transition">Judul Elemen</h3>
    </div>
</div>
```

### 2. Bento Grid Architecture (Apple / Linear / Raycast Standard)
- Jangan gunakan grid kolom datar yang monoton. Gunakan layout asimetris bento berbobot:
  - **Feature Anchor**: Span kolom lebih lebar (mis. 7/12 atau 8/12) untuk konten utama dengan visual kaya.
  - **Metric / Stat Cards**: Kartu kecil (mis. 4/12 atau 5/12) berisi angka, countdown waktu sholat, atau indikator status.
  - **Quick Action Pills**: Tombol interaktif mikro dengan preview popup.

### 3. Sacred Cultural / Geometric Lattices & Arabesque Watermarks
- Untuk institusi pendidikan Islam atau bernuansa tradisi:
  - Terapkan pola geometris bintang 8 penjuru (*Islamic star patterns*) dan arabesque tipis (`opacity-40` hingga `opacity-60`) pada latar belakang hero dan footer.
  - Pasangkan watermark ayat suci atau kaligrafi Arab berkualitas tinggi menggunakan font naskhi klasik (misalnya **Amiri**) dengan opacity transparan halus (`text-white/[0.03]`).
  - Padukan tipografi Latin modern (misalnya **Plus Jakarta Sans**) untuk kemudahan baca internasional.

### 4. Deep Multi-Layered Glassmorphism
- Gunakan perpaduan:
  - `backdrop-blur-md` atau `backdrop-blur-xl`
  - Border semi-transparan tipis: `border border-white/10` atau `border-gold-400/20`
  - Gradasi latar belakang halus: `bg-white/5` atau `bg-slate-950/80`
  - Subtle radial gradient glow di sudut luar kartu.

### 5. Dynamic Scroll Progress Indicator & Floating Hub
- Komponen mengambang di pojok layar dengan SVG stroke progress (`stroke-dashoffset`) yang melingkar mengikuti scroll pengguna, dipadukan dengan tombol aksi cepat (simulasi jurusan, jadwal sholat, kontak darurat, dan back-to-top).

### 6. Global Command Palette Modal (`Ctrl + K` / `Cmd + K`)
- Hadirkan pencarian instan modal yang terbuka saat menekan shortcut keyboard `Ctrl+K` untuk navigasi kilat di seluruh ekosistem website.

---

## 5. Rekayasa Fitur Tematik Berfungsi Penuh ("Overpower Functional Additions")

Setiap kali melakukan renovasi halaman, identifikasi kebutuhan fungsional domain dan bangun fitur nyata:
1. **Interactive Simulation / Wizard**:
   - Bangun kuis multi-step (mis. Kalkulator Peminatan Santri Baru / SPMB) yang menghitung persentase kecocokan minat santri ke jurusan MIPA, IPS, Keagamaan/Turats, atau Tahfidz, lengkap dengan tombol konsultasi WhatsApp dinamis berpesan terstruktur.
2. **Mesin Kalkulasi Astronomis Sholat**:
   - Hitung posisi matahari dan waktu sholat secara astronomis sesuai koordinat lintang/bujur spesifik lokasi lembaga (+2 menit waktu ihtiyat Kemenag).
   - Tampilkan live countdown ticker 1 detik menuju waktu sholat berikutnya di topbar navbar.
3. **Konverter Penanggalan Hijriah Dinamis**:
   - Konversi tanggal Masehi ke Hijriah harian secara otomatis.
4. **Client-Side Instant Filter & Search**:
   - Di direktori guru, prestasi, dan unduhan dokumen, sediakan pencarian instan tanpa perlu memuat ulang halaman (*zero-latency search* via Alpine.js).
5. **FAQ Interactive Accordion**:
   - Jawab pertanyaan umum calon peserta didik/wali santri dengan accordion interaktif yang rapi.

---

## 6. Protokol Nol Regresi & Integritas Pengujian (Zero-Regression Protocol)

Sebelum dan sesudah melakukan perubahan kode:
1. **Verifikasi Nama Route Terlebih Dahulu**:
   - Selalu inspeksi file `routes/web.php` sebelum menggunakan fungsi `route(...)` di Blade.
   - Jangan berasumsi nama rute (mis. jika rute sambutan bernama `'sambutan'`, jangan menulis `route('principal')`).
2. **Patuhi Invariant Assertion Pengujian**:
   - Periksa file pengujian di `tests/Feature/` (mis. `ExampleTest.php`, `CmsIntegrationTest.php`).
   - Jika tes memeriksa teks tertentu pada halaman (misal `'Membentuk Generasi Berilmu'` atau `'Berita terbaru'`), teks tersebut **wajib tetap hadir** di halaman yang baru.
3. **Kompilasi Aset Frontend**:
   - Jalankan `npm run build` setelah mengubah Tailwind atau JavaScript.
4. **Eksekusi Pengujian PHPUnit / Pest**:
   - Di environment Windows Laravel Herd, selalu gunakan PHP Herd executable:
     `& "C:\Users\LENOVO\.config\herd-lite\bin\php.exe" artisan test`
   - Pastikan **100% tes lulus (exit code 0)** sebelum menyelesaikan tugas.

---

## 7. Checklist Kualitas Akhir (Senior Principal Standard)
- [ ] **No Placeholders**: Tidak ada teks palsu generik atau tautan kosong `href="#"`. Semua tombol memiliki tujuan atau trigger modal yang jelas.
- [ ] **Identitas Warna Terpelihara**: Palet institusi (Hijau Zamrud, Hijau Mint, Emas/Amber, Hitam Obsidian, Putih Mutiara) konsisten.
- [ ] **Aksesibilitas Terjaga**: Rasio kontras teks tajam, tag semantik lengkap, aria-labels terpasang pada tombol ikon, dan tersedia kontrol ukuran font.
- [ ] **Clean Code**: Tidak ada kode duplikat, tidak ada inline script yang berantakan, terstruktur dalam komponen Blade yang modular.
- [ ] **Passing All Tests**: 100% pengujian otomatis lolos tanpa kompromi.
