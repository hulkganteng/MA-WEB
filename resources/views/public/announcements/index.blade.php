<x-layouts.app title="Pengumuman Resmi Madrasah" description="Informasi resmi, surat edaran, dan pemberitahuan terbaru dari MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Pusat Warta Resmi"
                   title="Pengumuman & Surat Edaran"
                   description="Pemberitahuan resmi kelembagaan terkait kegiatan akademik, libur pesantren, pendaftaran, dan informasi kedinasan." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-4xl space-y-6">
            <div class="space-y-4">
                @forelse ($announcements as $announcement)
                    <article class="interactive-card group flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 p-6">
                        <div class="flex items-start gap-4 min-w-0">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl {{ $announcement->is_important ? 'bg-gold-500 text-gold-950 shadow-soft' : 'bg-primary-100 text-primary-700' }} transition group-hover:scale-105">
                                <x-icon name="megaphone" class="size-6" />
                            </div>

                            <div class="space-y-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <x-icon name="calendar" class="size-3.5 text-slate-400" />
                                        <time datetime="{{ $announcement->publish_date->toDateString() }}">
                                            {{ $announcement->publish_date->translatedFormat('d F Y') }}
                                        </time>
                                    </span>
                                    @if ($announcement->is_important)
                                        <span class="rounded-full bg-gold-100 px-2 py-0.5 text-[10px] font-bold text-gold-900 ring-1 ring-gold-500/30">
                                            Penting & Wajib
                                        </span>
                                    @endif
                                </div>

                                <h2 class="text-base font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition">
                                    <a href="{{ route('pengumuman.show', $announcement) }}">
                                        {{ $announcement->title }}
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <a href="{{ route('pengumuman.show', $announcement) }}"
                           class="btn-outline shrink-0 !py-2 !px-4 text-xs font-semibold self-end sm:self-center">
                            <span>Baca Edaran</span>
                            <x-icon name="arrow-right" class="size-3.5" />
                        </a>
                    </article>
                @empty
                    <x-empty-state icon="megaphone" title="Belum ada pengumuman" description="Pengumuman dan edaran resmi terbaru akan ditampilkan di sini." />
                @endforelse
            </div>

            <div class="mt-8">{{ $announcements->links() }}</div>
        </div>
    </section>
</x-layouts.app>

