<?php

namespace Database\Seeders;

use App\Models\AcademicCalendar;
use App\Models\Achievement;
use App\Models\Album;
use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Curriculum;
use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\EducationProgram;
use App\Models\Event;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\FeaturedProgram;
use App\Models\HeroSlide;
use App\Models\OrganizationMember;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SocialLink;
use App\Models\StudentOrganization;
use App\Models\Tag;
use App\Models\Teacher;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;



class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Social Links
        $socials = [
            ['platform' => 'youtube', 'url' => 'https://www.youtube.com/@mamaarifnuassaadah', 'is_active' => true],
            ['platform' => 'instagram', 'url' => 'https://www.instagram.com/ma_assaadah', 'is_active' => true],
            ['platform' => 'facebook', 'url' => 'https://www.facebook.com/mamaarifnuassaadah', 'is_active' => true],
            ['platform' => 'tiktok', 'url' => 'https://www.tiktok.com/@ma_assaadah', 'is_active' => true],
        ];
        foreach ($socials as $soc) {
            SocialLink::updateOrCreate(['platform' => $soc['platform']], $soc);
        }

        // 2. Categories and Tags
        $catBerita = PostCategory::firstOrCreate(['slug' => 'berita'], ['name' => 'Berita']);
        $catPengumuman = PostCategory::firstOrCreate(['slug' => 'pengumuman'], ['name' => 'Pengumuman']);
        $catKegiatan = PostCategory::firstOrCreate(['slug' => 'kegiatan'], ['name' => 'Kegiatan']);
        $catPrestasi = PostCategory::firstOrCreate(['slug' => 'prestasi'], ['name' => 'Prestasi']);
        $catKeagamaan = PostCategory::firstOrCreate(['slug' => 'keagamaan'], ['name' => 'Keagamaan & Pesantren']);
        $catAkademik = PostCategory::firstOrCreate(['slug' => 'akademik'], ['name' => 'Akademik & Riset']);

        $tagHariSantri = Tag::firstOrCreate(['slug' => 'hari-santri'], ['name' => 'Hari Santri']);
        $tagPrestasi = Tag::firstOrCreate(['slug' => 'prestasi'], ['name' => 'Prestasi']);
        $tagQomaruddin = Tag::firstOrCreate(['slug' => 'pesantren-qomaruddin'], ['name' => 'Pesantren Qomaruddin']);
        $tagKSM = Tag::firstOrCreate(['slug' => 'ksm'], ['name' => 'KSM Kemenag']);
        $tagTahfidz = Tag::firstOrCreate(['slug' => 'tahfidz'], ['name' => 'Tahfidz Qur\'an']);
        $tagSpmb = Tag::firstOrCreate(['slug' => 'spmb-2026'], ['name' => 'SPMB 2026']);
        $tagRobotika = Tag::firstOrCreate(['slug' => 'robotika'], ['name' => 'Robotika']);

        // 3. Posts (Berita & Artikel)
        $postsData = [
            [
                'type' => 'berita',
                'title' => 'Peringatan Hari Santri Nasional & Haflah Qomaruddin: Mengukuhkan Spirit Aswaja dan Kemandirian Santri',
                'category' => $catKeagamaan,
                'excerpt' => 'Keluarga besar MA Ma\'arif NU Assa\'adah Bungah Gresik menggelar apel akbar dan serangkaian perlombaan dalam memperingati Hari Santri Nasional bersama Pondok Pesantren Qomaruddin.',
                'body' => '<p><strong>Gresik, MA Assa\'adah</strong> — Ribuan santri dan peserta didik dari seluruh penjuru Pondok Pesantren Qomaruddin dan MA Ma\'arif NU Assa\'adah Bungah memadati halaman madrasah untuk mengikuti Apel Akbar Hari Santri Nasional. Mengusung semangat jihad santri untuk kemajuan negeri, acara ini menjadi momentum refleksi atas kontribusi besar ulama dan santri dalam menjaga kemerdekaan Negara Kesatuan Republik Indonesia.</p>'
                    . '<p>Kepala Madrasah, <strong>Mohammad Isma\'il Cholilur Rohman, M.Pd.</strong>, dalam amanatnya menegaskan bahwa santri MA Ma\'arif NU Assa\'adah harus menjadi pelopor generasi cendekia yang berkarakter kuat, berwawasan global, namun tetap berpegang teguh pada amaliyah Ahlussunnah wal Jama\'ah An-Nahdliyyah.</p>'
                    . '<blockquote>"Santri masa kini bukan hanya mengaji kitab kuning di bilik pesantren, tapi juga mampu meretas batas teknologi, sains, dan diplomasi internasional tanpa kehilangan adab dan akhlakul karimah," tutur beliau disambut gema takbir para santri.</blockquote>'
                    . '<p>Rangkaian peringatan dilanjutkan dengan musabaqah qira\'atul kutub, festival hadrah Al-Banjari, parade busana santri nusantara, dan pameran inovasi karya riset madrasah santri MA Ma\'arif NU Assa\'adah.</p>',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'views' => 482,
            ],
            [
                'type' => 'berita',
                'title' => 'Siswa MA Ma\'arif NU Assa\'adah Raih Medali Emas Kompetisi Sains Madrasah (KSM) Tingkat Provinsi Jawa Timur',
                'category' => $catPrestasi,
                'excerpt' => 'Prestasi membanggakan kembali diukir oleh kontingen MA Ma\'arif NU Assa\'adah pada KSM Matematika dan Biologi Terintegrasi se-Jawa Timur.',
                'body' => '<p><strong>Surabaya</strong> — Prestasi gemilang kembali dipersembahkan oleh duta sains MA Ma\'arif NU Assa\'adah Bungah Gresik. Dalam ajang bergengsi Kompetisi Sains Madrasah (KSM) tingkat Provinsi Jawa Timur yang diselenggarakan oleh Kanwil Kemenag Jawa Timur, siswa MA Assa\'adah berhasil memboyong medali emas untuk cabang Matematika Terintegrasi dan medali perak untuk Biologi Terintegrasi.</p>'
                    . '<p>Keberhasilan ini merupakan buah dari program bimbingan intensif <em>Madrasah Riset & Sains Olympiad Club</em> yang secara konsisten membekali santri dengan penguasaan konsep sains mutakhir yang dipadukan dengan pemahaman ayat-ayat kauniyah dan khazanah Islam klasik.</p>'
                    . '<p>Koordinator Tim Riset Madrasah, <strong>Dewi Lestari, S.Kom., M.T.</strong>, menyampaikan rasa syukur dan kebanggaannya: "Kami melatih mereka tidak hanya memecahkan soal analitis tingkat tinggi, namun juga membangun mentalitas juara santri yang tawadhu\' dan pantang menyerah. Target kami berikutnya adalah melaju ke ajang KSM Nasional."',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
                'views' => 365,
            ],
            [
                'type' => 'berita',
                'title' => 'Program Bilingual Immersion: Membentuk Generasi Santri Cakap Bahasa Arab dan Inggris Berwawasan Global',
                'category' => $catAkademik,
                'excerpt' => 'MA Ma\'arif NU Assa\'adah mengintensifkan program pembiasaan bahasa asing (Arabic & English Club) dengan mendatangkan native speaker dan menggelar English Camp.',
                'body' => '<p><strong>Bungah, Gresik</strong> — Sebagai madrasah unggulan yang bertekad mengantarkan alumninya menembus universitas terkemuka dunia seperti Universitas Al-Azhar Kairo, Timur Tengah, dan kampus ternama dalam maupun luar negeri, MA Ma\'arif NU Assa\'adah menggelar agenda tahunan <em>Language Immersion Week</em>.</p>'
                    . '<p>Program ini mengharuskan seluruh santri berkomunikasi dalam bahasa Arab dan Inggris di lingkungan asrama dan kelas selama 24 jam penuh. Kegiatan diisi dengan debat ilmiah berbahasa Arab (munadzarah), khitobah 3 bahasa, story telling, hingga workshop penulisan esai akademik.</p>'
                    . '<p>Wakil Kepala Bidang Kurikulum, <strong>Drs. H. Ahmad Fauzi, M.Pd.</strong>, menyatakan bahwa penguasaan bahasa internasional adalah kunci utama agar santri dapat menyebarkan risalah Islam rahmatan lil \'alamin ke kancah global secara bermartabat.</p>',
                'is_featured' => false,
                'published_at' => now()->subDays(8),
                'views' => 290,
            ],
            [
                'type' => 'berita',
                'title' => 'Wisuda Tahfidzul Qur\'an Angkatan IX: 25 Santri Khatamkan Hafalan Al-Qur\'an Bersanad',
                'category' => $catKeagamaan,
                'excerpt' => 'Suasana haru dan khidmat menyelimuti prosesi Wisuda Tahfidzul Qur\'an MA Ma\'arif NU Assa\'adah yang bersinergi dengan Pondok Pesantren Qomaruddin.',
                'body' => '<p><strong>Gresik</strong> — Sebanyak 25 santri MA Ma\'arif NU Assa\'adah secara resmi diwisuda setelah menuntaskan setoran hafalan Al-Qur\'an, mulai dari program juz 30 hingga kategori 30 juz bil ghoib bersanad. Prosesi wisuda disaksikan oleh para Masyayikh Pondok Pesantren Qomaruddin, dewan asatidz, dan wali santri.</p>'
                    . '<p>Dalam kesempatan tersebut, para wisudawan diuji secara acak oleh para ulama penguji (imtihan khash) melalui sambung ayat dan pertanyaan hukum tajwid. Seluruh santri mampu menjawab dengan tartil, fasih, dan mutqin.</p>'
                    . '<p>Madrasah memberikan apresiasi berupa beasiswa penuh pendidikan lanjutan serta piagam penghargaan syahadah tahfidz kepada para wisudawan terbaik.</p>',
                'is_featured' => false,
                'published_at' => now()->subDays(14),
                'views' => 415,
            ],
            [
                'type' => 'artikel',
                'title' => 'Mengintegrasikan Turats Pesantren dan Kecerdasan Buatan (AI) di Madrasah Modern',
                'category' => $catAkademik,
                'excerpt' => 'Opini dan telaah ilmiah mengenai bagaimana santri MA Ma\'arif NU Assa\'adah merespons kemajuan teknologi AI dengan pondasi etika kitab kuning.',
                'body' => '<p>Perkembangan pesat teknologi digital dan kecerdasan buatan (Artificial Intelligence) kerap dipandang sebagai pisau bermata dua di dunia pendidikan. Namun di MA Ma\'arif NU Assa\'adah, transformasi digital bukan untuk dihindari, melainkan diserap dan diarahkan oleh nilai-nilai luhur turats pesantren.</p>'
                    . '<p>Dalam kitab <em>Ta\'limul Muta\'allim</em> karya Syekh Az-Zarnuji, ditekankan bahwa kemuliaan ilmu terletak pada niat yang suci untuk menghidupkan agama dan menolak kebodohan. Ketika santri dibekali kemampuan coding, literasi data, dan AI prompting, adab dan etika santri menjadi filter moral yang memastikan teknologi dimanfaatkan untuk kemaslahatan umat manusia (mashlahah \'ammah).</p>'
                    . '<p>Integrasi kurikulum inilah yang melahirkan profil lulusan MA Ma\'arif NU Assa\'adah yang berakhlak mulia, cakap berinovasi, dan cendekia dalam berpikir.</p>',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
                'views' => 230,
            ],
            [
                'type' => 'artikel',
                'title' => 'Tradisi Sanad dan Keberkahan Belajar: Warisan Luhur Pondok Pesantren Qomaruddin',
                'category' => $catKeagamaan,
                'excerpt' => 'Mengenal esensi sanad keilmuan para masyayikh Sampurnan Bungah yang menjadi ruh utama pembelajaran di MA Ma\'arif NU Assa\'adah.',
                'body' => '<p>Sanad keilmuan adalah identitas tak terpisahkan dari tradisi pesantren Nahdlatul Ulama. Di MA Ma\'arif NU Assa\'adah, setiap kitab turats yang dipelajari memiliki silsilah guru yang bersambung langsung hingga pengarang kitab dan bermuara kepada Baginda Rasulullah SAW.</p>'
                    . '<p>K.H. Qomaruddin, ulama kharismatik yang mendirikan pesantren pada abad ke-18 di Sampurnan Bungah, mewariskan keteladanan cinta ilmu dan keteguhan ibadah. Menghormati guru (ta\'dzim lil ustadz), istiqomah dalam mudzakarah, serta mengamalkan ilmu dalam kesederhanaan adalah pondasi yang terus ditanamkan kepada setiap peserta didik madrasah.</p>',
                'is_featured' => false,
                'published_at' => now()->subDays(18),
                'views' => 310,
            ],
        ];

        foreach ($postsData as $p) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'type' => $p['type'],
                    'title' => $p['title'],
                    'post_category_id' => $p['category']->id,
                    'author_id' => 1,
                    'excerpt' => $p['excerpt'],
                    'body' => $p['body'],
                    'status' => 'published',
                    'is_featured' => $p['is_featured'],
                    'published_at' => $p['published_at'],
                    'views' => $p['views'],
                    'seo_title' => $p['title'] . ' | MA Ma\'arif NU Assa\'adah',
                    'seo_description' => $p['excerpt'],
                ]
            );
            $post->tags()->syncWithoutDetaching([$tagHariSantri->id, $tagQomaruddin->id]);
        }

        // 4. Announcements
        $announcementsData = [
            [
                'title' => 'Penerimaan Santri & Peserta Didik Baru (SPMB) Tahun Ajaran 2026/2027 Gelombang 1',
                'slug' => 'spmb-tahun-ajaran-2026-2027-gelombang-1',
                'body' => '<p>MA Ma\'arif NU Assa\'adah Bungah Gresik secara resmi membuka Pendaftaran Santri dan Peserta Didik Baru (SPMB) Tahun Ajaran 2026/2027 untuk seluruh program unggulan (MIPA Riset, IPS Entrepreneur, Keagamaan Turats, dan Tahfidzul Qur\'an).</p>'
                    . '<h3>Jadwal Penting Gelombang 1:</h3>'
                    . '<ul><li>Pendaftaran Online & Offline: 1 Januari - 31 Maret 2026</li><li>Tes Seleksi & Wawancara Pemetaan: 5 April 2026</li><li>Pengumuman Hasil Seleksi: 10 April 2026</li><li>Daftar Ulang: 11 - 20 April 2026</li></ul>'
                    . '<p>Tersedia beasiswa santri berprestasi akademik, non-akademik, dan beasiswa tahfidz Al-Qur\'an minimal 3 juz. Pendaftaran dapat dilakukan secara online melalui website ini atau hadir langsung di Sekretariat SPMB Gedung MA Ma\'arif NU Assa\'adah Jl. Raya Bungah No. 01 Gresik.</p>',
                'publish_date' => now()->subDays(3),
                'is_important' => true,
            ],
            [
                'title' => 'Sosialisasi Kalender Akademik dan Pengajian Kitab Pasaran Ramadhan 1447 H',
                'slug' => 'sosialisasi-kalender-akademik-kitab-pasaran-ramadhan',
                'body' => '<p>Diberitahukan kepada seluruh wali murid dan santri MA Ma\'arif NU Assa\'adah bahwa rangkaian kegiatan pembelajaran bulan Ramadhan akan diisi dengan kajian kitab kuning pasaran bersama para Masyayikh Pondok Pesantren Qomaruddin. Kitab yang dikaji meliputi Fathul Qorib Al-Mujib, Bidayatul Hidayah, dan Arbain An-Nawawiyyah.</p>',
                'publish_date' => now()->subDays(7),
                'is_important' => false,
            ],
            [
                'title' => 'Petunjuk Teknis Asesmen Bakat Minat (ABM) dan Tryout UTBK SNBT Siswa Kelas XII',
                'slug' => 'juknis-abm-tryout-utbk-snbt-kelas-xii',
                'body' => '<p>Dalam rangka mempersiapkan santri kelas XII menghadapi seleksi masuk Perguruan Tinggi Negeri (PTN) favorit dan beasiswa luar negeri, madrasah menyelenggarakan Tryout UTBK berskala nasional bekerja sama dengan lembaga asesmen terakreditasi.</p>',
                'publish_date' => now()->subDays(12),
                'is_important' => false,
            ],
        ];

        foreach ($announcementsData as $a) {
            Announcement::updateOrCreate(
                ['slug' => $a['slug']],
                [
                    'title' => $a['title'],
                    'body' => $a['body'],
                    'publish_date' => $a['publish_date'],
                    'status' => 'published',
                    'is_important' => $a['is_important'],
                    'author_id' => 1,
                ]
            );
        }

        // 5. Events / Agenda
        $eventsData = [
            [
                'title' => 'Haflah Akhirussanah & Wisuda Purnasiswa MA Assa\'adah 2026',
                'slug' => 'haflah-akhirussanah-wisuda-purnasiswa-2026',
                'description' => 'Prosesi pelepasan santri kelas XII MA Ma\'arif NU Assa\'adah dan wisuda tahfidz Al-Qur\'an bersama Yayasan Pondok Pesantren Qomaruddin.',
                'location' => 'Graha Utama Pesantren Qomaruddin Bungah',
                'start_date' => now()->addDays(20)->toDateString(),
                'end_date' => now()->addDays(20)->toDateString(),
                'category' => 'kegiatan',
            ],
            [
                'title' => 'Kemah Bhakti Santri & Pelantikan Pramuka Penegak Bantara',
                'slug' => 'kemah-bhakti-santri-pramuka-penegak-bantara',
                'description' => 'Kegiatan kepramukaan Gugus Depan KH. Qomaruddin dalam rangka penguatan kedisiplinan, kepemimpinan, dan kepedulian lingkungan.',
                'location' => 'Bumi Perkemahan Wonosalam / Area Terbuka Bungah',
                'start_date' => now()->addDays(35)->toDateString(),
                'end_date' => now()->addDays(37)->toDateString(),
                'category' => 'kegiatan',
            ],
            [
                'title' => 'Simulasi Asesmen Sumatif Akhir Tahun (ASAT) Berbasis CBT',
                'slug' => 'simulasi-asat-cbt-genap',
                'description' => 'Uji coba sistem ujian berbasis komputer (Computer Based Test) untuk seluruh peserta didik jenjang kelas X dan XI.',
                'location' => 'Laboratorium Komputer Madrasah',
                'start_date' => now()->addDays(14)->toDateString(),
                'end_date' => now()->addDays(16)->toDateString(),
                'category' => 'ujian',
            ],
            [
                'title' => 'Seminar Parenting & Sinergi Madrasah bersama Wali Santri',
                'slug' => 'seminar-parenting-sinergi-madrasah',
                'description' => 'Forum silaturahmi komite madrasah dan pemaparan evaluasi perkembangan belajar santri semester genap.',
                'location' => 'Aula Pertemuan MA Ma\'arif NU Assa\'adah',
                'start_date' => now()->addDays(28)->toDateString(),
                'end_date' => now()->addDays(28)->toDateString(),
                'category' => 'akademik',
            ],
        ];

        foreach ($eventsData as $ev) {
            Event::updateOrCreate(
                ['slug' => $ev['slug']],
                array_merge($ev, ['status' => 'published', 'author_id' => 1])
            );
        }

        // 6. Pages (Tentang, Sejarah, Visi-Misi)
        Page::updateOrCreate(
            ['slug' => 'tentang-madrasah'],
            [
                'title' => 'Tentang MA Ma\'arif NU Assa\'adah',
                'body' => '<p><strong>MA Ma\'arif NU Assa\'adah (MAMNU Assa\'adah)</strong> adalah madrasah aliyah swasta terakreditasi <strong>A (Unggul)</strong> di bawah naungan <strong>Yayasan Pondok Pesantren Qomaruddin (YPPQ)</strong>, berlokasi di Jl. Raya Bungah No. 01, Bungah, Kabupaten Gresik, Jawa Timur.</p>'
                    . '<p>Didirikan pada tahun <strong>1972</strong>, madrasah ini telah menapaki perjalanan pengabdian lebih dari 5 dekade (50 tahun lebih) sebagai kawah candradimuka bagi ribuan santri dari berbagai penjuru tanah air. MA Ma\'arif NU Assa\'adah memadukan kurikulum nasional (Kementerian Agama & Kemendikbudristek) dengan kurikulum pesantren salaf-modern khas Pondok Pesantren Qomaruddin yang didirikan sejak tahun 1775 M.</p>'
                    . '<h2>Nilai Dasar Pendidikan Madrasah</h2>'
                    . '<ul>'
                    . '<li><strong>Berkarakter Pesantren:</strong> Menanamkan nilai-nilai Aswaja An-Nahdliyyah, ketawadhu\'an, adab santri, kemandirian, dan cinta tanah air.</li>'
                    . '<li><strong>Cakap & Terampil:</strong> Membekali santri dengan kecakapan abad ke-21: kemampuan bilingual (Arab-Inggris), sains terapan, robotika, literasi digital, dan life skills.</li>'
                    . '<li><strong>Cendekia:</strong> Menumbuhkan budaya literasi, riset, logika kritis, serta penguasaan mendalam atas literatur turats (kitab kuning) dan ilmu pengetahuan modern.</li>'
                    . '<li><strong>Berakhlakul Karimah:</strong> Menjadikan kemuliaan akhlak sebagai muara dari seluruh capaian intelektual dan spiritual.</li>'
                    . '</ul>'
                    . '<h2>Peminatan & Jalur Pembelajaran</h2>'
                    . '<p>Madrasah menyelenggarakan beragam peminatan sesuai dengan bakat dan aspirasi masa depan santri, meliputi Peminatan MIPA (Sains & Riset), Peminatan IPS (Sosial & Kewirausahaan), Program Keagamaan (Kajian Kitab Kuning & Ushuluddin), serta Program Khusus Tahfidzul Qur\'an 30 Juz.</p>',
                'status' => 'published',
                'seo_title' => 'Profil & Identitas | MA Ma\'arif NU Assa\'adah Bungah Gresik',
                'seo_description' => 'Mengenal profil, sejarah, dan nilai pendidikan MA Ma\'arif NU Assa\'adah Bungah Gresik, madrasah aliyah unggulan berkarakter pesantren.',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'sejarah'],
            [
                'title' => 'Sejarah Perjalanan Madrasah',
                'body' => '<p>Akar historis <strong>MA Ma\'arif NU Assa\'adah</strong> berpijak kokoh pada sejarah emas <strong>Pondok Pesantren Qomaruddin</strong>, salah satu pesantren tertua dan paling bersejarah di Nusantara yang didirikan oleh <strong>K.H. Qomaruddin</strong> pada tahun <strong>1775 M</strong> di Desa Sampurnan, Kecamatan Bungah, Kabupaten Gresik.</p>'
                    . '<h2>Kelahiran Lembaga Pendidikan Formal (1972)</h2>'
                    . '<p>Seiring dinamika peradaban dan kebutuhan umat akan adanya jenjang pendidikan formal setingkat sekolah menengah atas yang berbobot ilmu agama sekaligus mampu bersaing dalam kancah ilmu umum, para Masyayikh dan Pengurus Yayasan Pondok Pesantren Qomaruddin memprakarsai berdirinya <strong>Madrasah Aliyah Ma\'arif NU Assa\'adah pada tahun 1972</strong>.</p>'
                    . '<p>Nama <em>Assa\'adah</em> (kebahagiaan) disematkan sebagai doa dan harapan agung agar madrasah ini mampu menghantarkan para pencari ilmu menuju kebahagiaan sejati di dunia maupun di akhirat kelak (sa\'adatad-darain).</p>'
                    . '<h2>Tonggak Perkembangan & Transformasi Modern</h2>'
                    . '<p>Dalam rentang perjalanan lebih dari setengah abad, MA Ma\'arif NU Assa\'adah terus bertransformasi:</p>'
                    . '<ul>'
                    . '<li><strong>Era Perintisan (1972 - 1985):</strong> Pemantapan fondasi kurikulum madrasah terintegrasi dengan pengajian sorogan dan bandongan kitab pesantren.</li>'
                    . '<li><strong>Era Pengembangan Akademik (1986 - 2005):</strong> Perluasan gedung madrasah, pendirian laboratorium komputer dan IPA, serta diraihnya status Akreditasi A dari Badan Akreditasi Nasional.</li>'
                    . '<li><strong>Era Penguatan Prestasi & Riset (2006 - 2020):</strong> Lahirnya wadah pembinaan olimpiade sains (KSM), klub debat bahasa Arab dan Inggris, serta penguatan hafalan tahfidz Al-Qur\'an.</li>'
                    . '<li><strong>Era Digital & Modernisasi (2021 - Sekarang):</strong> Implementasi Kurikulum Merdeka, transformasi smart classroom, madrasah ramah digital, dan sinergi jejaring ribuan alumni melalui wadah <strong>IKBAL MADAH</strong>.</li>'
                    . '</ul>',
                'status' => 'published',
                'seo_title' => 'Sejarah MA Ma\'arif NU Assa\'adah Bungah Gresik',
                'seo_description' => 'Sejarah berdirinya MA Ma\'arif NU Assa\'adah sejak 1972 di bawah naungan Pondok Pesantren Qomaruddin Bungah Gresik.',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'visi-misi'],
            [
                'title' => 'Visi, Misi, dan Tujuan Pendidikan',
                'body' => '<h2>Visi Madrasah</h2>'
                    . '<blockquote><p><strong>"Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren"</strong></p></blockquote>'
                    . '<p><em>(Secara resmi tertuang dalam slogan madrasah: Berakhlak, Cendekia, dan Cakap).</em></p>'
                    . '<h2>Indikator Visi</h2>'
                    . '<ol>'
                    . '<li><strong>Berkepribadian menarik dan terpuji:</strong> Menampilkan perilaku santun, tawadhu\', jujur, dan berakhlakul karimah dalam kehidupan madrasah, pesantren, maupun bermasyarakat.</li>'
                    . '<li><strong>Berprestasi secara akademik dan non-akademik:</strong> Mampu bersaing dalam olimpiade sains, kajian keislaman, riset, seni hadrah, maupun olahraga prestasi.</li>'
                    . '<li><strong>Berjiwa Aswaja An-Nahdliyyah:</strong> Memegang teguh prinsip <em>Tawassuth</em> (moderat), <em>Tawazun</em> (seimbang), <em>I\'tidal</em> (tegak adil), dan <em>Tasamuh</em> (toleran).</li>'
                    . '<li><strong>Cakap & Melek Teknologi:</strong> Menguasai teknologi informasi serta mampu memanfaatkannya secara kreatif, bijak, dan produktif.</li>'
                    . '</ol>'
                    . '<h2>Misi Madrasah</h2>'
                    . '<ol>'
                    . '<li>Menyelenggarakan tata kelola pembelajaran terpadu antara kurikulum nasional dan kurikulum pesantren turats salaf.</li>'
                    . '<li>Membina pembiasaan akhlakul karimah dan ibadah harian berlandaskan syariat Islam Ahlussunnah wal Jama\'ah.</li>'
                    . '<li>Mengembangkan potensi minat, bakat, dan kreativitas santri melalui kegiatan riset ilmiah, robotika, dan ekstrakurikuler komprehensif.</li>'
                    . '<li>Mewujudkan lingkungan belajar yang berbasis literasi digital, bilingual, dan ramah santri.</li>'
                    . '<li>Menyiapkan lulusan berkualitas tinggi yang siap melanjutkan ke perguruan tinggi favorit dalam maupun luar negeri serta berkontribusi nyata di masyarakat.</li>'
                    . '</ol>',
                'status' => 'published',
                'seo_title' => 'Visi dan Misi | MA Ma\'arif NU Assa\'adah',
                'seo_description' => 'Visi, misi, dan nilai-nilai luhur pendidikan di MA Ma\'arif NU Assa\'adah Bungah Gresik.',
            ]
        );

        // 7. Teachers and Tendik
        $teachersList = [
            ['name' => 'Mohammad Isma\'il Cholilur Rohman, M.Pd.', 'type' => 'guru', 'position' => 'Kepala Madrasah', 'subject' => 'Manajemen Pendidikan & Fiqih', 'education' => 'S2 Manajemen Pendidikan Islam'],
            ['name' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'type' => 'guru', 'position' => 'Waka Kurikulum', 'subject' => 'Matematika', 'education' => 'S2 Pendidikan Matematika'],
            ['name' => 'M. Zainal Fanani, S.Pd.I.', 'type' => 'guru', 'position' => 'Waka Kesiswaan', 'subject' => 'Sejarah Kebudayaan Islam (SKI)', 'education' => 'S1 Pendidikan Agama Islam'],
            ['name' => 'H. Abdul Qodir, S.Ag., M.Pd.I.', 'type' => 'guru', 'position' => 'Waka Sarana Prasarana', 'subject' => 'Al-Qur\'an Hadits', 'education' => 'S2 Pendidikan Islam'],
            ['name' => 'Siti Aminah, S.Pd., M.A.', 'type' => 'guru', 'position' => 'Waka Humas', 'subject' => 'Bahasa Indonesia', 'education' => 'S2 Linguistik Terapan'],
            ['name' => 'Ustadz Muhammad Rofi, S.Pd.I., M.Ag.', 'type' => 'guru', 'position' => 'Koordinator Tahfidz & Keagamaan', 'subject' => 'Ushul Fiqih & Tafsir', 'education' => 'S2 Studi Islam & Sanad Tahfidz'],
            ['name' => 'Dewi Lestari, S.Kom., M.T.', 'type' => 'guru', 'position' => 'Koordinator Riset & IT', 'subject' => 'Informatika & Robotika', 'education' => 'S2 Teknik Elektro/Informatika'],
            ['name' => 'Ahmad Zubaidi, S.Pd.I.', 'type' => 'guru', 'position' => 'Guru', 'subject' => 'Bahasa Arab & Nahwu Shorof', 'education' => 'S1 Pendidikan Bahasa Arab'],
            ['name' => 'Fitriyah Rahmawati, M.Sc.', 'type' => 'guru', 'position' => 'Guru', 'subject' => 'Kimia & Biologi', 'education' => 'S2 Ilmu Kimia'],
            ['name' => 'Irfan Syauqi, M.Pd.', 'type' => 'guru', 'position' => 'Guru', 'subject' => 'Bahasa Inggris', 'education' => 'S2 Pendidikan Bahasa Inggris'],
            ['name' => 'Nur Laili Rohmatin, S.Psi.', 'type' => 'guru', 'position' => 'Koordinator BP/BK', 'subject' => 'Bimbingan Konseling', 'education' => 'S1 Psikologi Pendidikan'],
            ['name' => 'K.H. Lukman Hakim, Lc.', 'type' => 'guru', 'position' => 'Guru Pembina Turats', 'subject' => 'Kajian Kitab Kuning', 'education' => 'S1 Syariah Al-Azhar Kairo'],
            ['name' => 'Sutrisno, S.E.', 'type' => 'tendik', 'position' => 'Kepala Tata Usaha', 'subject' => null, 'education' => 'S1 Ekonomi Manajemen'],
            ['name' => 'Mahmudah, A.Md.', 'type' => 'tendik', 'position' => 'Staf Keuangan & Administrasi', 'subject' => null, 'education' => 'D3 Administrasi'],
            ['name' => 'Imam Safi\'i', 'type' => 'tendik', 'position' => 'Staf Laboratorium & IT Support', 'subject' => null, 'education' => 'D3 Teknik Komputer'],
            ['name' => 'Ahmad Sholihin', 'type' => 'tendik', 'position' => 'Staf Perpustakaan & Kearsipan', 'subject' => null, 'education' => 'S1 Ilmu Perpustakaan'],
        ];

        foreach ($teachersList as $i => $t) {
            Teacher::updateOrCreate(
                ['slug' => Str::slug($t['name'])],
                array_merge($t, [
                    'order' => $i + 1,
                    'is_active' => true,
                    'is_public' => true,
                    'bio' => 'Pendidik dan tenaga kependidikan profesional di MA Ma\'arif NU Assa\'adah Bungah Gresik.',
                ])
            );
        }

        // 8. Organization Members (Hierarchical Structure)
        $parentLeader = OrganizationMember::updateOrCreate(
            ['name' => 'Mohammad Isma\'il Cholilur Rohman, M.Pd.'],
            [
                'position' => 'Kepala Madrasah',
                'parent_id' => null,
                'order' => 1,
                'is_active' => true,
            ]
        );

        $subordinates = [
            ['name' => 'Drs. H. Ahmad Fauzi, M.Pd.', 'position' => 'Wakil Kepala Bidang Kurikulum', 'order' => 1],
            ['name' => 'M. Zainal Fanani, S.Pd.I.', 'position' => 'Wakil Kepala Bidang Kesiswaan', 'order' => 2],
            ['name' => 'H. Abdul Qodir, S.Ag., M.Pd.I.', 'position' => 'Wakil Kepala Bidang Sarana & Prasarana', 'order' => 3],
            ['name' => 'Siti Aminah, S.Pd., M.A.', 'position' => 'Wakil Kepala Bidang Hubungan Masyarakat', 'order' => 4],
            ['name' => 'Sutrisno, S.E.', 'position' => 'Kepala Tata Usaha', 'order' => 5],
            ['name' => 'Ustadz Muhammad Rofi, S.Pd.I.', 'position' => 'Koordinator Bidang Keagamaan & Tahfidz', 'order' => 6],
            ['name' => 'Dewi Lestari, S.Kom., M.T.', 'position' => 'Koordinator Laboratorium & Riset', 'order' => 7],
            ['name' => 'Nur Laili Rohmatin, S.Psi.', 'position' => 'Koordinator Bimbingan & Konseling', 'order' => 8],
        ];

        foreach ($subordinates as $sub) {
            OrganizationMember::updateOrCreate(
                ['name' => $sub['name']],
                array_merge($sub, [
                    'parent_id' => $parentLeader->id,
                    'is_active' => true,
                ])
            );
        }

        // 9. Achievements
        $achievementsData = [
            [
                'title' => 'Juara 1 KSM Matematika Terintegrasi Tingkat Provinsi Jawa Timur',
                'participant' => 'Muhammad Naufal Al-Faruq (Kelas XI MIPA)',
                'category' => 'Akademik Sains',
                'level' => 'provinsi',
                'organizer' => 'Kanwil Kemenag Jawa Timur',
                'rank' => 'Juara 1 (Medali Emas)',
                'year' => 2025,
            ],
            [
                'title' => 'Medali Emas Madrasah Young Researchers Supercamp (MYRES) Bidang Saintek',
                'participant' => 'Tim Riset MA Assa\'adah (Aisyah Putri & Fatimatuz Zahro)',
                'category' => 'Riset & Sains Terapan',
                'level' => 'nasional',
                'organizer' => 'Direktorat KSKK Madrasah Kemenag RI',
                'rank' => 'Medali Emas',
                'year' => 2025,
            ],
            [
                'title' => 'Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) 10 Juz Putra Tingkat Kabupaten',
                'participant' => 'Ahmad Wildan Habibi (Kelas XII PK)',
                'category' => 'Keagamaan',
                'level' => 'kabupaten',
                'organizer' => 'LPTQ Kabupaten Gresik',
                'rank' => 'Juara 1',
                'year' => 2025,
            ],
            [
                'title' => 'Juara 1 Festival Seni Hadrah Al-Banjari se-Jawa Timur',
                'participant' => 'Grup Hadrah Syauqul Habib MA Assa\'adah',
                'category' => 'Seni Islami',
                'level' => 'provinsi',
                'organizer' => 'PW IPNU Jawa Timur',
                'rank' => 'Juara 1 Umum & Best Jingle',
                'year' => 2024,
            ],
            [
                'title' => 'Juara 2 Lomba Debat Bahasa Arab (Munadzarah Ilmiyyah) Nasional',
                'participant' => 'Tim Arabic Debate Club MA Assa\'adah',
                'category' => 'Bahasa & Literasi',
                'level' => 'nasional',
                'organizer' => 'UIN Maulana Malik Ibrahim Malang',
                'rank' => 'Juara 2',
                'year' => 2024,
            ],
            [
                'title' => 'Juara 1 Kejuaraan Pencak Silat Pagar Nusa Tingkat Kabupaten Gresik',
                'participant' => 'M. Bahrul Ulum (Kelas XI IPS)',
                'category' => 'Olahraga Bela Diri',
                'level' => 'kabupaten',
                'organizer' => 'Pimpinan Cabang Pagar Nusa Gresik',
                'rank' => 'Juara 1 Kelas Tanding C Remaja',
                'year' => 2024,
            ],
        ];

        foreach ($achievementsData as $ach) {
            Achievement::updateOrCreate(
                ['slug' => Str::slug($ach['title'])],
                array_merge($ach, [
                    'achieved_date' => now()->subMonths(rand(1, 10)),
                    'status' => 'published',
                    'author_id' => 1,
                    'description' => 'Prestasi membanggakan yang diraih peserta didik MA Ma\'arif NU Assa\'adah dalam ajang kompetisi resmi.',
                ])
            );
        }

        // 10. Education Programs & Featured Programs
        $eduPrograms = [
            [
                'name' => 'Peminatan MIPA (Matematika & Sains Riset)',
                'category' => 'Reguler Unggulan',
                'description' => 'Program pendidikan yang berfokus pada penguatan sains modern, matematika tingkat lanjut, bioteknologi, eksperimen laboratorium, dan pembinaan olimpiade sains (KSM).',
            ],
            [
                'name' => 'Peminatan IPS (Sosial Humaniora & Digital Entrepreneurship)',
                'category' => 'Reguler Unggulan',
                'description' => 'Program yang mendalami sosiologi, ekonomi syariah, geografi, kepemimpinan publik, serta literasi keuangan dan kewirausahaan digital modern.',
            ],
            [
                'name' => 'Program Keagamaan (Kajian Kitab Kuning Turats)',
                'category' => 'Pesantren Terpadu',
                'description' => 'Pendalaman literatur klasik Islam mencakup Nahwu Shorof, Fiqih Ushul Fiqih, Tafsir Hadits, dan Balaghah dengan sanad keilmuan Pesantren Qomaruddin.',
            ],
            [
                'name' => 'Program Tahfidzul Qur\'an 30 Juz',
                'category' => 'Khusus Pesantren',
                'description' => 'Program hafalan Al-Qur\'an berjenjang (Juz 30, 5 Juz, 10 Juz, hingga 30 Juz) dibimbing oleh para Huffadz bersanad dengan sistem setoran dan muraja\'ah mutqin.',
            ],
            [
                'name' => 'Program Bilingual & Language Immersion',
                'category' => 'Pengembangan Kompetensi',
                'description' => 'Pembiasaan intensif komunikasi berbahasa Arab dan Inggris, program khitobah 3 bahasa, dan pembekalan persiapan studi lanjut ke Timur Tengah dan PTN favorit.',
            ],
            [
                'name' => 'Program Digital Skills & Robotika Santri',
                'category' => 'Vokasional Terapan',
                'description' => 'Pelatihan kompetensi digital meliputi dasar pemrograman, IoT, robotika madrasah, desain grafis, dan pembuatan media informasi dakwah digital.',
            ],
        ];

        foreach ($eduPrograms as $i => $ep) {
            EducationProgram::updateOrCreate(
                ['slug' => Str::slug($ep['name'])],
                array_merge($ep, [
                    'status' => 'active',
                    'order' => $i + 1,
                ])
            );
        }

        $featuredList = [
            [
                'name' => 'Program Tahfidzul Qur\'an Terstruktur',
                'description' => 'Pembinaan hafalan Al-Qur\'an terpadu dengan target mutqin, dibimbing langsung oleh ustadz huffadz bersanad resmi dari Pondok Pesantren Qomaruddin.',
                'highlights' => "Hafalan bersanad mutqin\nBimbingan intensif setiap ba'da Subuh & Ashar\nWisuda Syahadah Tahfidz tahunan\nBeasiswa bebas SPP bagi penghafal 5 juz ke atas",
            ],
            [
                'name' => 'Madrasah Riset & Sains Terapan (MIPA)',
                'description' => 'Laboratorium riset aktif yang mendorong santri menghasilkan karya ilmiah, inovasi sains, dan prestasi olimpiade KSM serta MYRES nasional.',
                'highlights' => "Bimbingan karya tulis ilmiah & riset eksperimental\nLaboratorium komputer dan sains lengkap\nMentoring langsung oleh dosen dan pakar riset\nLangganan juara KSM tingkat kabupaten & provinsi",
            ],
            [
                'name' => 'Pengajian Turats & Kitab Kuning Salaf',
                'description' => 'Kajian mendalam khazanah keilmuan Islam menggunakan metodologi sorogan, wetonan, dan musyawarah bahsul masail yang otentik.',
                'highlights' => "Kitab Fathul Qorib, Jurumiyah, Imrithi, Taqrib, Arbain\nSanad keilmuan masyayikh Qomaruddin tersambung ke Rasulullah SAW\nPraktik dakwah dan khitobah kemasyarakatan\nPembiasaan adab thalabul \'ilmi yang luhur",
            ],
            [
                'name' => 'Bilingual & Global Communication',
                'description' => 'Ekosistem asrama dan madrasah yang membiasakan percakapan bahasa Arab dan Inggris untuk menyiapkan pemimpin berwawasan internasional.',
                'highlights' => "Arabic & English Day di madrasah\nKlub debat munadzarah dan public speaking\nPersiapan tes TOAFL dan TOEFL bersertifikat\nJalur khusus beasiswa kuliah ke Timur Tengah & PTN",
            ],
        ];

        foreach ($featuredList as $i => $fp) {
            FeaturedProgram::updateOrCreate(
                ['slug' => Str::slug($fp['name'])],
                array_merge($fp, [
                    'status' => 'active',
                    'order' => $i + 1,
                ])
            );
        }

        // 11. Curriculums
        Curriculum::updateOrCreate(
            ['slug' => 'kurikulum-merdeka-terintegrasi-pesantren'],
            [
                'title' => 'Kurikulum Merdeka Terintegrasi Turats Pesantren 2026/2027',
                'academic_year' => '2026/2027',
                'description' => 'Struktur kurikulum nasional Kementerian Agama RI (Kurikulum Merdeka) yang diperkaya dengan kurikulum muatan lokal pesantren salaf-modern Yayasan Pondok Pesantren Qomaruddin Bungah Gresik.',
                'status' => 'active',
                'order' => 1,
            ]
        );

        // 12. Academic Calendar
        $calendarData = [
            [
                'title' => 'Masa Ta\'aruf Siswa Madrasah (MATSAMA) & Orientasi Santri',
                'slug' => 'matsama-orientasi-santri-2026',
                'category' => 'kegiatan',
                'start_date' => now()->startOfMonth()->addDays(14),
                'end_date' => now()->startOfMonth()->addDays(17),
                'description' => 'Pengenalan lingkungan madrasah, tradisi pesantren Qomaruddin, tata tertib, dan pemetaan minat bakat santri baru.',
                'academic_year' => '2026/2027',
            ],
            [
                'title' => 'Peringatan Hari Santri Nasional 2026 & Kirab Santri',
                'slug' => 'peringatan-hari-santri-nasional-2026',
                'category' => 'kegiatan',
                'start_date' => now()->addMonths(1)->startOfMonth()->addDays(21),
                'end_date' => now()->addMonths(1)->startOfMonth()->addDays(22),
                'description' => 'Upacara bendera, perlombaan seni hadrah, pameran inovasi santri, dan doa bersama untuk bangsa.',
                'academic_year' => '2026/2027',
            ],
            [
                'title' => 'Penilaian Sumatif Tengah Semester (PSTS) Ganjil',
                'slug' => 'psts-ganjil-2026',
                'category' => 'ujian',
                'start_date' => now()->addMonths(2)->startOfMonth()->addDays(5),
                'end_date' => now()->addMonths(2)->startOfMonth()->addDays(12),
                'description' => 'Evaluasi capaian pembelajaran tengah semester berbasis sistem Computer Based Test (CBT) madrasah.',
                'academic_year' => '2026/2027',
            ],
            [
                'title' => 'Asesmen Sumatif Akhir Semester (ASAS) Ganjil',
                'slug' => 'asas-ganjil-2026',
                'category' => 'ujian',
                'start_date' => now()->addMonths(3)->startOfMonth()->addDays(1),
                'end_date' => now()->addMonths(3)->startOfMonth()->addDays(10),
                'description' => 'Ujian akhir semester ganjil untuk seluruh mata pelajaran umum, keagamaan Kemenag, dan muatan lokal pesantren.',
                'academic_year' => '2026/2027',
            ],
            [
                'title' => 'Libur Semester Ganjil & Pulangan Santri',
                'slug' => 'libur-semester-ganjil-2026',
                'category' => 'libur',
                'start_date' => now()->addMonths(3)->startOfMonth()->addDays(20),
                'end_date' => now()->addMonths(4)->startOfMonth()->addDays(2),
                'description' => 'Masa libur pembelajaran semester ganjil dan kepulangan santri ke kampung halaman.',
                'academic_year' => '2026/2027',
            ],
        ];

        foreach ($calendarData as $cd) {
            AcademicCalendar::updateOrCreate(['slug' => $cd['slug']], $cd);
        }

        // 13. Extracurriculars
        $ekskulList = [
            [
                'name' => 'Hadrah Al-Banjari Syauqul Habib',
                'description' => 'Pengembangan seni musik rebana dan lantunan sholawat klasik serta modern dengan teknik pukulan dan vocal yang rapi.',
                'mentor' => 'Ustadz Ahmad Sholihin',
                'schedule' => 'Rabu & Sabtu, 15.30 - 17.00 WIB',
                'achievements' => 'Juara 1 Festival Hadrah se-Jawa Timur 2024',
            ],
            [
                'name' => 'Pramuka Gugus Depan KH. Qomaruddin',
                'description' => 'Pendidikan kepanduan penegak yang menanamkan kedisiplinan, kemandirian, kepemimpinan, dan kecintaan pada tanah air.',
                'mentor' => 'M. Zainal Fanani, S.Pd.I.',
                'schedule' => 'Jumat, 13.30 - 16.00 WIB',
                'achievements' => 'Gudep Unggulan Kwartir Cabang Gresik',
            ],
            [
                'name' => 'Pencak Silat Pagar Nusa',
                'description' => 'Seni bela diri tradisi Nahdlatul Ulama yang memadukan olah fisik ketangkasan dengan penguatan spiritual santri.',
                'mentor' => 'Kang M. Bahrul Ulum',
                'schedule' => 'Selasa & Kamis, 15.30 - 17.00 WIB',
                'achievements' => 'Juara 1 Kejuaraan Kabupaten Gresik 2024',
            ],
            [
                'name' => 'Madrasah Young Researchers & Robotika',
                'description' => 'Wadah penelitian sains terapan, karya tulis ilmiah (KIR), mikrokontroler Arduino/IoT, dan coding untuk kompetisi nasional.',
                'mentor' => 'Dewi Lestari, S.Kom., M.T.',
                'schedule' => 'Senin & Kamis, 15.00 - 17.00 WIB',
                'achievements' => 'Medali Emas MYRES Nasional Kemenag 2025',
            ],
            [
                'name' => 'Madah Cyber & Jurnalistik Santri',
                'description' => 'Pelatihan kepenulisan berita, desain grafis, fotografi jurnalistik, videografi, dan pengelolaan media dakwah digital madrasah.',
                'mentor' => 'Siti Aminah, S.Pd., M.A.',
                'schedule' => 'Sabtu, 13.00 - 15.00 WIB',
                'achievements' => 'Penerbit Majalah Santri Assa\'adah Terfavorit',
            ],
            [
                'name' => 'Arabic & English Debate Club',
                'description' => 'Klub debat dan muhadatsah bahasa asing untuk melatih kemampuan retorika, public speaking, dan pemikiran kritis bertaraf internasional.',
                'mentor' => 'Ahmad Zubaidi, S.Pd. & Irfan Syauqi, M.Pd.',
                'schedule' => 'Selasa & Jumat, 15.30 - 17.00 WIB',
                'achievements' => 'Juara 2 Debat Bahasa Arab Nasional UIN Malang',
            ],
            [
                'name' => 'Palang Merah Remaja (PMR) Wira',
                'description' => 'Pembinaan pertolongan pertama pada kecelakaan (PPPK), donor darah, mitigasi bencana, dan kegiatan kepedulian sosial kemanusiaan.',
                'mentor' => 'Nur Laili Rohmatin, S.Psi.',
                'schedule' => 'Rabu, 15.00 - 17.00 WIB',
                'achievements' => 'Juara Umum Jumbara PMR Tingkat Kabupaten',
            ],
            [
                'name' => 'Seni Kaligrafi Islam (Khat)',
                'description' => 'Pembelajaran seni menulis indah huruf Al-Qur\'an dengan beragam kaidah khat seperti Naskhi, Tsuluts, Riq\'ah, Diwani, dan Kufi.',
                'mentor' => 'Ustadz H. Abdul Qodir, S.Ag.',
                'schedule' => 'Ahad, 09.00 - 11.00 WIB',
                'achievements' => 'Juara 2 MTQ Cabang Kaligrafi Hiasan Mushaf',
            ],
        ];

        foreach ($ekskulList as $i => $ek) {
            Extracurricular::updateOrCreate(
                ['slug' => Str::slug($ek['name'])],
                array_merge($ek, [
                    'status' => 'active',
                    'order' => $i + 1,
                ])
            );
        }

        // 14. Student Organizations
        $orgsData = [
            [
                'name' => 'OSIM (Organisasi Siswa Intra Madrasah)',
                'slug' => 'osim-ma-assaadah',
                'description' => 'Induk organisasi kesiswaan di MA Ma\'arif NU Assa\'adah yang menaungi aspirasi peserta didik, menyelenggarakan kegiatan kebersamaan, dan memupuk jiwa kepemimpinan amanah.',
                'structure' => "Ketua: M. Azka Naufal (XI MIPA)\nWakil Ketua: Nabila Azzahra (XI IPS)\nSekretaris: Ahmad Fahmi (XI PK)\nBendahara: Siti Sarah (XI MIPA)",
                'work_program' => "1. Peringatan Hari Besar Islam (PHBI) & Hari Besar Nasional (PHBN)\n2. Penyelenggaraan Pekan Olahraga & Seni Madrasah (Porseni)\n3. Pengelolaan Majalah Dinding & Kampanye Budaya Bersih Pesantren\n4. Pelatihan Dasar Kepemimpinan Siswa (LDKS)",
                'activities' => 'Rapat koordinasi mingguan, bakti sosial ramadhan, festival santri nusantara, dan pengelolaan event madrasah.',
            ],
            [
                'name' => 'PK IPNU (Pimpinan Komisariat IPNU MA Assa\'adah)',
                'slug' => 'pk-ipnu-ma-assaadah',
                'description' => 'Wadah kaderisasi pelajar Nahdlatul Ulama putra untuk menanamkan ideologi Ahlussunnah wal Jama\'ah An-Nahdliyyah, loyalitas kebangsaan, dan tradisi intelektual santri.',
                'structure' => "Mandataris / Ketua: M. Badrut Tamam\nWakil Ketua Kaderisasi: M. Ilham Maulana\nSekretaris: M. Khoirul Anam\nBendahara: M. Rizky Pratama",
                'work_program' => "1. Masa Kesetiaan Anggota (MAKESTA)\n2. Majelis Dzikir dan Sholawat Rijalul Ansor & IPNU\n3. Diskusi Tematik Keaswajaan & Kebangsaan\n4. Pendelegasian kader pada forum pelajar regional Jawa Timur",
                'activities' => 'Rutinan pembacaan Diba\'iyah, istighosah malam Jumat, kaderisasi bertingkat, dan pengabdian masyarakat.',
            ],
            [
                'name' => 'PK IPPNU (Pimpinan Komisariat IPPNU MA Assa\'adah)',
                'slug' => 'pk-ippnu-ma-assaadah',
                'description' => 'Wadah pembinaan dan pemberdayaan pelajar putri Nahdlatul Ulama di MA Ma\'arif NU Assa\'adah untuk mewujudkan generasi santriwati yang cerdas, anggun, dan mandiri.',
                'structure' => "Ketua: Farida Hanum\nWakil Ketua: Dina Fauziyah\nSekretaris: Anisa Rahmawati\nBendahara: Zahrotul Fitri",
                'work_program' => "1. Pelaksanaan MAKESTA Putri Assa\'adah\n2. Workshop Keterampilan Keputrian & Entrepreneurship Santriwati\n3. Kajian Fiqih Nisa\' & Kesehatan Reproduksi Remaja Islami\n4. Majelis Khotmil Qur\'an dan Shalawat Nariyah",
                'activities' => 'Kajian rutin keputrian, seminar kesehatan santri, bakti sosial kaum dhuafa, dan peringatan hari santri.',
            ],
            [
                'name' => 'MPK (Majelis Perwakilan Kelas)',
                'slug' => 'mpk-ma-assaadah',
                'description' => 'Lembaga legislatif siswa yang berfungsi mengawasi pelaksanaan program kerja OSIM serta menjadi jembatan aspirasi perwakilan kelas kepada pengelola madrasah.',
                'structure' => "Ketua MPK: Faris Maulana\nWakil Ketua: Linda Khairunnisa\nKomisi A (Aspirasi): Zaidan Ali\nKomisi B (Pengawasan): Nurul Izzah",
                'work_program' => "1. Sidang Pleno Evaluasi Kinerja OSIM per Semester\n2. Penyerapan Kotak Aspirasi Santri & Siswa Madrasah\n3. Pengawasan Pemilihan Umum Ketua OSIM (Pemilos)\n4. Forum Musyawarah Perwakilan Kelas Bersama Pimpinan Madrasah",
                'activities' => 'Rapat dengar pendapat bulanan, verifikasi proposal kegiatan kesiswaan, dan pelaporan pertanggungjawaban.',
            ],
        ];

        foreach ($orgsData as $i => $od) {
            StudentOrganization::updateOrCreate(
                ['slug' => $od['slug']],
                array_merge($od, [
                    'status' => 'active',
                    'order' => $i + 1,
                ])
            );
        }

        // 15. Facilities
        $facilitiesList = [
            [
                'name' => 'Gedung Smart Classroom & Kelas Ber-AC Multimedia',
                'description' => 'Ruang kelas modern ber-AC dilengkapi proyektor interaktif, koneksi internet serat optik berkecepatan tinggi, dan pencahayaan ergonomis untuk kenyamanan optimal.',
            ],
            [
                'name' => 'Laboratorium Komputer & Digital Learning Center',
                'description' => 'Lab komputer dengan puluhan unit PC berspesifikasi tinggi, jaringan gigabit LAN, dan server mandiri untuk simulasi CBT, coding, dan riset multimedia.',
            ],
            [
                'name' => 'Laboratorium Sains Terpadu (Fisika, Kimia, Biologi)',
                'description' => 'Fasilitas eksperimen lengkap dengan mikroskop digital, neraca analitik, alat peraga sains mutakhir, dan instrumen riset karya ilmiah siswa.',
            ],
            [
                'name' => 'Perpustakaan Digital & Pojok Baca Santri',
                'description' => 'Koleksi ribuan judul buku umum, literatur sains, ensiklopedia, kitab kuning turats klasik, serta akses e-library dan jurnal ilmiah gratis.',
            ],
            [
                'name' => 'Musholla Al-Ihsan Madrasah',
                'description' => 'Pusat pembiasaan ibadah shalat Dhuha, shalat Dhuhur dan Ashar berjamaah, pengajian sorogan kitab kuning, serta istighosah santri.',
            ],
            [
                'name' => 'Asrama Santri Pondok Pesantren Qomaruddin',
                'description' => 'Kompleks asrama pesantren yang asri, aman, dan kondusif dengan pendampingan pembina 24 jam untuk penguatan hafalan Al-Qur\'an dan akhlak.',
            ],
            [
                'name' => 'Lapangan Olahraga Multifungsi',
                'description' => 'Fasilitas lapangan terbuka untuk futsal, bola voli, basket, bulutangkis, serta latihan pencak silat Pagar Nusa dan apel bendera.',
            ],
            [
                'name' => 'Graha Pertemuan & Aula Assa\'adah',
                'description' => 'Gedung serbaguna berkapasitas besar untuk haflah akhirussanah, seminar nasional, pameran inovasi santri, dan pertemuan wali murid.',
            ],
        ];

        foreach ($facilitiesList as $i => $fac) {
            Facility::updateOrCreate(
                ['slug' => Str::slug($fac['name'])],
                array_merge($fac, [
                    'is_active' => true,
                    'order' => $i + 1,
                ])
            );
        }

        // 16. Albums & Photos & Videos
        $albumsData = [
            [
                'name' => 'Dokumentasi Apel Akbar Hari Santri Nasional & Haflah Qomaruddin',
                'slug' => 'dokumentasi-apel-akbar-hari-santri-nasional',
                'description' => 'Potret kemeriahan apel akbar, kirab santri, dan rangkaian perlombaan seni budaya Islam di MA Ma\'arif NU Assa\'adah.',
                'album_date' => now()->subDays(2),
            ],
            [
                'name' => 'Wisuda Purnasiswa & Haflah Tahfidzul Qur\'an Angkatan IX',
                'slug' => 'wisuda-purnasiswa-haflah-tahfidz-angkatan-ix',
                'description' => 'Momen khidmat pelepasan alumni dan prosesi sujud syukur para wisudawan tahfidz Al-Qur\'an bersama orang tua tercinta.',
                'album_date' => now()->subMonths(3),
            ],
            [
                'name' => 'Ajang Kompetisi Sains Madrasah (KSM) & Ekspo Riset Santri',
                'slug' => 'ajang-ksm-ekspo-riset-santri',
                'description' => 'Dokumentasi perjuangan tim olimpiade sains dan pameran prototipe robotika siswa MA Ma\'arif NU Assa\'adah.',
                'album_date' => now()->subMonths(5),
            ],
            [
                'name' => 'Kemah Bhakti Gugus Depan KH. Qomaruddin di Alam Terbuka',
                'slug' => 'kemah-bhakti-gudep-kh-qomaruddin',
                'description' => 'Kegiatan perkemahan penegak Bantara, penjelajahan halang rintang, dan bakti sosial masyarakat desa.',
                'album_date' => now()->subMonths(7),
            ],
        ];

        foreach ($albumsData as $ad) {
            $alb = Album::updateOrCreate(
                ['slug' => $ad['slug']],
                array_merge($ad, ['status' => 'published'])
            );

            for ($k = 1; $k <= 4; $k++) {
                Photo::firstOrCreate(
                    ['album_id' => $alb->id, 'caption' => $ad['name'] . ' - Momen ' . $k],
                    ['order' => $k, 'image' => 'photos/sample-' . $k . '.jpg']
                );
            }
        }

        $videosData = [
            [
                'title' => 'Video Profil Resmi MA Ma\'arif NU Assa\'adah Bungah Gresik',
                'slug' => 'video-profil-resmi-ma-maarif-nu-assaadah',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'provider' => 'youtube',
                'description' => 'Mengenal lebih dekat visi, fasilitas, keunggulan akademik, dan tradisi pesantren di MA Ma\'arif NU Assa\'adah Gresik.',
                'video_date' => now()->subMonths(1),
            ],
            [
                'title' => 'Dokumenter Haflah Pondok Pesantren Qomaruddin Sampurnan',
                'slug' => 'dokumenter-haflah-pondok-pesantren-qomaruddin',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'provider' => 'youtube',
                'description' => 'Napak tilas sejarah emas pengabdian Pondok Pesantren Qomaruddin sejak 1775 M bersama lembaga pendidikan binaannya.',
                'video_date' => now()->subMonths(4),
            ],
            [
                'title' => 'Mars Ma\'arif NU & Mars Assa\'adah: Harmoni Semangat Santri',
                'slug' => 'mars-maarif-nu-mars-assaadah',
                'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'provider' => 'youtube',
                'description' => 'Lantunan mars kebanggaan warga madrasah dalam mengobarkan semangat thalabul ilmi dan cinta tanah air.',
                'video_date' => now()->subMonths(6),
            ],
        ];

        foreach ($videosData as $vd) {
            Video::updateOrCreate(
                ['slug' => $vd['slug']],
                array_merge($vd, ['status' => 'published'])
            );
        }

        // 17. Alumni (IKBAL MADAH)
        $alumniData = [
            [
                'name' => 'Muhammad Fatih, S.Hum.',
                'graduation_year' => 2019,
                'university' => 'Universitas Al-Azhar Kairo, Mesir',
                'major' => 'Ushuluddin & Studi Islam',
                'occupation' => 'Kandidat Master & Penerjemah Turats',
                'company' => 'Pusat Studi Islam Kairo',
                'testimonial' => 'MA Ma\'arif NU Assa\'adah memberikan pondasi bahasa Arab dan penguasaan kitab kuning yang sangat kuat. Ketika melanjutkan studi ke Al-Azhar Kairo, saya merasakan betapa berharganya bimbingan para masyayikh dan dewan guru di Bungah.',
            ],
            [
                'name' => 'Nurul Hidayati, S.Si., M.Biotech.',
                'graduation_year' => 2017,
                'university' => 'Universitas Gadjah Mada (UGM)',
                'major' => 'Bioteknologi',
                'occupation' => 'Peneliti Laboratorium Riset',
                'company' => 'Badan Riset dan Inovasi Nasional (BRIN)',
                'testimonial' => 'Belajar di MA Assa\'adah melatih saya berpikir analitis sekaligus tawadhu\'. Bimbingan riset madrasah sejak kelas X menjadi gerbang utama kecintaan saya pada dunia penelitian bioteknologi.',
            ],
            [
                'name' => 'Ahmad Rijaluddin, S.Kom.',
                'graduation_year' => 2020,
                'university' => 'Institut Teknologi Sepuluh Nopember (ITS)',
                'major' => 'Teknik Informatika',
                'occupation' => 'Software Engineer',
                'company' => 'Unicorn Tech Company Jakarta',
                'testimonial' => 'Suasana madrasah yang mendukung minat teknologi santri membuktikan bahwa anak pesantren bisa bersaing di panggung industri digital tingkat global.',
            ],
            [
                'name' => 'Gus M. Syarif Hidayatullah, Lc., M.H.',
                'graduation_year' => 2015,
                'university' => 'Ma\'had Aly Pondok Pesantren Qomaruddin',
                'major' => 'Fiqih & Ushul Fiqih',
                'occupation' => 'Pengasuh Pondok Pesantren & Dosen',
                'company' => 'Institut Qomaruddin Gresik',
                'testimonial' => 'Karakter pesantren yang tertanam di MA Ma\'arif NU Assa\'adah adalah warisan tak ternilai. Madrasah ini berhasil memadukan adab thalabul ilmi dengan dinamika keilmuan modern.',
            ],
            [
                'name' => 'dr. Safira Rahmania',
                'graduation_year' => 2018,
                'university' => 'Fakultas Kedokteran UIN Syarif Hidayatullah Jakarta',
                'major' => 'Pendidikan Dokter',
                'occupation' => 'Dokter Residen',
                'company' => 'RSUD Ibnu Sina Gresik',
                'testimonial' => 'Disiplin dan nilai empati yang saya dapatkan selama nyantri dan belajar di MA Assa\'adah menjadi pegangan utama saya saat melayani masyarakat di dunia medis.',
            ],
            [
                'name' => 'Fauzan Adhim, S.E.',
                'graduation_year' => 2021,
                'university' => 'Universitas Brawijaya Malang',
                'major' => 'Ekonomi Syariah',
                'occupation' => 'Founder & CEO',
                'company' => 'Madah Creative Studio',
                'testimonial' => 'Jiwa kepemimpinan dan kemandirian santri yang dipupuk lewat OSIM dan IPNU MA Assa\'adah menjadi modal terpenting saya dalam membangun usaha kreatif mandiri.',
            ],
        ];

        foreach ($alumniData as $i => $alm) {
            Alumni::updateOrCreate(
                ['slug' => Str::slug($alm['name'])],
                array_merge($alm, [
                    'status' => 'verified',
                    'is_public' => true,
                    'order' => $i + 1,
                ])
            );
        }

        // 18. Download Categories & Downloads
        $catSpmb = DownloadCategory::firstOrCreate(['slug' => 'panduan-spmb'], ['name' => 'Panduan SPMB / PPDB']);
        $catKurikulum = DownloadCategory::firstOrCreate(['slug' => 'kurikulum-akademik'], ['name' => 'Kurikulum & Kalender']);
        $catTataTertib = DownloadCategory::firstOrCreate(['slug' => 'tata-tertib-madrasah'], ['name' => 'Tata Tertib & Pedoman']);
        $catFormulir = DownloadCategory::firstOrCreate(['slug' => 'formulir-surat'], ['name' => 'Formulir & Layanan']);

        $downloadsList = [
            [
                'name' => 'Brosur & Panduan Lengkap SPMB MA Ma\'arif NU Assa\'adah 2026/2027',
                'slug' => 'brosur-panduan-spmb-ma-assaadah-2026-2027',
                'category_id' => $catSpmb->id,
                'file_size' => 4820000,
                'file_name' => 'Brosur_SPMB_MA_Assaadah_2026_2027.pdf',
                'description' => 'Informasi lengkap syarat pendaftaran santri baru, alur seleksi, rincian biaya, program beasiswa tahfidz, dan jadwal tes peminatan.',
                'publish_date' => now()->subDays(5),
                'downloads' => 342,
            ],
            [
                'name' => 'Kalender Akademik Resmi MA Ma\'arif NU Assa\'adah Tahun Ajaran 2026/2027',
                'slug' => 'kalender-akademik-resmi-2026-2027',
                'category_id' => $catKurikulum->id,
                'file_size' => 2150000,
                'file_name' => 'Kalender_Akademik_MA_Assaadah_2026_2027.pdf',
                'description' => 'Jadwal resmi kegiatan belajar mengajar, asesmen sumatif, peringatan hari besar Islam (PHBI), libur pesantren, dan agenda madrasah.',
                'publish_date' => now()->subDays(10),
                'downloads' => 520,
            ],
            [
                'name' => 'Buku Pedoman Santri & Tata Tertib Peserta Didik Madrasah Aliyah',
                'slug' => 'buku-pedoman-santri-tata-tertib-madrasah',
                'category_id' => $catTataTertib->id,
                'file_size' => 3120000,
                'file_name' => 'Buku_Pedoman_Santri_Tata_Tertib_MA_Assaadah.pdf',
                'description' => 'Panduan hak, kewajiban, norma kedisiplinan, kode etik busana santri, dan tata tertib kehidupan di madrasah dan asrama.',
                'publish_date' => now()->subDays(15),
                'downloads' => 218,
            ],
            [
                'name' => 'Struktur Kurikulum Merdeka Terintegrasi Turats Pesantren',
                'slug' => 'struktur-kurikulum-merdeka-terintegrasi-turats',
                'category_id' => $catKurikulum->id,
                'file_size' => 1840000,
                'file_name' => 'Struktur_Kurikulum_Merdeka_MA_Assaadah.pdf',
                'description' => 'Silabus dan alokasi jam pelajaran mata pelajaran umum Kemenag, peminatan MIPA/IPS, dan muatan lokal kitab kuning.',
                'publish_date' => now()->subDays(20),
                'downloads' => 195,
            ],
            [
                'name' => 'Formulir Pengajuan Beasiswa Santri Tahfidz & Prestasi',
                'slug' => 'formulir-beasiswa-santri-tahfidz-prestasi',
                'category_id' => $catFormulir->id,
                'file_size' => 950000,
                'file_name' => 'Formulir_Beasiswa_Santri_Tahfidz_Prestasi.pdf',
                'description' => 'Format isian pengajuan keringanan biaya pendidikan dan beasiswa penuh bagi santri berprestasi dan hafidz Qur\'an.',
                'publish_date' => now()->subDays(25),
                'downloads' => 140,
            ],
        ];

        foreach ($downloadsList as $dl) {
            Download::updateOrCreate(
                ['slug' => $dl['slug']],
                [
                    'name' => $dl['name'],
                    'download_category_id' => $dl['category_id'],
                    'file' => 'downloads/' . $dl['file_name'],
                    'file_name' => $dl['file_name'],
                    'file_size' => $dl['file_size'],
                    'description' => $dl['description'],
                    'publish_date' => $dl['publish_date'],
                    'downloads' => $dl['downloads'],
                    'status' => 'published',
                ]
            );
        }

        // 19. Hero Slides (CMS Homepage Showcase)
        $heroSlidesData = [
            [
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
            ],
            [
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
            ],
            [
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
            ],
        ];

        foreach ($heroSlidesData as $slide) {
            HeroSlide::updateOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }
    }
}


