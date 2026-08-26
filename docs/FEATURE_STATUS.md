# Status Implementasi Fitur

Dokumen ini mencocokkan implementasi aktual dengan master prompt. Gunakan status ini untuk menentukan pekerjaan berikutnya tanpa mengandalkan keberadaan route atau tabel saja.

Status:

- **Selesai**: alur utama tersedia dan telah diuji.
- **Parsial**: fondasi atau tampilan tersedia, tetapi requirement belum lengkap.
- **Belum**: belum ada implementasi yang dapat digunakan.

## Ringkasan fase

Master prompt menetapkan 13 fase. Phase 2 sekarang memiliki halaman publik nyata; fokus berikutnya adalah CMS admin pada Phase 3.

| Phase | Status | Implementasi | Kekurangan utama |
|---|---|---|---|
| 0 — Audit website lama | Parsial | Analisis konten, URL, privasi, dan risiko awal tersedia di `PLAN.md` | Audit source, hosting, malware, akun, DNS, dan credential membutuhkan akses website lama |
| 1 — Fondasi | Parsial | Laravel, schema, model, seeder, login, RBAC middleware, settings, layout, design system, dan penggantian kata sandi akun | Reset password via email, session timeout, dan pengelolaan pengguna belum tersedia |
| 2 — Website publik inti | Selesai | Homepage, profil, sambutan, struktur, GTK, fasilitas, program, kurikulum, kalender, ekstrakurikuler, organisasi, dan kontak | Konten resmi dan foto masih perlu dimasukkan melalui CMS |
| 3 — Content CMS | Parsial | Dashboard admin, CRUD Berita/Artikel/Halaman, CMS Profil, serta Guru & Tendik sudah terintegrasi dengan website publik | CRUD Pengumuman, Agenda, Prestasi, kategori, preview, sorting, dan bulk action belum tersedia |
| 4 — Media | Parsial | Galeri album, foto, lightbox, dan video eksternal tersedia | Media Library, upload admin, kompresi, thumbnail, WebP, metadata, dan reuse media belum tersedia |
| 5 — Alumni | Parsial | Direktori publik, jejak alumni, dan registrasi pending tersedia | Moderasi admin, upload foto, dan Turnstile belum tersedia |
| 6 — Document Center | Parsial | Daftar, filter kategori, penghitungan, dan delivery file tersedia | CRUD admin dan upload tervalidasi belum tersedia |
| 7 — SEO | Parsial | Meta, canonical, OpenGraph, Twitter Card, schema organisasi/artikel, sitemap awal, robots, dan middleware redirect tersedia | Sitemap semua entitas, schema Event/Breadcrumb/School, admin redirect, dan kebijakan 410 belum lengkap |
| 8 — Security hardening | Parsial | CSRF, escaping, sanitasi konten, validation, throttle, password hashing, dan security headers dasar tersedia | Turnstile, policy lengkap, reset password, session timeout, login history UI, 2FA, dan hardening upload belum tersedia |
| 9 — Performance | Parsial | Pagination, eager loading pada jalur utama, lazy loading, index database, dan production build tersedia | Responsive image, image pipeline, cache settings/menu terukur, bundle splitting, dan audit Core Web Vitals belum tersedia |
| 10 — Testing | Parsial | Migration/seeder, render homepage, dan 17 halaman publik diuji | Auth, authorization, CMS, upload, form POST, redirect, rate limit, dan security regression test belum tersedia |
| 11 — Migrasi konten | Belum | Strategi dan aturan sanitasi sudah didokumentasikan | Export, sanitizer, importer, media mapping, dan QA belum dikerjakan |
| 12 — Deployment | Belum | Target shared hosting dan VPS sudah ditentukan | Panduan deployment, backup/restore, production config, dan smoke test belum dikerjakan |

## Status fitur publik

Tabel ini menunjukkan cakupan fitur yang dapat diakses pengunjung.

| Fitur | Status | Catatan |
|---|---|---|
| Homepage 16 bagian | Parsial | Semua jenis section sudah diimplementasikan; section galeri/alumni hanya tampil jika data tersedia dan counter belum dianimasikan |
| Berita dan artikel | Selesai | Listing, filter berita, detail, tag, related content, reading time, views, dan sanitasi HTML tersedia |
| Pengumuman | Selesai | Listing, detail, status penting, periode aktif, dan lampiran tersedia |
| Agenda | Selesai | Listing, detail, tanggal, waktu, lokasi, kategori, dan agenda mendatang tersedia |
| Prestasi | Selesai | Listing dan filter tahun, kategori, serta tingkat tersedia |
| Profil | Selesai | Tentang, sejarah, visi-misi, sambutan, dan struktur tersedia dengan fallback konten kosong serta CMS khusus yang terhubung langsung |
| GTK | Selesai | Guru dan tenaga kependidikan dipisahkan; CMS mendukung input, edit, filter, status publik, foto, urutan, sampah, dan pemulihan |
| Program akademik | Selesai | Program pendidikan, program unggulan, kurikulum, dan kalender akademik tersedia |
| Kesiswaan | Selesai | Ekstrakurikuler, detail kegiatan, dan organisasi siswa tersedia |
| Fasilitas | Selesai | Grid fasilitas dinamis dan empty state tersedia |
| Galeri | Selesai | Album, foto, lazy loading, lightbox, dan video YouTube/external tersedia |
| Alumni | Parsial | Direktori dan submission pending tersedia; Turnstile dan moderasi admin belum ada |
| Download | Selesai | Filter kategori, ukuran, jumlah download, dan file guard tersedia |
| Global search | Selesai | Hasil dikelompokkan untuk delapan jenis konten sesuai master prompt |
| Kontak | Parsial | Informasi kontak, form, validation, dan rate limit tersedia; Turnstile dan tampilan peta belum ada |
| Floating WhatsApp | Selesai | Nomor, pesan default, dan status aktif menggunakan settings |

## Urutan implementasi berikutnya

Kelanjutan mengikuti master prompt dan menghindari menambah tampilan publik tanpa alat pengelolaannya.

1. Bangun shell dashboard admin, overview, sidebar, dan permission middleware.
2. Bangun CRUD berita dan artikel sebagai pola dasar CMS.
3. Terapkan pola CRUD ke pengumuman, agenda, prestasi, dan halaman statis.
4. Bangun Media Library dan pipeline upload tervalidasi.
5. Bangun moderasi alumni, pesan masuk, download, galeri, dan modul akademik.
6. Bangun pengaturan website, menu, pengguna, role, redirect, dan audit log.
7. Tambahkan Turnstile, test authorization/form/upload, backup, dan dokumentasi deployment.

## Batasan data

Seeder development menggunakan data contoh yang harus diganti atau diverifikasi sebelum produksi. Website tidak memiliki SPMB/PPDB dan tidak menyimpan atau menampilkan direktori peserta didik maupun data pribadi sensitif siswa.
