<x-layouts.app>
    {{-- 1. Experimental Hero Section with Islamic Geometric Canvas & Live Prayer Card --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-primary-950 via-primary-900 to-slate-950 text-white py-16 sm:py-24 lg:py-28">
        {{-- Background Glows & Arabesque Lattice --}}
        <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-50"></div>
        <div class="pointer-events-none absolute -top-40 -left-40 size-[500px] rounded-full bg-emerald-500/15 blur-[120px]"></div>
        <div class="pointer-events-none absolute top-1/2 -right-40 size-[500px] rounded-full bg-gold-500/15 blur-[120px]"></div>

        {{-- Arabic Verse Watermark --}}
        <div class="pointer-events-none absolute top-6 right-8 select-none text-right font-arabic text-3xl sm:text-5xl lg:text-7xl font-bold text-white/[0.03] leading-tight" dir="rtl">
            يَرْفَعِ اللَّهُ الَّذِينَ آمَنُوا مِنكُمْ وَالَّذِينَ أُوتُوا الْعِلْمَ دَرَجَاتٍ
        </div>

        <div class="container-app relative grid items-center gap-12 lg:grid-cols-12">
            {{-- Left Column: Hero Copy & CTA --}}
            <div class="lg:col-span-7 flex flex-col gap-6">
                <div class="inline-flex items-center gap-2.5 rounded-full border border-gold-400/40 bg-gold-500/15 px-4 py-1.5 text-xs font-semibold text-gold-300 backdrop-blur-md w-fit">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-gold-400"></span>
                    </span>
                    <span>Membentuk Generasi Berilmu · MA Ma'arif NU Assa'adah Bungah Gresik</span>
                </div>

                <div class="space-y-3">
                    <h1 class="text-balance text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl text-white">
                        <span class="block text-gradient-gold">{{ setting('hero.title', 'Membentuk Generasi Berilmu, Cakap, dan Berkarakter Pesantren') }}</span>
                    </h1>
                    <p class="max-w-[62ch] text-pretty text-base leading-relaxed text-slate-200 sm:text-lg">
                        {{ setting('hero.subtitle', 'Pendidikan tingkat menengah atas di bawah naungan Pondok Pesantren Qomaruddin Bungah Gresik. Memadukan kurikulum nasional Kementerian Agama, sains riset modern, hafalan Al-Qur\'an bersanad, dan kajian kitab kuning turats salaf.') }}
                    </p>
                </div>

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

                {{-- Fast Features Ticker --}}
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

            {{-- Right Column: Interactive Bento Hub & Stats Card --}}
            <div class="lg:col-span-5 space-y-4">
                {{-- Live Prayer Card in Hero --}}
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

                {{-- Interactive Stats Bento Grid --}}
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

    {{-- 2. Running Institutional Marquee Ticker --}}
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
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-slate-200">
                <x-icon name="award" class="size-3.5 text-gold-400" />
                <span>LEBIH DARI 50 TAHUN MENCETAK GENERASI SANTRI CENDEKIA</span>
            </span>
            <span class="text-slate-600">·</span>
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-gold-300">
                <x-icon name="book-open" class="size-3.5 text-gold-400" />
                <span>INTEGRASI KURIKULUM MERDEKA & KAJIAN TURATS KITAB KUNING</span>
            </span>
            <span class="text-slate-600">·</span>
            <span class="flex items-center gap-2 text-xs font-semibold tracking-wide text-emerald-400">
                <x-icon name="sparkles" class="size-3.5 text-emerald-400" />
                <span>PENERIMAAN SANTRI BARU (SPMB) TAHUN AJARAN 2026/2027 TELAH DIBUKA</span>
            </span>
        </div>
    </div>

    {{-- 3. Quick Bento Access Grid --}}
    <section aria-label="Akses Cepat Madrasah" class="relative -mt-6 z-20">
        <div class="container-app">
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6 rounded-3xl border border-slate-200/80 bg-white p-3 shadow-lift">
                @foreach ([
                    ['berita.index', 'newspaper', 'Berita Madrasah', 'bg-emerald-50 text-emerald-700'],
                    ['pengumuman.index', 'megaphone', 'Pengumuman Resmi', 'bg-amber-50 text-amber-700'],
                    ['agenda.index', 'calendar-days', 'Agenda Kegiatan', 'bg-blue-50 text-blue-700'],
                    ['prestasi.index', 'trophy', 'Prestasi Santri', 'bg-purple-50 text-purple-700'],
                    ['gallery.photos', 'images', 'Galeri Kegiatan', 'bg-rose-50 text-rose-700'],
                    ['downloads.index', 'download', 'Pusat Unduhan', 'bg-teal-50 text-teal-700'],
                ] as [$route, $icon, $label, $colorClass])
                    <a href="{{ route($route) }}"
                       class="group flex flex-col items-center justify-center rounded-2xl p-4 text-center transition duration-200 hover:bg-slate-50 hover:shadow-soft">
                        <span class="flex size-12 items-center justify-center rounded-2xl {{ $colorClass }} transition duration-300 group-hover:scale-110 group-hover:shadow-soft">
                            <x-icon :name="$icon" class="size-6 shrink-0" />
                        </span>
                        <span class="mt-2.5 text-xs font-bold text-slate-800 group-hover:text-primary-800">{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. Tentang Madrasah & 4 Pilar Karakter --}}
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
                    <div data-tilt class="tilt-card rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-primary-100 text-primary-800">
                            <x-icon name="heart" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Berakhlak Mulia</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Keteladanan adab thalabul 'ilmi, sholat dhuha dan dhuhur berjamaah, serta kepatuhan santun kepada guru dan orang tua.</p>
                    </div>

                    <div data-tilt class="tilt-card rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-gold-100 text-gold-800">
                            <x-icon name="sparkles" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Cakap & Terampil</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Penguasaan teknologi digital, robotika, coding, public speaking 3 bahasa, dan jiwa kepemimpinan organisasi.</p>
                    </div>

                    <div data-tilt class="tilt-card rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800">
                            <x-icon name="brain" class="size-5" />
                        </div>
                        <h4 class="mt-3 text-base font-bold text-slate-950">Cendekia & Kritis</h4>
                        <p class="mt-1 text-xs leading-relaxed text-slate-600">Budaya literasi sains, riset MYRES, bimbingan olimpiade sains (KSM), dan tembus seleksi PTN favorit dan beasiswa Timur Tengah.</p>
                    </div>

                    <div data-tilt class="tilt-card rounded-2xl border border-slate-200/80 bg-slate-50/70 p-5 transition hover:border-primary-500/40 hover:bg-primary-50/50 hover:shadow-soft">
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

    {{-- 5. Sambutan Kepala Madrasah --}}
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40"></div>
        <div class="container-app relative grid items-center gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div data-tilt class="tilt-card relative mx-auto max-w-sm overflow-hidden rounded-3xl border border-gold-400/30 bg-primary-950 shadow-lift p-2">
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

                <div class="border-t border-white/10 pt-4 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold text-white">{{ setting('principal.name', 'Mohammad Isma\'il Cholilur Rohman, M.Pd.') }}</p>
                        <p class="text-xs text-emerald-400">Kepala Madrasah Masa Khidmah 2023 - 2027</p>
                    </div>
                    <a href="{{ route('sambutan') }}" class="btn-gold !bg-gold-500 hover:!bg-gold-400 text-gold-950 font-bold">
                        <span>Baca Sambutan Lengkap</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. Program Unggulan & Peminatan Santri --}}
    @if ($programs->isNotEmpty())
        <section class="py-20 sm:py-24 bg-slate-50 relative">
            <div class="container-app space-y-12">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Pilihan Peminatan & Program"
                                      title="Ruang Tumbuh Optimal untuk Setiap Potensi Santri"
                                      description="Pilihan kurikulum peminatan MIPA, IPS, dan Keagamaan yang dirancang sistematis untuk menghantarkan santri menuju masa depan gemilang." />
                    <button type="button" @click="$store.spmbCalc.open()"
                            class="btn-gold shrink-0 font-bold shadow-soft">
                        <x-icon name="sparkles" class="size-4" />
                        <span>Simulasi Minat Bakat</span>
                    </button>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($programs as $program)
                        <div class="interactive-card spotlight-card group flex flex-col justify-between p-6">
                            <div>
                                <div class="flex size-12 items-center justify-center rounded-2xl bg-primary-100 text-primary-700 transition duration-300 group-hover:bg-primary-600 group-hover:text-white group-hover:scale-105">
                                    <x-icon name="graduation-cap" class="size-6" />
                                </div>
                                <h3 class="mt-5 text-xl font-bold tracking-tight text-slate-950 group-hover:text-primary-700 transition">{{ $program->name }}</h3>
                                <p class="mt-2 text-xs leading-relaxed text-slate-600 line-clamp-4">{{ $program->description }}</p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('programs.show', $program) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-700 hover:text-primary-800">
                                    <span>Kurikulum & Syarat</span>
                                    <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                                </a>
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">Aktif</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 7. Berita Terbaru Madrasah (Invariant: 'Berita terbaru') --}}
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
                <x-empty-state title="Belum ada berita" description="Berita terbaru akan segera diperbarui melalui CMS." />
            @endif
        </div>
    </section>

    {{-- 8. Pengumuman & Agenda Terdekat Bento Grid --}}
    <section class="py-20 bg-slate-50 relative">
        <div class="container-app grid gap-10 lg:grid-cols-2">
            {{-- Pengumuman --}}
            <div class="space-y-6">
                <div class="flex items-end justify-between gap-4">
                    <x-section-header eyebrow="Informasi Penting" title="Pengumuman Resmi" />
                    <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-primary-700 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-200/80 rounded-3xl border border-slate-200/80 bg-white p-2 shadow-soft">
                    @forelse ($announcements as $announcement)
                        <a href="{{ route('pengumuman.show', $announcement) }}"
                           class="group flex gap-4 p-4 rounded-2xl transition hover:bg-primary-50/60">
                            <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-800 transition group-hover:bg-amber-500 group-hover:text-white">
                                <x-icon name="megaphone" class="size-5" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-primary-800 transition line-clamp-1">
                                    {{ $announcement->title }}
                                </h4>
                                <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <x-icon name="calendar" class="size-3 text-slate-400" />
                                        <span>{{ $announcement->publish_date->translatedFormat('d M Y') }}</span>
                                    </span>
                                    <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-semibold text-slate-600 uppercase">Resmi</span>
                                </div>
                            </div>
                            <x-icon name="chevron-right" class="size-4 shrink-0 text-slate-300 self-center transition group-hover:translate-x-1 group-hover:text-primary-600" />
                        </a>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-500">Belum ada pengumuman baru.</div>
                    @endforelse
                </div>
            </div>

            {{-- Agenda Terdekat --}}
            <div class="space-y-6">
                <div class="flex items-end justify-between gap-4">
                    <x-section-header eyebrow="Kalender Madrasah" title="Agenda Terdekat" />
                    <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-primary-700 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="divide-y divide-white/10 rounded-3xl border border-primary-500/20 bg-primary-950 p-2 text-white shadow-lift">
                    @forelse ($events as $event)
                        <a href="{{ route('agenda.show', $event) }}"
                           class="group flex gap-4 p-4 rounded-2xl transition hover:bg-white/5">
                            <time class="flex size-12 shrink-0 flex-col items-center justify-center rounded-xl bg-gold-400 text-primary-950 font-bold leading-none text-center shadow-soft"
                                  datetime="{{ $event->start_date->toDateString() }}">
                                <span class="text-base font-extrabold">{{ $event->start_date->format('d') }}</span>
                                <span class="text-[9px] uppercase tracking-wider font-semibold">{{ $event->start_date->translatedFormat('M') }}</span>
                            </time>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-bold text-white group-hover:text-gold-300 transition line-clamp-1">
                                    {{ $event->title }}
                                </h4>
                                <p class="mt-1 flex items-center gap-1.5 text-xs text-primary-200">
                                    <x-icon name="map-pin" class="size-3 text-gold-400 shrink-0" />
                                    <span class="truncate">{{ $event->location ?: 'Kompleks Pesantren Qomaruddin' }}</span>
                                </p>
                            </div>
                            <x-icon name="chevron-right" class="size-4 shrink-0 text-primary-400 self-center transition group-hover:translate-x-1 group-hover:text-gold-300" />
                        </a>
                    @empty
                        <div class="p-8 text-center text-xs text-primary-200">Belum ada agenda mendatang.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- 9. Prestasi Santri & Madrasah Spotlight --}}
    @if($achievements->isNotEmpty())
        <section class="py-20 sm:py-24 bg-white relative">
            <div class="container-app space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Apresiasi & Prestasi"
                                      title="Capaian Santri Membanggakan"
                                      description="Dedikasi dan kerja keras para peserta didik dan asatidz MA Assa'adah dalam kancah keilmuan, tahfidz, sains, seni, dan bela diri." />
                    <a href="{{ route('prestasi.index') }}" class="btn-outline shrink-0 font-semibold">
                        <span>Semua Prestasi</span>
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($achievements as $achievement)
                        <article data-tilt class="tilt-card interactive-card spotlight-card flex flex-col justify-between p-6">
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-bold text-gold-900 ring-1 ring-gold-500/20">
                                        {{ $achievement->rank ?: 'Juara' }}
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        {{ ucfirst($achievement->level) }}
                                    </span>
                                </div>

                                <h3 class="mt-4 text-base font-bold text-slate-950 leading-snug">
                                    {{ $achievement->title }}
                                </h3>

                                <p class="mt-2 text-xs font-medium text-primary-800 flex items-center gap-1.5">
                                    <x-icon name="user-check" class="size-3.5 text-primary-600" />
                                    <span>{{ $achievement->participant }}</span>
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                <span class="truncate">{{ $achievement->organizer }}</span>
                                <span class="font-bold">{{ $achievement->year }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 10. Ekstrakurikuler Santri Showcase --}}
    @if($extracurriculars->isNotEmpty())
        <section class="py-20 bg-slate-50 relative">
            <div class="container-app space-y-10">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <x-section-header eyebrow="Kesiswaan & Minat Bakat"
                                      title="Wadah Eksplorasi Potensi & Karakter Santri"
                                      description="Beragam cabang ekstrakurikuler untuk membentuk fisik tangguh, intelektual tajam, dan kepribadian amanah." />
                    <a href="{{ route('extracurricular') }}" class="btn-outline shrink-0 font-semibold">
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

    {{-- 11. Galeri Kegiatan & Dokumentasi --}}
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

    {{-- 12. Jejak Alumni IKBAL MADAH --}}
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

    {{-- 13. Interactive Bottom SPMB Banner --}}
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
</x-layouts.app>

