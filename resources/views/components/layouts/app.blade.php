@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'robots' => 'index, follow',
    'type' => 'website',
    'schema' => null,
])

@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $siteTagline = setting('site.tagline', 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren');
    $defaultSeo = setting('seo.default_title', $siteName);
    $metaTitle = $title ? "{$title} — {$siteName}" : $defaultSeo;
    $metaDescription = $description ?: setting('seo.default_description', $siteTagline);
    $ogImage = $image ?: setting('seo.default_image');
    $canonicalUrl = $canonical ?: url()->current();
    $favicon = setting('site.favicon') ? asset('storage/'.setting('site.favicon')) : asset('storage/'.(setting('site.logo') ?? ''));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:type" content="{{ $type }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:alt" content="{{ $metaTitle }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if ($ogImage)
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    <link rel="icon" href="{{ $favicon }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $orgSchema = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'EducationalOrganization',
            'name' => $siteName,
            'slogan' => $siteTagline,
            'url' => url('/'),
            'email' => setting('contact.email'),
            'telephone' => setting('contact.phone'),
            'address' => ['@type' => 'PostalAddress', 'streetAddress' => setting('contact.address')],
        ]);
    @endphp
    <script type="application/ld+json">{!! $orgSchema !!}</script>
    @if ($schema)
        <script type="application/ld+json">{!! is_string($schema) ? $schema : json_encode($schema) !!}</script>
    @endif

    @stack('head')
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-primary-500 selection:text-white"
      x-data="{
          scrollY: 0,
          scrollProgress: 0,
          updateScroll() {
              this.scrollY = window.scrollY;
              const h = document.documentElement.scrollHeight - window.innerHeight;
              this.scrollProgress = h > 0 ? Math.min(100, Math.round((window.scrollY / h) * 100)) : 0;
          }
      }"
      @scroll.window="updateScroll()">

    <x-layouts.public.navbar />

    <main id="main" class="isolate">
        {{ $slot }}
    </main>

    <x-layouts.public.footer />

    {{-- Global Interactive Islamic & Accessibility Modals --}}

    {{-- 1. Jadwal Sholat Bungah Gresik Modal --}}
    <div x-show="$store.prayer.modalOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-md"
         @keydown.escape.window="$store.prayer.closeModal()"
         x-cloak>
        <div class="relative w-full max-w-lg overflow-hidden rounded-3xl border border-white/20 bg-primary-950 text-white shadow-2xl"
             @click.away="$store.prayer.closeModal()">
            <div class="absolute -right-16 -top-16 size-48 rounded-full bg-gold-500/15 blur-3xl"></div>
            <div class="absolute -left-16 -bottom-16 size-48 rounded-full bg-primary-500/20 blur-3xl"></div>

            <div class="relative p-6 sm:p-8">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-gold-400/20 text-gold-300">
                            <x-icon name="clock" class="size-5" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Jadwal Sholat Bungah Gresik</h3>
                            <p class="text-xs text-primary-200" x-text="$store.prayer.hijri"></p>
                        </div>
                    </div>
                    <button type="button" @click="$store.prayer.closeModal()"
                            class="rounded-full p-2 text-primary-300 transition hover:bg-white/10 hover:text-white"
                            aria-label="Tutup">
                        <x-icon name="x" class="size-5" />
                    </button>
                </div>

                {{-- Live Countdown Card --}}
                <div class="mt-6 rounded-2xl border border-primary-500/30 bg-primary-900/60 p-4 text-center backdrop-blur">
                    <p class="text-xs font-medium uppercase tracking-wider text-gold-300">Menuju Waktu Sholat Berikutnya</p>
                    <div class="mt-2 flex items-baseline justify-center gap-2">
                        <span class="text-2xl font-bold tracking-tight text-white" x-text="$store.prayer.nextPrayerName"></span>
                        <span class="font-mono text-3xl font-extrabold text-gradient-gold" x-text="$store.prayer.countdownText"></span>
                    </div>
                    <p class="mt-1 text-[11px] text-primary-200">Berdasarkan hisab akurat Kemenag RI untuk wilayah Bungah, Kab. Gresik (+2 menit ihtiyat)</p>
                </div>

                {{-- Prayer Schedule Grid --}}
                <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                    <template x-for="p in [
                        { name: 'Subuh', time: $store.prayer.times.subuh, icon: 'sunrise' },
                        { name: 'Terbit', time: $store.prayer.times.terbit, icon: 'sun' },
                        { name: 'Dzuhur', time: $store.prayer.times.dzuhur, icon: 'sun-medium' },
                        { name: 'Ashar', time: $store.prayer.times.ashar, icon: 'sunset' },
                        { name: 'Maghrib', time: $store.prayer.times.maghrib, icon: 'moon' },
                        { name: 'Isya\'', time: $store.prayer.times.isya, icon: 'sparkles' }
                    ]">
                        <div class="flex flex-col items-center rounded-xl p-3 text-center transition"
                             :class="$store.prayer.nextPrayerName === p.name ? 'border border-gold-400/50 bg-gold-500/15 shadow-glow-gold' : 'border border-white/5 bg-white/5'">
                            <span class="text-xs text-primary-200" x-text="p.name"></span>
                            <span class="mt-1 font-mono text-lg font-bold text-white" x-text="p.time"></span>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-4 text-xs text-primary-300">
                    <span>Yayasan Pondok Pesantren Qomaruddin</span>
                    <button type="button" @click="$store.prayer.closeModal()" class="font-medium text-gold-300 hover:text-gold-200">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Kalkulator Peminatan SPMB Quiz Modal --}}
    <div x-show="$store.spmbCalc.isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/75 backdrop-blur-md"
         @keydown.escape.window="$store.spmbCalc.close()"
         x-cloak>
        <div class="relative w-full max-w-2xl overflow-hidden rounded-3xl border border-slate-200 bg-white text-slate-900 shadow-2xl"
             @click.away="$store.spmbCalc.close()">
            <div class="bg-primary-950 p-6 text-white sm:p-7">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-gold-400 text-primary-950">
                            <x-icon name="sparkles" class="size-5" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold tracking-tight text-white">Simulasi Peminatan Santri Baru</h3>
                            <p class="text-xs text-primary-200">Temukan jurusan & program unggulan MA Assa'adah yang paling sesuai dengan bakatmu.</p>
                        </div>
                    </div>
                    <button type="button" @click="$store.spmbCalc.close()"
                            class="rounded-full p-2 text-primary-300 transition hover:bg-white/10 hover:text-white"
                            aria-label="Tutup">
                        <x-icon name="x" class="size-5" />
                    </button>
                </div>

                {{-- Progress Bar --}}
                <div class="mt-5" x-show="!$store.spmbCalc.result">
                    <div class="flex justify-between text-xs font-semibold text-primary-200">
                        <span>Pertanyaan <span x-text="$store.spmbCalc.step"></span> dari <span x-text="$store.spmbCalc.totalSteps"></span></span>
                        <span x-text="Math.round(($store.spmbCalc.step / $store.spmbCalc.totalSteps) * 100) + '%'"></span>
                    </div>
                    <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-white/10">
                        <div class="h-full rounded-full bg-gradient-to-r from-gold-400 to-primary-400 transition-all duration-300"
                             :style="'width: ' + (($store.spmbCalc.step / $store.spmbCalc.totalSteps) * 100) + '%'"></div>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                {{-- Question Phase --}}
                <div x-show="!$store.spmbCalc.result">
                    <template x-for="(q, qIndex) in $store.spmbCalc.questions">
                        <div x-show="$store.spmbCalc.step === (qIndex + 1)" x-transition>
                            <h4 class="text-lg font-bold text-slate-900 sm:text-xl" x-text="q.title"></h4>
                            <p class="mt-1 text-sm text-slate-500" x-text="q.subtitle"></p>

                            <div class="mt-6 grid gap-3">
                                <template x-for="(opt, oIndex) in q.options">
                                    <button type="button"
                                            @click="$store.spmbCalc.chooseOption(opt.program)"
                                            class="group flex items-center justify-between rounded-2xl border border-slate-200 p-4 text-left transition hover:border-primary-600 hover:bg-primary-50/70 hover:shadow-soft">
                                        <div class="flex items-center gap-3.5">
                                            <span class="flex size-9 items-center justify-center rounded-xl bg-slate-100 text-slate-700 transition group-hover:bg-primary-600 group-hover:text-white font-bold text-sm"
                                                  x-text="String.fromCharCode(65 + oIndex)"></span>
                                            <span class="text-sm font-semibold text-slate-800 group-hover:text-primary-950" x-text="opt.label"></span>
                                        </div>
                                        <x-icon name="arrow-right" class="size-4 shrink-0 text-slate-400 transition group-hover:translate-x-1 group-hover:text-primary-600" />
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Result Phase --}}
                <div x-show="$store.spmbCalc.result" x-transition>
                    <div class="rounded-2xl border border-primary-500/30 bg-primary-50/80 p-6">
                        <div class="flex items-center justify-between gap-4">
                            <span class="rounded-full bg-primary-600 px-3 py-1 text-xs font-bold text-white uppercase tracking-wider"
                                  x-text="$store.spmbCalc.result?.category"></span>
                            <span class="rounded-full bg-gold-400/30 px-3 py-1 text-xs font-bold text-gold-950"
                                  x-text="$store.spmbCalc.result?.badge"></span>
                        </div>
                        <h4 class="mt-3 text-2xl font-extrabold text-primary-950" x-text="$store.spmbCalc.result?.title"></h4>
                        <p class="mt-2 text-sm leading-relaxed text-slate-700" x-text="$store.spmbCalc.result?.description"></p>

                        <div class="mt-5 border-t border-primary-200/60 pt-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-primary-900">Keunggulan & Fokus Pembelajaran:</p>
                            <ul class="mt-2 grid gap-1.5 sm:grid-cols-2 text-xs font-medium text-slate-700">
                                <template x-for="item in ($store.spmbCalc.result?.highlights || [])">
                                    <li class="flex items-center gap-2">
                                        <x-icon name="check-circle-2" class="size-4 shrink-0 text-primary-600" />
                                        <span x-text="item"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <button type="button" @click="$store.spmbCalc.reset()"
                                class="btn-outline">
                            <x-icon name="rotate-ccw" class="size-4" /> Ulangi Simulasi
                        </button>
                        <a :href="$store.spmbCalc.result?.actionUrl" target="_blank" rel="noopener"
                           class="btn-gold !bg-gold-500 hover:!bg-gold-400 font-bold">
                            <x-icon name="message-circle" class="size-4" /> Konsultasi & Daftar via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Command Palette Modal (Ctrl+K) --}}
    <div x-show="$store.cmdPalette.isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-16 sm:pt-24 bg-slate-950/70 backdrop-blur-md"
         @keydown.escape.window="$store.cmdPalette.close()"
         x-cloak>
        <div class="relative w-full max-w-xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl"
             @click.away="$store.cmdPalette.close()">
            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4">
                <x-icon name="search" class="size-5 text-slate-400" />
                <input id="cmd-palette-input"
                       type="text"
                       x-model="$store.cmdPalette.searchQuery"
                       placeholder="Ketik untuk mencari halaman, program, guru, dokumen..."
                       class="w-full bg-transparent text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none"
                       autocomplete="off">
                <kbd class="hidden sm:inline-block rounded bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-500 border border-slate-200">ESC</kbd>
            </div>

            <div class="max-h-80 overflow-y-auto p-2">
                <template x-for="item in $store.cmdPalette.filteredItems">
                    <a :href="item.url"
                       @click="$store.cmdPalette.close()"
                       class="flex items-center justify-between rounded-xl px-4 py-3 text-sm text-slate-700 transition hover:bg-primary-50 hover:text-primary-900">
                        <div class="flex items-center gap-3">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-primary-100 text-primary-700">
                                <x-icon name="compass" class="size-4" />
                            </span>
                            <span class="font-medium" x-text="item.title"></span>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[11px] font-semibold text-slate-500" x-text="item.category"></span>
                    </a>
                </template>
                <div x-show="$store.cmdPalette.filteredItems.length === 0" class="p-8 text-center text-sm text-slate-500">
                    Tidak ada hasil untuk "<span x-text="$store.cmdPalette.searchQuery"></span>".
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50 px-5 py-3 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-slate-700">Pintasan Cepat:</span>
                    <span>Tekan <kbd class="rounded bg-white px-1.5 py-0.5 text-[10px] font-mono border">Ctrl</kbd> + <kbd class="rounded bg-white px-1.5 py-0.5 text-[10px] font-mono border">K</kbd></span>
                </div>
                <button type="button" @click="$store.spmbCalc.open(); $store.cmdPalette.close()" class="font-medium text-primary-700 hover:underline">
                    Simulasi Peminatan SPMB &rarr;
                </button>
            </div>
        </div>
    </div>

    {{-- 4. Floating Action Hub (Bottom Right) --}}
    <aside aria-label="Aksi Cepat" class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-3" x-data="{ expanded: false }">
        {{-- Expandable action items --}}
        <div x-show="expanded"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-3 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-3 scale-95"
             class="flex flex-col items-end gap-2.5"
             x-cloak>

            {{-- SPMB Calculator Trigger --}}
            <button type="button"
                    @click="$store.spmbCalc.open(); expanded = false"
                    class="group flex items-center gap-2.5 rounded-full border border-gold-400/40 bg-primary-950 px-4 py-2 text-xs font-semibold text-white shadow-lift transition hover:bg-primary-900">
                <span class="text-gold-300">Simulasi Jurusan SPMB</span>
                <span class="flex size-7 items-center justify-center rounded-full bg-gold-400 text-primary-950">
                    <x-icon name="sparkles" class="size-3.5" />
                </span>
            </button>

            {{-- Prayer Times Modal Trigger --}}
            <button type="button"
                    @click="$store.prayer.openModal(); expanded = false"
                    class="group flex items-center gap-2.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-800 shadow-soft transition hover:border-primary-500 hover:text-primary-700">
                <span>Jadwal Sholat Bungah</span>
                <span class="flex size-7 items-center justify-center rounded-full bg-primary-50 text-primary-700">
                    <x-icon name="clock" class="size-3.5" />
                </span>
            </button>

            {{-- Mars & Murottal Audio Player Trigger --}}
            <button type="button"
                    @click="$store.audioPlayer.isOpen = !$store.audioPlayer.isOpen; expanded = false"
                    class="group flex items-center gap-2.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-800 shadow-soft transition hover:border-primary-500 hover:text-primary-700">
                <span>Mars & Tilawah Santri</span>
                <span class="flex size-7 items-center justify-center rounded-full bg-gold-50 text-gold-700">
                    <x-icon name="music" class="size-3.5" />
                </span>
            </button>

            {{-- Accessibility Font Toggle --}}
            <button type="button"
                    @click="$store.accessibility.toggleFontSize()"
                    class="group flex items-center gap-2.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-800 shadow-soft transition hover:border-primary-500 hover:text-primary-700">
                <span x-text="$store.accessibility.isLargeFont ? 'Ukuran Huruf Normal' : 'Ukuran Huruf Besar'"></span>
                <span class="flex size-7 items-center justify-center rounded-full bg-slate-100 font-bold text-xs text-slate-700">
                    A<span class="text-[10px]">+</span>
                </span>
            </button>

            {{-- WhatsApp Hotline Direct --}}
            @php
                $waNum = setting('contact.whatsapp') ?: setting('whatsapp.number', '081234567890');
                $waMsg = rawurlencode(setting('whatsapp.message', 'Assalamualaikum, saya ingin bertanya tentang MA Ma\'arif NU Assa\'adah Bungah Gresik.'));
            @endphp
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNum) }}?text={{ $waMsg }}"
               target="_blank" rel="noopener"
               class="group flex items-center gap-2.5 rounded-full border border-emerald-500/40 bg-[#25D366] px-4 py-2 text-xs font-semibold text-white shadow-lift transition hover:brightness-105">
                <span>Hotline PPDB & Layanan</span>
                <span class="flex size-7 items-center justify-center rounded-full bg-white/20 text-white">
                    <x-icon name="message-circle" class="size-3.5" />
                </span>
            </a>
        </div>

        {{-- Main Hub Trigger Button & Scroll Progress Ring --}}
        <div class="flex items-center gap-2">
            {{-- Scroll to top button (visible when scrolled) --}}
            <button type="button"
                    x-show="scrollY > 300"
                    x-transition
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="relative flex size-12 items-center justify-center rounded-full bg-white text-slate-700 shadow-lift border border-slate-200 transition hover:bg-primary-50 hover:text-primary-700"
                    aria-label="Kembali ke atas">
                <svg class="size-12 -rotate-90 text-primary-600" viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="20" fill="none" stroke="#e2e8f0" stroke-width="3" />
                    <circle cx="24" cy="24" r="20" fill="none" stroke="currentColor" stroke-width="3"
                            stroke-linecap="round"
                            :stroke-dasharray="125.6"
                            :stroke-dashoffset="125.6 - (125.6 * scrollProgress) / 100" />
                </svg>
                <x-icon name="arrow-up" class="absolute size-4" />
            </button>

            {{-- Floating Menu Toggle --}}
            <button type="button"
                    @click="expanded = !expanded"
                    class="relative flex size-14 items-center justify-center rounded-full bg-primary-700 text-white shadow-lift transition duration-300 hover:scale-105 hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-500/30"
                    :class="expanded ? 'rotate-45 !bg-slate-900' : ''"
                    aria-label="Pusat Aksi Cepat">
                <span class="absolute -top-1 -right-1 flex size-3.5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold-400 opacity-75"></span>
                    <span class="relative inline-flex size-3.5 rounded-full bg-gold-400"></span>
                </span>
                <x-icon name="plus" class="size-6 transition-transform duration-300" x-show="expanded" />
                <x-icon name="sparkles" class="size-6 transition-transform duration-300" x-show="!expanded" />
    </aside>

    {{-- Docked Islamic Audio Player (Bottom Left) --}}
    <div x-show="$store.audioPlayer.isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-x-6 scale-95"
         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-x-6 scale-95"
         class="fixed bottom-6 left-6 z-40 w-80 sm:w-96 rounded-3xl border border-gold-400/30 bg-slate-950/95 p-4 text-white shadow-2xl backdrop-blur-xl"
         x-cloak>
        <div class="flex items-center justify-between border-b border-white/10 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="flex size-8 items-center justify-center rounded-xl bg-gold-500/20 text-gold-400">
                    <x-icon name="radio" class="size-4" />
                </span>
                <div class="min-w-0">
                    <h4 class="text-xs font-bold text-white leading-none truncate" x-text="$store.audioPlayer.currentTrack.title"></h4>
                    <p class="text-[10px] text-slate-400 mt-0.5 truncate" x-text="$store.audioPlayer.currentTrack.subtitle"></p>
                </div>
            </div>
            <button type="button" @click="$store.audioPlayer.isOpen = false"
                    class="flex size-6 items-center justify-center rounded-full text-slate-400 hover:text-white transition">
                <x-icon name="x" class="size-4" />
            </button>
        </div>

        <div class="mt-3 flex items-center justify-between gap-3">
            {{-- Equalizer Visualizer --}}
            <div class="flex items-end gap-1 h-5 px-1">
                <span class="equalizer-bar bg-emerald-400" :style="$store.audioPlayer.isPlaying ? '' : 'animation: none; height: 4px'"></span>
                <span class="equalizer-bar bg-gold-400" :style="$store.audioPlayer.isPlaying ? '' : 'animation: none; height: 4px'"></span>
                <span class="equalizer-bar bg-emerald-300" :style="$store.audioPlayer.isPlaying ? '' : 'animation: none; height: 4px'"></span>
                <span class="equalizer-bar bg-gold-300" :style="$store.audioPlayer.isPlaying ? '' : 'animation: none; height: 4px'"></span>
            </div>

            {{-- Playback Controls --}}
            <div class="flex items-center gap-2">
                <button type="button" @click="$store.audioPlayer.prevTrack()" class="p-1 text-slate-300 hover:text-white transition" title="Sebelumnya">
                    <x-icon name="skip-back" class="size-4" />
                </button>
                <button type="button" @click="$store.audioPlayer.togglePlay()"
                        class="flex size-8 items-center justify-center rounded-full bg-gold-500 text-slate-950 font-bold hover:bg-gold-400 transition"
                        :title="$store.audioPlayer.isPlaying ? 'Jeda' : 'Putar'">
                    <x-icon name="pause" class="size-4" x-show="$store.audioPlayer.isPlaying" />
                    <x-icon name="play" class="size-4 ml-0.5" x-show="!$store.audioPlayer.isPlaying" />
                </button>
                <button type="button" @click="$store.audioPlayer.nextTrack()" class="p-1 text-slate-300 hover:text-white transition" title="Berikutnya">
                    <x-icon name="skip-forward" class="size-4" />
                </button>
            </div>

            <span class="rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold text-emerald-300 border border-emerald-500/30 shrink-0"
                  x-text="$store.audioPlayer.currentTrack.category"></span>
        </div>
    </div>

    @if (session('flash'))
        <x-toast type="{{ session('flash.type', 'success') }}" message="{{ session('flash.message') }}" />
    @endif

    @stack('scripts')
</body>
</html>

