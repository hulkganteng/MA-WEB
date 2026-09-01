<x-layouts.app title="Kontak & Pusat Layanan" description="Hubungi MA Ma'arif NU Assa'adah Bungah Gresik. Layanan informasi SPMB, konsultasi akademik, dan alamat madrasah.">
    <x-page-header eyebrow="Layanan Informasi & Kunjungan"
                   title="Pusat Layanan & Kontak Resmi"
                   description="Silakan sampaikan pertanyaan, konsultasi peminatan santri, atau jadwalkan kunjungan silaturahmi ke madrasah." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app grid gap-12 lg:grid-cols-12">
            {{-- Contact Info Column (Span 5) --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-soft space-y-6">
                    <h2 class="text-xl font-bold tracking-tight text-[#1F1A17] flex items-center gap-2.5">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-primary-50 text-primary-700 font-bold">
                            <x-icon name="map-pin" class="size-5" />
                        </span>
                        <span>Informasi & Alamat Kantor</span>
                    </h2>

                    <dl class="space-y-4 text-xs text-slate-600">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <dt class="font-bold text-[#1F1A17] flex items-center gap-1.5 mb-1">
                                <x-icon name="building-2" class="size-3.5 text-primary-600" />
                                <span>Alamat Kampus:</span>
                            </dt>
                            <dd class="leading-relaxed">{{ setting('contact.address', 'Jl. Raya Bungah No. 01 Sampurnan, Bungah, Gresik, Jawa Timur 61152') }}</dd>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <dt class="font-bold text-[#1F1A17] flex items-center gap-1.5 mb-1">
                                    <x-icon name="phone" class="size-3.5 text-primary-600" />
                                    <span>Telepon Kantor:</span>
                                </dt>
                                <dd class="leading-relaxed font-mono">{{ setting('contact.phone', '(031) 3949xxx') }}</dd>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <dt class="font-bold text-[#1F1A17] flex items-center gap-1.5 mb-1">
                                    <x-icon name="mail" class="size-3.5 text-primary-600" />
                                    <span>Email Resmi:</span>
                                </dt>
                                <dd class="leading-relaxed truncate">{{ setting('contact.email', 'info@ma-assaadah.sch.id') }}</dd>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <dt class="font-bold text-[#1F1A17] flex items-center gap-1.5 mb-1">
                                <x-icon name="clock" class="size-3.5 text-gold-600" />
                                <span>Jam Pelayanan Tata Usaha:</span>
                            </dt>
                            <dd class="leading-relaxed">{{ setting('contact.hours', 'Senin - Kamis & Sabtu: 07.00 - 14.30 WIB | Jum\'at: 07.00 - 11.00 WIB') }}</dd>
                        </div>
                    </dl>

                    {{-- Direct SPMB Online Registration Button --}}
                    <a href="https://lynk.id/spmb-madah"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-primary-600 via-primary-700 to-primary-800 px-5 py-3.5 text-xs font-bold text-white shadow-soft transition hover:scale-[1.02]">
                        <x-icon name="sparkles" class="size-4 text-gold-300" />
                        <span>Pendaftaran SPMB Online (Lynk.id)</span>
                        <x-icon name="external-link" class="size-4 opacity-80" />
                    </a>

                    {{-- Fast WhatsApp Hotline Button --}}
                    @if(setting('contact.whatsapp'))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact.whatsapp')) }}?text={{ urlencode(setting('contact.whatsapp_message', 'Halo Admin MA Ma\'arif NU Assa\'adah, saya ingin berkonsultasi mengenai...')) }}"
                           target="_blank" rel="noopener"
                           class="flex items-center justify-center gap-2.5 rounded-2xl bg-[#25D366] px-5 py-3.5 text-xs font-bold text-white shadow-soft transition hover:brightness-105">
                            <x-icon name="message-circle" class="size-4" />
                            <span>Konsultasi Cepat via WhatsApp</span>
                        </a>
                    @endif
                </div>

                {{-- Foundation Legacy Badge --}}
                <div class="rounded-3xl border border-primary-600/30 bg-primary-800 p-6 text-white text-xs space-y-2">
                    <div class="flex items-center gap-2 text-gold-300 font-bold">
                        <x-icon name="landmark" class="size-4" />
                        <span>Kompleks Pondok Pesantren Qomaruddin</span>
                    </div>
                    <p class="text-primary-100 leading-relaxed">
                        Terletak strategis di pusat kawasan santri Sampurnan, Bungah, Gresik, mudah dijangkau dari jalur pantura Surabaya-Tuban.
                    </p>
                </div>
            </div>

            {{-- Contact Form Column (Span 7) --}}
            <div class="lg:col-span-7">
                <form method="POST" action="{{ route('contact.store') }}"
                      class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-soft space-y-6">
                    @csrf

                    <div>
                        <h2 class="text-xl font-bold text-[#1F1A17]">Kirim Pesan atau Pertanyaan</h2>
                        <p class="mt-1 text-xs text-slate-500">Tim kami akan merespons pesan Anda via email atau WhatsApp.</p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach ([
                            ['name', 'Nama Lengkap', 'text', true, 'Nama Anda'],
                            ['email', 'Alamat Email', 'email', true, 'email@domain.com'],
                            ['phone', 'Nomor WhatsApp (Opsional)', 'tel', false, '081234567890'],
                            ['subject', 'Subjek Pesan', 'text', true, 'Pertanyaan / SPMB / Konsultasi']
                        ] as [$name, $label, $type, $req, $ph])
                            <div>
                                <label for="{{ $name }}" class="label text-xs font-bold text-slate-700">
                                    {{ $label }} @if($req)<span class="text-rose-500">*</span>@endif
                                </label>
                                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                                       value="{{ old($name) }}" placeholder="{{ $ph }}"
                                       class="input text-xs" @required($req)>
                                @error($name)
                                    <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label for="message" class="label text-xs font-bold text-slate-700">
                            Isi Pesan <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="5"
                                  placeholder="Tuliskan pertanyaan atau maksud Anda secara jelas..."
                                  class="input text-xs" required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        <x-icon name="send" class="size-4" />
                        <span>Kirim Pesan Sekarang</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- FAQ Accordion Section --}}
        <div class="container-app max-w-4xl mt-16 space-y-6" x-data="{ activeAccordion: null }">
            <div class="text-center space-y-2">
                <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-bold text-gold-900 ring-1 ring-gold-500/20">
                    Pusat Informasi Santri Baru
                </span>
                <h3 class="text-2xl font-extrabold tracking-tight text-slate-950">Pertanyaan yang Sering Diajukan (FAQ)</h3>
            </div>

            <div class="space-y-3">
                @foreach([
                    ['Apakah siswa MA Ma\'arif NU Assa\'adah wajib mondok / tinggal di asrama?', 'Tidak wajib, namun sangat dianjurkan. Siswa dapat berstatus santri mukim (tinggal di asrama Pondok Pesantren Qomaruddin) atau santri kalong (pulang-pergi bagi warga sekitar Bungah dan Gresik). Fasilitas asrama putra dan putri tersedia secara terpisah dengan pembinaan 24 jam.'],
                    ['Apa saja jurusan peminatan yang dibuka pada SPMB 2026/2027?', 'Madrasah membuka 3 peminatan utama: Peminatan MIPA (Matematika dan Ilmu Pengetahuan Alam berbasis Riset), Peminatan IPS (Ilmu Pengetahuan Sosial berbasis Entrepreneur & Public Speaking), dan Peminatan Keagamaan/Turats (Kajian Kitab Kuning dan Tahfidzul Qur\'an bersanad).'],
                    ['Apakah tersedia beasiswa bagi santri berprestasi dan tahfidz?', 'Ya! Madrasah menyediakan beasiswa pembebasan biaya pendidikan bagi penghafal Al-Qur\'an (Tahfidz minimal 5 juz), juara KSM/MYRES tingkat kabupaten/provinsi/nasional, serta beasiswa afirmasi dari Yayasan PP Qomaruddin.'],
                    ['Bagaimana prosedur pendaftaran secara online?', 'Pendaftaran dapat dilakukan dengan mengisi simulasi peminatan di website, kemudian menghubungi panitia SPMB via WhatsApp atau langsung hadir di Sekretariat SPMB Kampus Sampurnan Bungah Gresik pada jam kerja.']
                ] as $idx => [$faqQ, $faqA])
                    <div class="rounded-2xl border border-slate-200/80 bg-white shadow-soft overflow-hidden">
                        <button type="button"
                                @click="activeAccordion = activeAccordion === {{ $idx }} ? null : {{ $idx }}"
                                class="flex w-full items-center justify-between p-5 text-left text-xs font-bold text-slate-900 transition hover:bg-slate-50">
                            <span>{{ $faqQ }}</span>
                            <x-icon name="chevron-down" class="size-4 shrink-0 text-slate-400 transition-transform duration-200"
                                    ::class="activeAccordion === {{ $idx }} ? 'rotate-180 text-primary-600' : ''" />
                        </button>
                        <div x-show="activeAccordion === {{ $idx }}" x-collapse class="px-5 pb-5 text-xs text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                            {{ $faqA }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
