<x-layouts.app title="Galeri Dokumentasi Foto" description="Dokumentasi visual kegiatan belajar mengajar, pengajian pesantren, dan prestasi MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Arsip Dokumentasi"
                   title="Galeri Dokumentasi Foto"
                   description="Merekam momen kebersamaan santri, rihlah ilmiah, upacara hari santri, dan dinamika kehidupan madrasah." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-10">
            @if($albums->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($albums as $album)
                        <article class="interactive-card group flex flex-col justify-between overflow-hidden">
                            <a href="{{ route('gallery.album', $album) }}" class="block">
                                <div class="relative aspect-[16/11] w-full overflow-hidden bg-slate-900">
                                    @if($album->cover)
                                        <img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->name }}"
                                             loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-900 to-slate-950 text-gold-300">
                                            <x-icon name="images" class="size-12" />
                                            <span class="mt-2 text-xs font-bold text-primary-200">Album Foto</span>
                                        </div>
                                    @endif

                                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                                        <span class="rounded-full bg-slate-950/80 px-2.5 py-1 text-xs font-bold text-white backdrop-blur border border-white/10 flex items-center gap-1.5">
                                            <x-icon name="camera" class="size-3" />
                                            <span>{{ $album->photos_count }} Foto</span>
                                        </span>
                                        @if($album->album_date)
                                            <span class="rounded-full bg-slate-950/80 px-2.5 py-1 text-xs font-semibold text-slate-300 backdrop-blur border border-white/10">
                                                {{ $album->album_date->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h2 class="text-base font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition line-clamp-2">
                                        {{ $album->name }}
                                    </h2>

                                    @if($album->description)
                                        <p class="mt-2 text-xs leading-relaxed text-slate-500 line-clamp-2">
                                            {{ $album->description }}
                                        </p>
                                    @endif
                                </div>
                            </a>

                            <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('gallery.album', $album) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-700 hover:text-primary-800">
                                    <span>Buka Album</span>
                                    <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">{{ $albums->links() }}</div>
            @else
                <x-empty-state icon="images" title="Galeri foto belum tersedia" description="Album foto dokumentasi akan segera dipublikasikan." />
            @endif
        </div>
    </section>
</x-layouts.app>
