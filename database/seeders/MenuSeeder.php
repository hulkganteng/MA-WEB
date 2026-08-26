<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::truncate();

        $menus = [
            ['name' => 'Beranda', 'url' => '/', 'order' => 1],
            ['name' => 'Profil', 'url' => null, 'order' => 2, 'children' => [
                ['name' => 'Tentang Madrasah', 'url' => '/profil'],
                ['name' => 'Sejarah', 'url' => '/profil/sejarah'],
                ['name' => 'Visi & Misi', 'url' => '/profil/visi-misi'],
                ['name' => 'Sambutan Kepala Madrasah', 'url' => '/profil/sambutan-kepala'],
                ['name' => 'Struktur Organisasi', 'url' => '/profil/struktur-organisasi'],
                ['name' => 'Guru & Tenaga Kependidikan', 'url' => '/guru'],
                ['name' => 'Sarana & Prasarana', 'url' => '/fasilitas'],
            ]],
            ['name' => 'Akademik', 'url' => null, 'order' => 3, 'children' => [
                ['name' => 'Program Pendidikan', 'url' => '/program'],
                ['name' => 'Program Unggulan', 'url' => '/program/unggulan'],
                ['name' => 'Simulasi Peminatan SPMB', 'url' => '#spmb-simulasi'],
                ['name' => 'Kurikulum', 'url' => '/akademik/kurikulum'],
                ['name' => 'Kalender Akademik', 'url' => '/akademik/kalender'],
                ['name' => 'Prestasi', 'url' => '/prestasi'],
            ]],
            ['name' => 'Kesiswaan', 'url' => null, 'order' => 4, 'children' => [
                ['name' => 'Ekstrakurikuler', 'url' => '/kesiswaan/ekstrakurikuler'],
                ['name' => 'Organisasi Siswa', 'url' => '/kesiswaan/organisasi'],
                ['name' => 'Kegiatan Siswa', 'url' => '/agenda'],
            ]],
            ['name' => 'Informasi', 'url' => null, 'order' => 5, 'children' => [
                ['name' => 'Berita', 'url' => '/berita'],
                ['name' => 'Pengumuman', 'url' => '/pengumuman'],
                ['name' => 'Agenda', 'url' => '/agenda'],
                ['name' => 'Artikel', 'url' => '/artikel'],
            ]],
            ['name' => 'Galeri', 'url' => null, 'order' => 6, 'children' => [
                ['name' => 'Galeri Foto', 'url' => '/galeri/foto'],
                ['name' => 'Galeri Video', 'url' => '/galeri/video'],
            ]],
            ['name' => 'Alumni', 'url' => null, 'order' => 7, 'children' => [
                ['name' => 'Alumni', 'url' => '/alumni'],
                ['name' => 'Registrasi Alumni', 'url' => '/alumni/registrasi'],
            ]],
            ['name' => 'Download', 'url' => '/download', 'order' => 8],
            ['name' => 'Kontak', 'url' => '/kontak', 'order' => 9],
        ];

        foreach ($menus as $menu) {
            $children = $menu['children'] ?? [];
            unset($menu['children']);
            $parent = Menu::create($menu);

            foreach ($children as $i => $child) {
                Menu::create(array_merge($child, ['parent_id' => $parent->id, 'order' => $i + 1]));
            }
        }
    }
}
