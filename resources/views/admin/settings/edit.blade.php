<x-layouts.admin title="Pengaturan website">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf @method('PUT')
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div><h2 class="text-2xl font-semibold tracking-tight text-slate-950">Pengaturan website</h2><p class="mt-2 text-base text-slate-600">Perubahan tersimpan langsung digunakan oleh website publik.</p></div>
            <button type="submit" class="btn-primary !py-2" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan pengaturan'">Simpan pengaturan</button>
        </div>
        @if($errors->any())<div class="mt-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-800">Pengaturan belum dapat disimpan. Periksa field yang ditandai.</div>@endif

        <div class="mt-7 grid gap-7 xl:grid-cols-2">
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
                    <div><label for="principal_speech" class="label">Sambutan</label><textarea id="principal_speech" name="principal_speech" rows="7" class="input">{{ old('principal_speech', $settings['principal.speech'] ?? '') }}</textarea></div>
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
        </div>
    </form>
</x-layouts.admin>
