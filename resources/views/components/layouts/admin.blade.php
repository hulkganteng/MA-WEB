@props(['title' => 'Dashboard'])
<!DOCTYPE html>
<html lang="id" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Admin MA Assa'adah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="admin-shell bg-slate-50 font-sans text-slate-800 antialiased min-h-dvh overflow-x-hidden"
    x-effect="document.body.style.overflow = mobileOpen ? 'hidden' : ''"
      x-data="{
          mobileOpen: false,
          desktopCollapsed: localStorage.getItem('admin_sidebar_collapsed') === 'true',
          toggleDesktop() {
              this.desktopCollapsed = !this.desktopCollapsed;
              localStorage.setItem('admin_sidebar_collapsed', this.desktopCollapsed);
          },
          toggleMobile() {
              this.mobileOpen = !this.mobileOpen;
          }
      }">
@php
    $groups = [
        'Utama' => [
            ['admin.dashboard', 'layout-dashboard', 'Dashboard', 'dashboard.view', []],
        ],
        'Konten' => [
            ['admin.hero-slides.index', 'gallery-horizontal', 'Hero Slider / Banner', ['pages.view', 'settings.manage'], [], 'admin.hero-slides.*'],
            ['admin.posts.index', 'newspaper', 'Berita', 'posts.view', ['type' => 'berita']],
            ['admin.posts.index', 'file-text', 'Artikel', 'articles.view', ['type' => 'artikel']],
            ['admin.announcements.index', 'megaphone', 'Pengumuman', 'announcements.view', [], 'admin.announcements.*'],
            ['admin.events.index', 'calendar-days', 'Agenda Kegiatan', 'events.view', [], 'admin.events.*'],
            ['admin.pages.index', 'files', 'Halaman Statis', 'pages.view', []],
        ],
        'Akademik' => [
            ['admin.programs.index', 'book-marked', 'Program / Jurusan', 'programs.view', [], 'admin.programs.*'],
            ['admin.curriculums.index', 'book-open', 'Kurikulum', 'curriculums.view', [], 'admin.curriculums.*'],
            ['admin.calendars.index', 'calendar-range', 'Kalender Akademik', 'calendars.view', [], 'admin.calendars.*'],
            ['admin.achievements.index', 'trophy', 'Prestasi Santri', 'achievements.view', [], 'admin.achievements.*'],
        ],
        'Kesiswaan' => [
            ['admin.extracurriculars.index', 'activity', 'Ekstrakurikuler', 'extracurriculars.view', [], 'admin.extracurriculars.*'],
            ['admin.organizations.index', 'flag', 'Organisasi Siswa', 'organizations.view', [], 'admin.organizations.*'],
        ],
        'Profil & Lembaga' => [
            ['admin.profile.index', 'school', 'Profil & Struktur', ['pages.view', 'structure.manage', 'settings.manage'], []],
            ['admin.teachers.index', 'users', 'Guru & Tendik', 'teachers.view', [], 'admin.teachers.*'],
            ['admin.facilities.index', 'building', 'Sarana & Prasarana', 'facilities.view', [], 'admin.facilities.*'],
        ],
        'Galeri & Media' => [
            ['admin.gallery.albums.index', 'images', 'Galeri Foto', 'gallery.view', [], 'admin.gallery.albums.*'],
            ['admin.gallery.videos.index', 'video', 'Galeri Video', 'videos.view', [], 'admin.gallery.videos.*'],
        ],
        'Alumni' => [
            ['admin.alumni.index', 'graduation-cap', 'Kelola Alumni', 'alumni.view', [], 'admin.alumni.*'],
        ],
        'Sistem' => [
            ['admin.settings.edit', 'settings', 'Pengaturan Website', 'settings.manage', []],
            ['admin.backups.index', 'database-backup', 'Backup Data', 'settings.manage', [], 'admin.backups.*'],
        ],
    ];
@endphp

<div class="flex min-h-dvh w-full bg-slate-50">
    <!-- Mobile Sidebar Drawer -->
    <div x-show="mobileOpen"
         x-cloak
         class="fixed inset-0 z-50 lg:hidden"
         role="dialog"
            aria-modal="true"
            aria-label="Menu navigasi admin"
            @keydown.escape.window="mobileOpen = false">
        <!-- Backdrop -->
        <div x-show="mobileOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm"
             @click="mobileOpen = false"
             aria-hidden="true"></div>

        <!-- Mobile Drawer content -->
        <div class="fixed inset-y-0 left-0 flex max-w-full">
            <div x-show="mobileOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex h-full w-72 max-w-[85vw] flex-1 flex-col shadow-2xl">
                <aside class="h-full w-full bg-primary-950 text-white">
                    <x-admin-sidebar :groups="$groups" />
                </aside>
            </div>
        </div>
    </div>

    <!-- Desktop Sticky Sidebar (Collapsible with Margin Sliding Transition) -->
    <aside :class="desktopCollapsed ? '-ml-72' : 'ml-0'"
           class="hidden lg:flex flex-col w-72 shrink-0 min-h-dvh bg-primary-950 text-white border-r border-emerald-950/30 transition-[margin] duration-300 ease-in-out z-40">
        <div class="sticky top-0 h-dvh w-72 flex flex-col overflow-hidden">
            <x-admin-sidebar :groups="$groups" />
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex min-w-0 flex-1 flex-col w-full">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center justify-between border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-md sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                <!-- Sidebar Toggle Button (Desktop & Mobile) -->
                <button type="button"
                        @click="window.innerWidth >= 1024 ? toggleDesktop() : toggleMobile()"
                        class="flex size-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 hover:text-primary-700 shadow-xs transition active:scale-95 cursor-pointer"
                        :title="desktopCollapsed ? 'Tampilkan Sidebar (Unhide)' : 'Sembunyikan Sidebar (Hide)'"
                        aria-label="Toggle Sidebar">
                    <x-icon name="panel-left" class="size-5" />
                </button>

                <div class="min-w-0 flex items-center gap-2">
                    <h1 class="truncate text-lg font-bold text-slate-900 tracking-tight">{{ $title }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('home') }}"
                   target="_blank"
                   class="hidden sm:inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 hover:border-primary-300 hover:bg-primary-50 hover:text-primary-800 transition shadow-2xs">
                    <x-icon name="globe" class="size-3.5 text-primary-600" />
                    <span>Lihat Website</span>
                    <x-icon name="arrow-up-right" class="size-3 text-slate-400" />
                </a>

                <div class="hidden h-5 w-px bg-slate-200 sm:block"></div>

                <!-- User Profile Chip -->
                <a href="{{ route('admin.account.edit') }}"
                   class="flex items-center gap-2 rounded-xl border border-slate-200/80 bg-white p-1.5 pr-3 hover:border-primary-300 hover:bg-primary-50/50 transition shadow-2xs group">
                    <div class="flex size-7 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-primary-600 to-emerald-700 text-xs font-bold text-white shadow-2xs">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                    </div>
                    <span class="max-w-36 truncate text-xs font-semibold text-slate-800 group-hover:text-primary-700 transition">
                        {{ auth()->user()->name }}
                    </span>
                </a>
            </div>
        </header>

        <!-- Main Body Slot -->
        <main class="isolate min-w-0 flex-1 overflow-x-hidden p-4 sm:p-6 lg:p-8 w-full">
            {{ $slot }}
        </main>
    </div>
</div>

@if(session('flash'))
    <x-toast type="{{ session('flash.type', 'success') }}" message="{{ session('flash.message') }}" />
@endif

@stack('scripts')
</body>
</html>
