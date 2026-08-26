<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrganizationMemberController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PrincipalProfileController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
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

    Route::get('/pengaturan', [SettingController::class, 'edit'])->middleware('permission:settings.manage')->name('settings.edit');
    Route::put('/pengaturan', [SettingController::class, 'update'])->middleware('permission:settings.manage')->name('settings.update');
});
