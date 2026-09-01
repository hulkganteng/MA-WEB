<x-layouts.app :title="$program->name" :description="$program->description" :image="$program->cover">
    <x-page-header eyebrow="{{ $program->category ?: 'Program Pendidikan' }}"
                   :title="$program->name"
                   description="Struktur kompetensi, fokus kurikulum, dan prospek studi lanjutan peserta didik." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app grid gap-10 lg:grid-cols-12">
            <article class="lg:col-span-8 space-y-8">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-soft">
                    @if($program->cover)
                        <div class="relative mb-8 overflow-hidden rounded-2xl border border-slate-100">
                            <img src="{{ asset('storage/'.$program->cover) }}" alt="{{ $program->name }}"
                                 class="aspect-[16/8] w-full object-cover">
                        </div>
                    @endif

                    <div class="prose-content max-w-none text-slate-700 leading-relaxed">
                        <h2 class="text-2xl font-bold text-[#1F1A17]">Deskripsi & Visi Keilmuan</h2>
                        <p class="whitespace-pre-line text-sm leading-relaxed sm:text-base">{{ $program->description }}</p>
                    </div>

                    @if($program->highlights)
                        <div class="mt-8 rounded-2xl border border-primary-200 bg-primary-50/70 p-6">
                            <h3 class="text-base font-bold text-primary-800 flex items-center gap-2">
                                <x-icon name="sparkles" class="size-5 text-gold-600" />
                                <span>Fokus & Keunggulan Pembelajaran:</span>
                            </h3>
                            <ul class="mt-4 grid gap-2 sm:grid-cols-2 text-xs font-semibold text-[#1F1A17]">
                                @foreach(preg_split('/\r\n|\r|\n/', $program->highlights) as $hl)
                                    @if(trim($hl))
                                        <li class="flex items-center gap-2">
                                            <x-icon name="check-circle-2" class="size-4 text-primary-600 shrink-0" />
                                            <span>{{ $hl }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-6">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-soft space-y-5">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-primary-100 text-primary-700 font-bold">
                            <x-icon name="graduation-cap" class="size-5" />
                        </span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-950">Informasi Pendaftaran</h4>
                            <p class="text-xs text-slate-500">Tahun Ajaran 2026/2027</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Status Jurusan:</span>
                            <span class="font-bold text-emerald-700">Penerimaan Aktif</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Kurikulum:</span>
                            <span class="font-bold text-slate-900">Merdeka + Turats Pesantren</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-100">
                            <span class="text-slate-500">Lokasi Belajar:</span>
                            <span class="font-bold text-slate-900">Kampus Bungah Gresik</span>
                        </div>
                    </div>

                    <div class="pt-2 flex flex-col gap-2.5">
                        <a href="https://lynk.id/spmb-madah"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-primary w-full flex items-center justify-center gap-2 font-bold shadow-soft">
                            <x-icon name="sparkles" class="size-4 text-gold-300" />
                            <span>Pendaftaran SPMB Online</span>
                            <x-icon name="external-link" class="size-3.5 opacity-80" />
                        </a>
                        <button type="button" @click="$store.spmbCalc.open()"
                                class="btn-gold w-full text-center font-bold">
                            <x-icon name="compass" class="size-4" /> Simulasi Peminatan
                        </button>
                        <a href="{{ route('contact') }}" class="btn-outline w-full text-center">
                            Hubungi Tim Madrasah
                        </a>
                        <a href="{{ route('programs') }}" class="btn-ghost w-full text-center text-xs">
                            &larr; Kembali ke Semua Program
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
