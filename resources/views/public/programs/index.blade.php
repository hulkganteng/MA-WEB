<x-layouts.app title="Program Pendidikan & Peminatan" description="Pilihan peminatan MIPA, IPS, dan Keagamaan MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Akademik & Kurikulum"
                   title="Program Pendidikan & Peminatan"
                   description="Struktur pembelajaran terpadu antara kurikulum nasional Kementerian Agama, sains terapan, dan tradisi keilmuan pesantren." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-12">
            {{-- Interactive SPMB Simulator Banner --}}
            <div class="rounded-3xl border border-white/20 bg-gradient-to-r from-[#006437] via-[#007a34] to-[#006437] p-6 sm:p-8 text-white shadow-lift flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/15 px-3 py-1 text-xs font-bold text-gold-300">
                        <x-icon name="sparkles" class="size-3.5" />
                        <span>Kalkulator Peminatan SPMB 2026/2027</span>
                    </div>
                    <h3 class="text-xl font-bold text-white sm:text-2xl">Bingung Memilih Jurusan yang Tepat?</h3>
                    <p class="text-xs text-primary-100 leading-relaxed max-w-xl">
                        Ikuti simulasi peminatan santri baru untuk mendapatkan rekomendasi jurusan yang paling sesuai dengan potensi dan cita-citamu.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="https://lynk.id/spmb-madah"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn-primary !bg-[#00923F] hover:!bg-[#007a34] font-bold shadow-soft flex items-center gap-2">
                        <x-icon name="sparkles" class="size-4 text-gold-300" />
                        <span>Daftar SPMB Online</span>
                        <x-icon name="external-link" class="size-4 opacity-80" />
                    </a>
                    <button type="button" @click="$store.spmbCalc.open()"
                            class="btn-gold font-bold shadow-soft">
                        <x-icon name="compass" class="size-4" /> Mulai Simulasi
                    </button>
                </div>
            </div>

            {{-- Programs Grid --}}
            @if($programs->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($programs as $program)
                        <article class="interactive-card group flex flex-col justify-between p-6 sm:p-8 bg-white border border-slate-200/90">
                            <div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-bold text-primary-800">
                                        {{ $program->category ?: 'Peminatan' }}
                                    </span>
                                    <span class="flex size-9 items-center justify-center rounded-xl bg-slate-100 text-[#1F1A17] group-hover:bg-primary-600 group-hover:text-white transition">
                                        <x-icon name="graduation-cap" class="size-5" />
                                    </span>
                                </div>

                                <h2 class="mt-4 text-xl font-bold tracking-tight text-[#1F1A17] group-hover:text-primary-700 transition">
                                    <a href="{{ route('programs.show', $program) }}">
                                        {{ $program->name }}
                                    </a>
                                </h2>

                                <p class="mt-2.5 text-xs leading-relaxed text-slate-600 line-clamp-3">
                                    {{ $program->description }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('programs.show', $program) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-700 hover:text-primary-800">
                                    <span>Pelajari Detail Jurusan</span>
                                    <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
                                </a>
                                <span class="text-xs font-semibold text-slate-400">Terakreditasi A</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="graduation-cap" title="Program belum tersedia" description="Daftar program pendidikan akan segera diperbarui oleh admin." />
            @endif
        </div>
    </section>
</x-layouts.app>
