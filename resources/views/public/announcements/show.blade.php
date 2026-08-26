<x-layouts.app :title="$announcement->seo_title ?: $announcement->title" :description="$announcement->seo_description">
    <article class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-4xl space-y-8">
            <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-primary-700 hover:text-primary-800">
                <x-icon name="arrow-left" class="size-4" />
                <span>Kembali ke Semua Pengumuman</span>
            </a>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-12 shadow-soft space-y-8">
                <header class="space-y-4 pb-6 border-b border-slate-100">
                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                        <span class="flex items-center gap-1.5 font-medium">
                            <x-icon name="calendar" class="size-3.5 text-slate-400" />
                            <time datetime="{{ $announcement->publish_date->toDateString() }}">
                                {{ $announcement->publish_date->translatedFormat('d F Y') }}
                            </time>
                        </span>
                        @if($announcement->is_important)
                            <span class="rounded-full bg-gold-100 px-3 py-0.5 text-xs font-bold text-gold-900 ring-1 ring-gold-500/30">
                                Pengumuman Penting
                            </span>
                        @endif
                        <span class="rounded-full bg-emerald-100 px-3 py-0.5 text-xs font-bold text-emerald-800">
                            Resmi Madrasah
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-950 leading-tight">
                        {{ $announcement->title }}
                    </h1>
                </header>

                <div class="prose-content max-w-none text-slate-700 leading-relaxed text-base">
                    {!! clean($announcement->body) !!}
                </div>

                @if($announcement->attachment)
                    <div class="pt-6 border-t border-slate-100">
                        <div class="rounded-2xl border border-primary-500/30 bg-primary-50/70 p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="flex size-10 items-center justify-center rounded-xl bg-primary-600 text-white">
                                    <x-icon name="file-text" class="size-5" />
                                </span>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">Lampiran Dokumen Resmi (PDF)</h4>
                                    <p class="text-[11px] text-slate-500">Surat edaran asli bernomor & bertanda tangan pimpinan</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/'.$announcement->attachment) }}" download
                               class="btn-gold !bg-gold-500 hover:!bg-gold-400 text-gold-950 font-bold shrink-0 text-xs shadow-soft">
                                <x-icon name="download" class="size-3.5" /> Unduh Dokumen
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </article>
</x-layouts.app>

