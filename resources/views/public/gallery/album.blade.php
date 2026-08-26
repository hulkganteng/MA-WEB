<x-layouts.app :title="$album->name" :description="$album->description">
    <div x-data="{ lightbox: null, caption: '' }">
        <x-page-header eyebrow="Album Dokumentasi"
                       :title="$album->name"
                       :description="$album->description ?: 'Dokumentasi kegiatan keluarga besar MA Ma\'arif NU Assa\'adah.'" />

        <section class="bg-slate-50/60 py-14 sm:py-20">
            <div class="container-app space-y-8">
                <a href="{{ route('gallery.photos') }}" class="inline-flex items-center gap-2 text-xs font-bold text-primary-700 hover:text-primary-800">
                    <x-icon name="arrow-left" class="size-4" />
                    <span>Kembali ke Semua Album</span>
                </a>

                @if($album->photos->isNotEmpty())
                    <div class="columns-1 gap-4 sm:columns-2 lg:columns-3 space-y-4">
                        @foreach($album->photos as $photo)
                            <div class="break-inside-avoid">
                                <button type="button"
                                        class="group relative w-full overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-1.5 shadow-soft transition hover:shadow-lift focus:outline-none"
                                        @click="lightbox = @js($photo->url); caption = @js($photo->caption ?: $album->name)">
                                    <div class="overflow-hidden rounded-xl bg-slate-900">
                                        <img src="{{ $photo->url }}" alt="{{ $photo->caption ?: $album->name }}" loading="lazy"
                                             class="w-full object-cover transition duration-500 group-hover:scale-105">
                                    </div>
                                    <div class="absolute inset-x-3 bottom-3 flex items-center justify-between rounded-xl bg-slate-950/80 p-2.5 text-xs text-white backdrop-blur opacity-0 transition group-hover:opacity-100">
                                        <span class="truncate font-medium">{{ $photo->caption ?: 'Lihat Foto' }}</span>
                                        <x-icon name="maximize-2" class="size-3.5 shrink-0 text-gold-400" />
                                    </div>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    {{-- Lightbox Modal --}}
                    <div x-show="lightbox" x-cloak
                         @keydown.escape.window="lightbox = null"
                         class="fixed inset-0 z-[70] flex flex-col items-center justify-start overflow-y-auto overscroll-contain bg-slate-950/95 p-4 sm:justify-center sm:p-8 backdrop-blur-sm"
                         role="dialog" aria-modal="true">
                        <button type="button" @click="lightbox = null" aria-label="Tutup foto"
                                class="absolute right-5 top-5 flex size-11 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition">
                            <x-icon name="x" class="size-6" />
                        </button>
                        <div class="relative my-auto max-h-[calc(100dvh-2rem)] max-w-5xl overflow-y-auto overscroll-contain rounded-2xl">
                            <img :src="lightbox" alt="" class="max-h-[80vh] max-w-full rounded-2xl object-contain">
                            <p x-text="caption" class="mt-3 text-center text-xs text-slate-300"></p>
                        </div>
                    </div>
                @else
                    <x-empty-state icon="image" title="Album ini belum memiliki foto" description="Foto-foto kegiatan akan segera ditambahkan." />
                @endif
            </div>
        </section>
    </div>
</x-layouts.app>
