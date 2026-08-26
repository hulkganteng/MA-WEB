@props(['title' => 'Dashboard'])
<!DOCTYPE html>
<html lang="id" class="antialiased">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ $title }} — Admin</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body class="bg-slate-50" x-data="{ sidebar: false }">
@php
    $groups = [
        'Utama' => [['admin.dashboard','layout-dashboard','Dashboard','dashboard.view',[]]],
        'Konten' => [
            ['admin.posts.index','newspaper','Berita','posts.view',['type'=>'berita']],
            ['admin.posts.index','file-text','Artikel','articles.view',['type'=>'artikel']],
            ['admin.announcements.index','megaphone','Pengumuman','announcements.view',[],'admin.announcements.*'],
            ['admin.events.index','calendar-days','Agenda','events.view',[],'admin.events.*'],
            ['admin.pages.index','files','Halaman','pages.view',[]],
        ],
        'Profil' => [
            ['admin.profile.index','school','Profil Madrasah',['pages.view','structure.manage','settings.manage'],[]],
            ['admin.teachers.index','users','Guru & Tendik','teachers.view',[]],
        ],
        'Akademik' => [['admin.achievements.index','trophy','Prestasi','achievements.view',[],'admin.achievements.*']],
        'Alumni' => [['admin.alumni.index','graduation-cap','Kelola Alumni','alumni.view',[],'admin.alumni.*']],
        'Sistem' => [['admin.settings.edit','settings','Pengaturan website','settings.manage',[]]],
    ];
@endphp
<div class="min-h-dvh lg:grid lg:grid-cols-[16rem_1fr]">
    <div x-show="sidebar" x-cloak class="fixed inset-0 z-50 lg:hidden"><button type="button" aria-label="Tutup menu" class="absolute inset-0 bg-slate-950/40" @click="sidebar=false"></button><aside class="relative h-full w-64 bg-primary-950 text-white"><x-admin-sidebar :groups="$groups" /></aside></div>
    <aside class="hidden min-h-dvh bg-primary-950 text-white lg:block"><div class="sticky top-0 h-dvh"><x-admin-sidebar :groups="$groups" /></div></aside>
    <div class="min-w-0">
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between bg-white/90 px-4 ring-1 ring-slate-900/5 backdrop-blur sm:px-6 lg:px-8"><div class="flex min-w-0 items-center gap-3"><button type="button" class="relative rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" @click="sidebar=true" aria-label="Buka menu"><span class="absolute left-1/2 top-1/2 size-[max(100%,3rem)] -translate-x-1/2 -translate-y-1/2" aria-hidden="true"></span><x-icon name="menu" class="size-5" /></button><h1 class="truncate text-lg font-semibold text-slate-950">{{ $title }}</h1></div><div class="flex items-center gap-3"><a href="{{ route('home') }}" target="_blank" class="hidden font-medium text-slate-600 hover:text-primary-700 sm:inline">Lihat website</a><div class="hidden h-5 w-px bg-slate-900/10 sm:block"></div><a href="{{ route('admin.account.edit') }}" class="max-w-44 truncate text-sm font-medium text-slate-800 hover:text-primary-700">{{ auth()->user()->name }}</a></div></header>
        <main class="isolate p-4 sm:p-6 lg:p-8">{{ $slot }}</main>
    </div>
</div>
@if(session('flash'))<x-toast type="{{ session('flash.type','success') }}" message="{{ session('flash.message') }}" />@endif
@stack('scripts')
</body></html>
