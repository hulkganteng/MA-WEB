@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $tagline = setting('site.tagline', 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren');
    $logo = setting('site.logo');
    $address = setting('contact.address', 'Jl. Raya Bungah No. 01, Sampurnan, Bungah, Gresik, Jawa Timur 61152');
    $phone = setting('contact.phone', '0812-3456-7890');
    $email = setting('contact.email', 'info@mamnu-assaadah.sch.id');
    $social = \App\Models\SocialLink::where('is_active', true)->get();
    $year = date('Y');
@endphp

<footer class="relative overflow-hidden bg-slate-950 text-slate-300">
    {{-- Islamic Decorative Background Accents --}}
    <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-40"></div>
    <div class="pointer-events-none absolute -top-40 -right-40 size-96 rounded-full bg-primary-600/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-40 -left-40 size-96 rounded-full bg-gold-500/10 blur-3xl"></div>

    {{-- Top Bento Newsletter & SPMB Banner --}}
    <div class="relative border-b border-white/10 bg-primary-950/60 backdrop-blur-md">
        <div class="container-app py-10">
            <div class="grid gap-6 rounded-3xl border border-primary-500/20 bg-gradient-to-r from-primary-900/60 via-primary-950/80 to-slate-950/90 p-6 sm:p-8 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-500/10 px-3 py-1 text-xs font-semibold text-gold-300">
                        <x-icon name="sparkles" class="size-3.5" />
                        <span>Penerimaan Santri Baru (SPMB) 2026/2027</span>
                    </div>
                    <h3 class="mt-3 text-xl font-bold tracking-tight text-white sm:text-2xl lg:text-3xl">
                        Bergabunglah Bersama Generasi Santri Cendekia & Berkarakter
                    </h3>
                    <p class="mt-2 text-sm text-slate-300 leading-relaxed max-w-xl">
                        Pendidikan terpadu kurikulum Kementerian Agama, riset modern, hafalan Al-Qur'an bersanad, dan kajian kitab kuning di lingkungan Pondok Pesantren Qomaruddin Bungah.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 lg:col-span-5 lg:justify-end">
                    <button type="button"
                            @click="$store.spmbCalc.open()"
                            class="btn-gold !bg-gold-500 hover:!bg-gold-400 font-bold shadow-glow-gold">
                        <x-icon name="compass" class="size-4" />
                        <span>Simulasi Peminatan</span>
                    </button>
                    <a href="{{ route('contact') }}"
                       class="btn-outline !border-white/20 !bg-white/5 !text-white hover:!bg-white/10">
                        <x-icon name="map-pin" class="size-4" />
                        <span>Lokasi & Kunjungan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Bento Navigation Grid --}}
    <div class="relative container-app grid gap-8 py-16 sm:grid-cols-2 lg:grid-cols-12">
        {{-- Column 1: Institutional Legacy & Identity (Span 4) --}}
        <div class="lg:col-span-4 space-y-5">
            <div class="flex items-center gap-3.5">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-700 to-primary-950 p-0.5 shadow-lift border border-gold-400/30">
                    @if ($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }}" class="size-full rounded-[14px] object-cover">
                    @else
                        <span class="text-xl font-extrabold text-gold-300">MA</span>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">{{ $siteName }}</h2>
                    <p class="text-xs font-medium text-emerald-400">Bungah, Gresik · Didirikan 1972</p>
                </div>
            </div>

            <p class="text-sm leading-relaxed text-slate-300">
                Lembaga pendidikan tingkat madrasah aliyah di bawah naungan <strong>Yayasan Pondok Pesantren Qomaruddin (YPPQ) Sampurnan</strong> (berdiri 1775 M). Memadukan tradisi ilmiah pesantren salaf dengan keunggulan riset modern berdaya saing global.
            </p>

            {{-- Trust Badges --}}
            <div class="flex flex-wrap gap-2 pt-2">
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-500/30 bg-emerald-950/40 px-3 py-1 text-xs font-semibold text-emerald-300">
                    <x-icon name="shield-check" class="size-3.5" />
                    <span>Akreditasi A Unggul</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-gold-400/30 bg-gold-950/40 px-3 py-1 text-xs font-semibold text-gold-300">
                    <x-icon name="award" class="size-3.5" />
                    <span>NPSN: 20580225</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-slate-700 bg-slate-900/60 px-3 py-1 text-xs font-medium text-slate-300">
                    <x-icon name="landmark" class="size-3.5" />
                    <span>LP Ma'arif NU</span>
                </span>
            </div>

            {{-- Social Icons --}}
            <div class="flex items-center gap-2.5 pt-2">
                @foreach ($social as $link)
                    @if ($link->url)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($link->platform) }}"
                           class="flex size-9 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-slate-300 transition hover:border-gold-400/50 hover:bg-gold-500/20 hover:text-white hover:scale-105">
                            <x-icon name="{{ $link->platform === 'youtube' ? 'youtube' : $link->platform }}" class="size-4" />
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Column 2: Profil & Akademik (Span 2) --}}
        <div class="lg:col-span-2 space-y-4">
            <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white">
                <span class="size-2 rounded-full bg-emerald-500"></span>
                <span>Madrasah</span>
            </h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('about') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Tentang Kami</a></li>
                <li><a href="{{ route('sejarah') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Sejarah YPPQ (1972)</a></li>
                <li><a href="{{ route('visi-misi') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Visi, Misi & Tujuan</a></li>
                <li><a href="{{ route('sambutan') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Sambutan Kepala</a></li>
                <li><a href="{{ route('structure') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Struktur Pimpinan</a></li>
                <li><a href="{{ route('guru.index') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Guru & Tenaga Kependidikan</a></li>
            </ul>
        </div>

        {{-- Column 3: Akademik & Kesiswaan (Span 3) --}}
        <div class="lg:col-span-3 space-y-4">
            <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white">
                <span class="size-2 rounded-full bg-gold-400"></span>
                <span>Akademik & Santri</span>
            </h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('programs') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Peminatan MIPA, IPS & PK</a></li>
                <li><a href="{{ route('programs.featured') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Program Unggulan Tahfidz</a></li>
                <li><a href="{{ route('curriculum') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Kurikulum Merdeka & Turats</a></li>
                <li><a href="{{ route('academic-calendar') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Kalender Akademik</a></li>
                <li><a href="{{ route('extracurricular') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Ekstrakurikuler Santri</a></li>
                <li><a href="{{ route('organizations') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> OSIM, IPNU, IPPNU, MPK</a></li>
                <li><a href="{{ route('alumni.index') }}" class="hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-slate-500" /> Jaringan IKBAL MADAH</a></li>
            </ul>
        </div>

        {{-- Column 4: Kontak & Lokasi (Span 3) --}}
        <div class="lg:col-span-3 space-y-4">
            <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white">
                <span class="size-2 rounded-full bg-emerald-400"></span>
                <span>Pusat Layanan</span>
            </h3>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-xs space-y-3">
                <div class="flex gap-2.5">
                    <x-icon name="map-pin" class="size-4 shrink-0 text-gold-400 mt-0.5" />
                    <span class="text-slate-300 leading-relaxed">{{ $address }}</span>
                </div>
                <div class="flex gap-2.5">
                    <x-icon name="phone" class="size-4 shrink-0 text-gold-400 mt-0.5" />
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-slate-300 hover:text-white transition">{{ $phone }}</a>
                </div>
                <div class="flex gap-2.5">
                    <x-icon name="mail" class="size-4 shrink-0 text-gold-400 mt-0.5" />
                    <a href="mailto:{{ $email }}" class="break-all text-slate-300 hover:text-white transition">{{ $email }}</a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="$store.prayer.openModal()"
                        class="w-full rounded-xl border border-primary-500/30 bg-primary-900/40 p-2.5 text-center text-xs font-semibold text-emerald-300 hover:bg-primary-900/70 transition">
                    Lihat Jadwal Sholat Lengkap &rarr;
                </button>
            </div>
        </div>
    </div>

    {{-- Bottom Bar: Copyright & Pesantren Heritage Acknowledgement --}}
    <div class="relative border-t border-white/10 bg-black/40">
        <div class="container-app flex flex-col items-center justify-between gap-3 py-6 text-xs text-slate-400 sm:flex-row">
            <p>&copy; {{ $year }} <strong>{{ $siteName }}</strong>. Terdaftar di Kemenag RI & LP Ma'arif NU. Hak cipta dilindungi.</p>
            <div class="flex items-center gap-4 text-slate-400">
                <span class="flex items-center gap-1.5">
                    <x-icon name="shield" class="size-3.5 text-emerald-400" />
                    <span>Madrasah Aliyah Assa'adah Bungah Gresik</span>
                </span>
            </div>
        </div>
    </div>
</footer>

