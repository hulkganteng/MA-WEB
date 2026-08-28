<x-layouts.app title="Sambutan Kepala Madrasah" :description="setting('principal.name')">
    <x-page-header eyebrow="Pimpinan Madrasah"
                   title="Sambutan Kepala Madrasah"
                   description="Arahan, visi kepemimpinan, dan pesan dedikasi dari pimpinan MA Ma’arif NU Assa’adah Bungah Gresik." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app grid items-start gap-12 lg:grid-cols-12">
            {{-- Executive Profile Card --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 shadow-soft text-center">
                    <div class="relative mx-auto aspect-[4/5] w-full max-w-[280px] overflow-hidden rounded-2xl border border-slate-100 bg-[#006437]">
                        @if(setting('principal.photo'))
                            <img src="{{ asset('storage/'.setting('principal.photo')) }}"
                                 alt="{{ setting('principal.name') }}"
                                 class="size-full object-cover">
                        @else
                            <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-700 to-[#006437] text-gold-300">
                                <x-icon name="user-round" class="size-16" />
                                <span class="mt-3 text-xs font-semibold text-primary-100">Kepala Madrasah</span>
                            </div>
                        @endif
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-[#1F1A17]">{{ setting('principal.name', 'Mohammad Isma\'il Cholilur Rohman, M.Pd.') }}</h3>
                    <p class="text-xs font-bold text-primary-700">{{ setting('principal.position', 'Kepala MA Ma\'arif NU Assa\'adah') }}</p>
                    <p class="mt-1 text-xs text-slate-500">Masa Khidmah 2023 - 2027</p>

                    <div class="mt-5 pt-5 border-t border-slate-100 space-y-2 text-left text-xs text-slate-600">
                        <div class="flex items-center gap-2">
                            <x-icon name="shield-check" class="size-4 text-primary-600 shrink-0" />
                            <span>Yayasan Pondok Pesantren Qomaruddin</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icon name="landmark" class="size-4 text-gold-600 shrink-0" />
                            <span>LP Ma'arif NU Kab. Gresik</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-primary-600/30 bg-[#006437] p-6 text-white text-xs space-y-3">
                    <p class="font-bold text-gold-300 uppercase tracking-wider">Komitmen Kepemimpinan</p>
                    <p class="text-primary-100 leading-relaxed">
                        Menjaga marwah intelektual santri, mengawal akselerasi prestasi nasional, dan mempererat ukhuwah wali santri dan masyayikh.
                    </p>
                </div>
            </div>

            {{-- Speech Article --}}
            <article class="lg:col-span-8">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-12 shadow-soft">
                    <div class="text-center pb-8 border-b border-slate-100">
                        <p class="font-arabic text-2xl sm:text-3xl text-primary-800 font-bold" dir="rtl">
                            بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                        </p>
                        <p class="mt-2 text-xs font-bold uppercase tracking-widest text-primary-700">
                            Pesan Kelembagaan & Arah Pendidikan
                        </p>
                    </div>

                    <div class="mt-8 prose-content max-w-none text-slate-700 leading-relaxed">
                        @if(setting('principal.speech'))
                            {!! clean(setting('principal.speech')) !!}
                        @else
                            <p>Assalamu’alaikum warahmatullahi wabarakatuh.</p>
                            <p>Alhamdulillahirabbil 'alamin, puji syukur ke hadirat Allah SWT yang senantiasa melimpahkan taufiq dan hidayah-Nya kepada keluarga besar MA Ma'arif NU Assa'adah Bungah Gresik.</p>
                            <p>Di era transformasi digital yang bergerak sangat dinamis, madrasah kami memegang teguh prinsip <em>al-muhafadhotu 'ala qodimis sholih wal akhdzu bil jadidil ashlah</em>. Kami membimbing santri mendalami ilmu syariah bersanad shahih sekaligus menguasai sains dan riset modern.</p>
                        @endif
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <p class="text-xs text-slate-500">Bungah, Gresik, Jawa Timur</p>
                            <p class="text-sm font-bold text-slate-900">{{ setting('principal.name') }}</p>
                        </div>
                        <a href="{{ route('contact') }}" class="btn-primary">
                            <x-icon name="message-square" class="size-4" /> Hubungi Kepala & Pimpinan
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>
</x-layouts.app>
