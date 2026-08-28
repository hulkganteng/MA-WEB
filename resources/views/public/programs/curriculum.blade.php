<x-layouts.app title="Kurikulum & Dokumen Akademik" description="Struktur Kurikulum Merdeka terintegrasi Pesantren MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Panduan Pembelajaran"
                   title="Kurikulum & Standar Akademik"
                   description="Struktur kurikulum nasional Kementerian Agama yang diperkaya dengan khazanah keilmuan Islam pesantren salaf-modern." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-5xl space-y-8">
            {{-- Curriculum Philosophy Banner --}}
            <div class="rounded-3xl border border-white/20 bg-[#006437] p-6 sm:p-8 text-white shadow-lift">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="space-y-2">
                        <span class="rounded-full bg-gold-400 px-3 py-1 text-xs font-bold text-[#1F1A17]">
                            Sistem Pembelajaran Terpadu
                        </span>
                        <h3 class="text-xl font-bold text-white sm:text-2xl">Integrasi Kurikulum Merdeka & Turats Salaf</h3>
                        <p class="text-xs text-primary-100 leading-relaxed max-w-xl">
                            Mengembangkan daya nalar kritis dan literasi sains tingkat tinggi tanpa meninggalkan adab, sanad keilmuan, dan hafalan kitab kuning.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="rounded-2xl border border-white/20 bg-white/10 p-4 text-center">
                            <span class="block font-mono text-2xl font-bold text-gold-300">54</span>
                            <span class="text-xs text-primary-100 uppercase">JP per Pekan</span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Curriculums List --}}
            <div class="space-y-4">
                @forelse($curriculums as $curriculum)
                    <article class="interactive-card flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 p-6 sm:p-8 bg-white border border-slate-200/90">
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-primary-50 px-3 py-0.5 text-xs font-bold text-primary-800">
                                    Tahun Ajaran {{ $curriculum->academic_year ?: setting('site.academic_year', '2026/2027') }}
                                </span>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600">
                                    SK Kemenag RI
                                </span>
                            </div>
                            <h2 class="text-xl font-bold tracking-tight text-[#1F1A17]">
                                {{ $curriculum->title }}
                            </h2>
                            <p class="text-xs leading-relaxed text-slate-600 max-w-2xl">
                                {{ $curriculum->description }}
                            </p>
                        </div>

                        @if($curriculum->document)
                            <a href="{{ asset('storage/'.$curriculum->document) }}" download
                                class="btn-gold font-bold shrink-0 shadow-soft">
                                <x-icon name="download" class="size-4" />
                                <span>Unduh Silabus (PDF)</span>
                            </a>
                        @endif
                    </article>
                @empty
                    <x-empty-state icon="book-open" title="Kurikulum belum tersedia" description="Silabus dan dokumen kurikulum sedang disiapkan." />
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
