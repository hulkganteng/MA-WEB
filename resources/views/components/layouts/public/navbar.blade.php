@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $siteTagline = setting('site.tagline', 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren');
    $logo = setting('site.logo');
    $phone = setting('contact.phone');
    $email = setting('contact.email');
    $social = \App\Models\SocialLink::where('is_active', true)->get();
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
        }">

    {{-- Top Utility Bar: Islamic Date & Live Prayer Times --}}
    <div class="border-b border-emerald-800/40 bg-gradient-to-r from-primary-950 via-primary-900 to-primary-950 text-white text-xs py-1.5 px-4">
        <div class="container-app flex flex-wrap items-center justify-between gap-3">
            {{-- Left: Live Hijri Date & Masehi Date --}}
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 font-medium text-gold-300">
                    <x-icon name="calendar" class="size-3.5 text-gold-400 shrink-0" />
                    <span x-text="$store.prayer.hijri">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </span>
                <span class="hidden md:inline text-primary-400">|</span>
                <span class="hidden md:inline text-primary-200" x-text="$store.prayer.masehi">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
            </div>

            {{-- Center/Right: Live Prayer Times Countdown Badge & Contact --}}
            <div class="flex items-center gap-3">
                <button type="button"
                        @click="$store.prayer.openModal()"
                        class="group flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-500/10 px-2.5 py-0.5 text-xs text-gold-200 transition hover:border-gold-400 hover:bg-gold-500/20 cursor-pointer"
                        title="Lihat Jadwal Sholat Lengkap">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
                    </span>
                    <span class="font-medium">
                        Sholat <span class="font-bold text-white" x-text="$store.prayer.nextPrayerName">Dzuhur</span>:
                        <span class="font-mono text-gold-300" x-text="$store.prayer.countdownText">--:--:--</span>
                    </span>
                    <x-icon name="chevron-right" class="size-3 transition group-hover:translate-x-0.5 text-gold-400 shrink-0" />
                </button>

                <div class="hidden lg:flex items-center gap-3 pl-2 border-l border-primary-800/80">
                    @if ($phone)
                        <a href="tel:{{ preg_replace('/[^\+0-9]/', '', $phone) }}" class="flex items-center gap-1 text-primary-200 hover:text-white transition">
                            <x-icon name="phone" class="size-3 text-gold-400 shrink-0" />
                            <span>{{ $phone }}</span>
                        </a>
                    @endif

                    @foreach ($social as $link)
                        @if ($link->url)
                            @php
                                $p = strtolower($link->platform);
                                $icon = match($p) {
                                    'facebook' => 'facebook',
                                    'instagram' => 'instagram',
                                    'youtube' => 'youtube',
                                    'twitter', 'x' => 'twitter',
                                    'tiktok' => 'video',
                                    default => 'globe'
                                };
                            @endphp
                            <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($link->platform) }}"
                               class="text-primary-300 hover:text-gold-300 transition">
                                <x-icon :name="$icon" class="size-3.5" />
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navbar --}}
    <nav class="relative border-b transition-all duration-300"
         :class="isScrolled
            ? 'border-slate-200/90 bg-white/95 shadow-soft backdrop-blur-xl'
            : 'border-slate-200/60 bg-white/90 backdrop-blur-lg'">

        <div class="container-app flex h-16 items-center justify-between gap-4 lg:h-20">
            {{-- Brand Logo & Identity --}}
            <a href="{{ route('home') }}" class="group flex items-center gap-3.5 shrink-0">
                <div class="relative flex size-11 sm:size-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-700 via-primary-800 to-primary-950 p-0.5 text-white shadow-soft transition duration-300 group-hover:shadow-glow">
                    @if ($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }}" class="size-full rounded-[14px] object-cover">
                    @else
                        <div class="flex size-full items-center justify-center rounded-[14px] bg-primary-900 border border-gold-400/30">
                            <span class="font-extrabold text-gold-300 text-lg">MA</span>
                        </div>
                    @endif
                    <div class="absolute -bottom-1 -right-1 flex size-4 items-center justify-center rounded-full bg-gold-400 text-[9px] font-bold text-primary-950 shadow">
                        ✓
                    </div>
                </div>

                <div class="min-w-0">
                    <span class="block text-base font-extrabold tracking-tight text-primary-950 sm:text-lg group-hover:text-primary-700 transition">
                        {{ $siteName }}
                    </span>
                    <span class="hidden sm:flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                        <span class="inline-block size-1.5 rounded-full bg-emerald-500"></span>
                        <span>Bungah, Gresik · YPP. Qomaruddin</span>
                        <span class="rounded bg-gold-100 px-1 py-0.2 text-[9px] font-bold text-gold-800 uppercase">Akreditasi A</span>
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation Menu --}}
            <div class="hidden lg:flex items-center gap-1">
                <ul class="flex items-center gap-1">
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
                               class="flex items-center gap-1.5 rounded-xl px-3 py-2 text-sm font-semibold transition {{ $isActive ? 'bg-primary-50 text-primary-800' : 'text-slate-700 hover:bg-slate-50 hover:text-primary-700' }}"
                               :class="open ? 'bg-primary-50 text-primary-800' : ''">
                                <span>{{ $item->name }}</span>
                                @if ($hasChildren)
                                    <x-icon name="chevron-down" class="size-3.5 transition-transform duration-200 text-slate-400"
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
                                     class="absolute left-0 top-full pt-2 w-64 z-50"
                                     x-cloak>
                                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-2 shadow-lift backdrop-blur-xl">
                                        @foreach ($item->children as $child)
                                            @php
                                                $childUrl = $child->url ? (str_starts_with($child->url, 'http') ? $child->url : url($child->url)) : '#';
                                                $isChildActive = $child->url && request()->is(ltrim($child->url, '/') . '*');
                                            @endphp
                                            <a href="{{ $childUrl }}"
                                               target="{{ $child->target ?? '_self' }}"
                                               class="group flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm transition {{ $isChildActive ? 'bg-primary-50 text-primary-900 font-bold' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-900 font-medium' }}">
                                                <span>{{ $child->name }}</span>
                                                <x-icon name="arrow-right" class="size-3 text-slate-300 opacity-0 transition group-hover:opacity-100 group-hover:translate-x-0.5 group-hover:text-primary-600" />
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Right Actions: Command Search & Quick CTA --}}
            <div class="flex items-center gap-2.5">
                {{-- Quick Command Search Trigger --}}
                <button type="button"
                        @click="$store.cmdPalette.open()"
                        class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/80 px-3 py-1.5 text-xs text-slate-500 transition hover:border-primary-500 hover:bg-white hover:text-primary-700 hover:shadow-soft cursor-pointer"
                        aria-label="Buka Pencarian Cepat">
                    <x-icon name="search" class="size-4 text-slate-400" />
                    <span class="hidden sm:inline">Cari...</span>
                    <kbd class="hidden md:inline-flex items-center gap-0.5 rounded bg-white px-1.5 py-0.5 font-mono text-[10px] text-slate-400 border border-slate-200">
                        <span>Ctrl</span><span>K</span>
                    </kbd>
                </button>

                {{-- Interactive SPMB Simulator Trigger --}}
                <button type="button"
                        @click="$store.spmbCalc.open()"
                        class="hidden sm:inline-flex btn-gold !py-2 !px-4 text-xs font-bold shadow-soft hover:shadow-lift cursor-pointer">
                    <x-icon name="sparkles" class="size-3.5" />
                    <span>Simulasi SPMB</span>
                </button>

                {{-- Mobile Menu Hamburger --}}
                <button type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="flex size-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 hover:text-primary-700 lg:hidden cursor-pointer"
                        aria-label="Menu Utama">
                    <x-icon name="menu" class="size-5" x-show="!mobileOpen" />
                    <x-icon name="x" class="size-5" x-show="mobileOpen" x-cloak />
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
             class="border-t border-slate-200 bg-white/95 backdrop-blur-xl lg:hidden max-h-[80vh] overflow-y-auto shadow-2xl"
             x-cloak>
            <div class="container-app py-4 space-y-3">
                {{-- Quick Mobile Info Banner --}}
                <div class="rounded-2xl border border-primary-500/20 bg-primary-50 p-4">
                    <div class="flex items-center justify-between text-xs font-semibold text-primary-900">
                        <span x-text="$store.prayer.hijri">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        <button type="button" @click="$store.prayer.openModal(); mobileOpen = false" class="text-primary-700 font-bold underline cursor-pointer">
                            Jadwal Sholat &rarr;
                        </button>
                    </div>
                </div>

                {{-- Navigation Items --}}
                <ul class="space-y-1 divide-y divide-slate-100">
                    @foreach ($menus as $item)
                        @php
                            $hasChildren = $item->children && $item->children->count() > 0;
                            $menuUrl = $item->url ? (str_starts_with($item->url, 'http') ? $item->url : url($item->url)) : '#';
                        @endphp
                        <li class="pt-1">
                            @if ($hasChildren)
                                <div x-data="{ expanded: false }">
                                    <button type="button" @click="expanded = !expanded"
                                            class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-800 hover:bg-slate-50 cursor-pointer">
                                        <span>{{ $item->name }}</span>
                                        <x-icon name="chevron-down" class="size-4 transition-transform duration-200 text-slate-400"
                                                x-bind:class="{ 'rotate-180 text-primary-600': expanded }" />
                                    </button>
                                    <div x-show="expanded" x-transition class="ml-4 mt-1 space-y-1 border-l-2 border-primary-100 pl-3">
                                        @foreach ($item->children as $child)
                                            @php
                                                $childUrl = $child->url ? (str_starts_with($child->url, 'http') ? $child->url : url($child->url)) : '#';
                                            @endphp
                                            <a href="{{ $childUrl }}"
                                               target="{{ $child->target ?? '_self' }}"
                                               @click="mobileOpen = false"
                                               class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-primary-50 hover:text-primary-700">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $menuUrl }}"
                                   target="{{ $item->target ?? '_self' }}"
                                   @click="mobileOpen = false"
                                   class="block rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-800 hover:bg-slate-50">
                                    {{ $item->name }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                    <button type="button"
                            @click="$store.spmbCalc.open(); mobileOpen = false"
                            class="btn-gold w-full text-center font-bold cursor-pointer">
                        <x-icon name="sparkles" class="size-4" />
                        <span>Simulasi Peminatan Santri Baru</span>
                    </button>
                    <a href="{{ route('contact') }}"
                       class="btn-primary w-full text-center">
                        Hubungi Madrasah
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
