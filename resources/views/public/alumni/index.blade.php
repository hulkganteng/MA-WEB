<x-layouts.app title="Jejak Alumni (IKBAL MADAH)" description="Direktori dan testimoni Ikatan Keluarga Besar Alumni MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Jaringan Global Santri"
                   title="Jejak Alumni (IKBAL MADAH)"
                   description="Kiprah santri dan lulusan MA Ma'arif NU Assa'adah yang berkarya di perguruan tinggi ternama, birokrasi, riset, pesantren, dan dunia usaha." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-12">
            {{-- IKBAL MADAH Network Banner --}}
            <div class="rounded-3xl border border-white/20 bg-gradient-to-r from-primary-800 via-primary-700 to-primary-800 p-6 sm:p-8 text-white shadow-lift flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/15 px-3 py-1 text-xs font-bold text-gold-300">
                        <x-icon name="users" class="size-3.5" />
                        <span>IKBAL MADAH · Sejak 1972</span>
                    </div>
                    <h3 class="text-xl font-bold text-white sm:text-2xl">Bagian dari Keluarga Besar Alumni?</h3>
                    <p class="text-xs text-primary-100 leading-relaxed max-w-xl">
                        Tautkan data alumni Anda ke dalam database pusat IKBAL MADAH untuk memperkuat jejaring karier, beasiswa adik kelas, dan silaturahmi almamater.
                    </p>
                </div>
                <a href="{{ route('alumni.register') }}"
                   class="btn-gold font-bold shrink-0 shadow-soft">
                    <x-icon name="user-plus" class="size-4" /> Gabung Jaringan Alumni
                </a>
            </div>

            {{-- Alumni Grid --}}
            @if($alumni->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($alumni as $person)
                        <article class="interactive-card group flex flex-col justify-between p-6 sm:p-7 bg-white border border-slate-200/90">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-primary-50 text-primary-800 font-bold overflow-hidden shadow-soft">
                                        @if($person->photo)
                                            <img src="{{ asset('storage/'.$person->photo) }}" alt="{{ $person->name }}"
                                                 loading="lazy" class="size-full object-cover">
                                        @else
                                            <span class="text-lg">{{ substr($person->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h2 class="text-base font-bold tracking-tight text-[#1F1A17] group-hover:text-primary-700 transition truncate">
                                            {{ $person->name }}
                                        </h2>
                                        <p class="text-xs text-slate-500">Angkatan / Lulusan {{ $person->graduation_year }}</p>
                                    </div>
                                </div>

                                <blockquote class="text-xs leading-relaxed text-slate-600 italic bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    “{{ $person->testimonial ?: 'Bangga menjadi bagian dari keluarga besar MA Ma\'arif NU Assa\'adah Bungah Gresik.' }}”
                                </blockquote>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-slate-700">
                                <x-icon name="briefcase" class="size-3.5 text-primary-600 shrink-0" />
                                <span class="truncate">
                                    {{ collect([$person->occupation, $person->company])->filter()->join(' · ') ?: collect([$person->university, $person->major])->filter()->join(' · ') ?: 'Alumni Terverifikasi' }}
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">{{ $alumni->links() }}</div>
            @else
                <x-empty-state icon="graduation-cap" title="Profil alumni belum tersedia" description="Profil alumni yang telah diverifikasi akan tampil di halaman ini." />
            @endif
        </div>
    </section>
</x-layouts.app>
