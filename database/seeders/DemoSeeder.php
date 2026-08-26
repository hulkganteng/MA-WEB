<?php

namespace Database\Seeders;

use App\Models\AcademicCalendar;
use App\Models\Achievement;
use App\Models\Album;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Curriculum;
use App\Models\EducationProgram;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\FeaturedProgram;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\StudentOrganization;
use App\Models\Tag;
use App\Models\Teacher;
use App\Models\Video;
use Illuminate\Database\Seeder;



class DemoSeeder extends Seeder
{
    /**
     * Data contoh untuk pengembangan. Hapus dengan `php artisan db:seed --class=DemoSeeder --purge`.
     */
    public function run(): void
    {
        $catBerita = PostCategory::firstOrCreate(['slug' => 'berita'], ['name' => 'Berita']);
        PostCategory::firstOrCreate(['slug' => 'pengumuman'], ['name' => 'Pengumuman']);
        PostCategory::firstOrCreate(['slug' => 'kegiatan'], ['name' => 'Kegiatan']);
        PostCategory::firstOrCreate(['slug' => 'prestasi'], ['name' => 'Prestasi']);
        PostCategory::firstOrCreate(['slug' => 'keagamaan'], ['name' => 'Keagamaan']);
        PostCategory::firstOrCreate(['slug' => 'akademik'], ['name' => 'Akademik']);

        Tag::firstOrCreate(['slug' => 'sekilas-info'], ['name' => 'Sekilas Info']);
        Tag::firstOrCreate(['slug' => 'prestasi'], ['name' => 'Prestasi']);

        $demoPosts = [
            ['title' => 'Kegiatan Peringatan Hari Santri Nasional', 'category' => $catBerita],
            ['title' => 'Pesantren Kilat: Membentuk Karakter Generasi Berakhlak', 'category' => $catBerita],
            ['title' => 'Kunjungan Industri Siswa MA Ma\'arif NU Assa\'adah', 'category' => $catBerita],
        ];

        foreach ($demoPosts as $i => $p) {
            Post::create([
                'type' => 'berita',
                'title' => $p['title'],
                'slug' => \Illuminate\Support\Str::slug($p['title']),
                'post_category_id' => $p['category']->id,
                'author_id' => 1,
                'excerpt' => 'Contoh ringkasan berita untuk keperluan tampilan pengembangan. Data ini bersifat sementara.',
                'body' => '<p>Contoh isi berita. Konten ini dibuat otomatis untuk kebutuhan pengembangan dan dapat dihapus.</p><p>MA Ma\'arif NU Assa\'adah terus berkomitmen menghadirkan pendidikan yang memadukan akademik, karakter, dan keislaman.</p>',
                'status' => 'published',
                'published_at' => now()->subDays($i),
                'views' => rand(20, 200),
            ]);
        }

        $teachers = [
            ['name' => 'Drs. Ahmad Fauzi, M.Pd.', 'subject' => 'Matematika', 'position' => 'Waka Kurikulum'],
            ['name' => 'Siti Aminah, S.Pd.', 'subject' => 'Bahasa Indonesia', 'position' => 'Guru'],
            ['name' => 'Muhammad Rofi, S.Pd.I.', 'subject' => 'Pendidikan Agama Islam', 'position' => 'Guru'],
            ['name' => 'Dewi Lestari, S.Kom.', 'subject' => 'Informatika', 'position' => 'Guru'],
            ['name' => 'H. Abdul Qodir, S.Ag.', 'subject' => 'Al-Qur\'an Hadits', 'position' => 'Guru'],
        ];
        foreach ($teachers as $t) {
            Teacher::create(array_merge($t, ['type' => 'guru', 'slug' => \Illuminate\Support\Str::slug($t['name']), 'is_active' => true, 'is_public' => true]));
        }

        $tendik = ['Sutrisno', 'Mahmudah', 'Imam Safi\'i'];
        foreach ($tendik as $name) {
            Teacher::create(['name' => $name, 'type' => 'tendik', 'slug' => \Illuminate\Support\Str::slug($name), 'position' => 'Staf', 'is_active' => true, 'is_public' => true]);
        }

        Achievement::create([
            'title' => 'Juara 1 Olimpiade Matematika Tingkat Kabupaten',
            'slug' => 'juara-1-olimpiade-matematika',
            'participant' => 'Ananda Rizky Ramadhan',
            'category' => 'Akademik',
            'level' => 'kabupaten',
            'organizer' => 'Kemenag Gresik',
            'rank' => 'Juara 1',
            'achieved_date' => now()->subMonths(2),
            'year' => now()->year,
            'status' => 'published',
        ]);

        $programs = ['Program Tahfidz', 'Program Sains', 'Program Bahasa', 'Program Teknologi'];
        foreach ($programs as $name) {
            EducationProgram::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'description' => 'Deskripsi contoh program '.$name.'.',
                'category' => 'Unggulan',
                'status' => 'active',
            ]);
        }

        FeaturedProgram::create([
            'name' => 'Program Tahfidz',
            'slug' => 'program-tahfidz',
            'description' => 'Pembinaan hafalan Al-Qur\'an terstruktur dengan target tahfidz 1-2 juz.',
            'highlights' => "Bimbingan intensif\nTilawah yang benar\nKelas khusus tahfidz",
            'status' => 'active',
        ]);

        Event::create([
            'title' => 'Peringatan Maulid Nabi Muhammad SAW',
            'slug' => 'peringatan-maulid-nabi',
            'description' => 'Acara peringatan Maulid Nabi beserta kegiatan santunan.',
            'location' => 'Lapangan Madrasah',
            'start_date' => now()->addDays(14)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
            'category' => 'kegiatan',
            'status' => 'published',
        ]);

        Announcement::create([
            'title' => 'Informasi Tahun Ajaran Baru 2026/2027',
            'slug' => 'informasi-tahun-ajaran-baru',
            'body' => 'Contoh pengumuman terkait tahun ajaran baru.',
            'publish_date' => now()->toDateString(),
            'status' => 'published',
            'is_important' => true,
        ]);

        $eks = ['Pramuka', 'Hadrah', 'Futsal', 'Robotik'];
        foreach ($eks as $name) {
            Extracurricular::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'description' => 'Contoh ekstrakurikuler '.$name.'.',
                'status' => 'active',
            ]);
        }

        $facilities = ['Ruang Kelas', 'Laboratorium Komputer', 'Laboratorium IPA', 'Perpustakaan', 'Musholla', 'Lapangan'];
        foreach ($facilities as $name) {
            Facility::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'description' => 'Fasilitas '.$name.' madrasah.',
                'is_active' => true,
            ]);
        }

        Page::create([
            'title' => 'Tentang Madrasah',
            'slug' => 'tentang-madrasah',
            'body' => '<p>Konten contoh untuk pengembangan. MA Ma\'arif NU Assa\'adah merupakan madrasah aliyah yang memadukan pembelajaran akademik, pembentukan akhlak, dan karakter pesantren.</p><h2>Nilai pendidikan</h2><p>Madrasah mendorong peserta didik untuk tumbuh sebagai pribadi yang berilmu, cakap, bertanggung jawab, dan berakhlak mulia.</p>',
            'status' => 'published',
        ]);

        Page::create([
            'title' => 'Visi dan Misi',
            'slug' => 'visi-misi',
            'body' => '<p>Konten visi dan misi ini merupakan data contoh pengembangan dan harus diverifikasi sebelum digunakan sebagai informasi resmi.</p>',
            'status' => 'published',
        ]);

        Curriculum::create([
            'title' => 'Kurikulum Madrasah',
            'slug' => 'kurikulum-madrasah',
            'academic_year' => '2026/2027',
            'description' => 'Contoh informasi kurikulum untuk kebutuhan tampilan pengembangan.',
            'status' => 'active',
        ]);

        AcademicCalendar::create([
            'title' => 'Awal Tahun Ajaran',
            'slug' => 'awal-tahun-ajaran-2026',
            'category' => 'akademik',
            'start_date' => now()->addMonth()->startOfMonth(),
            'description' => 'Contoh agenda kalender akademik.',
            'academic_year' => '2026/2027',
        ]);

        StudentOrganization::create([
            'name' => 'OSIM',
            'slug' => 'osim',
            'description' => 'Contoh profil Organisasi Siswa Intra Madrasah untuk pengembangan.',
            'work_program' => "Kegiatan kepemimpinan\nPengabdian sosial\nPengembangan kreativitas siswa",
            'status' => 'active',
        ]);

        Alumni::create([
            'name' => 'Alumni Contoh',
            'slug' => 'alumni-contoh',
            'graduation_year' => 2022,
            'university' => 'Perguruan Tinggi Contoh',
            'occupation' => 'Mahasiswa',
            'testimonial' => 'Lingkungan madrasah membantu saya membangun kebiasaan belajar dan karakter yang kuat.',
            'status' => 'verified',
            'is_public' => true,
        ]);

        $album = Album::create([
            'name' => 'Kegiatan Masa Ta\'aruf Siswa Madrasah (Matsama)',
            'slug' => 'kegiatan-matsama-2026',
            'description' => 'Dokumentasi kegiatan pengenalan lingkungan dan nilai-nilai madrasah bagi peserta didik baru.',
            'category' => 'Kegiatan',
            'album_date' => now()->subDays(10)->toDateString(),
            'status' => 'published',
        ]);

        Photo::create([
            'album_id' => $album->id,
            'image' => 'gallery/photos/demo-matsama-1.jpg',
            'caption' => 'Apel pembukaan kegiatan Matsama',
            'order' => 1,
        ]);

        Photo::create([
            'album_id' => $album->id,
            'image' => 'gallery/photos/demo-matsama-2.jpg',
            'caption' => 'Sesi keakraban dan orientasi madrasah',
            'order' => 2,
        ]);

        Video::create([
            'title' => 'Profil MA Ma\'arif NU Assa\'adah',
            'slug' => 'profil-ma-maarif-nu-assaadah',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'provider' => 'youtube',
            'category' => 'Profil',
            'description' => 'Mengenal lebih dekat lingkungan belajar, fasilitas, dan keunggulan MA Ma\'arif NU Assa\'adah.',
            'video_date' => now()->subMonth()->toDateString(),
            'status' => 'published',
        ]);

        HeroSlide::create([
            'title' => 'Membangun Generasi Unggul, Berkarakter & Berakhlak Mulia',
            'subtitle' => 'Pendidikan terpadu memadukan keunggulan akademik, pembiasaan akhlak pesantren, dan penguasaan sains teknologi.',
            'tagline' => 'Madrasah Aliyah Berbasis Pesantren di Gresik',
            'image' => 'hero-slides/demo-hero-1.jpg',
            'button_text' => 'Kenali Madrasah',
            'button_url' => '/profil',
            'secondary_button_text' => 'Lihat Program',
            'secondary_button_url' => '/program',
            'order' => 1,
            'status' => 'published',
        ]);

        HeroSlide::create([
            'title' => 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027',
            'subtitle' => 'Mari bergabung bersama keluarga besar MA Ma\'arif NU Assa\'adah. Raih masa depan gemilang dengan bekal ilmu dan adab.',
            'tagline' => 'Pendaftaran Gelombang 1 Dibuka',
            'image' => 'hero-slides/demo-hero-2.jpg',
            'button_text' => 'Daftar Sekarang',
            'button_url' => '/kontak',
            'secondary_button_text' => 'Info Brosur',
            'secondary_button_url' => '/download',
            'order' => 2,
            'status' => 'published',
        ]);

        HeroSlide::create([
            'title' => 'Program Unggulan Tahfidz & Kelas Sains Terintegrasi',
            'subtitle' => 'Membina potensi dan minat siswa melalui kurikulum adaptif, bimbingan intensif, serta ragam ekstrakurikuler berprestasi.',
            'tagline' => 'Prestasi & Karya Siswa',
            'image' => 'hero-slides/demo-hero-3.jpg',
            'button_text' => 'Eksplorasi Program',
            'button_url' => '/program',
            'secondary_button_text' => 'Galeri Foto',
            'secondary_button_url' => '/galeri/foto',
            'order' => 3,
            'status' => 'published',
        ]);
    }
}


