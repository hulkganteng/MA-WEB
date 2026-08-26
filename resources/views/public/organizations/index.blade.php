<x-layouts.app title="Organisasi Siswa & IPNU-IPPNU" description="Wadah kaderisasi kepemimpinan santri: OSIM, PK IPNU, PK IPPNU, dan MPK MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Kaderisasi & Kepemimpinan"
                   title="Organisasi Kesiswaan & Santri"
                   description="Wadah tempa kepemimpinan santri berlandaskan nilai-nilai Ahlussunnah wal Jama'ah An-Nahdliyyah." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-12">
            @if($organizations->isNotEmpty())
                <div class="grid gap-8 lg:grid-cols-2">
                    @foreach($organizations as $organization)
                        <article class="interactive-card group flex flex-col justify-between p-6 sm:p-8">
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <div class="relative size-16 shrink-0 overflow-hidden rounded-2xl border border-slate-100 bg-white p-2 shadow-soft">
                                        @if($organization->logo)
                                            <img src="{{ asset('storage/'.$organization->logo) }}" alt="{{ $organization->name }}"
                                                 class="size-full object-contain">
                                        @else
                                            <div class="flex size-full items-center justify-center bg-primary-100 text-primary-800 font-bold">
                                                <x-icon name="network" class="size-7" />
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 uppercase tracking-wider">
                                            Organisasi Resmi
                                        </span>
                                        <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition">
                                            {{ $organization->name }}
                                        </h2>
                                    </div>
                                </div>

                                <p class="text-xs leading-relaxed text-slate-600">
                                    {{ $organization->description }}
                                </p>

                                <div class="space-y-4 pt-4 border-t border-slate-100 text-xs">
                                    @if($organization->structure)
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <h4 class="font-bold text-slate-900 flex items-center gap-1.5 mb-1.5">
                                                <x-icon name="users" class="size-3.5 text-primary-600" />
                                                <span>Susunan Pengurus:</span>
                                            </h4>
                                            <p class="whitespace-pre-line text-slate-600 leading-relaxed">{{ $organization->structure }}</p>
                                        </div>
                                    @endif

                                    @if($organization->work_program)
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <h4 class="font-bold text-slate-900 flex items-center gap-1.5 mb-1.5">
                                                <x-icon name="target" class="size-3.5 text-gold-600" />
                                                <span>Program Kerja Unggulan:</span>
                                            </h4>
                                            <p class="whitespace-pre-line text-slate-600 leading-relaxed">{{ $organization->work_program }}</p>
                                        </div>
                                    @endif

                                    @if($organization->activities)
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <h4 class="font-bold text-slate-900 flex items-center gap-1.5 mb-1.5">
                                                <x-icon name="calendar" class="size-3.5 text-emerald-600" />
                                                <span>Aktivitas & Pengabdian:</span>
                                            </h4>
                                            <p class="whitespace-pre-line text-slate-600 leading-relaxed">{{ $organization->activities }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="network" title="Organisasi siswa belum tersedia" description="Daftar organisasi kesiswaan sedang disiapkan." />
            @endif
        </div>
    </section>
</x-layouts.app>
