<x-layouts.app title="Pusat Unduhan Berkas & Dokumen" description="Pusat berkas, silabus, brosur SPMB, formulir pendaftaran, dan kalender pendidikan MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Pusat Arsip Digital"
                   title="Pusat Unduhan & Dokumen Resmi"
                   description="Akses mudah dan terbuka untuk mengunduh berkas administrasi, formulir, panduan santri, dan materi kurikulum." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-5xl space-y-8">
            @if($categories->isNotEmpty())
                <nav aria-label="Filter kategori" class="overflow-x-auto pb-2">
                    <div class="flex min-w-max items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-2.5 shadow-soft">
                        <a href="{{ route('downloads.index') }}"
                           class="rounded-xl px-4 py-2 text-xs font-bold transition {{ !request('kategori') ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                            Semua Berkas
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('downloads.index', ['kategori' => $category->slug]) }}"
                               class="rounded-xl px-4 py-2 text-xs font-bold transition {{ request('kategori') === $category->slug ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            @endif

            <div class="space-y-4">
                @forelse($downloads as $download)
                    <article class="interactive-card group flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 p-6">
                        <div class="flex items-start gap-4 min-w-0">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-primary-100 text-primary-700 transition group-hover:bg-primary-600 group-hover:text-white">
                                <x-icon name="file-down" class="size-6" />
                            </div>

                            <div class="space-y-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                    @if($download->category)
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-bold text-slate-700 uppercase">
                                            {{ $download->category->name }}
                                        </span>
                                    @endif
                                    <span class="flex items-center gap-1">
                                        <x-icon name="calendar" class="size-3 text-slate-400" />
                                        <time>{{ optional($download->publish_date)->translatedFormat('d M Y') }}</time>
                                    </span>
                                </div>

                                <h2 class="text-base font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition">
                                    {{ $download->name }}
                                </h2>

                                @if($download->description)
                                    <p class="text-xs leading-relaxed text-slate-600 line-clamp-2">
                                        {{ $download->description }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-3 text-xs text-slate-400 pt-1">
                                    <span>Ukuran: {{ format_bytes($download->file_size) }}</span>
                                    <span>·</span>
                                    <span>Diunduh: {{ number_format($download->downloads) }} kali</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('downloads.show', $download) }}"
                           class="btn-primary shrink-0 !py-2.5 !px-4 text-xs font-semibold self-end sm:self-center">
                            <x-icon name="download" class="size-3.5" />
                            <span>Unduh Berkas</span>
                        </a>
                    </article>
                @empty
                    <x-empty-state icon="file-down" title="Dokumen belum tersedia" description="Arsip dokumen akan segera diperbarui." />
                @endforelse
            </div>

            <div class="mt-8">{{ $downloads->links() }}</div>
        </div>
    </section>
</x-layouts.app>
