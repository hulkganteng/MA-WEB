<x-layouts.app title="Struktur Organisasi Pimpinan" description="Struktur pengelola dan dewan pimpinan MA Ma’arif NU Assa’adah Bungah Gresik.">
    <x-page-header eyebrow="Profil Kepemimpinan"
                   title="Struktur Organisasi Madrasah"
                   description="Bagan susunan pimpinan, dewan masyayikh, wakil kepala madrasah, dan kepala unit penunjang pendidikan." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-12">
            @if($members->isNotEmpty())
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($members as $member)
                        <div class="interactive-card group flex flex-col justify-between p-6 sm:p-8 bg-white border border-slate-200/90">
                            <div class="text-center">
                                {{-- Leader Portrait --}}
                                <div class="relative mx-auto size-28 overflow-hidden rounded-full border-2 border-gold-400/40 bg-[#006437] p-0.5 shadow-soft group-hover:scale-105 transition duration-300">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" class="size-full rounded-full object-cover">
                                    @else
                                        <div class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-primary-600 via-primary-700 to-[#006437] text-gold-300 font-bold text-2xl">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <span class="mt-4 inline-block rounded-full bg-gold-100 px-3 py-0.5 text-xs font-bold text-[#1F1A17] ring-1 ring-gold-500/30">
                                    {{ $member->position }}
                                </span>

                                <h2 class="mt-2 text-lg font-bold text-[#1F1A17] group-hover:text-primary-700 transition">
                                    {{ $member->name }}
                                </h2>
                            </div>

                            {{-- Sub-Division / Sub-Department Staff --}}
                            @if($member->children->isNotEmpty())
                                <div class="mt-6 border-t border-slate-100 pt-4">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Bawahan / Anggota Unit:</p>
                                    <ul role="list" class="divide-y divide-slate-100 rounded-2xl bg-slate-50 p-2">
                                        @foreach($member->children as $child)
                                            <li class="flex items-center justify-between p-2 text-xs">
                                                <div class="min-w-0">
                                                    <p class="font-bold text-[#1F1A17] truncate">{{ $child->name }}</p>
                                                    <p class="text-[11px] text-slate-500 truncate">{{ $child->position }}</p>
                                                </div>
                                                <span class="size-2 rounded-full bg-primary-600 shrink-0 ml-2"></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="network" title="Struktur organisasi belum tersedia" description="Bagan susunan pimpinan akan segera diperbarui oleh administrator." />
            @endif

            {{-- Institutional Leadership Hierarchy Info Banner --}}
            <div class="rounded-3xl border border-white/20 bg-[#006437] p-6 sm:p-8 text-white shadow-lift">
                <div class="grid gap-6 sm:grid-cols-3 items-center text-center sm:text-left">
                    <div class="flex items-center gap-3 justify-center sm:justify-start">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-gold-400 text-[#1F1A17] font-bold">
                            <x-icon name="landmark" class="size-6" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Pondok Pesantren Qomaruddin</h4>
                            <p class="text-xs text-primary-100">Yayasan Pengasuh Utama (1775 M)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-center sm:justify-start">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white font-bold">
                            <x-icon name="shield-check" class="size-6 text-gold-400" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">LP Ma'arif NU Gresik</h4>
                            <p class="text-xs text-primary-100">Badan Pelaksana Pendidikan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-center sm:justify-start">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-blue-500 text-white font-bold">
                            <x-icon name="graduation-cap" class="size-6" />
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Kementerian Agama RI</h4>
                            <p class="text-xs text-primary-200">Regulator Pendidikan Madrasah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
