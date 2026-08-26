<x-layouts.app :title="$extracurricular->name" :description="$extracurricular->description" :image="$extracurricular->photo">
    <x-page-header eyebrow="Ekstrakurikuler Madrasah"
                   :title="$extracurricular->name"
                   description="Profil kegiatan, jadwal pembinaan rutin, capaian prestasi santri, dan pembimbing." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app grid gap-10 lg:grid-cols-12">
            <article class="lg:col-span-8 space-y-8">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-soft">
                    @if($extracurricular->photo)
                        <div class="relative mb-8 overflow-hidden rounded-2xl border border-slate-100">
                            <img src="{{ asset('storage/'.$extracurricular->photo) }}" alt="{{ $extracurricular->name }}"
                                 class="aspect-[16/8] w-full object-cover">
                        </div>
                    @endif

                    <div class="prose-content max-w-none text-slate-700 leading-relaxed">
                        <h2 class="text-2xl font-bold text-slate-950">Tentang Kegiatan</h2>
                        <p class="whitespace-pre-line text-sm leading-relaxed sm:text-base">{{ $extracurricular->description }}</p>
                    </div>

                    @if($extracurricular->achievements)
                        <div class="mt-8 rounded-2xl border border-gold-400/30 bg-gold-50/60 p-6">
                            <h3 class="text-base font-bold text-gold-950 flex items-center gap-2">
                                <x-icon name="trophy" class="size-5 text-gold-600" />
                                <span>Rekam Jejak Prestasi:</span>
                            </h3>
                            <p class="mt-3 whitespace-pre-line text-xs font-medium text-slate-800 leading-relaxed">
                                {{ $extracurricular->achievements }}
                            </p>
                        </div>
                    @endif
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-6">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-soft space-y-5">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-primary-100 text-primary-700 font-bold">
                            <x-icon name="info" class="size-5" />
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-950">Informasi Keanggotaan</h4>
                            <p class="text-xs text-slate-500">Santri MA Assa'adah</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Pembina / Pelatih:</span>
                            <span class="font-bold text-slate-900">{{ $extracurricular->mentor ?: 'Tim Pembina Kesiswaan' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Jadwal Latihan:</span>
                            <span class="font-bold text-slate-900">{{ $extracurricular->schedule ?: 'Sore hari ba\'da ashar' }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Tempat:</span>
                            <span class="font-bold text-slate-900">Kompleks Qomaruddin</span>
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col gap-2.5">
                        <a href="{{ route('contact') }}" class="btn-primary w-full text-center">
                            Daftar / Hubungi Pembina
                        </a>
                        <a href="{{ route('extracurricular') }}" class="btn-ghost w-full text-center text-xs">
                            &larr; Kembali ke Daftar Ekskul
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
