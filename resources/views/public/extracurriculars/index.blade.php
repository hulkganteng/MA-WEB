<x-layouts.app title="Ekstrakurikuler Santri" description="Wadah pengembangan minat, bakat, seni Islami, sains, dan keolahragaan MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Kesiswaan & Pengembangan Diri"
                   title="Ekstrakurikuler Santri"
                   description="Ruang ekspresi kepemimpinan, kreativitas seni hadrah sholawat, olahraga prestasi, pramuka, dan riset sains teknologi." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-10">
            @if($extracurriculars->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($extracurriculars as $item)
                        <article class="interactive-card group flex flex-col justify-between overflow-hidden">
                            <div>
                                <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-900">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}"
                                             loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-900 to-slate-950 text-gold-300">
                                            <x-icon name="sparkles" class="size-12" />
                                            <span class="mt-2 text-xs font-bold text-primary-200">Ekstrakurikuler</span>
                                        </div>
                                    @endif

                                    <div class="absolute top-3 right-3">
                                        <span class="rounded-full bg-slate-950/80 px-2.5 py-1 text-xs font-bold text-white backdrop-blur border border-white/10">
                                            Aktif
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h2 class="text-xl font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition">
                                        <a href="{{ route('extracurricular.show', $item) }}">
                                            {{ $item->name }}
                                        </a>
                                    </h2>

                                    <p class="mt-2 text-xs leading-relaxed text-slate-600 line-clamp-3">
                                        {{ $item->description }}
                                    </p>

                                    @if($item->schedule)
                                        <div class="mt-4 flex items-center gap-2 rounded-xl bg-slate-50 p-2.5 text-xs text-slate-600">
                                            <x-icon name="clock" class="size-4 text-primary-600 shrink-0" />
                                            <span class="truncate">{{ $item->schedule }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('extracurricular.show', $item) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-700 hover:text-primary-800">
                                    <span>Pelajari & Daftar</span>
                                    <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                                </a>
                                @if($item->mentor)
                                    <span class="text-xs text-slate-400 truncate max-w-[120px]">
                                        {{ $item->mentor }}
                                    </span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="users" title="Ekstrakurikuler belum tersedia" description="Daftar kegiatan ekstrakurikuler sedang diperbarui." />
            @endif
        </div>
    </section>
</x-layouts.app>
