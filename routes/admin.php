<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\OrganizationMemberController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PrincipalProfileController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:dashboard.view'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/akun', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/akun', [AccountController::class, 'update'])->name('account.update');

    Route::middleware('permission:posts.view|articles.view')->group(function () {
        Route::get('/konten', [PostController::class, 'index'])->name('posts.index');
        Route::get('/konten/tambah', [PostController::class, 'create'])->middleware('permission:posts.create|articles.create')->name('posts.create');
        Route::post('/konten', [PostController::class, 'store'])->middleware('permission:posts.create|articles.create')->name('posts.store');
        Route::get('/konten/{post}/edit', [PostController::class, 'edit'])->middleware('permission:posts.update|articles.update')->name('posts.edit');
        Route::put('/konten/{post}', [PostController::class, 'update'])->middleware('permission:posts.update|articles.update')->name('posts.update');
        Route::delete('/konten/{post}', [PostController::class, 'destroy'])->middleware('permission:posts.delete|articles.delete')->name('posts.destroy');
    });

    Route::middleware('permission:pages.view')->group(function () {
        Route::resource('halaman', PageController::class)->except('show')->parameters(['halaman' => 'page'])->names('pages');
    });

    Route::get('/profil', [ProfileController::class, 'index'])
        ->middleware('permission:pages.view|structure.manage|settings.manage')->name('profile.index');
    Route::middleware('permission:pages.update')->group(function () {
        Route::get('/profil/halaman/{section}', [ProfileController::class, 'edit'])->name('profile.pages.edit');
        Route::put('/profil/halaman/{section}', [ProfileController::class, 'update'])->name('profile.pages.update');
    });
    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('/profil/sambutan-kepala', [PrincipalProfileController::class, 'edit'])->name('profile.principal.edit');
        Route::put('/profil/sambutan-kepala', [PrincipalProfileController::class, 'update'])->name('profile.principal.update');
    });
    Route::middleware('permission:structure.manage')->group(function () {
        Route::get('/profil/struktur', [OrganizationMemberController::class, 'index'])->name('profile.structure.index');
        Route::post('/profil/struktur', [OrganizationMemberController::class, 'store'])->name('profile.structure.store');
        Route::put('/profil/struktur/{organizationMember}', [OrganizationMemberController::class, 'update'])->name('profile.structure.update');
        Route::delete('/profil/struktur/{organizationMember}', [OrganizationMemberController::class, 'destroy'])->name('profile.structure.destroy');
    });

    Route::middleware('permission:teachers.view')->group(function () {
        Route::get('/guru-tendik', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/guru-tendik/tambah', [TeacherController::class, 'create'])->middleware('permission:teachers.create')->name('teachers.create');
        Route::post('/guru-tendik', [TeacherController::class, 'store'])->middleware('permission:teachers.create')->name('teachers.store');
        Route::get('/guru-tendik/{teacher}/edit', [TeacherController::class, 'edit'])->middleware('permission:teachers.update')->name('teachers.edit');
        Route::put('/guru-tendik/{teacher}', [TeacherController::class, 'update'])->middleware('permission:teachers.update')->name('teachers.update');
        Route::delete('/guru-tendik/{teacher}', [TeacherController::class, 'destroy'])->middleware('permission:teachers.delete')->name('teachers.destroy');
        Route::post('/guru-tendik/{teacher}/pulihkan', [TeacherController::class, 'restore'])->middleware('permission:teachers.delete')->name('teachers.restore');
    });

    Route::middleware('permission:announcements.view')->group(function () {
        Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/pengumuman/tambah', [AnnouncementController::class, 'create'])->middleware('permission:announcements.create')->name('announcements.create');
        Route::post('/pengumuman', [AnnouncementController::class, 'store'])->middleware('permission:announcements.create')->name('announcements.store');
        Route::get('/pengumuman/{announcement}/edit', [AnnouncementController::class, 'edit'])->middleware('permission:announcements.update')->name('announcements.edit');
        Route::put('/pengumuman/{announcement}', [AnnouncementController::class, 'update'])->middleware('permission:announcements.update')->name('announcements.update');
        Route::delete('/pengumuman/{announcement}', [AnnouncementController::class, 'destroy'])->middleware('permission:announcements.delete')->name('announcements.destroy');
    });

    Route::middleware('permission:events.view')->group(function () {
        Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
        Route::get('/agenda/tambah', [EventController::class, 'create'])->middleware('permission:events.create')->name('events.create');
        Route::post('/agenda', [EventController::class, 'store'])->middleware('permission:events.create')->name('events.store');
        Route::get('/agenda/{event}/edit', [EventController::class, 'edit'])->middleware('permission:events.update')->name('events.edit');
        Route::put('/agenda/{event}', [EventController::class, 'update'])->middleware('permission:events.update')->name('events.update');
        Route::delete('/agenda/{event}', [EventController::class, 'destroy'])->middleware('permission:events.delete')->name('events.destroy');
    });

    Route::middleware('permission:achievements.view')->group(function () {
        Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements.index');
        Route::get('/prestasi/tambah', [AchievementController::class, 'create'])->middleware('permission:achievements.create')->name('achievements.create');
        Route::post('/prestasi', [AchievementController::class, 'store'])->middleware('permission:achievements.create')->name('achievements.store');
        Route::get('/prestasi/{achievement}/edit', [AchievementController::class, 'edit'])->middleware('permission:achievements.update')->name('achievements.edit');
        Route::put('/prestasi/{achievement}', [AchievementController::class, 'update'])->middleware('permission:achievements.update')->name('achievements.update');
        Route::delete('/prestasi/{achievement}', [AchievementController::class, 'destroy'])->middleware('permission:achievements.delete')->name('achievements.destroy');
    });

    Route::middleware('permission:alumni.view')->group(function () {
        Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
        Route::get('/alumni/tambah', [AlumniController::class, 'create'])->middleware('permission:alumni.create')->name('alumni.create');
        Route::post('/alumni', [AlumniController::class, 'store'])->middleware('permission:alumni.create')->name('alumni.store');
        Route::get('/alumni/{alumnus}/edit', [AlumniController::class, 'edit'])->middleware('permission:alumni.update')->name('alumni.edit');
        Route::put('/alumni/{alumnus}', [AlumniController::class, 'update'])->middleware('permission:alumni.update')->name('alumni.update');
        Route::delete('/alumni/{alumnus}', [AlumniController::class, 'destroy'])->middleware('permission:alumni.delete')->name('alumni.destroy');
        Route::post('/alumni/registrasi/{submission}/setujui', [AlumniController::class, 'approve'])->middleware('permission:alumni.verify')->name('alumni.submissions.approve');
        Route::post('/alumni/registrasi/{submission}/tolak', [AlumniController::class, 'reject'])->middleware('permission:alumni.verify')->name('alumni.submissions.reject');
    });

    Route::get('/pengaturan', [SettingController::class, 'edit'])->middleware('permission:settings.manage')->name('settings.edit');
    Route::put('/pengaturan', [SettingController::class, 'update'])->middleware('permission:settings.manage')->name('settings.update');
});
