<x-layouts.app>
    {{-- ================================================================= --}}
    {{-- 1. HERO SECTION (DYNAMIC CMS SLIDER & ISLAMIC HUB BENTO)          --}}
    {{-- ================================================================= --}}
    @if($heroSlides->isNotEmpty())
        <section class="relative bg-primary-950 text-white overflow-hidden"
                 x-data="heroSlider(@js($heroSlides->map(fn($s) => [
                     'id' => $s->id,
                     'title' => $s->title,
                     'subtitle' => $s->subtitle,
                     'tagline' => $s->tagline,
                     'imageUrl' => $s->image_url,
                     'buttonText' => $s->button_text,
                     'buttonUrl' => $s->button_url,
                     'secondaryButtonText' => $s->secondary_button_text,
                     'secondaryButtonUrl' => $s->secondary_button_url,
                 ])))"
                 @mouseenter="pause()"
                 @mouseleave="resume()"
                 @keydown.arrow-right.window="next()"
                 @keydown.arrow-left.window="prev()"
                 aria-label="Banner Utama Madrasah">

            <!-- Background decorative pattern -->
            <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40 z-0"></div>

            <!-- Banner Slides Viewport -->
            <div class="relative min-h-[500px] sm:min-h-[560px] lg:min-h-[620px] flex items-center">
                <!-- Slide Background Images -->
                <template x-for="(slide, index) in slides" :key="slide.id">
                    <div x-show="currentIndex === index"
                         x-transition:enter="transition-opacity duration-700 ease-out"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-500 ease-in"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 z-0 overflow-hidden">
                        <img :src="slide.imageUrl"
                             :alt="slide.title"
                             class="size-full object-cover object-center">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-950/75 to-primary-950/40 lg:bg-gradient-to-r lg:from-primary-950/95 lg:via-primary-950/75 lg:to-primary-950/35"></div>
                    </div>
                </template>

                <!-- Slide Content Container -->
                <div class="container-app relative z-10 py-14 sm:py-20 lg:py-24 w-full">
                    <div class="grid items-center gap-10 lg:grid-cols-12">
                        <div class="lg:col-span-7">
                            <template x-for="(slide, index) in slides" :key="'text-' + slide.id">
                                <div x-show="currentIndex === index"
                                     x-transition:enter="transition ease-out duration-500 delay-100 transform"
                                     x-transition:enter-start="opacity-0 translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-4 sm:gap-5">

                                    <!-- Eyebrow / Tagline -->
                                    <template x-if="slide.tagline">
                                        <div>
                                            <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-500/10 px-3.5 py-1 text-xs font-semibold text-gold-300 backdrop-blur"
                                                  x-text="slide.tagline"></span>
                                        </div>
                                    </template>

                                    <!-- Title Heading -->
                                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight text-balance"
                                        x-text="slide.title"></h1>

                                    <!-- Subtitle -->
                                    <template x-if="slide.subtitle">
                                        <p class="text-base sm:text-lg text-primary-100 leading-relaxed text-pretty font-normal"
                                           x-text="slide.subtitle"></p>
                                    </template>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-wrap items-center gap-3 pt-2">
                                        <template x-if="slide.buttonText && slide.buttonUrl">
                                            <a :href="slide.buttonUrl" class="btn-gold !bg-gold-500 hover:!bg-gold-400 text-gold-950 font-bold shadow-glow-gold !px-6 !py-3 text-sm">
                                                <span x-text="slide.buttonText"></span>
                                                <x-icon name="arrow-right" class="size-4 shrink-0" />
                                            </a>
                                        </template>

                                        <button type="button"
                                                @click="$store.spmbCalc.open()"
                                                class="btn-gold !bg-emerald-600 hover:!bg-emerald-500 text-white font-bold !px-5 !py-3 text-sm">
                                            <x-icon name="sparkles" class="size-4" />
                                            <span>Simulasi SPMB</span>
                                        </button>

                                        <template x-if="slide.secondaryButtonText && slide.secondaryButtonUrl">
                                            <a :href="slide.secondaryButtonUrl" class="btn-outline !border-white/25 !bg-white/10 !text-white hover:!bg-white/20 !px-5 !py-3 text-sm backdrop-blur">
                                                <span x-text="slide.secondaryButtonText"></span>
                                            </a>
                                        </template>

                                        <!-- Lightbox Modal Button -->
                                        <button type="button"
                                                @click="openModal(slide)"
                                                class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3.5 py-3 text-xs sm:text-sm font-medium text-gold-300 hover:text-white hover:bg-white/20 border border-white/20 transition backdrop-blur cursor-pointer"
                                                title="Lihat Foto Banner">
                                            <x-icon name="maximize-2" class="size-4" />
                                            <span>Foto</span>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Slide Navigation Controls -->
                            <div class="mt-8 flex items-center gap-4 pt-4 border-t border-white/10" x-show="slides.length > 1">
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                            @click="prev()"
                                            class="flex size-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white border border-white/20 transition"
                                            aria-label="Slide sebelumnya">
                                        <x-icon name="chevron-left" class="size-5" />
                                    </button>
                                    <button type="button"
                                            @click="next()"
                                            class="flex size-9 items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white border border-white/20 transition"
                                            aria-label="Slide berikutnya">
                                        <x-icon name="chevron-right" class="size-5" />
                                    </button>
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <template x-for="(slide, index) in slides" :key="'dot-' + slide.id">
                                        <button type="button"
                                                @click="goTo(index)"
                                                :class="currentIndex === index ? 'w-8 bg-gold-400' : 'w-2 bg-white/30 hover:bg-white/60'"
                                                class="h-2 rounded-full transition-all duration-300"
                                                :aria-label="'Pindah ke slide ' + (index + 1)"></button>
                                    </template>
                                </div>

                                <span class="text-xs text-primary-200 font-mono" x-text="(currentIndex + 1) + ' / ' + slides.length"></span>
                            </div>
                        </div>

                        <!-- Right Column: Live Prayer Card & Stats Bento -->
                        <div class="lg:col-span-5 space-y-4">
                            <!-- Live Prayer Card in Hero -->
                            <div class="overflow-hidden rounded-3xl border border-gold-400/30 bg-gradient-to-br from-primary-900/80 via-primary-950/90 to-slate-950 p-6 shadow-lift backdrop-blur-xl">
                                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex size-10 items-center justify-center rounded-xl bg-gold-400/20 text-gold-300">
                                            <x-icon name="clock" class="size-5" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-white">Jadwal Sholat Bungah Gresik</h3>
                                            <p class="text-xs text-primary-200" x-text="$store.prayer.hijri"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="$store.prayer.openModal()" class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-semibold text-gold-300 hover:bg-white/20 transition">
                                        Detail
                                    </button>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-300">Waktu Sholat Berikutnya</span>
                                        <div class="mt-1 flex items-baseline gap-2">
                                            <span class="text-xl font-extrabold text-white" x-text="$store.prayer.nextPrayerName"></span>
                                            <span class="font-mono text-2xl font-bold text-gradient-gold" x-text="$store.prayer.countdownText"></span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-block rounded-lg bg-emerald-500/20 px-3 py-1.5 font-mono text-sm font-bold text-emerald-300 border border-emerald-500/30">
                                            {{ date('H:i') }} WIB
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Interactive Stats Bento Grid -->
                            <div class="rounded-3xl border border-white/15 bg-white/5 p-6 shadow-lift backdrop-blur-xl">
                                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                                    <span class="text-xs font-bold uppercase tracking-wider text-gold-300">Pendidikan Terpadu & Berkelanjutan</span>
                                    <x-icon name="trending-up" class="size-4 text-emerald-400" />
                                </div>

                                <dl class="mt-4 grid grid-cols-2 gap-4">
                                    <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-emerald-500/30 hover:bg-emerald-950/30">
                                        <dt class="text-xs text-primary-200">Peserta Didik</dt>
                                        <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ setting('stats.students', 850) }}+</dd>
                                        <span class="text-[10px] text-emerald-400">Jenjang X, XI, XII</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-gold-500/30 hover:bg-gold-950/30">
                                        <dt class="text-xs text-primary-200">Guru & Tendik</dt>
                                        <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ $teacherCount ?: setting('stats.teachers', 45) }}</dd>
                                        <span class="text-[10px] text-gold-400">Pendidik Berlisensi</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-emerald-500/30 hover:bg-emerald-950/30">
                                        <dt class="text-xs text-primary-200">Alumni IKBAL</dt>
                                        <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ setting('stats.alumni', 4200) }}+</dd>
                                        <span class="text-[10px] text-emerald-400">Kiprah Nusantara</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-gold-500/30 hover:bg-gold-950/30">
                                        <dt class="text-xs text-primary-200">Prestasi Juara</dt>
                                        <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ setting('stats.achievements', 120) }}+</dd>
                                        <span class="text-[10px] text-gold-400">Kab., Prov., & Nas.</span>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Lightbox Preview -->
            <template x-if="modalPhoto">
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 p-4 backdrop-blur-sm"
                     @click.self="modalPhoto = null; resume();"
                     @keydown.escape.window="modalPhoto = null; resume();">
                    <div class="relative max-w-5xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-white/10">
                        <div class="flex items-center justify-between p-4 border-b border-white/10 bg-slate-950">
                            <div>
                                <h3 class="text-base font-bold text-white" x-text="modalPhoto.title"></h3>
                                <p class="text-xs text-primary-200" x-text="modalPhoto.tagline"></p>
                            </div>
                            <button type="button" @click="modalPhoto = null; resume();" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                                <x-icon name="x" class="size-6" />
                            </button>
                        </div>
                        <div class="p-2 max-h-[75vh] overflow-auto flex items-center justify-center bg-black">
                            <img :src="modalPhoto.imageUrl" :alt="modalPhoto.title" class="max-h-[70vh] w-auto object-contain rounded-lg">
                        </div>
                        <template x-if="modalPhoto.subtitle">
                            <div class="p-4 bg-slate-950 border-t border-white/10 text-sm text-slate-300" x-text="modalPhoto.subtitle"></div>
                        </template>
                    </div>
                </div>
            </template>
        </section>
    @else
        <!-- Fallback Default Hero Section when no slides exist -->
        <section class="relative overflow-hidden bg-gradient-to-br from-primary-950 via-primary-900 to-slate-950 text-white py-16 sm:py-24 lg:py-28">
            <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40"></div>
            <div class="container-app relative grid items-center gap-12 lg:grid-cols-12">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex flex-wrap items-center gap-2 rounded-full border border-gold-400/40 bg-gold-500/10 px-3.5 py-1.5 text-xs font-semibold text-gold-300 backdrop-blur">
                        <x-icon name="sparkles" class="size-3.5 text-gold-400" />
                        <span>Madrasah Riset & Pesantren Digital</span>
                        <span class="text-gold-400/50">·</span>
                        <span class="text-primary-200">Sanad Keilmuan Pondok Pesantren Qomaruddin</span>
                    </div>

                    <h1 class="font-display text-3xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-white leading-tight">
                        {{ setting('hero.title', setting('hero_title', 'Mencetak Generasi Unggul, Cendekia, dan Berakhlakul Karimah')) }}
                    </h1>

                    <p class="max-w-2xl text-base text-primary-100 sm:text-lg leading-relaxed font-normal">
                        {{ setting('hero.subtitle', setting('hero_subtitle', 'Pendidikan terpadu memadukan keunggulan kurikulum sains teknologi, pendalaman kitab kuning turats pesantren, dan pembiasaan adab islami bersanad terpercaya.')) }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3.5 pt-2">
                        <button type="button"
                                @click="$store.spmbCalc.open()"
                                class="btn-gold !bg-gold-500 hover:!bg-gold-400 text-gold-950 font-bold shadow-glow-gold !px-6 !py-3.5 text-sm">
                            <x-icon name="sparkles" class="size-4" />
                            <span>Simulasi Peminatan SPMB</span>
                        </button>
                        <a href="{{ route('about') }}"
                           class="btn-outline !border-white/25 !bg-white/10 !text-white hover:!bg-white/20 !px-6 !py-3.5 text-sm backdrop-blur">
                            <span>Kenali Madrasah</span>
                            <x-icon name="arrow-right" class="size-4" />
                        </a>
                        <a href="{{ route('programs') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-3 text-xs font-semibold text-emerald-300 hover:text-white transition">
                            <x-icon name="book-open" class="size-4 text-emerald-400" />
                            <span>Program Pendidikan</span>
                        </a>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-medium text-slate-300 border-t border-white/10 pt-4">
                        <span class="flex items-center gap-1.5">
                            <x-icon name="check-circle-2" class="size-4 text-emerald-400" />
                            <span>Akreditasi A BAN-S/M</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <x-icon name="check-circle-2" class="size-4 text-gold-400" />
                            <span>Sanad Masyayikh Qomaruddin 1775 M</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <x-icon name="check-circle-2" class="size-4 text-emerald-400" />
                            <span>Madrasah Riset & CBT Lab</span>
                        </span>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-4">
                    <div class="overflow-hidden rounded-3xl border border-gold-400/30 bg-gradient-to-br from-primary-900/80 via-primary-950/90 to-slate-950 p-6 shadow-lift backdrop-blur-xl">
                        <div class="flex items-center justify-between border-b border-white/10 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-xl bg-gold-400/20 text-gold-300">
                                    <x-icon name="clock" class="size-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-white">Jadwal Sholat Bungah Gresik</h3>
                                    <p class="text-xs text-primary-200" x-text="$store.prayer.hijri"></p>
                                </div>
                            </div>
                            <button type="button" @click="$store.prayer.openModal()" class="rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-semibold text-gold-300 hover:bg-white/20 transition">
                                Detail
                            </button>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-300">Waktu Sholat Berikutnya</span>
                                <div class="mt-1 flex items-baseline gap-2">
                                    <span class="text-xl font-extrabold text-white" x-text="$store.prayer.nextPrayerName"></span>
                                    <span class="font-mono text-2xl font-bold text-gradient-gold" x-text="$store.prayer.countdownText"></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block rounded-lg bg-emerald-500/20 px-3 py-1.5 font-mono text-sm font-bold text-emerald-300 border border-emerald-500/30">
                                    {{ date('H:i') }} WIB
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-white/15 bg-white/5 p-6 shadow-lift backdrop-blur-xl">
                        <div class="flex items-center justify-between pb-3 border-b border-white/10">
                            <span class="text-xs font-bold uppercase tracking-wider text-gold-300">Pendidikan Terpadu & Berkelanjutan</span>
                            <x-icon name="trending-up" class="size-4 text-emerald-400" />
                        </div>

                        <dl class="mt-4 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-emerald-500/30 hover:bg-emerald-950/30">
                                <dt class="text-xs text-primary-200">Peserta Didik</dt>
                                <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ setting('stats.students', 850) }}+</dd>
                                <span class="text-[10px] text-emerald-400">Jenjang X, XI, XII</span>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-gold-500/30 hover:bg-gold-950/30">
                                <dt class="text-xs text-primary-200">Guru & Tendik</dt>
                                <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ $teacherCount ?: setting('stats.teachers', 45) }}</dd>
                                <span class="text-[10px] text-gold-400">Pendidik Berlisensi</span>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-emerald-500/30 hover:bg-emerald-950/30">
                                <dt class="text-xs text-primary-200">Alumni IKBAL</dt>
                                <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ setting('stats.alumni', 4200) }}+</dd>
                                <span class="text-[10px] text-emerald-400">Kiprah Nusantara</span>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-white/5 p-3.5 transition hover:border-gold-500/30 hover:bg-gold-950/30">
                                <dt class="text-xs text-primary-200">Prestasi Juara</dt>
                                <dd class="mt-1 text-2xl font-extrabold tracking-tight text-white tabular-nums">{{ setting('stats.achievements', 120) }}+</dd>
                                <span class="text-[10px] text-gold-400">Kab., Prov., & Nas.</span>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================= --}}
    {{-- 2. RUNNING INSTITUTIONAL MARQUEE TICKER                           --}}
    {{-- ================================================================= --}}
    <div class="border-y border-slate-200 bg-slate-900 text-white overflow-hidden py-3">
        <div class="flex items-center gap-8 whitespace-nowrap animate-marquee">
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-gold-300">
                <x-icon name="sparkles" class="size-3.5 text-gold-400" />
                <span>YAYASAN PONDOK PESANTREN QOMARUDDIN BUNGAH GRESIK (EST. 1775 M)</span>
            </span>
            <span class="text-slate-600">·</span>
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-emerald-400">
                <x-icon name="shield-check" class="size-3.5 text-emerald-400" />
                <span>AKREDITASI A UNGGUL BAN-S/M</span>
            </span>
            <span class="text-slate-600">·</span>
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-white">
                <x-icon name="book-open" class="size-3.5 text-gold-400" />
                <span>KURIKULUM MERDEKA TERPADU TURATS PESANTREN</span>
            </span>
            <span class="text-slate-600">·</span>
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-emerald-300">
                <x-icon name="award" class="size-3.5 text-emerald-400" />
                <span>PUSAT RISET & PENGEMBANGAN POTENSI SANTRI NUSANTARA</span>
            </span>
            <span class="text-slate-600">·</span>
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-gold-300">
                <x-icon name="sparkles" class="size-3.5 text-gold-400" />
                <span>SPMB TAHUN AJARAN 2026/2027 TELAH DIBUKA</span>
            </span>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- 3. AKSES CEPAT (QUICK NAVIGATION PILLS GRID)                      --}}
    {{-- ================================================================= --}}
    <section class="py-10 bg-slate-50 border-b border-slate-200">
        <div class="container-app">
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                @foreach([
                    ['berita.index', 'newspaper', 'Berita & Artikel', 'Kabar Madrasah'],
                    ['pengumuman.index', 'megaphone', 'Pengumuman', 'Edaran Resmi'],
                    ['agenda.index', 'calendar', 'Agenda Kalender', 'Jadwal Kegiatan'],
                    ['prestasi.index', 'trophy', 'Prestasi Santri', 'Capaian Juara'],
                    ['gallery.photos', 'images', 'Galeri Foto', 'Dokumentasi'],
                    ['downloads.index', 'file-down', 'Pusat Unduhan', 'Brosur & Dokumen'],
                ] as [$route, $icon, $title, $subtitle])
                    <a href="{{ route($route) }}"
                       class="interactive-card group flex flex-col items-center justify-center p-4 text-center">
                        <span class="flex size-11 items-center justify-center rounded-2xl bg-primary-50 text-primary-700 transition duration-300 group-hover:bg-primary-600 group-hover:text-white group-hover:scale-110">
                            <x-icon :name="$icon" class="size-5" />
                        </span>
                        <span class="mt-3 text-xs font-bold text-slate-900 group-hover:text-primary-700 transition">{{ $title }}</span>
                        <span class="text-[10px] text-slate-500">{{ $subtitle }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 4. TENTANG MADRASAH (EDITORIAL OVERVIEW & 4 PILAR)                --}}
    {{-- ================================================================= --}}
    <section class="py-20 sm:py-24 bg-white relative">
        <div class="container-app grid items-center gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5 space-y-4">
                <div class="relative overflow-hidden rounded-3xl border border-slate-200 shadow-lift group aspect-[4/3] bg-primary-950">
                    @if($aboutPage?->cover)
                        <img src="{{ asset('storage/'.$aboutPage->cover) }}" alt="Lingkungan MA Ma’arif NU Assa’adah"
                             class="size-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-900 via-primary-950 to-slate-950 p-8 text-center text-white">
                            <div class="flex size-16 items-center justify-center rounded-2xl bg-gold-400/20 text-gold-300">
                                <x-icon name="school" class="size-8" />
                            </div>
                            <h4 class="mt-4 text-lg font-bold text-white">Kampus MA Ma'arif NU Assa'adah</h4>
                            <p class="mt-1 text-xs text-primary-200">Sampurnan, Bungah, Gresik · Didirikan 1972</p>
                        </div>
                    @endif
                    <div class="absolute bottom-4 left-4 right-4 rounded-2xl bg-slate-950/80 p-4 text-white backdrop-blur-md border border-white/10">
                        <p class="text-xs font-semibold text-gold-300 uppercase tracking-wider">Filosofi Pendidikan</p>
                        <p class="text-xs text-slate-200 mt-0.5">Mempertahankan tradisi salaf yang baik dan mengambil hal baru yang lebih maslahat.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-6">
                <x-section-header eyebrow="Tentang Madrasah"
                                  title="Berakar pada Nilai Luhur Pesantren, Bergerak Bersama Zaman"
                                  description="MA Ma’arif NU Assa’adah Bungah memadukan keunggulan akademik sains terapan, hafalan Qur'an, pembiasaan akhlak mulia, dan kecakapan digital masa depan." />

                <div class="grid gap-4 sm:grid-cols-2 pt-2">
                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-primary-100 text-primary-800">
                            <x-icon name="heart" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Berakhlak Mulia</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Keteladanan adab thalabul 'ilmi, sholat dhuha dan dhuhur berjamaah, serta kepatuhan santun kepada guru dan orang tua.</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-gold-100 text-gold-800">
                            <x-icon name="sparkles" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Cakap & Terampil</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Penguasaan teknologi digital, robotika, coding, public speaking 3 bahasa, dan jiwa kepemimpinan organisasi.</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800">
                            <x-icon name="brain" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Cendekia & Kritis</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Budaya literasi sains, riset MYRES, bimbingan olimpiade sains (KSM), dan tembus seleksi PTN favorit dan beasiswa Timur Tengah.</p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800">
                            <x-icon name="book-open" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Berkarakter Pesantren</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Kajian kitab kuning matan dan syarah dengan metode sorogan-bandongan bersanad shahih masyayikh Qomaruddin.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <a href="{{ route('about') }}" class="btn-primary">
                        <span>Profil Lengkap & Sejarah</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                    <a href="{{ route('structure') }}" class="btn-ghost">
                        <span>Struktur Pimpinan</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 5. SAMBUTAN KEPALA MADRASAH                                       --}}
    {{-- ================================================================= --}}
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40"></div>
        <div class="container-app relative grid items-center gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="relative mx-auto max-w-sm overflow-hidden rounded-3xl border border-gold-400/30 bg-primary-950 shadow-lift p-2">
                    @if(setting('principal.photo'))
                        <img src="{{ asset('storage/'.setting('principal.photo')) }}"
                             alt="{{ setting('principal.name') }}"
                             class="aspect-[4/5] w-full rounded-2xl object-cover">
                    @else
                        <div class="flex aspect-[4/5] w-full flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-primary-800 to-primary-950 text-gold-300">
                            <x-icon name="user-round" class="size-16" />
                            <span class="mt-3 text-xs font-semibold text-primary-200">Kepala Madrasah</span>
                        </div>
                    @endif
                    <div class="p-4 text-center">
                        <h4 class="text-base font-bold text-white">{{ setting('principal.name', 'Mohammad Isma\'il Cholilur Rohman, M.Pd.') }}</h4>
                        <p class="text-xs text-gold-300">{{ setting('principal.position', 'Kepala MA Ma\'arif NU Assa\'adah') }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-6">
                <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-500/10 px-3.5 py-1 text-xs font-semibold text-gold-300">
                    <x-icon name="quote" class="size-3.5" />
                    <span>Sambutan Kepala Madrasah</span>
                </div>

                <blockquote class="text-pretty text-xl font-medium leading-relaxed text-slate-100 sm:text-2xl lg:text-3xl font-display">
                    “{{ Str::limit(setting('principal.speech', 'Selamat datang di portal resmi MA Ma\'arif NU Assa\'adah Bungah Gresik. Kami berkomitmen menyelenggarakan pendidikan terpadu yang memadukan kedalaman ilmu agama dan ketajaman riset sains.'), 240) }}”
                </blockquote>

                <p class="text-sm text-primary-100 leading-relaxed max-w-3xl">
                    Sebagai lembaga pendidikan di bawah naungan Pondok Pesantren Qomaruddin yang telah berdiri sejak 1775 M, kami mendidik generasi santri yang teguh memegang aqidah Ahlussunnah wal Jama'ah An-Nahdliyyah sekaligus mahir dalam sains, teknologi, dan bahasa global.
                </p>

                <div class="pt-2">
                    <a href="{{ route('sambutan') }}" class="btn-gold font-bold">
                        <span>Baca Sambutan Lengkap</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 6. PROGRAM UNGGULAN MADRASAH                                      --}}
    {{-- ================================================================= --}}
    @if($programs->isNotEmpty())
        <section class="py-20 sm:py-24 bg-slate-50 relative">
            <div class="container-app space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Pendidikan Terpadu"
                                      title="Program Unggulan Madrasah"
                                      description="Pilihan program intensif yang dirancang untuk mengoptimalkan potensi intelektual, spiritual, dan keterampilan hidup peserta didik." />
                    <a href="{{ route('programs') }}" class="btn-outline shrink-0 font-semibold">
                        <span>Semua Program Unggulan</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($programs as $prog)
                        <div class="interactive-card group flex flex-col justify-between p-6">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="flex size-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-800 transition duration-300 group-hover:bg-primary-600 group-hover:text-white group-hover:scale-110">
                                        <x-icon name="sparkles" class="size-6" />
                                    </span>
                                    <span class="text-xs font-bold text-gold-600">Unggulan</span>
                                </div>
                                <h3 class="mt-5 text-lg font-bold text-slate-950 group-hover:text-primary-700 transition">
                                    {{ $prog->name }}
                                </h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600 line-clamp-3">
                                    {{ $prog->description }}
                                </p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-slate-100">
                                <a href="{{ route('programs.show', $prog) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-700 hover:text-primary-800">
                                    <span>Detail Kurikulum</span>
                                    <x-icon name="arrow-right" class="size-3.5" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================= --}}
    {{-- 7. BERITA TERBARU MADRASAH                                        --}}
    {{-- ================================================================= --}}
    <section class="py-20 sm:py-24 bg-white relative">
        <div class="container-app space-y-10">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <x-section-header eyebrow="Kabar Madrasah"
                                  title="Berita terbaru"
                                  description="Ikuti perkembangan, dinamika akademik, prestasi, dan kegiatan harian di lingkungan MA Ma'arif NU Assa'adah." />
                <a href="{{ route('berita.index') }}"
                   class="btn-outline shrink-0 !border-slate-300 hover:!border-primary-600 font-semibold">
                    <span>Semua Berita & Artikel</span>
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            </div>

            @if ($posts->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 p-12 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada publikasi berita terbaru.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 8. PENGUMUMAN RESMI MADRASAH                                      --}}
    {{-- ================================================================= --}}
    <section class="py-20 sm:py-24 bg-slate-50 relative">
        <div class="container-app space-y-10">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <x-section-header eyebrow="Informasi Terkini"
                                  title="Pengumuman terbaru"
                                  description="Surat edaran, kebijakan akademik, dan jadwal penting yang perlu diketahui wali santri dan peserta didik." />
                <a href="{{ route('pengumuman.index') }}" class="btn-outline shrink-0 font-semibold">
                    <span>Arsip Pengumuman</span>
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            </div>

            @if($announcements->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2">
                    @foreach($announcements as $item)
                        <a href="{{ route('pengumuman.show', $item) }}"
                           class="interactive-card group flex flex-col justify-between p-6">
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full {{ $item->is_important ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-primary-100 text-primary-800' }} px-3 py-1 text-xs font-bold">
                                        <x-icon name="{{ $item->is_important ? 'alert-circle' : 'megaphone' }}" class="size-3.5" />
                                        <span>{{ $item->is_important ? 'Penting' : 'Informasi' }}</span>
                                    </span>
                                    <span class="text-xs text-slate-400 font-mono">
                                        {{ optional($item->publish_date)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="mt-4 text-base font-bold text-slate-950 group-hover:text-primary-700 transition line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                <p class="mt-2 text-xs leading-relaxed text-slate-600 line-clamp-2">
                                    {{ strip_tags($item->body) }}
                                </p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-primary-700">
                                <span>Lihat Pengumuman</span>
                                <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 p-12 text-center">
                    <p class="text-sm font-semibold text-slate-500">Tidak ada pengumuman aktif saat ini.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 9. AGENDA & KALENDER KEGIATAN                                     --}}
    {{-- ================================================================= --}}
    <section class="py-20 sm:py-24 bg-white relative">
        <div class="container-app space-y-10">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <x-section-header eyebrow="Jadwal & Agenda"
                                  title="Agenda madrasah"
                                  description="Kegiatan akademik, pengajian bulanan santri, peringatan hari besar Islam (PHBI), dan asesmen madrasah." />
                <a href="{{ route('agenda.index') }}" class="btn-outline shrink-0 font-semibold">
                    <span>Lihat Kalender Lengkap</span>
                    <x-icon name="arrow-right" class="size-4" />
                </a>
            </div>

            @if($events->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($events as $ev)
                        <a href="{{ route('agenda.show', $ev) }}"
                           class="interactive-card group flex flex-col justify-between p-6">
                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="flex size-14 shrink-0 flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-primary-800 to-primary-950 text-white shadow-soft">
                                        <span class="text-lg font-black leading-none">{{ optional($ev->start_date)->format('d') }}</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gold-300">{{ optional($ev->start_date)->translatedFormat('M') }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="inline-block rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600 uppercase">
                                            {{ $ev->category ?? 'Akademik' }}
                                        </span>
                                        <p class="text-xs text-slate-400 truncate mt-0.5">
                                            <x-icon name="clock" class="size-3 inline mr-1" />
                                            {{ $ev->start_time ? substr($ev->start_time, 0, 5) . ' WIB' : 'Sepanjang Hari' }}
                                        </p>
                                    </div>
                                </div>
                                <h3 class="mt-4 text-sm font-bold text-slate-950 group-hover:text-primary-700 transition line-clamp-2">
                                    {{ $ev->title }}
                                </h3>
                                <p class="mt-1 text-xs text-slate-500 line-clamp-2">{{ $ev->location }}</p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-primary-700">
                                <span>Detail Acara</span>
                                <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-300 p-12 text-center">
                    <p class="text-sm font-semibold text-slate-500">Belum ada agenda terdekat yang dijadwalkan.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ================================================================= --}}
    {{-- 10. PRESTASI SANTRI & SISWA                                       --}}
    {{-- ================================================================= --}}
    @if($achievements->isNotEmpty())
        <section class="py-20 sm:py-24 bg-slate-50 relative">
            <div class="container-app space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Etalase Kejuaraan"
                                      title="Prestasi Membanggakan Santri"
                                      description="Dedikasi dan kerja keras santri MA Assa'adah dalam mengharumkan nama madrasah di tingkat daerah, provinsi, hingga nasional." />
                    <a href="{{ route('prestasi.index') }}" class="btn-outline shrink-0 font-semibold">
                        <span>Semua Prestasi</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($achievements as $ach)
                        <div class="interactive-card group flex flex-col justify-between p-6">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex size-12 items-center justify-center rounded-2xl bg-gold-100 text-gold-800">
                                        <x-icon name="trophy" class="size-6 text-gold-600" />
                                    </span>
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-800 uppercase">
                                        {{ $ach->level }}
                                    </span>
                                </div>
                                <h3 class="mt-4 text-base font-bold text-slate-950 group-hover:text-primary-700 transition">
                                    {{ $ach->title }}
                                </h3>
                                <p class="mt-1 text-xs font-semibold text-gold-700">{{ $ach->rank }} · {{ $ach->participant }}</p>
                                <p class="mt-2 text-xs leading-relaxed text-slate-600 line-clamp-3">
                                    {{ $ach->description }}
                                </p>
                            </div>
                            <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                                <span>{{ $ach->organizer }}</span>
                                <span class="font-bold">{{ $ach->year }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================= --}}
    {{-- 11. EKSTRAKURIKULER & PENGEMBANGAN BAKAT                          --}}
    {{-- ================================================================= --}}
    @if($extracurriculars->isNotEmpty())
        <section class="py-20 sm:py-24 bg-white relative">
            <div class="container-app space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Pengembangan Minat & Bakat"
                                      title="Ekstrakurikuler & Organisasi Santri"
                                      description="Wadah aktualisasi diri, kepemimpinan, olahraga, seni Islami, dan penguasaan teknologi." />
                    <a href="{{ route('extracurricular.index') }}" class="btn-outline shrink-0 font-semibold">
                        <span>Semua Ekstrakurikuler</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach($extracurriculars->take(6) as $item)
                        <a href="{{ route('extracurricular.show', $item) }}"
                           class="interactive-card group flex flex-col items-center justify-center p-5 text-center">
                            <span class="flex size-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-800 transition duration-300 group-hover:bg-primary-600 group-hover:text-white group-hover:scale-110">
                                <x-icon name="activity" class="size-6" />
                            </span>
                            <h3 class="mt-3 text-xs font-bold text-slate-900 group-hover:text-primary-800 transition line-clamp-2">
                                {{ $item->name }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================= --}}
    {{-- 12. GALERI KEGIATAN & DOKUMENTASI                                 --}}
    {{-- ================================================================= --}}
    @if($albums->isNotEmpty())
        <section class="py-20 sm:py-24 bg-primary-950 text-white relative overflow-hidden">
            <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40"></div>
            <div class="container-app relative space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header theme="dark"
                                      eyebrow="Dokumentasi Visual"
                                      title="Galeri Kegiatan & Kehidupan Santri"
                                      description="Potret kebersamaan, khidmat mengaji, penelitian laboratorium, dan dinamika pembelajaran di MA Assa'adah." />
                    <a href="{{ route('gallery.photos') }}" class="btn-gold !bg-gold-500 hover:!bg-gold-400 font-bold shrink-0">
                        <span>Lihat Galeri Foto</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($albums->take(4) as $album)
                        <a href="{{ route('gallery.album', $album) }}" class="group block overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-3 backdrop-blur transition hover:border-gold-400/40 hover:bg-white/10">
                            <div class="relative aspect-square overflow-hidden rounded-2xl bg-slate-900">
                                @if($album->cover)
                                    <img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->name }}"
                                         loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex size-full items-center justify-center bg-gradient-to-br from-primary-900 to-slate-950 text-gold-300">
                                        <x-icon name="images" class="size-10" />
                                    </div>
                                @endif
                                <span class="absolute bottom-2.5 right-2.5 rounded-full bg-slate-950/80 px-2.5 py-0.5 text-[11px] font-semibold text-white backdrop-blur">
                                    {{ $album->photos_count ?? 4 }} Foto
                                </span>
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-bold text-white group-hover:text-gold-300 transition line-clamp-1">{{ $album->name }}</h3>
                                <p class="text-xs text-primary-200 mt-1 line-clamp-1">{{ $album->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================= --}}
    {{-- 13. JEJAK ALUMNI IKBAL MADAH                                      --}}
    {{-- ================================================================= --}}
    @if($alumni->isNotEmpty())
        <section class="py-20 sm:py-24 bg-white relative">
            <div class="container-app space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Keluarga Alumni IKBAL MADAH"
                                      title="Tumbuh, Mengabdi, dan Berkarya di Berbagai Penjuru"
                                      description="Kisah inspiratif para lulusan MA Ma'arif NU Assa'adah yang berkontribusi nyata di dunia profesional, akademik, dan pesantren." />
                    <a href="{{ route('alumni.index') }}" class="btn-outline shrink-0 font-semibold">
                        <span>Direktori Alumni</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($alumni->take(3) as $person)
                        <figure class="interactive-card flex flex-col justify-between p-6">
                            <blockquote class="text-sm leading-relaxed text-slate-700 italic">
                                “{{ $person->testimonial }}”
                            </blockquote>

                            <figcaption class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-3.5">
                                <div class="flex size-11 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-800 font-bold text-sm">
                                    {{ substr($person->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-950 truncate">{{ $person->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">Lulusan {{ $person->graduation_year }} · {{ $person->occupation ?: $person->university }}</p>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================= --}}
    {{-- 14. INTERACTIVE BOTTOM SPMB BANNER & CTA                          --}}
    {{-- ================================================================= --}}
    <section class="relative overflow-hidden bg-gradient-to-r from-primary-950 via-primary-900 to-slate-950 py-16 text-white">
        <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40"></div>
        <div class="container-app relative flex flex-col items-center justify-between gap-8 text-center sm:flex-row sm:text-left">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-500/10 px-3 py-1 text-xs font-semibold text-gold-300">
                    <x-icon name="sparkles" class="size-3.5" />
                    <span>Pendaftaran Santri Baru (SPMB) 2026/2027</span>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl lg:text-4xl">
                    Siap Memulai Perjalanan Terbaik Bersama Kami?
                </h2>
                <p class="text-sm text-primary-100 leading-relaxed">
                    Konsultasikan peminatan, beasiswa tahfidz, dan proses pendaftaran langsung bersama tim layanan madrasah.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3 shrink-0">
                <button type="button"
                        @click="$store.spmbCalc.open()"
                        class="btn-gold !bg-gold-500 hover:!bg-gold-400 font-bold shadow-glow-gold">
                    <x-icon name="sparkles" class="size-4" />
                    <span>Simulasi Peminatan Santri</span>
                </button>
                <a href="{{ route('contact') }}"
                   class="btn-outline !border-white/20 !bg-white/10 !text-white hover:!bg-white/20">
                    <x-icon name="phone" class="size-4" />
                    <span>Hubungi Madrasah</span>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function heroSlider(slides = []) {
            return {
                slides: slides,
                currentIndex: 0,
                intervalId: null,
                modalPhoto: null,
                autoplayDelay: 6000,
                init() {
                    if (this.slides.length > 1) {
                        this.startAutoplay();
                    }
                    this.$nextTick(() => {
                        if (window.lucide) {
                            window.lucide.createIcons();
                        }
                    });
                },
                startAutoplay() {
                    this.stopAutoplay();
                    this.intervalId = setInterval(() => {
                        this.next();
                    }, this.autoplayDelay);
                },
                stopAutoplay() {
                    if (this.intervalId) {
                        clearInterval(this.intervalId);
                        this.intervalId = null;
                    }
                },
                pause() {
                    this.stopAutoplay();
                },
                resume() {
                    if (this.slides.length > 1 && !this.modalPhoto) {
                        this.startAutoplay();
                    }
                },
                next() {
                    if (this.slides.length === 0) return;
                    this.currentIndex = (this.currentIndex + 1) % this.slides.length;
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },
                prev() {
                    if (this.slides.length === 0) return;
                    this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },
                goTo(index) {
                    this.currentIndex = index;
                    this.startAutoplay();
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                },
                openModal(slide) {
                    this.pause();
                    this.modalPhoto = slide;
                    this.$nextTick(() => {
                        if (window.lucide) window.lucide.createIcons();
                    });
                }
            }
        }
    </script>
    @endpush
</x-layouts.app>
