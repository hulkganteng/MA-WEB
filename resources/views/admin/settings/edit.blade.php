<x-layouts.admin title="Pengaturan website">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data"
          x-data="{ saving: false, primary: @js(old('primary_color', $settings['theme.primary'] ?? '#00923F')), accent: @js(old('accent_color', $settings['theme.accent'] ?? '#FFF500')), secondary: @js(old('secondary_color', $settings['theme.secondary'] ?? '#75C5F0')) }"
          @submit="saving = true">
        @csrf @method('PUT')
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div><h2 class="text-2xl font-semibold tracking-tight text-slate-950">Pengaturan website</h2><p class="mt-2 text-base text-slate-600">Perubahan tersimpan langsung digunakan oleh website publik.</p></div>
            <button type="submit" class="btn-primary !py-2" :disabled="saving" :aria-busy="saving">Simpan pengaturan</button>
        </div>
        @if($errors->any())<div class="mt-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-800">Pengaturan belum dapat disimpan. Periksa field yang ditandai.</div>@endif

        <div class="mt-7 grid gap-7 xl:grid-cols-2">
            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10 xl:col-span-2">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h3 class="font-semibold text-slate-950">Warna website</h3>
                        <p class="mt-1 text-base text-slate-600 sm:text-sm">Palet ini diterapkan ke seluruh halaman publik setelah pengaturan disimpan.</p>
                    </div>
                    <button type="button" class="btn-outline !px-3 !py-1.5"
                            @click="primary = '#00923F'; accent = '#FFF500'; secondary = '#75C5F0'">
                        Gunakan warna bawaan
                    </button>
                </div>

                <div class="mt-5 grid gap-5 lg:grid-cols-[minmax(0,1fr)_minmax(18rem,1fr)]">
                    <div class="grid gap-4 sm:grid-cols-3">
                        @foreach([
                            ['primary_color', 'Warna utama', 'primary'],
                            ['accent_color', 'Warna aksen', 'accent'],
                            ['secondary_color', 'Warna sekunder', 'secondary'],
                        ] as [$name, $label, $model])
                            <div>
                                <label for="{{ $name }}" class="label">{{ $label }}</label>
                                <div class="flex items-center gap-3">
                                    <input id="{{ $name }}" name="{{ $name }}" type="color" x-model="{{ $model }}"
                                           class="size-11 shrink-0 cursor-pointer rounded-xl border border-slate-300 bg-white p-1"
                                           required>
                                    <output class="min-w-0 font-mono text-base font-semibold uppercase text-slate-700 sm:text-sm" x-text="{{ $model }}"></output>
                                </div>
                                @error($name)<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-slate-900/10" :style="`background-color: ${primary}`">
                        <div class="p-5 text-white">
                            <p class="text-base font-bold sm:text-sm">Pratinjau warna</p>
                            <p class="mt-1 text-base text-white/80 sm:text-sm">Tampilan ringkas kombinasi palet website.</p>
                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                <span class="rounded-xl px-3 py-2 text-sm font-bold text-slate-950" :style="`background-color: ${accent}`">Aksi utama</span>
                                <span class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-950" :style="`background-color: ${secondary}`">Informasi</span>
                                <span class="rounded-xl border border-white/40 px-3 py-2 text-sm font-semibold">Tombol sekunder</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                <h3 class="font-semibold text-slate-950">Identitas madrasah</h3>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2"><label for="site_name" class="label">Nama madrasah</label><input id="site_name" name="site_name" type="text" value="{{ old('site_name', $settings['site.name'] ?? '') }}" class="input" required></div>
                    <div class="sm:col-span-2"><label for="site_tagline" class="label">Tagline</label><input id="site_tagline" name="site_tagline" type="text" value="{{ old('site_tagline', $settings['site.tagline'] ?? '') }}" class="input" required></div>
                    <div><label for="academic_year" class="label">Tahun akademik</label><input id="academic_year" name="academic_year" type="text" value="{{ old('academic_year', $settings['site.academic_year'] ?? '') }}" class="input"></div>
                    <div><label for="copyright" class="label">Copyright</label><input id="copyright" name="copyright" type="text" value="{{ old('copyright', $settings['site.copyright'] ?? '') }}" class="input"></div>
                    <div><label for="logo" class="label">Logo</label><input id="logo" name="logo" type="file" class="input" accept="image/jpeg,image/png,image/webp"><p class="mt-1 text-sm text-slate-500">JPG, PNG, atau WebP. Maksimal 2 MB.</p>@error('logo')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="favicon" class="label">Favicon</label><input id="favicon" name="favicon" type="file" class="input" accept="image/jpeg,image/png,image/webp"><p class="mt-1 text-sm text-slate-500">JPG, PNG, atau WebP. Maksimal 512 KB.</p>@error('favicon')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                <h3 class="font-semibold text-slate-950">Kontak</h3>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2"><label for="address" class="label">Alamat</label><textarea id="address" name="address" rows="3" class="input" required>{{ old('address', $settings['contact.address'] ?? '') }}</textarea></div>
                    @foreach([['email','Email','email','contact.email'],['phone','Telepon','text','contact.phone'],['whatsapp','WhatsApp','text','contact.whatsapp'],['hours','Jam pelayanan','text','contact.hours'],['maps_url','Google Maps URL','url','contact.maps_url']] as [$name,$label,$type,$key])
                        <div class="{{ $name === 'maps_url' ? 'sm:col-span-2' : '' }}"><label for="{{ $name }}" class="label">{{ $label }}</label><input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $settings[$key] ?? '') }}" class="input" @required(in_array($name, ['email','phone']))></div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                <h3 class="font-semibold text-slate-950">Homepage dan kepala madrasah</h3>
                <div class="mt-5 flex flex-col gap-5">
                    <div><label for="hero_title" class="label">Judul hero</label><input id="hero_title" name="hero_title" type="text" value="{{ old('hero_title', $settings['hero.title'] ?? '') }}" class="input" required></div>
                    <div><label for="hero_subtitle" class="label">Subjudul hero</label><textarea id="hero_subtitle" name="hero_subtitle" rows="3" class="input" required>{{ old('hero_subtitle', $settings['hero.subtitle'] ?? '') }}</textarea></div>
                    <div class="grid gap-5 sm:grid-cols-2"><div><label for="principal_name" class="label">Nama kepala madrasah</label><input id="principal_name" name="principal_name" type="text" value="{{ old('principal_name', $settings['principal.name'] ?? '') }}" class="input"></div><div><label for="principal_position" class="label">Jabatan</label><input id="principal_position" name="principal_position" type="text" value="{{ old('principal_position', $settings['principal.position'] ?? '') }}" class="input"></div></div>
                    <div><label for="principal_photo" class="label">Foto kepala madrasah</label><input id="principal_photo" name="principal_photo" type="file" class="input" accept="image/jpeg,image/png,image/webp"><p class="mt-1 text-sm text-slate-500">JPG, PNG, atau WebP. Maksimal 3 MB.</p>@error('principal_photo')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><x-rich-editor name="principal_speech" label="Sambutan Kepala Madrasah" :value="$settings['principal.speech'] ?? ''" minHeight="300px" placeholder="Tuliskan sambutan kepala madrasah..." /></div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                <h3 class="font-semibold text-slate-950">SEO dan WhatsApp</h3>
                <div class="mt-5 flex flex-col gap-5">
                    <div><label for="seo_title" class="label">Default SEO title</label><input id="seo_title" name="seo_title" type="text" value="{{ old('seo_title', $settings['seo.default_title'] ?? '') }}" class="input" required></div>
                    <div><label for="seo_description" class="label">Default meta description</label><textarea id="seo_description" name="seo_description" rows="4" class="input" required>{{ old('seo_description', $settings['seo.default_description'] ?? '') }}</textarea></div>
                    <div><label for="whatsapp_message" class="label">Pesan WhatsApp default</label><textarea id="whatsapp_message" name="whatsapp_message" rows="4" class="input">{{ old('whatsapp_message', $settings['whatsapp.message'] ?? '') }}</textarea></div>
                </div>
            </section>

            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                <h3 class="font-semibold text-slate-950">Statistik Madrasah (Homepage)</h3>
                <p class="mt-1 text-sm text-slate-600">Hanya Peserta Didik yang dapat diatur di sini. Alumni, Guru & Tendik, dan Prestasi Juara akan otomatis mengambil data dari database.</p>
                <div class="mt-5">
                    <label for="stats_students" class="label">Peserta Didik</label>
                    <input id="stats_students" name="stats_students" type="number" min="0" max="9999" value="{{ old('stats_students', $settings['stats.students'] ?? 850) }}" class="input">
                    @error('stats_students')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
            </section>
        </div>
    </form>
</x-layouts.admin>
