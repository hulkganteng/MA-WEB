<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'site', 'key' => 'site.name', 'value' => 'MA Ma\'arif NU Assa\'adah', 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.tagline', 'value' => 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren', 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.logo', 'value' => null, 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.favicon', 'value' => null, 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.copyright', 'value' => 'Yayasan Pondok Pesantren Qomaruddin', 'type' => 'string'],
            ['group' => 'site', 'key' => 'site.academic_year', 'value' => '2026/2027', 'type' => 'string'],

            ['group' => 'contact', 'key' => 'contact.address', 'value' => 'Jl. Raya Bungah No. 01, Bungah, Gresik, Jawa Timur 61152', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.email', 'value' => 'mamnu.assaadah@gmail.com', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.phone', 'value' => '031 3949501', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.whatsapp', 'value' => '081234567890', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.maps_url', 'value' => 'https://maps.google.com/?q=MA+Ma\'arif+NU+Assa\'adah', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact.hours', 'value' => 'Senin - Jumat, 07.00 - 15.00 WIB', 'type' => 'string'],

            ['group' => 'seo', 'key' => 'seo.default_title', 'value' => 'MA Ma\'arif NU Assa\'adah — Madrasah Aliyah Modern di Gresik', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'seo.default_description', 'value' => 'Website resmi MA Ma\'arif NU Assa\'adah Bungah Gresik. Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren.', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'seo.default_image', 'value' => null, 'type' => 'string'],

            ['group' => 'whatsapp', 'key' => 'whatsapp.enabled', 'value' => true, 'type' => 'boolean'],
            ['group' => 'whatsapp', 'key' => 'whatsapp.number', 'value' => '081234567890', 'type' => 'string'],
            ['group' => 'whatsapp', 'key' => 'whatsapp.message', 'value' => 'Assalamualaikum, saya ingin bertanya tentang MA Ma\'arif NU Assa\'adah.', 'type' => 'string'],

            ['group' => 'stats', 'key' => 'stats.students', 'value' => 300, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.teachers', 'value' => 28, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.staff', 'value' => 10, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.alumni', 'value' => 1500, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.achievements', 'value' => 60, 'type' => 'integer'],
            ['group' => 'stats', 'key' => 'stats.extracurriculars', 'value' => 12, 'type' => 'integer'],

            ['group' => 'principal', 'key' => 'principal.name', 'value' => 'Mohammad Isma\'il Cholilur Rohman, M.Pd.', 'type' => 'string'],
            ['group' => 'principal', 'key' => 'principal.position', 'value' => 'Kepala Madrasah', 'type' => 'string'],
            ['group' => 'principal', 'key' => 'principal.photo', 'value' => null, 'type' => 'string'],
            ['group' => 'principal', 'key' => 'principal.speech', 'value' => null, 'type' => 'string'],

            ['group' => 'hero', 'key' => 'hero.title', 'value' => 'Membentuk Generasi Berilmu, Berakhlak, dan Berkarakter Pesantren', 'type' => 'string'],
            ['group' => 'hero', 'key' => 'hero.subtitle', 'value' => 'MA Ma\'arif NU Assa\'adah menghadirkan pendidikan yang memadukan akademik, karakter, keislaman, dan perkembangan teknologi.', 'type' => 'string'],
            ['group' => 'hero', 'key' => 'hero.image', 'value' => null, 'type' => 'string'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        Setting::flushGroup('general');
    }
}
