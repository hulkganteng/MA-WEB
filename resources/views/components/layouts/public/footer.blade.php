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

<footer class="relative overflow-hidden bg-[#006437] text-white">
    {{-- Islamic Decorative Background Accents --}}
    <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-30"></div>
    <div class="pointer-events-none absolute -top-40 -right-40 size-96 rounded-full bg-gold-400/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-40 -left-40 size-96 rounded-full bg-primary-400/10 blur-3xl"></div>

    {{-- Top Bento Newsletter & SPMB Banner --}}
    <div class="relative border-b border-white/15 bg-[#004d2a]/70 backdrop-blur-md">
        <div class="container-app py-10">
            <div class="grid gap-6 rounded-3xl border border-white/20 bg-gradient-to-r from-[#006437] to-[#004d2a] p-6 sm:p-8 lg:grid-cols-12 lg:items-center shadow-lift">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/15 px-3 py-1 text-xs font-semibold text-gold-300">
                        <x-icon name="sparkles" class="size-3.5" />
                        <span>Penerimaan Santri Baru (SPMB) 2026/2027</span>
                    </div>
                    <h3 class="mt-3 text-xl font-bold tracking-tight text-white sm:text-2xl lg:text-3xl">
                        Bergabunglah Bersama Generasi Santri Cendekia & Berkarakter
                    </h3>
                    <p class="mt-2 text-sm text-primary-100 leading-relaxed max-w-xl">
                        Pendidikan terpadu kurikulum Kementerian Agama, riset sains, tahfidzul Qur'an bersanad, dan kajian kitab turats di lingkungan Pondok Pesantren Qomaruddin Bungah.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 lg:col-span-5 lg:justify-end">
                    <a href="https://lynk.id/spmb-madah"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn-primary !bg-[#00923F] hover:!bg-[#007a34] font-bold shadow-soft flex items-center gap-2">
                        <x-icon name="sparkles" class="size-4 text-gold-300" />
                        <span>Daftar SPMB Online</span>
                        <x-icon name="external-link" class="size-4 opacity-80" />
                    </a>
                    <a href="{{ route('contact') }}"
                       class="btn-outline !border-white/30 !bg-white/10 !text-white hover:!bg-white/20">
                        <x-icon name="map-pin" class="size-4" />
                        <span>Lokasi</span>
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
                <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-primary-800 p-0.5 shadow-lift border border-gold-400/40">
                    @if ($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }}" class="size-full rounded-[14px] object-cover">
                    @else
                        <span class="text-xl font-extrabold text-gold-300">MA</span>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">{{ $siteName }}</h2>
                    <p class="text-xs font-medium text-gold-300">Bungah, Gresik · Didirikan 1972</p>
                </div>
            </div>

            <p class="text-sm leading-relaxed text-primary-100">
                Lembaga pendidikan tingkat madrasah aliyah di bawah naungan <strong>Yayasan Pondok Pesantren Qomaruddin (YPPQ) Sampurnan</strong> (berdiri 1775 M). Memadukan tradisi ilmiah pesantren salaf dengan keunggulan riset modern berdaya saing global.
            </p>

            {{-- Trust Badges --}}
            <div class="flex flex-wrap gap-2 pt-2">
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold text-white">
                    <x-icon name="shield-check" class="size-3.5 text-gold-400" />
                    <span>Akreditasi A Unggul</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-gold-400/40 bg-gold-400/20 px-3 py-1 text-xs font-semibold text-gold-300">
                    <x-icon name="award" class="size-3.5" />
                    <span>NPSN: 20580225</span>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium text-white">
                    <x-icon name="landmark" class="size-3.5 text-secondary-300" />
                    <span>LP Ma'arif NU</span>
                </span>
            </div>

            {{-- Social Icons --}}
            <div class="flex items-center gap-2.5 pt-2">
                @foreach ($social as $link)
                    @if ($link->url)
                        @php
                            $platform = strtolower($link->platform);
                            $socialIcon = match ($platform) {
                                'youtube' => 'video',
                                'instagram' => 'camera',
                                'facebook' => 'thumbs-up',
                                'tiktok' => 'music-2',
                                'whatsapp' => 'message-circle',
                                default => 'globe',
                            };
                            $socialLabel = match ($platform) {
                                'youtube' => 'YouTube',
                                'instagram' => 'Instagram',
                                'facebook' => 'Facebook',
                                'tiktok' => 'TikTok',
                                'whatsapp' => 'WhatsApp',
                                default => ucfirst($link->platform),
                            };
                        @endphp
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ $socialLabel }}"
                           class="group relative flex size-9 items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white transition hover:scale-105 hover:border-gold-400 hover:bg-gold-400 hover:text-[#1F1A17] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gold-400 focus-visible:ring-offset-2 focus-visible:ring-offset-[#006437]">
                            @switch($platform)
                                @case('youtube')
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="size-4 fill-current"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.376.505A3.016 3.016 0 0 0 .502 6.186C0 8.064 0 12 0 12s0 3.936.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.376-.505a3.016 3.016 0 0 0 2.122-2.136C24 15.936 24 12 24 12s0-3.936-.502-5.814ZM9.545 15.568V8.432L15.818 12l-6.273 3.568Z" /></svg>
                                    @break
                                @case('instagram')
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="size-4 fill-current"><path d="M7.8 2h8.4A5.8 5.8 0 0 1 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8A5.8 5.8 0 0 1 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2Zm-.2 2A3.6 3.6 0 0 0 4 7.6v8.8A3.6 3.6 0 0 0 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6A3.6 3.6 0 0 0 16.4 4H7.6ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.25-3.25a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z" /></svg>
                                    @break
                                @case('facebook')
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="size-4 fill-current"><path d="M13.5 22v-8h2.75l.5-3h-3.25V9.05c0-.87.24-1.46 1.5-1.46h1.85V4.91c-.32-.04-1.42-.14-2.7-.14-2.67 0-4.5 1.63-4.5 4.62V11H6.6v3h3.05v8h3.85Z" /></svg>
                                    @break
                                @case('tiktok')
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="size-4 fill-current"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03C3.21 20.77 1.8 18.55 1.77 16.2c-.03-1.48.39-2.96 1.19-4.2 1.15-1.8 3.26-3.03 5.4-3.25 1.02-.11 2.04.04 3 .33.01 1.48-.04 2.96-.04 4.44-.68-.22-1.46-.39-2.13-.15-.5.17-.95.46-1.3.85-.59.6-.88 1.51-.73 2.33.14.83.68 1.56 1.41 1.95.73.39 1.62.43 2.38.13.69-.25 1.29-.78 1.57-1.46.18-.31.27-.68.27-1.04.02-5.39-.03-10.77.02-16.14Z" /></svg>
                                    @break
                                @default
                                    <x-icon name="{{ $socialIcon }}" class="size-4" />
                            @endswitch
                            <span class="pointer-events-none absolute left-1/2 top-full z-20 mt-2 max-w-[calc(100vw-2rem)] -translate-x-1/2 whitespace-nowrap rounded-md bg-[#1F1A17] px-2 py-1 text-[10px] font-semibold text-white opacity-0 shadow-lg transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100">
                                {{ $socialLabel }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Column 2: Profil & Akademik (Span 2) --}}
        <div class="lg:col-span-2 space-y-4">
            <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white">
                <span class="size-2 rounded-full bg-gold-400"></span>
                <span>Madrasah</span>
            </h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('about') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Tentang Kami</a></li>
                <li><a href="{{ route('sejarah') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Sejarah YPPQ (1972)</a></li>
                <li><a href="{{ route('visi-misi') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Visi, Misi & Tujuan</a></li>
                <li><a href="{{ route('sambutan') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Sambutan Kepala</a></li>
                <li><a href="{{ route('structure') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Struktur Pimpinan</a></li>
                <li><a href="{{ route('guru.index') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Guru & Tenaga Pendidik</a></li>
            </ul>
        </div>

        {{-- Column 3: Akademik & Kesiswaan (Span 3) --}}
        <div class="lg:col-span-3 space-y-4">
            <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white">
                <span class="size-2 rounded-full bg-secondary-300"></span>
                <span>Akademik & Santri</span>
            </h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('programs') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Peminatan MIPA, IPS & PK</a></li>
                <li><a href="{{ route('programs.featured') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Program Unggulan Tahfidz</a></li>
                <li><a href="{{ route('curriculum') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Kurikulum Merdeka & Turats</a></li>
                <li><a href="{{ route('academic-calendar') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Kalender Akademik</a></li>
                <li><a href="{{ route('extracurricular') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Ekstrakurikuler Santri</a></li>
                <li><a href="{{ route('organizations') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> OSIM, IPNU, IPPNU, MPK</a></li>
                <li><a href="{{ route('alumni.index') }}" class="text-primary-100 hover:text-gold-300 transition flex items-center gap-1.5"><x-icon name="chevron-right" class="size-3 text-gold-400" /> Jaringan IKBAL MADAH</a></li>
            </ul>
        </div>

        {{-- Column 4: Kontak & Lokasi (Span 3) --}}
        <div class="lg:col-span-3 space-y-4">
            <h3 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-white">
                <span class="size-2 rounded-full bg-gold-400"></span>
                <span>Pusat Layanan</span>
            </h3>
            <div class="rounded-2xl border border-white/20 bg-white/10 p-4 text-xs space-y-3">
                <div class="flex gap-2.5">
                    <x-icon name="map-pin" class="size-4 shrink-0 text-gold-300 mt-0.5" />
                    <span class="text-primary-100 leading-relaxed">{{ $address }}</span>
                </div>
                <div class="flex gap-2.5">
                    <x-icon name="phone" class="size-4 shrink-0 text-gold-300 mt-0.5" />
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-primary-100 hover:text-white transition">{{ $phone }}</a>
                </div>
                <div class="flex gap-2.5">
                    <x-icon name="mail" class="size-4 shrink-0 text-gold-300 mt-0.5" />
                    <a href="mailto:{{ $email }}" class="break-all text-primary-100 hover:text-white transition">{{ $email }}</a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="$store.prayer.openModal()"
                        class="w-full rounded-xl border border-gold-400/40 bg-gold-400/20 p-2.5 text-center text-xs font-bold text-gold-300 hover:bg-gold-400 hover:text-[#1F1A17] transition">
                    Lihat Jadwal Sholat Lengkap &rarr;
                </button>
            </div>
        </div>
    </div>

    {{-- Bottom Bar: Copyright & Pesantren Heritage Acknowledgement --}}
    <div class="relative border-t border-white/15 bg-[#004d2a]">
        <div class="container-app flex flex-col items-center justify-between gap-3 py-6 text-center text-xs text-primary-100 md:flex-row md:text-left">
            <p class="max-w-full">&copy; {{ $year }} <strong>{{ $siteName }}</strong>. Terdaftar di Kemenag RI & LP Ma'arif NU. Hak cipta dilindungi.</p>
            <div class="flex w-full items-center justify-center gap-4 text-primary-100 md:w-auto">
                <span class="flex items-center gap-1.5">
                    <x-icon name="shield-check" class="size-3.5 text-gold-400" />
                    <span>Madrasah Aliyah Assa'adah Bungah Gresik</span>
                </span>
            </div>
        </div>
    </div>
</footer>

