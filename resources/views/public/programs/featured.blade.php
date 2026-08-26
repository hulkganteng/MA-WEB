<x-layouts.app title="Program Unggulan Madrasah" description="Program unggulan Tahfidz, Madrasah Riset, Pengajian Turats, dan Bahasa Asing MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Pendidikan Unggul"
                   title="Program Unggulan Madrasah"
                   description="Pembinaan intensif dan terstruktur untuk melahirkan santri penghafal Al-Qur'an, saintis riset, serta kader ulama masa depan." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-12">
            @if($programs->isNotEmpty())
                <div class="grid gap-8 lg:grid-cols-2">
                    @foreach($programs as $program)
                        <article class="overflow-hidden rounded-3xl border border-primary-500/20 bg-primary-950 text-white shadow-lift flex flex-col justify-between transition hover:border-gold-400/40">
                            <div class="grid sm:grid-cols-12">
                                {{-- Visual Area (Span 5) --}}
                                <div class="sm:col-span-5 relative min-h-56 overflow-hidden bg-slate-900">
                                    @if($program->cover)
                                        <img src="{{ asset('storage/'.$program->cover) }}" alt="{{ $program->name }}"
                                             loading="lazy" class="size-full object-cover">
                                    @else
                                        <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-800 to-primary-950 p-6 text-center text-gold-300">
                                            <div class="flex size-14 items-center justify-center rounded-2xl bg-gold-400/20 text-gold-300">
                                                <x-icon name="sparkles" class="size-7" />
                                            </div>
                                            <span class="mt-3 text-xs font-bold uppercase tracking-wider text-primary-200">Program Unggulan</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="rounded-full bg-gold-500 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-gold-950 shadow">
                                            Spesialisasi
                                        </span>
                                    </div>
                                </div>

                                {{-- Content Area (Span 7) --}}
                                <div class="sm:col-span-7 p-6 sm:p-7 flex flex-col justify-between">
                                    <div>
                                        <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">{{ $program->name }}</h2>
                                        <p class="mt-2 text-xs leading-relaxed text-slate-300">{{ $program->description }}</p>

                                        @if($program->highlights)
                                            <div class="mt-4 pt-4 border-t border-white/10">
                                                <p class="text-[11px] font-bold uppercase tracking-wider text-gold-300 mb-2">Keunggulan Utama:</p>
                                                <ul class="space-y-1.5 text-xs text-slate-200">
                                                    @foreach(preg_split('/\r\n|\r|\n/', $program->highlights) as $highlight)
                                                        @if(trim($highlight))
                                                            <li class="flex items-start gap-2">
                                                                <x-icon name="check-circle-2" class="size-3.5 text-emerald-400 shrink-0 mt-0.5" />
                                                                <span>{{ $highlight }}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-primary-900/60 border-t border-white/10 flex items-center justify-between">
                                <span class="text-xs text-primary-200 flex items-center gap-1.5">
                                    <x-icon name="award" class="size-4 text-gold-400" />
                                    <span>Bersertifikat Resmi Madrasah</span>
                                </span>
                                <button type="button" @click="$store.spmbCalc.open()"
                                        class="rounded-xl bg-gold-500 px-3 py-1.5 text-xs font-bold text-gold-950 hover:bg-gold-400 transition">
                                    Daftar / Konsultasi
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="sparkles" title="Program unggulan belum tersedia" description="Informasi program unggulan akan segera diperbarui oleh admin." />
            @endif
        </div>
    </section>
</x-layouts.app>
