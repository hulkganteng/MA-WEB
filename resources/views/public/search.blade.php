<x-layouts.app title="Pencarian Informasi" description="Pencarian informasi cepat di portal resmi MA Ma'arif NU Assa'adah Bungah Gresik." robots="noindex, follow">
    <x-page-header eyebrow="Pusat Eksplorasi"
                   title="Pencarian Informasi Madrasah"
                   description="Temukan berita terbaru, pengumuman, agenda, program unggulan, guru, fasilitas, dokumen unduhan, dan ekstrakurikuler." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-4xl space-y-10">
            {{-- Search Bar --}}
            <form action="{{ route('search') }}" method="GET"
                  class="rounded-3xl border border-slate-200/80 bg-white p-3 shadow-soft flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <x-icon name="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-slate-400" />
                    <input id="search-query" name="q" type="search" value="{{ $term }}"
                           placeholder="Ketik kata kunci pencarian (misal: Tahfidz, SPMB, Jadwal, MIPA)..."
                           class="w-full rounded-2xl border-0 bg-transparent py-3 pl-12 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-0">
                </div>
                <button type="submit" class="btn-primary shrink-0 !py-3 !px-6 text-xs font-bold">
                    <span>Cari Sekarang</span>
                    <x-icon name="arrow-right" class="size-4" />
                </button>
            </form>

            @if($term)
                <div class="flex items-center justify-between border-b border-slate-200/80 pb-4">
                    <p class="text-xs font-semibold text-slate-600">
                        Menemukan <strong class="text-slate-950 font-bold font-mono">{{ $results->sum(fn($items) => $items->count()) }}</strong> hasil untuk kata kunci <span class="rounded bg-gold-100 px-2 py-0.5 text-gold-900 font-bold">“{{ $term }}”</span>
                    </p>
                </div>
            @endif

            <div class="space-y-8">
                @forelse($results as $group => $items)
                    <section class="space-y-3">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-primary-800 flex items-center gap-2">
                            <span class="size-2 rounded-full bg-emerald-500"></span>
                            <span>{{ $group }} ({{ $items->count() }})</span>
                        </h2>

                        <div class="divide-y divide-slate-100 rounded-3xl border border-slate-200/80 bg-white p-2 shadow-soft">
                            @foreach($items as $item)
                                <article class="p-4 rounded-2xl transition hover:bg-slate-50">
                                    <h3 class="text-sm font-bold text-slate-950 hover:text-primary-700 transition">
                                        <a href="{{ $item['url'] }}" class="block">
                                            {{ $item['title'] }}
                                        </a>
                                    </h3>
                                    @if($item['description'])
                                        <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-slate-600">
                                            {{ \Illuminate\Support\Str::limit($item['description'], 180) }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                @empty
                    @if($term)
                        <x-empty-state icon="search-x" title="Tidak ada hasil yang cocok" description="Coba gunakan kata kunci lain atau periksa ejaan kata kunci Anda." />
                    @endif
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
