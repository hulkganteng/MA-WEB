<x-layouts.app title="Program Unggulan Madrasah" description="Program unggulan Tahfidz, Madrasah Riset, Pengajian Turats, dan Bahasa Asing MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Pendidikan Unggul"
                   title="Program Unggulan Madrasah"
                   description="Pembinaan intensif dan terstruktur untuk melahirkan santri penghafal Al-Qur'an, saintis riset, serta kader ulama masa depan." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-12">
            @if($programs->isNotEmpty())
                <div class="grid gap-8 lg:grid-cols-2">
                    @foreach($programs as $program)
                        <article class="overflow-hidden rounded-3xl border border-slate-200/90 bg-white text-[#1F1A17] shadow-soft flex flex-col justify-between transition hover:border-primary-600">
                            <div class="grid sm:grid-cols-12">
                                {{-- Visual Area (Span 5) --}}
                                <div class="sm:col-span-5 relative min-h-56 overflow-hidden bg-[#006437]">
                                    @if($program->cover)
                                        <img src="{{ asset('storage/'.$program->cover) }}" alt="{{ $program->name }}"
                                             loading="lazy" class="size-full object-cover">
                                    @else
                                        <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-[#006437] via-[#007a34] to-[#00923F] p-6 text-center text-white">
                                            <div class="flex size-14 items-center justify-center rounded-2xl bg-gold-400 text-[#1F1A17] font-bold">
                                                <x-icon name="sparkles" class="size-7" />
                                            </div>
                                            <span class="mt-3 text-xs font-bold uppercase tracking-wider text-gold-300">Program Unggulan</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="rounded-full bg-gold-400 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#1F1A17] shadow">
                                            Spesialisasi
                                        </span>
                                    </div>
                                </div>

                                {{-- Content Area (Span 7) --}}
                                <div class="sm:col-span-7 p-6 sm:p-7 flex flex-col justify-between">
                                    <div>
                                        <h2 class="text-xl font-bold tracking-tight text-[#1F1A17] sm:text-2xl">{{ $program->name }}</h2>
                                        <p class="mt-2 text-xs leading-relaxed text-slate-600">{{ $program->description }}</p>

                                        @if($program->highlights)
                                            <div class="mt-4 pt-4 border-t border-slate-100">
                                                <p class="text-[11px] font-bold uppercase tracking-wider text-primary-700 mb-2">Keunggulan Utama:</p>
                                                <ul class="space-y-1.5 text-xs text-[#1F1A17]">
                                                    @foreach(preg_split('/\r\n|\r|\n/', $program->highlights) as $highlight)
                                                        @if(trim($highlight))
                                                            <li class="flex items-start gap-2">
                                                                <x-icon name="check-circle-2" class="size-3.5 text-primary-600 shrink-0 mt-0.5" />
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

                            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-600 flex items-center gap-1.5 font-medium">
                                    <x-icon name="award" class="size-4 text-primary-600" />
                                    <span>Sertifikasi & Sanad Resmi</span>
                                </span>
                                <a href="{{ route('programs.show', $program) }}"
                                   class="btn-primary !px-4 !py-2 text-xs">
                                    <span>Pelajari Program</span>
                                    <x-icon name="arrow-right" class="size-3.5" />
                                </a>
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
