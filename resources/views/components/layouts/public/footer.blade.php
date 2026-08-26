@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $tagline = setting('site.tagline');
    $logo = setting('site.logo');
    $address = setting('contact.address');
    $phone = setting('contact.phone');
    $email = setting('contact.email');
    $social = \App\Models\SocialLink::where('is_active', true)->get();
    $year = date('Y');
@endphp

<footer class="bg-primary-950 text-primary-100">
    <div class="container-app grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-5">
        <div class="lg:col-span-2">
            <div class="flex items-center gap-3">
                @if ($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }}" class="h-12 w-12 rounded-full object-cover">
                @else
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-600 text-xl font-bold text-white">M</span>
                @endif
                <span class="font-semibold text-white">{{ $siteName }}</span>
            </div>
            @if ($tagline)
                <p class="mt-4 max-w-md text-sm leading-relaxed text-primary-200">{{ $tagline }}</p>
            @endif
            <div class="mt-5 flex items-center gap-3">
                @foreach ($social as $link)
                    @if ($link->url)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($link->platform) }}"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-primary-100 transition hover:bg-primary-600 hover:text-white">
                            <x-icon name="{{ $link->platform }}" class="h-4 w-4" />
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Madrasah</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('about') }}" class="text-primary-200 hover:text-white">Tentang Madrasah</a></li>
                <li><a href="{{ route('visi-misi') }}" class="text-primary-200 hover:text-white">Visi & Misi</a></li>
                <li><a href="{{ route('guru.index') }}" class="text-primary-200 hover:text-white">Guru & Tenaga Kependidikan</a></li>
                <li><a href="{{ route('facilities') }}" class="text-primary-200 hover:text-white">Sarana & Prasarana</a></li>
                <li><a href="{{ route('programs') }}" class="text-primary-200 hover:text-white">Program</a></li>
            </ul>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Informasi</h3>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('berita.index') }}" class="text-primary-200 hover:text-white">Berita</a></li>
                <li><a href="{{ route('pengumuman.index') }}" class="text-primary-200 hover:text-white">Pengumuman</a></li>
                <li><a href="{{ route('agenda.index') }}" class="text-primary-200 hover:text-white">Agenda</a></li>
                <li><a href="{{ route('prestasi.index') }}" class="text-primary-200 hover:text-white">Prestasi</a></li>
                <li><a href="{{ route('artikel.index') }}" class="text-primary-200 hover:text-white">Artikel</a></li>
            </ul>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Kontak</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex gap-2.5"><x-icon name="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" /><span class="text-primary-200">{{ $address }}</span></li>
                <li class="flex gap-2.5"><x-icon name="phone" class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" /><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-primary-200 hover:text-white">{{ $phone }}</a></li>
                <li class="flex gap-2.5"><x-icon name="mail" class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" /><a href="mailto:{{ $email }}" class="break-all text-primary-200 hover:text-white">{{ $email }}</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-app flex flex-col items-center justify-between gap-2 py-5 text-xs text-primary-300 sm:flex-row">
            <p>&copy; {{ $year }} {{ $siteName }}. Hak cipta dilindungi.</p>
            <p class="flex items-center gap-1">
                <x-icon name="heart" class="h-3 w-3 text-gold-400" /> Yayasan Pondok Pesantren Qomaruddin
            </p>
        </div>
    </div>
</footer>
