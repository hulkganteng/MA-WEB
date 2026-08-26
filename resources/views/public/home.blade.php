<x-layouts.app>
    <section class="relative overflow-hidden bg-primary-950 py-16 text-white sm:py-24">
        <div class="absolute inset-0 opacity-25 [background-image:radial-gradient(circle_at_80%_20%,#d4af37_0,transparent_25%),radial-gradient(circle_at_10%_90%,#10b981_0,transparent_30%)]"></div>
        <div class="container-app relative grid items-center gap-12 lg:grid-cols-[1.2fr_.8fr]">
            <div class="flex flex-col gap-6">
                <p class="font-medium text-gold-300">Madrasah aliyah berbasis pesantren di Gresik</p>
                <h1 class="max-w-[18ch] text-balance text-4xl font-semibold leading-[1.05] tracking-tight sm:text-5xl lg:text-6xl">{{ setting('hero.title') }}</h1>
                <p class="max-w-[64ch] text-pretty text-base text-primary-100 sm:text-lg">{{ setting('hero.subtitle') }}</p>
                <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('about') }}" class="btn-gold">Kenali madrasah <x-icon name="arrow-right" class="size-4 shrink-0" /></a>
                    <a href="{{ route('programs') }}" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 font-medium text-white hover:bg-white/10">Lihat program pendidikan</a>
                </div>
            </div>
            <div class="rounded-[min(3vw,1.5rem)] bg-white/10 p-7 ring-1 ring-white/15 backdrop-blur sm:p-9">
                <div class="flex items-center gap-4">
                    <div class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-gold-400 text-primary-950">
                        <x-icon name="graduation-cap" class="size-7" />
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-white">Pendidikan terpadu</p>
                        <p class="text-base text-primary-100">Akademik, karakter, keislaman, dan teknologi dalam satu lingkungan belajar.</p>
                    </div>
                </div>
                <dl class="mt-8 grid grid-cols-2 gap-6 border-t border-white/10 pt-8">
                    <div><dt class="text-base text-primary-200">Peserta didik</dt><dd class="mt-1 text-3xl font-semibold tabular-nums">{{ setting('stats.students', 0) }}+</dd></div>
                    <div><dt class="text-base text-primary-200">Guru</dt><dd class="mt-1 text-3xl font-semibold tabular-nums">{{ $teacherCount ?: setting('stats.teachers', 0) }}</dd></div>
                    <div><dt class="text-base text-primary-200">Alumni</dt><dd class="mt-1 text-3xl font-semibold tabular-nums">{{ setting('stats.alumni', 0) }}+</dd></div>
                    <div><dt class="text-base text-primary-200">Prestasi</dt><dd class="mt-1 text-3xl font-semibold tabular-nums">{{ setting('stats.achievements', 0) }}+</dd></div>
                </dl>
            </div>
        </div>
    </section>

    <nav aria-label="Akses cepat" class="bg-white py-6 ring-1 ring-slate-900/5">
        <ul role="list" class="container-app grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ([['berita.index','newspaper','Berita'],['pengumuman.index','megaphone','Pengumuman'],['agenda.index','calendar-days','Agenda'],['prestasi.index','trophy','Prestasi'],['gallery.photos','images','Galeri'],['downloads.index','download','Unduhan']] as [$route, $icon, $label])
                <li><a href="{{ route($route) }}" class="flex items-center gap-3 rounded-xl px-3 py-3 font-medium text-slate-700 hover:bg-primary-50 hover:text-primary-800"><x-icon :name="$icon" class="size-5 shrink-0 text-primary-600" /> {{ $label }}</a></li>
            @endforeach
        </ul>
    </nav>

    <section class="bg-white py-16 sm:py-20">
        <div class="container-app grid items-center gap-10 lg:grid-cols-2">
            <div class="flex aspect-[16/11] items-center justify-center overflow-hidden rounded-[min(2vw,1rem)] bg-primary-50">
                @if($aboutPage?->cover)
                    <img src="{{ asset('storage/'.$aboutPage->cover) }}" alt="Lingkungan MA Ma’arif NU Assa’adah" class="size-full object-cover outline outline-1 -outline-offset-1 outline-black/5">
                @else
                    <div class="max-w-sm p-10 text-center"><x-icon name="school" class="mx-auto size-12 text-primary-300" /><p class="mt-4 text-base text-primary-800">Foto lingkungan madrasah dapat ditambahkan melalui CMS.</p></div>
                @endif
            </div>
            <div><x-section-header eyebrow="Tentang madrasah" title="Berakar pada nilai pesantren, bergerak bersama zaman" description="MA Ma’arif NU Assa’adah memadukan pendidikan akademik, pembentukan akhlak, tradisi keislaman, dan keterampilan yang relevan untuk masa depan." /><dl class="mt-8 grid gap-5 sm:grid-cols-2"><div><dt class="font-semibold text-primary-900">Berkarakter</dt><dd class="mt-1 text-base text-slate-600">Pembiasaan akhlak dan tanggung jawab dalam keseharian.</dd></div><div><dt class="font-semibold text-primary-900">Cakap</dt><dd class="mt-1 text-base text-slate-600">Pembelajaran yang menguatkan kompetensi dan keterampilan.</dd></div><div><dt class="font-semibold text-primary-900">Cendekia</dt><dd class="mt-1 text-base text-slate-600">Budaya belajar, literasi, dan berpikir kritis.</dd></div><div><dt class="font-semibold text-primary-900">Berjiwa pesantren</dt><dd class="mt-1 text-base text-slate-600">Tradisi keislaman yang ramah dan berkesinambungan.</dd></div></dl><a href="{{ route('about') }}" class="mt-8 inline-flex items-center gap-2 font-medium text-primary-700">Selengkapnya <x-icon name="arrow-right" class="size-4 shrink-0" /></a></div>
        </div>
    </section>

    <section class="bg-primary-50 py-16 sm:py-20">
        <div class="container-app grid items-center gap-10 lg:grid-cols-[1fr_2fr]">
            <div class="mx-auto w-full max-w-sm">@if(setting('principal.photo'))<img src="{{ asset('storage/'.setting('principal.photo')) }}" alt="" class="aspect-[4/5] w-full rounded-[min(2vw,1rem)] object-cover outline outline-1 -outline-offset-1 outline-black/5">@else<div class="flex aspect-[4/5] items-center justify-center rounded-2xl bg-white ring-1 ring-primary-900/10"><x-icon name="user-round" class="size-12 text-primary-300" /></div>@endif</div>
            <div><p class="font-medium text-primary-700">Sambutan kepala madrasah</p><blockquote class="mt-4 max-w-[55ch] text-pretty text-2xl font-medium tracking-tight text-primary-950 sm:text-3xl">“Selamat datang di ruang informasi MA Ma’arif NU Assa’adah, tempat kami berbagi perkembangan pendidikan dan kegiatan madrasah.”</blockquote><p class="mt-6 font-semibold text-slate-950">{{ setting('principal.name') }}</p><p class="mt-1 text-base text-slate-600">{{ setting('principal.position') }}</p><a href="{{ route('sambutan') }}" class="mt-7 inline-flex items-center gap-2 font-medium text-primary-700">Baca sambutan <x-icon name="arrow-right" class="size-4 shrink-0" /></a></div>
        </div>
    </section>

    @if ($programs->isNotEmpty())
        <section class="py-16 sm:py-20">
            <div class="container-app">
                <x-section-header eyebrow="Program unggulan" title="Ruang tumbuh untuk setiap potensi" description="Program terarah yang menyeimbangkan kompetensi akademik, nilai keislaman, dan keterampilan masa depan." />
                <dl class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($programs as $program)
                        <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                            <div class="flex size-11 items-center justify-center rounded-xl bg-primary-100 text-primary-700"><x-icon name="sparkles" class="size-5" /></div>
                            <dt class="mt-5 text-xl font-semibold tracking-tight text-slate-950">{{ $program->name }}</dt>
                            <dd class="mt-2 text-pretty text-base text-slate-600">{{ $program->description }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </section>
    @endif

    <section class="bg-white py-16 sm:py-20">
        <div class="container-app">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <x-section-header eyebrow="Kabar madrasah" title="Berita terbaru" description="Ikuti kegiatan dan perkembangan terbaru dari lingkungan MA Ma'arif NU Assa'adah." />
                <a href="{{ route('berita.index') }}" class="inline-flex shrink-0 items-center gap-2 font-medium text-primary-700 hover:text-primary-800">Semua berita <x-icon name="arrow-right" class="size-4 shrink-0" /></a>
            </div>
            @if ($posts->isNotEmpty())
                <div class="mt-9 grid gap-6 md:grid-cols-2 lg:grid-cols-3">@foreach ($posts as $post)<x-post-card :post="$post" />@endforeach</div>
            @else
                <x-empty-state title="Belum ada berita" description="Berita terbaru akan tampil di bagian ini." />
            @endif
        </div>
    </section>

    <section class="py-16 sm:py-20">
        <div class="container-app grid gap-10 lg:grid-cols-2">
            <div>
                <div class="flex items-end justify-between gap-4"><x-section-header eyebrow="Informasi penting" title="Pengumuman" /><a href="{{ route('pengumuman.index') }}" class="shrink-0 font-medium text-primary-700">Lihat semua</a></div>
                <div class="mt-7 divide-y divide-slate-900/10 rounded-2xl bg-white px-6 ring-1 ring-slate-900/10">
                    @forelse ($announcements as $announcement)
                        <a href="{{ route('pengumuman.show', $announcement) }}" class="flex gap-4 py-5">
                            <x-icon name="megaphone" class="size-5 shrink-0 text-primary-600" />
                            <span class="min-w-0"><span class="font-medium text-slate-950">{{ $announcement->title }}</span><span class="mt-1 block text-base text-slate-500">{{ $announcement->publish_date->translatedFormat('d M Y') }}</span></span>
                        </a>
                    @empty
                        <p class="py-6 text-base text-slate-500">Belum ada pengumuman.</p>
                    @endforelse
                </div>
            </div>
            <div>
                <div class="flex items-end justify-between gap-4"><x-section-header eyebrow="Kalender kegiatan" title="Agenda terdekat" /><a href="{{ route('agenda.index') }}" class="shrink-0 font-medium text-primary-700">Lihat semua</a></div>
                <div class="mt-7 divide-y divide-slate-900/10 rounded-2xl bg-primary-950 px-6 text-white">
                    @forelse ($events as $event)
                        <a href="{{ route('agenda.show', $event) }}" class="flex gap-4 py-5">
                            <time class="flex size-12 shrink-0 flex-col items-center justify-center rounded-xl bg-white/10 text-center" datetime="{{ $event->start_date->toDateString() }}"><span class="font-semibold tabular-nums">{{ $event->start_date->format('d') }}</span><span class="text-xs text-primary-200">{{ $event->start_date->translatedFormat('M') }}</span></time>
                            <span class="min-w-0"><span class="font-medium text-white">{{ $event->title }}</span><span class="mt-1 flex items-center gap-1 text-base text-primary-200"><x-icon name="map-pin" class="size-4 shrink-0" /> {{ $event->location ?: 'MA Ma’arif NU Assa’adah' }}</span></span>
                        </a>
                    @empty
                        <p class="py-6 text-base text-primary-200">Belum ada agenda mendatang.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    @if($achievements->isNotEmpty())
        <section class="bg-white py-16 sm:py-20"><div class="container-app"><div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"><x-section-header eyebrow="Capaian madrasah" title="Prestasi terbaru" description="Apresiasi atas kerja keras peserta didik, guru, dan tim madrasah." /><a href="{{ route('prestasi.index') }}" class="inline-flex shrink-0 items-center gap-2 font-medium text-primary-700">Semua prestasi <x-icon name="arrow-right" class="size-4" /></a></div><div class="mt-9 grid gap-6 md:grid-cols-3">@foreach($achievements as $achievement)<article class="rounded-2xl p-6 ring-1 ring-slate-900/10"><div class="flex items-center justify-between gap-4"><p class="font-medium text-primary-700">{{ ucfirst($achievement->level) }}</p><x-icon name="trophy" class="size-6 text-gold-600" /></div><h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950">{{ $achievement->title }}</h3><p class="mt-3 text-base text-slate-600">{{ $achievement->participant }}</p></article>@endforeach</div></div></section>
    @endif

    @if($extracurriculars->isNotEmpty())
        <section class="py-16 sm:py-20"><div class="container-app"><div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"><x-section-header eyebrow="Kesiswaan" title="Eksplorasi minat dan bakat" description="Kegiatan yang membantu siswa bertumbuh di luar ruang kelas." /><a href="{{ route('extracurricular') }}" class="inline-flex shrink-0 items-center gap-2 font-medium text-primary-700">Semua kegiatan <x-icon name="arrow-right" class="size-4" /></a></div><div class="mt-9 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">@foreach($extracurriculars as $item)<a href="{{ route('extracurricular.show',$item) }}" class="rounded-2xl bg-white p-5 text-center ring-1 ring-slate-900/10 hover:ring-primary-700/30"><x-icon name="activity" class="mx-auto size-6 text-primary-600" /><h3 class="mt-3 font-semibold text-slate-950">{{ $item->name }}</h3></a>@endforeach</div></div></section>
    @endif

    @if($albums->isNotEmpty())
        <section class="bg-primary-950 py-16 text-white sm:py-20"><div class="container-app"><div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"><x-section-header theme="dark" eyebrow="Dokumentasi" title="Galeri kegiatan" description="Momen pembelajaran, kegiatan keagamaan, dan kebersamaan warga madrasah." /><a href="{{ route('gallery.photos') }}" class="inline-flex shrink-0 items-center gap-2 font-medium text-gold-300">Lihat galeri <x-icon name="arrow-right" class="size-4" /></a></div><div class="mt-9 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">@foreach($albums as $album)<a href="{{ route('gallery.album',$album) }}" class="group">@if($album->cover)<img src="{{ asset('storage/'.$album->cover) }}" alt="" loading="lazy" class="aspect-square w-full rounded-[min(2vw,1rem)] object-cover outline outline-1 -outline-offset-1 outline-white/10">@else<div class="flex aspect-square items-center justify-center rounded-2xl bg-white/10"><x-icon name="images" class="size-8 text-primary-200" /></div>@endif<h3 class="mt-4 font-semibold text-white">{{ $album->name }}</h3><p class="mt-1 text-base text-primary-200">{{ $album->photos_count }} foto</p></a>@endforeach</div></div></section>
    @endif

    @if($alumni->isNotEmpty())
        <section class="bg-white py-16 sm:py-20"><div class="container-app"><x-section-header eyebrow="Jejak alumni" title="Tumbuh dan berkarya di berbagai bidang" description="Cerita alumni yang melanjutkan pendidikan, bekerja, dan berkontribusi bagi masyarakat." /><div class="mt-9 grid gap-6 md:grid-cols-3">@foreach($alumni as $person)<figure class="flex flex-col justify-between rounded-2xl bg-primary-50 p-6"><blockquote><p class="relative text-pretty text-base leading-7 text-slate-700 before:absolute before:-translate-x-full before:content-['“'] after:content-['”']">{{ $person->testimonial }}</p></blockquote><figcaption class="mt-7 flex items-center gap-3">@if($person->photo)<img src="{{ asset('storage/'.$person->photo) }}" alt="" class="size-12 shrink-0 rounded-full object-cover outline outline-1 -outline-offset-1 outline-black/5">@endif<div class="min-w-0"><p class="font-semibold text-slate-950">{{ $person->name }}</p><p class="text-sm text-slate-500">Lulusan {{ $person->graduation_year }} · {{ $person->occupation ?: $person->university }}</p></div></figcaption></figure>@endforeach</div></div></section>
    @endif

    <section class="bg-gold-100 py-14">
        <div class="container-app flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div><h2 class="text-balance text-2xl font-semibold tracking-tight text-primary-950 sm:text-3xl">Ingin mengenal madrasah lebih dekat?</h2><p class="mt-2 max-w-[62ch] text-pretty text-base text-primary-900">Hubungi kami untuk informasi tentang program, kegiatan, dan lingkungan belajar.</p></div>
            <a href="{{ route('contact') }}" class="btn-outline shrink-0 !border-primary-800 !bg-transparent !text-primary-950">Hubungi madrasah <x-icon name="arrow-right" class="size-4 shrink-0" /></a>
        </div>
    </section>
</x-layouts.app>
