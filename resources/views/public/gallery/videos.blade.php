<x-layouts.app title="Galeri Video Madrasah" description="Dokumentasi audiovisual kegiatan, profil, dan karya multimedia santri MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Arsip Multimedia"
                   title="Galeri Video Madrasah"
                   description="Dokumentasi audiovisual upacara hari santri, mars madrasah, pidato bahasa asing, dan liputan kegiatan." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-10">
            @if($videos->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($videos as $video)
                        <article class="interactive-card group flex flex-col justify-between overflow-hidden">
                            <div>
                                <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                                    @if($video->embed_url)
                                        <iframe src="{{ $video->embed_url }}" title="{{ $video->title }}"
                                                class="size-full border-0" loading="lazy" allowfullscreen></iframe>
                                    @elseif($video->thumbnail)
                                        <img src="{{ $video->thumbnail }}" alt="{{ $video->title }}"
                                             loading="lazy" class="size-full object-cover">
                                    @else
                                        <div class="flex size-full items-center justify-center text-gold-400">
                                            <x-icon name="video" class="size-12" />
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6">
                                    <div class="flex items-center gap-2 text-xs text-primary-700 font-semibold mb-2">
                                        <x-icon name="calendar" class="size-3.5 text-primary-500" />
                                        <span>{{ optional($video->video_date)->translatedFormat('d F Y') }}</span>
                                    </div>

                                    <h2 class="text-base font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition line-clamp-2">
                                        {{ $video->title }}
                                    </h2>

                                    @if($video->description)
                                        <p class="mt-2 text-xs leading-relaxed text-slate-500 line-clamp-3">
                                            {{ $video->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">{{ $videos->links() }}</div>
            @else
                <x-empty-state icon="video" title="Galeri video belum tersedia" description="Video dokumentasi akan segera dipublikasikan." />
            @endif
        </div>
    </section>
</x-layouts.app>
