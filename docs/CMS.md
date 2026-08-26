# Menggunakan CMS Admin

CMS admin sekarang terintegrasi dengan website publik. Perubahan pada berita, artikel, halaman, dan pengaturan menggunakan tabel serta model yang sama dengan halaman pengunjung.

## Masuk ke CMS

Buka `/admin/login`, lalu gunakan akun development yang dibuat oleh seeder:

- Email: `admin@ma-assaadah.sch.id`
- Kata sandi awal: `password`

Ganti kata sandi awal melalui nama akun di kanan atas segera setelah login. Jangan gunakan kredensial development ini di production.

## Mengelola berita dan artikel

Menu **Berita** dan **Artikel** menyediakan alur publikasi lengkap.

1. Buka menu Berita atau Artikel.
2. Pilih **Tambah Berita** atau **Tambah Artikel**.
3. Isi judul, ringkasan, isi, kategori, tag, cover, status, dan metadata SEO.
4. Pilih status **Published** dan isi tanggal publikasi agar konten tampil di website.
5. Pilih **Simpan**.

CMS membersihkan HTML sebelum menyimpannya. Upload cover menerima JPG, PNG, atau WebP hingga 3 MB.

## Mengelola profil madrasah

Menu **Profil Madrasah** menyediakan akses langsung ke:

- Tentang Madrasah;
- Sejarah Madrasah;
- Visi dan Misi;
- Sambutan Kepala Madrasah;
- Struktur Organisasi.

Editor tidak perlu mengingat slug. Setiap formulir terhubung langsung dengan halaman publik yang sesuai. Sambutan mengelola nama, jabatan, foto, dan isi sambutan. Struktur organisasi mendukung pimpinan tingkat utama, anggota bawahan, urutan tampil, foto, serta status tampil/sembunyi.

## Mengelola halaman lain

Menu **Halaman** tetap tersedia untuk konten statis di luar alur profil khusus.

Slug tertentu digunakan oleh halaman profil:

| Halaman publik | Slug CMS |
|---|---|
| Tentang madrasah | `tentang-madrasah` |
| Sejarah | `sejarah` |
| Visi dan misi | `visi-misi` |

Gunakan status **Published** agar halaman dapat dibuka pengunjung.

## Mengelola guru dan tenaga kependidikan

Menu **Guru & Tendik** mengelola direktori sumber daya manusia yang tampil di website publik.

1. Pilih **Tambah data**.
2. Tentukan jenis Guru atau Tenaga Kependidikan.
3. Isi nama, jabatan, mata pelajaran bila relevan, pendidikan terakhir, foto, dan urutan tampil.
4. Aktifkan **Status aktif** dan **Tampilkan di direktori publik** agar data muncul di website.
5. Pilih **Simpan data**.

Daftar dapat dicari dan difilter berdasarkan jenis serta status. Data yang dihapus masuk ke filter **Sampah** dan dapat dipulihkan. CMS tidak meminta alamat, nomor pribadi, atau data sensitif lainnya.

## Mengubah pengaturan website

Menu **Pengaturan website** mengubah identitas dan konten global secara langsung.

Pengaturan mencakup:

- nama, tagline, logo, favicon, dan tahun akademik;
- alamat, email, telepon, WhatsApp, Google Maps, dan jam pelayanan;
- judul dan subjudul hero;
- nama, jabatan, foto, dan sambutan kepala madrasah;
- default SEO title dan description;
- pesan WhatsApp default.

## Role dan permission

Semua route CMS dilindungi autentikasi dan permission Spatie. Seeder menyediakan role Super Administrator, Administrator, Humas/Editor, Operator Akademik, dan Operator Kesiswaan.

Controller memeriksa permission berdasarkan jenis konten. Pengguna dengan permission artikel tidak otomatis dapat membuat berita.

## Audit aktivitas

CMS mencatat login, logout, pembuatan, pembaruan, penghapusan, perubahan akun, dan perubahan pengaturan ke `activity_logs`. Dashboard menampilkan aktivitas terbaru tanpa menyimpan password, token, atau session credential.

## Cakupan saat ini

CMS operasional saat ini mencakup Dashboard, Berita, Artikel, Profil Madrasah, Guru & Tendik, Halaman, Pengaturan Website, dan Akun Saya. CRUD untuk Pengumuman, Agenda, Prestasi, Akademik lainnya, Galeri, Alumni, Download, Menu, Pengguna, Role, Redirect, serta Media Library tetap berada pada tahap berikutnya.
