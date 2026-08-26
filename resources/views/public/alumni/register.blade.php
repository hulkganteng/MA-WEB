<x-layouts.app title="Registrasi Data Alumni" description="Pendaftaran data alumni ke dalam basis data resmi IKBAL MADAH MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="IKBAL MADAH Network"
                   title="Registrasi Alumni Madrasah"
                   description="Mari terhubung kembali. Formulir pendataan lulusan untuk memperkuat jejaring karier, profesional, dan pengabdian umat." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-2xl">
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-soft">
                {{-- Privacy & Security Notice --}}
                <div class="mb-8 rounded-2xl border border-emerald-500/20 bg-emerald-50/60 p-4 flex items-start gap-3">
                    <x-icon name="shield-check" class="size-5 text-emerald-600 shrink-0 mt-0.5" />
                    <p class="text-xs text-emerald-900 leading-relaxed">
                        <strong>Privasi Terjamin:</strong> Data kontak nomor telepon dan email tidak akan pernah dipublikasikan secara terbuka. Profil Anda akan diverifikasi oleh pengelola sebelum ditampilkan di direktori alumni.
                    </p>
                </div>

                <form method="POST" action="{{ route('alumni.register.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach ([
                            ['name', 'Nama Lengkap Beserta Gelar', 'text', true, 'Contoh: Ahmad Fauzi, S.Kom.'],
                            ['graduation_year', 'Tahun Kelulusan di MA', 'number', false, 'Contoh: 2020'],
                            ['email', 'Alamat Email Aktif', 'email', true, 'email@domain.com'],
                            ['phone', 'Nomor WhatsApp Aktif', 'tel', false, '081234567890'],
                            ['university', 'Perguruan Tinggi / Kampus', 'text', false, 'Contoh: Universitas Indonesia'],
                            ['occupation', 'Profesi / Pekerjaan Saat Ini', 'text', false, 'Contoh: Software Engineer / Pengusaha']
                        ] as [$name, $label, $type, $required, $placeholder])
                            <div>
                                <label for="{{ $name }}" class="label text-xs font-bold text-slate-700">
                                    {{ $label }} @if($required)<span class="text-rose-500">*</span>@endif
                                </label>
                                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                                       value="{{ old($name) }}" placeholder="{{ $placeholder }}"
                                       class="input text-xs" @required($required)>
                                @error($name)
                                    <p class="mt-1.5 text-xs text-rose-600 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label for="testimonial" class="label text-xs font-bold text-slate-700">
                            Kesan & Pesan untuk Almamater / Pesan untuk Santri Baru
                        </label>
                        <textarea id="testimonial" name="testimonial" rows="4"
                                  placeholder="Ceritakan pengalaman berharga Anda selama belajar di MA Ma'arif NU Assa'adah..."
                                  class="input text-xs">{{ old('testimonial') }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                        <a href="{{ route('alumni.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                            &larr; Kembali ke Daftar Alumni
                        </a>
                        <button type="submit" class="btn-primary">
                            <x-icon name="send" class="size-4" /> Kirim Data Alumni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
