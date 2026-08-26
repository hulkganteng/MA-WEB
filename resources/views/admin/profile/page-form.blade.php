<x-layouts.admin :title="$config['title']">
    <form method="POST" action="{{ route('admin.profile.pages.update', $section) }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf @method('PUT')
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.profile.index') }}" class="text-sm font-medium text-primary-700">← Kembali ke profil</a>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">{{ $config['title'] }}</h2>
                <p class="mt-2 text-base text-slate-600">Kelola isi halaman profil tanpa mengubah alamat halamannya.</p>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan perubahan'">Simpan perubahan</button>
        </div>
        @if($errors->any())<div class="mt-6 rounded-xl bg-rose-50 p-4 text-base text-rose-800 sm:text-sm">Perubahan belum dapat disimpan. Periksa field yang ditandai.</div>@endif

        <div class="mt-7 grid gap-8 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                <div class="flex flex-col gap-5">
                    <div><label for="title" class="label">Judul halaman</label><input id="title" name="title" type="text" value="{{ old('title', $page->title) }}" class="input" required>@error('title')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="body" class="label">Isi profil</label><textarea id="body" name="body" rows="20" class="input font-mono" required>{{ old('body', $page->body) }}</textarea><p class="mt-1 text-sm text-slate-500">HTML dasar diperbolehkan dan dibersihkan sebelum ditampilkan.</p>@error('body')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    <div><label for="cover" class="label">Gambar sampul</label><input id="cover" name="cover" type="file" accept="image/jpeg,image/png,image/webp" class="input"><p class="mt-1 text-sm text-slate-500">JPG, PNG, atau WebP. Maksimal 3 MB.</p>@error('cover')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                    @if($page->cover)<img src="{{ asset('storage/'.$page->cover) }}" alt="Sampul saat ini" class="aspect-[16/7] w-full rounded-xl object-cover outline outline-1 -outline-offset-1 outline-black/5">@endif
                </div>
            </section>
            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10"><h3 class="font-semibold text-slate-950">Publikasi</h3><div class="mt-5"><label for="status" class="label">Status halaman</label><select id="status" name="status" class="input"><option value="draft" @selected(old('status', $page->status) === 'draft')>Draft — tidak tampil</option><option value="published" @selected(old('status', $page->status) === 'published')>Published — tampil di website</option></select>@error('status')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div><a href="{{ route($config['public_route']) }}" target="_blank" class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-primary-700">Lihat halaman publik <x-icon name="external-link" class="size-4" /></a></section>
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10"><h3 class="font-semibold text-slate-950">SEO</h3><div class="mt-5 flex flex-col gap-5"><div><label for="seo_title" class="label">Judul SEO</label><input id="seo_title" name="seo_title" type="text" value="{{ old('seo_title', $page->seo_title) }}" class="input"></div><div><label for="seo_description" class="label">Deskripsi SEO</label><textarea id="seo_description" name="seo_description" rows="4" class="input">{{ old('seo_description', $page->seo_description) }}</textarea>@error('seo_description')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div></div></section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
