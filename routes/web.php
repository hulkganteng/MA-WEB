<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\AgendaController;
use App\Http\Controllers\Public\AlumniController;
use App\Http\Controllers\Public\AnnouncementController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\BeritaController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\DownloadController;
use App\Http\Controllers\Public\FacilityController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\GuruController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\PrestasiController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\ProgramController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{post:slug}', [ArticleController::class, 'show'])->name('artikel.show');

Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{announcement:slug}', [AnnouncementController::class, 'show'])->name('pengumuman.show');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{event:slug}', [AgendaController::class, 'show'])->name('agenda.show');

Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');

Route::get('/program/unggulan', [ProgramController::class, 'featured'])->name('programs.featured');
Route::get('/program/unggulan/{featuredProgram:slug}', [ProgramController::class, 'featuredShow'])->name('programs.featured.show');
Route::get('/program', [ProgramController::class, 'index'])->name('programs');
Route::get('/program/{program:slug}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');

Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities');

Route::get('/galeri/foto', [GalleryController::class, 'photos'])->name('gallery.photos');
Route::get('/galeri/foto/{album:slug}', [GalleryController::class, 'album'])->name('gallery.album');
Route::get('/galeri/video', [GalleryController::class, 'videos'])->name('gallery.videos');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/registrasi', [AlumniController::class, 'create'])->name('alumni.register');
Route::post('/alumni/registrasi', [AlumniController::class, 'store'])->middleware('throttle:5,1')->name('alumni.register.store');

Route::get('/download', [DownloadController::class, 'index'])->name('downloads.index');
Route::get('/download/{download:slug}', [DownloadController::class, 'download'])->name('downloads.show');

Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/api/prayer-times', function () {
    $date = request('date');
    if (! is_string($date) || ! preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
        abort(422, 'Format tanggal tidak valid.');
    }

    $response = Http::acceptJson()
        ->timeout(3)
        ->get("https://api.aladhan.com/v1/timings/{$date}", [
            'latitude' => -7.0583,
            'longitude' => 112.5694,
            'method' => 20,
            'school' => 0,
        ]);

    if ($response->failed() || ! is_array($response->json('data.timings'))) {
        abort(503, 'Jadwal sholat sementara tidak tersedia.');
    }

    return response()->json([
        'timings' => $response->json('data.timings'),
        'source' => 'Aladhan / Kementerian Agama Republik Indonesia',
    ])->header('Cache-Control', 'public, max-age=1800');
})->middleware('throttle:60,1')->name('api.prayer-times');

Route::get('/profil', [ProfileController::class, 'about'])->name('about');
Route::get('/profil/sejarah', [ProfileController::class, 'history'])->name('sejarah');
Route::get('/profil/visi-misi', [ProfileController::class, 'visiMisi'])->name('visi-misi');
Route::get('/profil/sambutan-kepala', [ProfileController::class, 'sambutan'])->name('sambutan');
Route::get('/profil/struktur-organisasi', [ProfileController::class, 'structure'])->name('structure');
Route::get('/akademik/kurikulum', [ProgramController::class, 'curriculum'])->name('curriculum');
Route::get('/akademik/kalender', [ProgramController::class, 'calendar'])->name('academic-calendar');
Route::get('/kesiswaan/ekstrakurikuler', [ProgramController::class, 'extracurricular'])->name('extracurricular');
Route::get('/kesiswaan/ekstrakurikuler/{extracurricular:slug}', [ProgramController::class, 'extracurricularShow'])->name('extracurricular.show');
Route::get('/kesiswaan/organisasi', [ProgramController::class, 'organizations'])->name('organizations');

// Admin / auth
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit')->middleware('throttle:6,1');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth');

require __DIR__.'/admin.php';

Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');
