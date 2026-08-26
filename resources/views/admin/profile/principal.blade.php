<x-layouts.admin title="Sambutan Kepala Madrasah">
    <form method="POST" action="{{ route('admin.profile.principal.update') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true" class="max-w-5xl">
        @csrf @method('PUT')
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div><a href="{{ route('admin.profile.index') }}" class="text-sm font-medium text-primary-700">← Kembali ke profil</a><h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">Sambutan kepala madrasah</h2><p class="mt-2 text-base text-slate-600">Informasi ini tampil pada homepage dan halaman sambutan.</p></div>
            <button type="submit" class="btn-primary shrink-0 !py-2" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan perubahan'">Simpan perubahan</button>
        </div>
        @if($errors->any())<div class="mt-6 rounded-xl bg-rose-50 p-4 text-base text-rose-800 sm:text-sm">Perubahan belum dapat disimpan. Periksa field yang ditandai.</div>@endif
        <section class="mt-7 rounded-2xl bg-white p-6 ring-1 ring-slate-900/10 sm:p-7">
            <div class="grid gap-7 lg:grid-cols-[13rem_1fr]">
                <div>
                    @if($settings['principal.photo'])<img src="{{ asset('storage/'.$settings['principal.photo']) }}" alt="Foto kepala madrasah saat ini" class="aspect-[4/5] w-full rounded-xl object-cover outline outline-1 -outline-offset-1 outline-black/5">@else<div class="flex aspect-[4/5] items-center justify-center rounded-xl bg-slate-100"><x-icon name="user-round" class="size-12 text-slate-400" /></div>@endif
                    <label for="photo" class="label mt-4">Ganti foto</label><input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="input"><p class="mt-1 text-sm text-slate-500">Maksimal 3 MB.</p>@error('photo')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col gap-5">
                    <div><label for="name" class="label">Nama kepala madrasah</label><input id="name" name="name" type="text" value="{{ old('name', $settings['principal.name']) }}" class="input" required>@error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="position" class="label">Jabatan</label><input id="position" name="position" type="text" value="{{ old('position', $settings['principal.position']) }}" class="input" required>@error('position')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="speech" class="label">Isi sambutan</label><textarea id="speech" name="speech" rows="16" class="input" required>{{ old('speech', $settings['principal.speech']) }}</textarea><p class="mt-1 text-sm text-slate-500">HTML dasar diperbolehkan dan dibersihkan sebelum ditampilkan.</p>@error('speech')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                </div>
            </div>
        </section>
    </form>
</x-layouts.admin>
