<x-layouts.app>
    {{-- ================================================================= --}}
    {{-- 1. HERO SLIDER SECTION (AUTHENTIC INSTITUTIONAL SHOWCASE)         --}}
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

            <!-- Banner Slides Viewport -->
            <div class="relative min-h-[480px] sm:min-h-[540px] lg:min-h-[600px] flex items-center">
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

                        <!-- Balanced Directional Gradient Overlay (#002e1a to #006437):
                             Provides solid text readability on the left without drowning the banner photo -->
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-950/95 via-primary-950/65 to-primary-950/30 lg:bg-gradient-to-r lg:from-primary-950/95 lg:via-primary-950/60 lg:to-primary-950/15"></div>
                    </div>
                </template>

                <!-- Slide Content Container -->
                <div class="container-app relative z-10 py-14 sm:py-20 lg:py-24 w-full">
                    <div class="max-w-2xl">
                        <template x-for="(slide, index) in slides" :key="'text-' + slide.id">
                            <div x-show="currentIndex === index"
                                 x-transition:enter="transition ease-out duration-500 delay-100 transform"
                                 x-transition:enter-start="opacity-0 translate-y-4"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="flex flex-col gap-4 sm:gap-5">

                                <!-- Eyebrow / Tagline -->
                                <template x-if="slide.tagline">
                                    <div>
                                        <span class="inline-block rounded-md bg-primary-800/80 border border-gold-400/50 px-3 py-1 text-xs sm:text-sm font-semibold text-gold-300 shadow-sm"
                                              x-text="slide.tagline"></span>
                                    </div>
                                </template>

                                <!-- Title Heading -->
                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white leading-tight text-balance"
                                    x-text="slide.title"></h1>

                                <!-- Subtitle -->
                                <template x-if="slide.subtitle">
                                    <p class="text-base sm:text-lg text-primary-100 leading-relaxed text-pretty font-normal"
                                       x-text="slide.subtitle"></p>
                                </template>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap items-center gap-3 pt-2">
                                    <template x-if="slide.buttonText && slide.buttonUrl">
                                        <a :href="slide.buttonUrl" class="btn-gold !px-5 !py-2.5 text-sm sm:text-base font-bold rounded-lg shadow-sm">
                                            <span x-text="slide.buttonText"></span>
                                            <x-icon name="arrow-right" class="size-4 shrink-0" />
                                        </a>
                                    </template>

                                    <template x-if="slide.secondaryButtonText && slide.secondaryButtonUrl">
                                        <a :href="slide.secondaryButtonUrl" class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2.5 text-sm sm:text-base font-medium text-white border border-white/20 hover:bg-white/20 transition-colors">
                                            <span x-text="slide.secondaryButtonText"></span>
                                        </a>
                                    </template>

                                    <!-- Lightbox Modal Button -->
                                    <button type="button"
                                            @click="openModal(slide)"
                                            class="inline-flex items-center gap-2 rounded-lg bg-primary-900/80 px-3 py-2 text-xs sm:text-sm font-medium text-gold-300 hover:text-white hover:bg-primary-800 border border-primary-700 transition-colors cursor-pointer"
                                            title="Lihat Foto Banner">
                                        <x-icon name="maximize-2" class="size-3.5" />
                                        <span>Lihat Foto Penuh</span>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Slider Navigation Controls -->
                <div class="absolute inset-x-0 bottom-5 z-20 container-app flex items-center justify-between pointer-events-none">
                    <!-- Dots Indicators -->
                    <div class="flex items-center gap-2 pointer-events-auto bg-primary-950/80 border border-primary-800 px-3 py-1.5 rounded-full">
                        <template x-for="(slide, index) in slides" :key="'dot-' + slide.id">
                            <button type="button"
                                    @click="goTo(index)"
                                    class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                                    :class="currentIndex === index ? 'w-6 bg-gold-400' : 'w-2 bg-primary-700 hover:bg-primary-500'"
                                    :aria-label="'Pindah ke slide ' + (index + 1)"></button>
                        </template>
                    </div>

                    <!-- Slide Numbers & Prev/Next Buttons -->
                    <div class="flex items-center gap-2 pointer-events-auto">
                        <div class="hidden sm:flex items-center rounded-full bg-primary-950/80 border border-primary-800 px-3 py-1 text-xs font-mono text-primary-200">
                            <span x-text="String(currentIndex + 1).padStart(2, '0')" class="font-bold text-gold-300"></span>
                            <span class="mx-1 text-primary-600">/</span>
                            <span x-text="String(slides.length).padStart(2, '0')"></span>
                        </div>

                        <button type="button"
                                @click="prev()"
                                class="flex size-9 sm:size-10 items-center justify-center rounded-full bg-primary-950/80 border border-primary-800 text-white hover:bg-primary-600 transition-colors cursor-pointer"
                                aria-label="Slide sebelumnya">
                            <x-icon name="chevron-left" class="size-4" />
                        </button>
                        <button type="button"
                                @click="next()"
                                class="flex size-9 sm:size-10 items-center justify-center rounded-full bg-primary-950/80 border border-primary-800 text-white hover:bg-primary-600 transition-colors cursor-pointer"
                                aria-label="Slide berikutnya">
                            <x-icon name="chevron-right" class="size-4" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lightbox Modal -->
            <div x-show="modalPhoto"
                 x-cloak
                 @keydown.escape.window="modalPhoto = null"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
                 role="dialog"
                 aria-modal="true">
                <div class="fixed inset-0 bg-primary-950/90" @click="modalPhoto = null"></div>

                <div class="relative z-10 w-full max-w-4xl overflow-hidden rounded-2xl bg-primary-900 border border-primary-700 shadow-2xl" @click.stop>
                    <button type="button"
                            @click="modalPhoto = null"
                            class="absolute right-4 top-4 z-20 flex size-9 items-center justify-center rounded-full bg-black/70 text-white hover:bg-rose-600 transition-colors cursor-pointer"
                            aria-label="Tutup foto">
                        <x-icon name="x" class="size-5" />
                    </button>

                    <div class="bg-primary-950 flex items-center justify-center max-h-[75vh] overflow-hidden">
                        <img :src="modalPhoto?.imageUrl" :alt="modalPhoto?.title" class="max-h-[75vh] w-full object-contain mx-auto">
                    </div>

                    <div class="p-5 bg-primary-900 border-t border-primary-800">
                        <h3 class="text-lg font-bold text-white" x-text="modalPhoto?.title"></h3>
                        <template x-if="modalPhoto?.subtitle">
                            <p class="mt-1 text-sm text-primary-200" x-text="modalPhoto?.subtitle"></p>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Fallback Static Hero -->
        <section class="bg-primary-950 py-16 sm:py-24 text-white">
            <div class="container-app max-w-4xl text-center mx-auto">
                <span class="inline-block rounded-md bg-primary-800/80 border border-gold-400/40 px-3 py-1 text-xs sm:text-sm font-semibold text-gold-300">
                    Madrasah Aliyah Berbasis Pesantren di Gresik
                </span>
                <h1 class="mt-5 text-3xl sm:text-5xl font-bold tracking-tight text-white text-balance leading-tight">
                    {{ setting('hero.title', 'Membentuk Generasi Berilmu, Berakhlak, dan Berkarakter Pesantren') }}
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-base sm:text-lg text-primary-100 leading-relaxed text-pretty">
                    {{ setting('hero.subtitle', 'MA Ma’arif NU Assa’adah menghadirkan pendidikan yang memadukan keunggulan akademik, tradisi pesantren, dan teknologi masa depan.') }}
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('about') }}" class="btn-gold !px-5 !py-2.5 text-base font-bold rounded-lg shadow-sm">
                        Kenali Madrasah <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                    <a href="{{ route('programs') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2.5 text-base font-medium text-white border border-white/20 hover:bg-white/20 transition-colors">
                        Program Pendidikan
                    </a>
                </div>
            </div>
        </section>
    @endif


    {{-- ================================================================= --}}
    {{-- 2. KILAS STATISTIK MADRASAH (CLEAN DATA STRIP)                    --}}
    {{-- ================================================================= --}}
    <section class="bg-white border-b border-slate-200/80 py-8">
        <div class="container-app">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Stat 1 -->
                <div class="flex items-center gap-3.5 p-3 sm:p-4 rounded-xl border border-slate-100 bg-primary-50/50">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-primary-600 text-white shadow-sm">
                        <x-icon name="users" class="size-5" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl sm:text-2xl font-bold tabular-nums text-slate-900">
                            {{ setting('stats.students', 0) }}+
                        </p>
                        <p class="text-xs font-medium text-slate-600">Peserta Didik</p>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="flex items-center gap-3.5 p-3 sm:p-4 rounded-xl border border-slate-100 bg-primary-50/50">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-primary-800 text-gold-300 shadow-sm">
                        <x-icon name="graduation-cap" class="size-5" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl sm:text-2xl font-bold tabular-nums text-slate-900">
                            {{ $teacherCount ?: setting('stats.teachers', 0) }}
                        </p>
                        <p class="text-xs font-medium text-slate-600">Guru & Tendik</p>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="flex items-center gap-3.5 p-3 sm:p-4 rounded-xl border border-slate-100 bg-primary-50/50">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-primary-600 text-white shadow-sm">
                        <x-icon name="trophy" class="size-5" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl sm:text-2xl font-bold tabular-nums text-slate-900">
                            {{ setting('stats.achievements', 0) }}+
                        </p>
                        <p class="text-xs font-medium text-slate-600">Prestasi Juara</p>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="flex items-center gap-3.5 p-3 sm:p-4 rounded-xl border border-slate-100 bg-primary-50/50">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-primary-800 text-gold-300 shadow-sm">
                        <x-icon name="user-check" class="size-5" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-xl sm:text-2xl font-bold tabular-nums text-slate-900">
                            {{ setting('stats.alumni', 0) }}+
                        </p>
                        <p class="text-xs font-medium text-slate-600">Alumni Tersebar</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================= --}}
    {{-- 3. AKSES CEPAT (QUICK NAVIGATION BAR)                             --}}
    {{-- ================================================================= --}}
    <nav aria-label="Akses Cepat Madrasah" class="bg-slate-50/50 py-8 border-b border-slate-200/80">
        <div class="container-app">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                @foreach ([
                    ['berita.index', 'newspaper', 'Berita', 'Kabar Madrasah'],
                    ['pengumuman.index', 'megaphone', 'Pengumuman', 'Edaran Resmi'],
                    ['agenda.index', 'calendar-days', 'Agenda', 'Jadwal Kegiatan'],
                    ['prestasi.index', 'trophy', 'Prestasi', 'Capaian Siswa'],
                    ['gallery.photos', 'images', 'Galeri', 'Dokumentasi'],
                    ['downloads.index', 'download', 'Unduhan', 'Pusat Berkas']
                ] as [$route, $icon, $label, $sub])
                    <a href="{{ route($route) }}"
                       class="group flex flex-col items-center text-center p-4 rounded-xl bg-white border border-slate-200 shadow-sm hover:border-primary-600 hover:shadow-md transition-all duration-200">
                        <div class="flex size-11 items-center justify-center rounded-lg bg-primary-50 text-primary-700 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                            <x-icon :name="$icon" class="size-5 shrink-0" />
                        </div>
                        <span class="mt-3 font-semibold text-slate-900 text-sm group-hover:text-primary-700 transition-colors">
                            {{ $label }}
                        </span>
                        <span class="text-[11px] text-slate-500 mt-0.5">
                            {{ $sub }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </nav>


    {{-- ================================================================= --}}
    {{-- 4. TENTANG MADRASAH (EDITORIAL OVERVIEW)                          --}}
    {{-- ================================================================= --}}
    <section class="bg-white py-16 sm:py-20 border-b border-slate-200/80">
        <div class="container-app grid items-center gap-10 lg:grid-cols-2">
            <!-- Left: Campus Image Frame -->
            <div class="relative">
                <div class="aspect-[16/11] overflow-hidden rounded-2xl bg-slate-100 border border-slate-200 shadow-sm">
                    @if($aboutPage?->cover)
                        <img src="{{ asset('storage/'.$aboutPage->cover) }}"
                             alt="Gedung MA Ma’arif NU Assa’adah"
                             class="size-full object-cover">
                    @else
                        <div class="flex size-full flex-col items-center justify-center p-8 text-center bg-slate-50">
                            <x-icon name="school" class="size-12 text-primary-700" />
                            <p class="mt-3 font-semibold text-slate-800">MA Ma'arif NU Assa'adah</p>
                            <p class="text-xs text-slate-500">Bungah, Gresik, Jawa Timur</p>
                        </div>
                    @endif
                </div>

                <!-- Accreditation Plaque -->
                <div class="mt-3 flex items-center justify-between rounded-xl bg-primary-950 px-4 py-2.5 text-white border border-primary-900">
                    <div class="flex items-center gap-2">
                        <x-icon name="award" class="size-4 text-gold-400" />
                        <span class="text-xs font-semibold text-gold-300">Terakreditasi "A"</span>
                    </div>
                    <span class="text-xs text-primary-200">Pendidikan Terpadu Berbasis Pesantren</span>
                </div>
            </div>

            <!-- Right: Content & 4 Pillars -->
            <div class="flex flex-col gap-5">
                <x-section-header eyebrow="Tentang Madrasah"
                                  title="Berakar pada Nilai Pesantren, Bergerak Bersama Zaman"
                                  description="MA Ma’arif NU Assa’adah memadukan kurikulum akademik modern, penguatan karakter pesantren, nilai-nilai keislaman Ahlussunnah wal Jama'ah, dan kecakapan teknologi." />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-3.5">
                        <div class="flex items-center gap-2">
                            <x-icon name="shield-check" class="size-4 text-primary-700" />
                            <h3 class="font-bold text-slate-900 text-sm">Berkarakter</h3>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">Pembiasaan akhlak santri, adab islami, dan keteladanan dalam keseharian.</p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-3.5">
                        <div class="flex items-center gap-2">
                            <x-icon name="sparkles" class="size-4 text-primary-700" />
                            <h3 class="font-bold text-slate-900 text-sm">Cakap</h3>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">Pembelajaran sains dan teknologi yang menguatkan kompetensi abad ke-21.</p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-3.5">
                        <div class="flex items-center gap-2">
                            <x-icon name="book-open" class="size-4 text-primary-700" />
                            <h3 class="font-bold text-slate-900 text-sm">Cendekia</h3>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">Budaya literasi mendalam, riset keilmuan, dan berpikir kritis berbobot.</p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-3.5">
                        <div class="flex items-center gap-2">
                            <x-icon name="landmark" class="size-4 text-primary-700" />
                            <h3 class="font-bold text-slate-900 text-sm">Berjiwa Pesantren</h3>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">Kedalaman ilmu agama dan tradisi keislaman yang ramah serta moderat.</p>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('about') }}" class="btn-primary !px-4 !py-2 text-sm font-semibold rounded-lg">
                        Selengkapnya tentang Madrasah <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================= --}}
    {{-- 5. SAMBUTAN KEPALA MADRASAH                                       --}}
    {{-- ================================================================= --}}
    <section class="bg-primary-950 py-16 sm:py-20 text-white border-b border-primary-900">
        <div class="container-app grid items-center gap-10 lg:grid-cols-[1fr_2fr]">
            <!-- Principal Photo Plaque -->
            <div class="mx-auto w-full max-w-xs">
                <div class="overflow-hidden rounded-2xl bg-primary-900 border border-primary-800 shadow-md">
                    @if(setting('principal.photo'))
                        <img src="{{ asset('storage/'.setting('principal.photo')) }}"
                             alt="{{ setting('principal.name') }}"
                             class="aspect-[4/5] w-full object-cover">
                    @else
                        <div class="flex aspect-[4/5] items-center justify-center bg-primary-900">
                            <x-icon name="user-round" class="size-16 text-primary-400" />
                        </div>
                    @endif
                    <div class="p-3.5 text-center bg-primary-950 border-t border-primary-800">
                        <p class="font-bold text-white text-sm">{{ setting('principal.name', 'Kepala Madrasah') }}</p>
                        <p class="text-xs text-gold-300 font-medium mt-0.5">{{ setting('principal.position', 'Kepala MA Ma’arif NU Assa’adah') }}</p>
                    </div>
                </div>
            </div>

            <!-- Principal Message -->
            <div class="flex flex-col gap-4 sm:gap-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-300">
                    Sambutan Kepala Madrasah
                </p>

                <blockquote class="text-xl sm:text-2xl lg:text-3xl font-semibold leading-snug tracking-tight text-white text-pretty">
                    “Selamat datang di website resmi MA Ma’arif NU Assa’adah. Kami berikhtiar menghadirkan ruang belajar yang menyeimbangkan keunggulan akademik, keluhuran akhlak, dan tradisi pesantren.”
                </blockquote>

                <p class="text-sm sm:text-base text-primary-100 leading-relaxed max-w-2xl font-normal">
                    Melalui kurikulum terpadu dan pembinaan intensif, kami mendampingi setiap peserta didik agar siap menghadapi tantangan zaman dengan integritas dan keilmuan yang kokoh.
                </p>

                <div class="pt-2">
                    <a href="{{ route('sambutan') }}" class="btn-gold !px-5 !py-2.5 text-sm font-bold rounded-lg">
                        Baca Sambutan Lengkap <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================= --}}
    {{-- 6. PROGRAM UNGGULAN                                               --}}
    {{-- ================================================================= --}}
    @if ($programs->isNotEmpty())
        <section class="py-16 sm:py-20 bg-slate-50/50 border-b border-slate-200/80">
            <div class="container-app">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Program Unggulan"
                                      title="Ruang Tumbuh untuk Setiap Potensi"
                                      description="Program terarah yang menyeimbangkan kompetensi akademik, nilai keislaman, dan keterampilan masa depan." />
                    <a href="{{ route('programs') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-primary-700 hover:text-primary-800">
                        Semua program <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($programs as $program)
                        <div class="group flex flex-col justify-between rounded-xl bg-white p-5 border border-slate-200 shadow-sm hover:border-primary-600 hover:shadow-md transition-all duration-200">
                            <div>
                                <div class="flex size-11 items-center justify-center rounded-lg bg-primary-50 text-primary-700 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                                    <x-icon name="sparkles" class="size-5" />
                                </div>
                                <h3 class="mt-4 text-base font-bold text-slate-900 group-hover:text-primary-700 transition-colors">
                                    {{ $program->name }}
                                </h3>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    {{ $program->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- ================================================================= --}}
    {{-- 7. BERITA TERBARU & ARTIKEL                                       --}}
    {{-- ================================================================= --}}
    <section class="bg-white py-16 sm:py-20 border-b border-slate-200/80">
        <div class="container-app">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <x-section-header eyebrow="Kabar Madrasah"
                                  title="Berita & Artikel Terbaru"
                                  description="Ikuti perkembangan, prestasi, dan kegiatan terkini dari civitas akademika MA Ma'arif NU Assa'adah." />
                <a href="{{ route('berita.index') }}" class="btn-outline !py-2 shrink-0 inline-flex items-center gap-1.5 text-sm font-medium rounded-lg">
                    Semua Berita <x-icon name="arrow-right" class="size-4 shrink-0" />
                </a>
            </div>

            @if ($posts->isNotEmpty())
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            @else
                <div class="mt-8">
                    <x-empty-state title="Belum ada berita" description="Berita terbaru akan tampil di bagian ini segera." />
                </div>
            @endif
        </div>
    </section>


    {{-- ================================================================= --}}
    {{-- 8. INFORMASI TERKINI: PENGUMUMAN & AGENDA                         --}}
    {{-- ================================================================= --}}
    <section class="py-16 sm:py-20 bg-slate-50/50 border-b border-slate-200/80">
        <div class="container-app grid gap-8 lg:grid-cols-2">
            <!-- Kolom 1: Pengumuman Resmi -->
            <div class="flex flex-col rounded-2xl bg-white p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-primary-100 text-primary-800">
                            <x-icon name="megaphone" class="size-4" />
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Pengumuman</h2>
                            <p class="text-xs text-slate-500">Informasi dan edaran resmi</p>
                        </div>
                    </div>
                    <a href="{{ route('pengumuman.index') }}" class="text-xs font-semibold text-primary-700 hover:text-primary-800 inline-flex items-center gap-1">
                        Lihat semua <x-icon name="arrow-right" class="size-3" />
                    </a>
                </div>

                <div class="mt-3 divide-y divide-slate-100">
                    @forelse ($announcements as $announcement)
                        <a href="{{ route('pengumuman.show', $announcement) }}" class="group flex items-start gap-3 py-3.5 transition hover:bg-slate-50 rounded-lg px-2 -mx-2">
                            <div class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded bg-slate-100 text-slate-600 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                                <x-icon name="bell" class="size-3.5" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-medium text-slate-900 text-sm group-hover:text-primary-700 transition-colors line-clamp-2">
                                    {{ $announcement->title }}
                                </h3>
                                <div class="mt-1 flex items-center gap-2 text-xs text-slate-500">
                                    <span>{{ $announcement->publish_date->translatedFormat('d M Y') }}</span>
                                    @if($announcement->is_important)
                                        <span class="inline-flex items-center rounded bg-rose-50 px-1.5 py-0.5 text-[10px] font-semibold text-rose-700 border border-rose-200">
                                            Penting
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="py-6 text-center text-xs text-slate-500">Belum ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </div>

            <!-- Kolom 2: Agenda Kegiatan -->
            <div class="flex flex-col rounded-2xl bg-white p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-primary-100 text-primary-800">
                            <x-icon name="calendar-days" class="size-4" />
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Agenda Terdekat</h2>
                            <p class="text-xs text-slate-500">Jadwal kegiatan madrasah</p>
                        </div>
                    </div>
                    <a href="{{ route('agenda.index') }}" class="text-xs font-semibold text-primary-700 hover:text-primary-800 inline-flex items-center gap-1">
                        Lihat semua <x-icon name="arrow-right" class="size-3" />
                    </a>
                </div>

                <div class="mt-3 divide-y divide-slate-100">
                    @forelse ($events as $event)
                        <a href="{{ route('agenda.show', $event) }}" class="group flex items-start gap-3 py-3.5 transition hover:bg-slate-50 rounded-lg px-2 -mx-2">
                            <!-- Date Box -->
                            <time class="flex size-11 shrink-0 flex-col items-center justify-center rounded-lg bg-primary-950 text-center text-white border border-primary-900"
                                  datetime="{{ $event->start_date->toDateString() }}">
                                <span class="text-sm font-bold leading-none tabular-nums text-white">{{ $event->start_date->format('d') }}</span>
                                <span class="text-[9px] font-bold text-gold-400 uppercase mt-0.5">{{ $event->start_date->translatedFormat('M') }}</span>
                            </time>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-medium text-slate-900 text-sm group-hover:text-primary-700 transition-colors line-clamp-2">
                                    {{ $event->title }}
                                </h3>
                                <div class="mt-1 flex items-center gap-1 text-xs text-slate-500">
                                    <x-icon name="map-pin" class="size-3 shrink-0 text-slate-400" />
                                    <span class="truncate">{{ $event->location ?: 'MA Ma’arif NU Assa’adah' }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="py-6 text-center text-xs text-slate-500">Belum ada agenda mendatang.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================= --}}
    {{-- 9. PRESTASI TERBARU                                               --}}
    {{-- ================================================================= --}}
    @if($achievements->isNotEmpty())
        <section class="bg-white py-16 sm:py-20 border-b border-slate-200/80">
            <div class="container-app">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Capaian Madrasah"
                                      title="Prestasi & Penghargaan"
                                      description="Apresiasi atas dedikasi dan kerja keras peserta didik, guru, dan tim madrasah." />
                    <a href="{{ route('prestasi.index') }}" class="btn-outline !py-2 shrink-0 inline-flex items-center gap-1.5 text-sm font-medium rounded-lg">
                        Semua Prestasi <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($achievements as $achievement)
                        <article class="group flex flex-col justify-between rounded-xl bg-slate-50/60 p-5 border border-slate-200 hover:bg-white hover:shadow-md transition-all duration-200">
                            <div>
                                <div class="flex items-center justify-between gap-3">
                                    <span class="inline-block rounded bg-primary-50 px-2 py-0.5 text-xs font-semibold text-primary-800 border border-primary-200">
                                        Tingkat {{ ucfirst($achievement->level) }}
                                    </span>
                                    <x-icon name="trophy" class="size-4 text-primary-700" />
                                </div>
                                <h3 class="mt-3 text-base font-bold text-slate-900 group-hover:text-primary-700 transition-colors">
                                    {{ $achievement->title }}
                                </h3>
                                <p class="mt-1.5 text-xs sm:text-sm font-medium text-slate-600">
                                    {{ $achievement->participant }}
                                </p>
                            </div>

                            @if($achievement->achieved_date)
                                <div class="mt-4 pt-3 border-t border-slate-200 text-xs text-slate-500">
                                    Diraih: {{ $achievement->achieved_date->translatedFormat('d M Y') }}
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- ================================================================= --}}
    {{-- 10. EKSTRAKURIKULER (KESISWAAN)                                   --}}
    {{-- ================================================================= --}}
    @if($extracurriculars->isNotEmpty())
        <section class="py-16 sm:py-20 bg-slate-50/50 border-b border-slate-200/80">
            <div class="container-app">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Kesiswaan & Minat Bakat"
                                      title="Eksplorasi Minat & Bakat Siswa"
                                      description="Kegiatan ekstrakurikuler yang membantu siswa bertumbuh dan mengembangkan potensi diri." />
                    <a href="{{ route('extracurricular') }}" class="inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-primary-700 hover:text-primary-800">
                        Semua Kegiatan <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach($extracurriculars as $item)
                        <a href="{{ route('extracurricular.show', $item) }}"
                           class="group flex flex-col items-center text-center p-4 rounded-xl bg-white border border-slate-200 shadow-sm hover:border-primary-600 hover:shadow-md transition-all duration-200">
                            <div class="flex size-11 items-center justify-center rounded-lg bg-primary-50 text-primary-700 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-200">
                                <x-icon name="activity" class="size-5" />
                            </div>
                            <h3 class="mt-3 font-semibold text-slate-900 text-xs sm:text-sm group-hover:text-primary-700 transition-colors">
                                {{ $item->name }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- ================================================================= --}}
    {{-- 11. GALERI DOKUMENTASI KEGIATAN                                   --}}
    {{-- ================================================================= --}}
    @if($albums->isNotEmpty())
        <section class="bg-primary-950 py-16 sm:py-20 text-white border-b border-primary-900">
            <div class="container-app">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header theme="dark"
                                      eyebrow="Dokumentasi"
                                      title="Galeri Kegiatan Madrasah"
                                      description="Momen pembelajaran, keagamaan, prestasi, dan kebersamaan warga madrasah." />
                    <a href="{{ route('gallery.photos') }}" class="btn-gold !py-2 shrink-0 inline-flex items-center gap-1.5 text-sm font-bold rounded-lg">
                        Lihat Semua Foto <x-icon name="arrow-right" class="size-4 shrink-0" />
                    </a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($albums as $album)
                        <a href="{{ route('gallery.album', $album) }}" class="group block overflow-hidden rounded-xl bg-primary-900 border border-primary-800 hover:border-primary-600 transition-colors">
                            <div class="aspect-square overflow-hidden bg-primary-950">
                                @if($album->cover)
                                    <img src="{{ asset('storage/'.$album->cover) }}"
                                         alt="{{ $album->name }}"
                                         loading="lazy"
                                         class="size-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex size-full items-center justify-center bg-primary-900">
                                        <x-icon name="images" class="size-8 text-primary-400" />
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 bg-primary-900">
                                <span class="text-[11px] text-gold-300 font-medium">
                                    {{ $album->photos_count }} foto
                                </span>
                                <h3 class="mt-1 font-semibold text-white text-sm line-clamp-1 group-hover:text-gold-300 transition-colors">
                                    {{ $album->name }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- ================================================================= --}}
    {{-- 12. JEJAK ALUMNI (TESTIMONI)                                      --}}
    {{-- ================================================================= --}}
    @if($alumni->isNotEmpty())
        <section class="bg-white py-16 sm:py-20 border-b border-slate-200/80">
            <div class="container-app">
                <x-section-header eyebrow="Jejak Alumni"
                                  title="Tumbuh & Berkarya di Berbagai Bidang"
                                  description="Kisah inspiratif para alumni yang melanjutkan pendidikan, berkarier, dan berkontribusi bagi masyarakat." />

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($alumni as $person)
                        <figure class="flex flex-col justify-between rounded-xl bg-slate-50/70 p-5 border border-slate-200">
                            <blockquote>
                                <p class="text-slate-700 text-sm leading-relaxed italic">
                                    “{{ $person->testimonial }}”
                                </p>
                            </blockquote>

                            <figcaption class="mt-5 pt-4 border-t border-slate-200 flex items-center gap-3">
                                @if($person->photo)
                                    <img src="{{ asset('storage/'.$person->photo) }}"
                                         alt="{{ $person->name }}"
                                         class="size-10 shrink-0 rounded-full object-cover border border-slate-200">
                                @else
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-800 font-bold text-sm">
                                        {{ substr($person->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-900 text-sm">{{ $person->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate">
                                        Lulusan {{ $person->graduation_year }} · {{ $person->occupation ?: $person->university }}
                                    </p>
                                </div>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- ================================================================= --}}
    {{-- 13. CALL TO ACTION BANNER                                         --}}
    {{-- ================================================================= --}}
    <section class="bg-primary-950 py-14 sm:py-16 text-white border-b border-primary-900">
        <div class="container-app flex flex-col justify-between items-center gap-6 md:flex-row text-center md:text-left">
            <div class="max-w-2xl">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Ingin Mengenal MA Ma'arif NU Assa'adah Lebih Dekat?
                </h2>
                <p class="mt-2 text-sm sm:text-base text-primary-100">
                    Hubungi kami atau kunjungi kampus untuk informasi kurikulum, program unggulan, dan kegiatan madrasah.
                </p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('contact') }}" class="btn-gold !px-6 !py-3 text-base font-bold rounded-lg shadow-sm">
                    Hubungi Madrasah <x-icon name="arrow-right" class="size-4 shrink-0" />
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
