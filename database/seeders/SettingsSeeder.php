<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $speech = '<p><strong>Assalamu’alaikum Warahmatullahi Wabarakatuh</strong></p>'
            . '<p>Segala puji bagi Allah SWT, Rabb semesta alam, yang melimpahkan rahmat, taufiq, serta hidayah-Nya kepada kita semua. Sholawat dan salam semoga senantiasa tercurah kepada junjungan kita Nabi Besar Muhammad SAW, keluarga, sahabat, dan umat beliau hingga akhir zaman.</p>'
            . '<p>Selamat datang di portal informasi resmi <strong>Madrasah Aliyah Ma’arif NU Assa’adah (MAMNU Assa\'adah) Bungah, Gresik</strong>, lembaga pendidikan formal menengah atas yang bernaung di bawah panji luhur <strong>Yayasan Pondok Pesantren Qomaruddin</strong> Sampurnan Bungah Gresik.</p>'
            . '<p>Sebagai madrasah yang lahir dan berakar kuat di lingkungan pesantren bersejarah yang telah mengabdi lebih dari dua setengah abad, MA Ma’arif NU Assa’adah terus teguh memegang amanah peradaban: memadukan keluhuran tradisi keislaman Ahlussunnah wal Jama’ah An-Nahdliyyah, ketajaman literasi kitab kuning (turats), dengan keunggulan sains terapan, riset madrasah, dan kompetensi teknologi abad ke-21.</p>'
            . '<p>Visi kami adalah <em>"Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren"</em>. Kami berikhtiar mendidik generasi santri yang tidak hanya unggul secara akademis dan siap menembus perguruan tinggi terkemuka dunia, namun juga memiliki kedalaman spiritual, integritas moral, serta kecakapan hidup (life skills) untuk mengabdi bagi agama, nusa, dan bangsa.</p>'
            . '<p>Semoga media digital ini menjadi jembatan silaturahmi, transparansi informasi, dan inspirasi bagi para peserta didik, santri, wali murid, alumni IKBAL MADAH, serta masyarakat luas. Mari bersama kita jemput masa depan dengan ilmu dan barokah.</p>'
            . '<p><strong>Wassalamu’alaikum Warahmatullahi Wabarakatuh</strong></p>';

        $settings = [
            ['group' => 'site', 'key' => 'site.name', 'value' => 'MA Ma\'arif NU Assa\'adah', 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.tagline', 'value' => 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren', 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.logo', 'value' => null, 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.favicon', 'value' => null, 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.copyright', 'value' => 'Yayasan Pondok Pesantren Qomaruddin', 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.academic_year', 'value' => '2026/2027', 'type' => 'string'],

            ['group' => 'contact', 'key' => 'contact.address', 'value' => 'Jl. Raya Bungah No. 01, Sampurnan, Bungah, Gresik, Jawa Timur 61152', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.email', 'value' => 'mamnu.assaadah@gmail.com', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.phone', 'value' => '031 3949501', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.whatsapp', 'value' => '081234567890', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.maps_url', 'value' => 'https://maps.google.com/?q=MA+Ma\'arif+NU+Assa\'adah+Bungah+Gresik', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.hours', 'value' => 'Senin - Sabtu, 07.00 - 15.00 WIB', 'type' => 'string'],

            ['group' => 'seo', 'key' => 'seo.default_title', 'value' => 'MA Ma\'arif NU Assa\'adah — Madrasah Aliyah Unggulan Berkarakter Pesantren Gresik', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'seo.default_description', 'value' => 'Website resmi MA Ma\'arif NU Assa\'adah Bungah Gresik di bawah naungan Yayasan Pondok Pesantren Qomaruddin. Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren.', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'seo.default_image', 'value' => null, 'type' => 'string'],

            ['group' => 'whatsapp', 'key' => 'whatsapp.enabled', 'value' => true, 'type' => 'boolean'],
            ['group' => 'whatsapp', 'key' => 'whatsapp.number', 'value' => '081234567890', 'type' => 'string'],
            ['group' => 'whatsapp', 'key' => 'whatsapp.message', 'value' => 'Assalamualaikum Wr. Wb., saya ingin bertanya tentang pendaftaran dan program di MA Ma\'arif NU Assa\'adah Bungah Gresik.', 'type' => 'string'],

            ['group' => 'stats', 'key' => 'stats.students', 'value' => 380, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.teachers', 'value' => 28, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.staff', 'value' => 12, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.alumni', 'value' => 2450, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.achievements', 'value' => 75, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.extracurriculars', 'value' => 14, 'type' => 'integer'],

            ['group' => 'principal', 'key' => 'principal.name', 'value' => 'Mohammad Isma\'il Cholilur Rohman, M.Pd.', 'type' => 'string'],
            ['group' => 'principal', 'key' => 'principal.position', 'value' => 'Kepala Madrasah', 'type' => 'string'],
            ['group' => 'principal', 'key' => 'principal.photo', 'value' => null, 'type' => 'string'],
            ['group' => 'principal', 'key' => 'principal.speech', 'value' => $speech, 'type' => 'string'],

            ['group' => 'hero', 'key' => 'hero.title', 'value' => 'Membentuk Generasi Berilmu, Berakhlak, dan Berkarakter Pesantren', 'type' => 'string'],
            ['group' => 'hero', 'key' => 'hero.subtitle', 'value' => 'MA Ma\'arif NU Assa\'adah menghadirkan pendidikan unggul yang memadukan kedalaman spiritual pesantren Qomaruddin, kecakapan riset sains, dan inovasi teknologi abad modern.', 'type' => 'string'],
            ['group' => 'hero', 'key' => 'hero.image', 'value' => null, 'type' => 'string'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        Setting::flushGroup('general');
    }
}
