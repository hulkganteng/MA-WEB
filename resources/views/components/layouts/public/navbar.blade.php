@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $siteTagline = setting('site.tagline', 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren');
    $logo = setting('site.logo');
    $phone = setting('contact.phone');
    $email = setting('contact.email');
    $menus = \App\Models\Menu::where('location', 'main')
        ->where('is_active', true)
        ->whereNull('parent_id')
        ->with(['children' => function($q) {
            $q->where('is_active', true)->orderBy('order');
        }])
        ->orderBy('order')
        ->get();
@endphp

<header class="sticky top-0 z-40 w-full transition-all duration-300"
        x-data="{
            isScrolled: false,
            mobileOpen: false,
            init() {
                this.isScrolled = window.scrollY > 20;
                window.addEventListener('scroll', () => {
                    this.isScrolled = window.scrollY > 20;
                }, { passive: true });
            }
        }"
        x-effect="document.body.style.overflow = mobileOpen ? 'hidden' : ''">

    {{-- Top Utility Bar: Islamic Date & Live Prayer Times --}}
    <div class="border-b border-primary-600/30 bg-primary-800 text-white text-[10px] sm:text-xs py-2 sm:py-1.5 px-3 sm:px-4">
        <div class="container-app flex flex-wrap items-center justify-between gap-2 sm:gap-3">
            {{-- Left: Live Hijri Date & Masehi Date --}}
            <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                <span class="flex items-center gap-1 font-semibold text-gold-300 truncate">
                    <x-icon name="calendar" class="size-2.5 sm:size-3 text-gold-400 shrink-0" />
                    <span x-text="$store.prayer.hijri" class="truncate">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </span>
                <span class="hidden sm:inline text-primary-300">·</span>
                <span class="hidden md:inline text-primary-100 truncate" x-text="$store.prayer.masehi">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
            </div>

            {{-- Right: Live Prayer Times Countdown Badge --}}
            <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">
                <button type="button"
                        @click="$store.prayer.openModal()"
                        class="group flex items-center gap-1 sm:gap-1.5 rounded-full border border-gold-400/40 bg-gold-400/10 px-1.5 sm:px-2 py-0.5 text-[10px] sm:text-xs text-gold-200 transition hover:border-gold-400 hover:bg-gold-400/20 cursor-pointer whitespace-nowrap"
                        title="Lihat Jadwal Sholat Lengkap">
                    <span class="relative flex size-1">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold-400 opacity-75"></span>
                        <span class="relative inline-flex size-1 rounded-full bg-gold-400"></span>
                    </span>
                    <span class="hidden sm:inline">
                        <span class="font-medium text-white/90" x-text="$store.prayer.nextPrayerName">Dzuhur</span>:
                        <span class="font-mono font-bold text-gold-300" x-text="$store.prayer.countdownText">--:--:--</span>
                    </span>
                    <span class="sm:hidden font-mono font-bold text-gold-300" x-text="$store.prayer.countdownText">--:--:--</span>
                    <x-icon name="chevron-right" class="size-2 sm:size-2.5 text-gold-400 shrink-0" />
                </button>

                @if ($phone)
                    <a href="tel:{{ preg_replace('/[^\+0-9]/', '', $phone) }}" class="hidden lg:flex items-center gap-1 text-primary-100 hover:text-white transition pl-2 border-l border-primary-700">
                        <x-icon name="phone" class="size-3 text-gold-400 shrink-0" />
                        <span>{{ $phone }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Navbar --}}
    <nav class="relative border-b transition-all duration-300"
         :class="isScrolled
            ? 'border-slate-200/90 bg-white/95 shadow-soft backdrop-blur-xl'
            : 'border-slate-200/60 bg-white/90 backdrop-blur-lg'">

        <div class="container-app flex h-14 sm:h-16 items-center justify-between gap-2 sm:gap-3">
            {{-- Brand Logo & Identity (Compact & Clean) --}}
            <a href="{{ route('home') }}" class="group flex items-center gap-1.5 sm:gap-2.5 shrink-0 min-w-0">
                <div class="relative size-9 sm:size-10 shrink-0 transition duration-300 group-hover:scale-105">
                    @if ($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }}" class="size-full object-cover rounded-lg">
                    @else
                        <div class="flex size-full items-center justify-center rounded-lg bg-primary-50">
                            <span class="font-extrabold text-xs sm:text-sm text-gold-300">MA</span>
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 flex size-3 sm:size-3.5 items-center justify-center rounded-full bg-gold-400 text-[7px] sm:text-[8px] font-bold text-[#1F1A17] shadow-md">
                        ✓
                    </div>
                </div>

                <div class="min-w-0 hidden sm:block">
                    <span class="block text-sm sm:text-base font-extrabold tracking-tight text-[#1F1A17] group-hover:text-primary-700 transition leading-tight line-clamp-1">
                        {{ $siteName }}
                    </span>
                    <span class="hidden lg:flex items-center gap-1.5 text-xs text-slate-500 leading-tight">
                        <span class="truncate">YPP. Qomaruddin · Bungah</span>
                        <span class="rounded bg-gold-100 px-1 py-0.5 text-[8px] font-bold text-[#1F1A17] ring-1 ring-gold-400/40 uppercase shrink-0">A</span>
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation Menu (Streamlined spacing) --}}
            <div class="hidden xl:flex min-w-0 items-center gap-0.5">
                <ul class="flex items-center gap-0.5">
                    @foreach ($menus as $item)
                        @php
                            $hasChildren = $item->children && $item->children->count() > 0;
                            $menuUrl = $item->url ? (str_starts_with($item->url, 'http') ? $item->url : url($item->url)) : '#';
                            $isActive = $item->url && request()->is(ltrim($item->url, '/') . '*');
                        @endphp
                        <li class="relative"
                            x-data="{ open: false }"
                            @mouseenter="open = true"
                            @mouseleave="open = false"
                            @click.outside="open = false">

                            <a href="{{ $menuUrl }}"
                                target="{{ $item->target ?? '_self' }}"
                                class="flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs xl:text-sm font-semibold transition {{ $isActive ? 'bg-primary-50 text-primary-700 font-bold' : 'text-[#1F1A17] hover:bg-primary-50/70 hover:text-primary-700' }}"
                                :class="open ? 'bg-primary-50 text-primary-700' : ''">
                                <span>{{ $item->name }}</span>
                                @if ($hasChildren)
                                    <x-icon name="chevron-down" class="size-3 transition-transform duration-200 text-slate-400"
                                            x-bind:class="{ 'rotate-180 text-primary-600': open }" />
                                @endif
                            </a>

                            {{-- Dropdown Panel --}}
                            @if ($hasChildren)
                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2"
                                     class="absolute left-0 top-full pt-2 w-60 z-50"
                                     x-cloak>
                                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-1.5 shadow-lift backdrop-blur-xl">
                                        @foreach ($item->children as $child)
                                            @php
                                                $isSpmbCalc = ($child->url === '#spmb-simulasi' || str_contains($child->name, 'Simulasi'));
                                                $childUrl = $child->url ? (str_starts_with($child->url, 'http') ? $child->url : url($child->url)) : '#';
                                                $isChildActive = $child->url && request()->is(ltrim($child->url, '/') . '*');
                                            @endphp
                                            @if ($isSpmbCalc)
                                                <button type="button"
                                                        @click="$store.spmbCalc.open(); open = false"
                                                        class="group flex w-full items-center justify-between rounded-xl px-3 py-2 text-xs font-semibold text-gold-700 hover:bg-gold-50 hover:text-gold-900 cursor-pointer transition">
                                                    <span class="flex items-center gap-1.5">
                                                        <x-icon name="sparkles" class="size-3.5 text-gold-500" />
                                                        <span>{{ $child->name }}</span>
                                                    </span>
                                                    <span class="rounded bg-gold-100 px-1 py-0.5 text-[9px] font-bold text-gold-800 uppercase">Kuis</span>
                                                </button>
                                            @else
                                                <a href="{{ $childUrl }}"
                                                   target="{{ $child->target ?? '_self' }}"
                                                   class="group flex items-center justify-between rounded-xl px-3 py-2 text-xs transition {{ $isChildActive ? 'bg-primary-50 text-primary-900 font-bold' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-900 font-medium' }}">
                                                    <span>{{ $child->name }}</span>
                                                    <x-icon name="arrow-right" class="size-3 text-slate-300 opacity-0 transition group-hover:opacity-100 group-hover:translate-x-0.5 group-hover:text-primary-600" />
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Right Actions: Command Search, SPMB Button & Mobile Hamburger --}}
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                {{-- Quick Command Search Trigger --}}
                <button type="button"
                        @click="$store.cmdPalette.open()"
                        class="hidden sm:flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50/90 px-2 sm:px-2.5 py-1.5 sm:py-2 text-xs text-slate-600 transition hover:border-primary-500 hover:bg-white hover:text-primary-700 cursor-pointer"
                        title="Pencarian Cepat (Ctrl+K)"
                        aria-label="Buka Pencarian Cepat">
                    <x-icon name="search" class="size-4 text-slate-500" />
                    <span class="hidden md:inline text-xs">Cari...</span>
                    <kbd class="hidden lg:inline-flex items-center gap-0.5 rounded bg-white px-1.5 py-0.5 font-mono text-[8px] text-slate-400 border border-slate-200">
                        <span>Ctrl K</span>
                    </kbd>
                </button>

                {{-- Mobile Search Button --}}
                <button type="button"
                        @click="$store.cmdPalette.open()"
                        class="sm:hidden flex size-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50/90 text-slate-600 hover:border-primary-500 hover:bg-white hover:text-primary-700 cursor-pointer transition"
                        title="Pencarian Cepat"
                        aria-label="Cari">
                    <x-icon name="search" class="size-4" />
                </button>

                {{-- Direct SPMB Registration External Button (Tablet & Desktop) --}}
                <a href="https://lynk.id/spmb-madah"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn-primary hidden sm:inline-flex items-center gap-1 sm:gap-1.5 !px-2.5 sm:!px-3.5 !py-1.5 sm:!py-2 text-xs font-bold shadow-soft transition hover:scale-105 shrink-0">
                    <x-icon name="sparkles" class="size-3 sm:size-3.5 text-gold-300" />
                    <span>Daftar SPMB</span>
                    <x-icon name="external-link" class="size-3 sm:size-3.5 opacity-80 hidden sm:inline" />
                </a>

                {{-- Mobile Menu Hamburger (Prominent, High-Contrast & Safe Spaced) --}}
                <button type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="flex size-9 sm:size-10 items-center justify-center rounded-lg bg-primary-50 border border-primary-200/90 text-primary-800 hover:bg-primary-100 active:scale-95 shadow-sm transition xl:hidden cursor-pointer shrink-0"
                        :class="mobileOpen ? '!bg-primary-700 !text-white !border-primary-700' : ''"
                        aria-label="Menu Utama">
                    <x-icon name="menu" class="size-4.5 sm:size-5" x-show="!mobileOpen" />
                    <x-icon name="x" class="size-4.5 sm:size-5" x-show="mobileOpen" x-cloak />
                </button>
            </div>
        </div>

        {{-- Mobile Drawer Navigation --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="max-h-[calc(100dvh-3.5rem)] sm:max-h-[calc(100dvh-4rem)] overscroll-contain overflow-y-auto border-t border-slate-200 bg-white/95 shadow-2xl backdrop-blur-xl xl:hidden"
             x-cloak>
            <div class="container-app py-3 sm:py-4 space-y-2.5 sm:space-y-3">
                {{-- Quick Mobile Info Banner --}}
                <div class="rounded-xl sm:rounded-2xl border border-primary-500/20 bg-primary-50 p-3 sm:p-4">
                    <div class="flex items-center justify-between text-xs sm:text-sm font-semibold text-primary-900">
                        <span x-text="$store.prayer.hijri" class="line-clamp-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        <button type="button" @click="$store.prayer.openModal(); mobileOpen = false" class="text-primary-700 font-bold underline cursor-pointer whitespace-nowrap text-xs sm:text-sm">
                            Jadwal &rarr;
                        </button>
                    </div>
                </div>

                {{-- Navigation Items --}}
                <ul class="space-y-0.5 sm:space-y-1 divide-y divide-slate-100">
                    @foreach ($menus as $item)
                        @php
                            $hasChildren = $item->children && $item->children->count() > 0;
                            $menuUrl = $item->url ? (str_starts_with($item->url, 'http') ? $item->url : url($item->url)) : '#';
                        @endphp
                        <li class="pt-1 sm:pt-1.5">
                            @if ($hasChildren)
                                <div x-data="{ expanded: false }">
                                    <button type="button" @click="expanded = !expanded"
                                            class="flex w-full items-center justify-between rounded-lg sm:rounded-xl px-2.5 sm:px-3 py-2 sm:py-2.5 text-sm sm:text-base font-semibold text-slate-800 hover:bg-slate-50 cursor-pointer transition">
                                        <span>{{ $item->name }}</span>
                                        <x-icon name="chevron-down" class="size-4 transition-transform duration-200 text-slate-400"
                                                x-bind:class="{ 'rotate-180 text-primary-600': expanded }" />
                                    </button>
                                    <div x-show="expanded" x-transition class="ml-2 sm:ml-4 mt-1 space-y-0.5 sm:space-y-1 border-l-2 border-primary-100 pl-2 sm:pl-3">
                                        @foreach ($item->children as $child)
                                            @php
                                                $isSpmbCalc = ($child->url === '#spmb-simulasi' || str_contains($child->name, 'Simulasi'));
                                                $childUrl = $child->url ? (str_starts_with($child->url, 'http') ? $child->url : url($child->url)) : '#';
                                            @endphp
                                            @if ($isSpmbCalc)
                                                <button type="button"
                                                        @click="$store.spmbCalc.open(); mobileOpen = false"
                                                        class="flex w-full items-center justify-between rounded-lg px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gold-700 hover:bg-gold-50 cursor-pointer transition">
                                                    <span class="flex items-center gap-1.5 sm:gap-2">
                                                        <x-icon name="sparkles" class="size-3 sm:size-3.5 text-gold-500 shrink-0" />
                                                        <span>{{ $child->name }}</span>
                                                    </span>
                                                    <span class="rounded bg-gold-100 px-1.5 py-0.5 text-[8px] sm:text-xs font-bold text-gold-800 uppercase shrink-0">SPMB</span>
                                                </button>
                                            @else
                                                <a href="{{ $childUrl }}"
                                                   target="{{ $child->target ?? '_self' }}"
                                                   @click="mobileOpen = false"
                                                   class="block rounded-lg px-2.5 sm:px-3 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-slate-600 hover:bg-primary-50 hover:text-primary-700 transition">
                                                    {{ $child->name }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $menuUrl }}"
                                   target="{{ $item->target ?? '_self' }}"
                                   @click="mobileOpen = false"
                                   class="block rounded-lg sm:rounded-xl px-2.5 sm:px-3 py-2 sm:py-2.5 text-sm sm:text-base font-semibold text-slate-800 hover:bg-slate-50 transition">
                                    {{ $item->name }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <div class="pt-2 sm:pt-3 border-t border-slate-100 flex flex-col gap-2">
                    <a href="https://lynk.id/spmb-madah"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn-primary w-full flex items-center justify-center gap-2 font-bold shadow-soft text-xs sm:text-sm py-2 sm:py-2.5">
                        <x-icon name="sparkles" class="size-3.5 sm:size-4 text-gold-300 shrink-0" />
                        <span>Daftar SPMB Online</span>
                        <x-icon name="external-link" class="size-3.5 sm:size-4 opacity-80 shrink-0" />
                    </a>
                    <button type="button"
                            @click="$store.spmbCalc.open(); mobileOpen = false"
                            class="btn-gold w-full text-center font-bold cursor-pointer text-xs sm:text-sm py-2 sm:py-2.5">
                        <x-icon name="compass" class="size-3.5 sm:size-4 inline mr-1 shrink-0" />
                        <span>Simulasi Peminatan</span>
                    </button>
                    <a href="{{ route('contact') }}"
                       class="btn-outline w-full text-center text-xs sm:text-sm py-2 sm:py-2.5 font-bold">
                        Hubungi Madrasah
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
