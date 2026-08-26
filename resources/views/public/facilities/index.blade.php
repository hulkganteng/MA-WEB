<x-layouts.app title="Sarana & Prasarana Madrasah" description="Fasilitas modern terpadu pendukung pembelajaran, riset, dan kehidupan santri MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Fasilitas & Lingkungan Belajar"
                   title="Sarana & Prasarana Madrasah"
                   description="Lingkungan belajar representatif berbasis smart classroom, laboratorium riset modern, dan asrama pesantren yang asri dan kondusif." />

    <section class="bg-slate-50/60 py-14 sm:py-20" x-data="{ previewModal: false, previewImg: '', previewTitle: '' }">
        <div class="container-app space-y-12">
            {{-- Campus Highlights Banner --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
                    <div class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800">
                            <x-icon name="wifi" class="size-5" />
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Fiber Optic Gigabit</h4>
                            <p class="text-xs text-slate-500">Koneksi internet cepat terpadu</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
                    <div class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-gold-100 text-gold-800">
                            <x-icon name="server" class="size-5" />
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Dedicated CBT Server</h4>
                            <p class="text-xs text-slate-500">Ujian mandiri berbasis komputer</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
                    <div class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-blue-100 text-blue-800">
                            <x-icon name="book-marked" class="size-5" />
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Perpustakaan Turats</h4>
                            <p class="text-xs text-slate-500">Ribuan kitab kuning & buku sains</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
                    <div class="flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-purple-100 text-purple-800">
                            <x-icon name="home" class="size-5" />
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Asrama Santri YPPQ</h4>
                            <p class="text-xs text-slate-500">Pesantren putra & putri terpisah</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Facilities Grid --}}
            @if($facilities->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($facilities as $facility)
                        <article class="interactive-card group flex flex-col justify-between overflow-hidden">
                            <div>
                                <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-900">
                                    @if($facility->thumbnail)
                                        <img src="{{ asset('storage/'.$facility->thumbnail) }}" alt="{{ $facility->name }}"
                                             loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-900 to-slate-950 text-gold-300">
                                            <x-icon name="building-2" class="size-12" />
                                            <span class="mt-2 text-xs font-bold text-primary-200">MA Assa'adah</span>
                                        </div>
                                    @endif

                                    <div class="absolute top-3 right-3">
                                        <span class="rounded-full bg-slate-950/80 px-2.5 py-1 text-[11px] font-bold text-white backdrop-blur border border-white/10">
                                            Fasilitas
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h2 class="text-lg font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition">
                                        {{ $facility->name }}
                                    </h2>
                                    <p class="mt-2 text-xs leading-relaxed text-slate-600 line-clamp-3">
                                        {{ $facility->description }}
                                    </p>
                                </div>
                            </div>

                            <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] font-semibold text-emerald-700 flex items-center gap-1.5">
                                    <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Tersedia & Terawat</span>
                                </span>
                                <span class="text-xs text-slate-400">Kompleks Qomaruddin</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="building-2" title="Data fasilitas belum tersedia" description="Informasi sarana prasarana akan segera diperbarui oleh admin." />
            @endif
        </div>
    </section>
</x-layouts.app>
