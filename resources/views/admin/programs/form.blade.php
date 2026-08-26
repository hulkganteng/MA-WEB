@php $editing = $program->exists; @endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Program Pendidikan'">
    <form method="POST" action="{{ $editing ? route('admin.programs.update', $program) : route('admin.programs.store') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.programs.index') }}" class="text-xs font-semibold text-primary-700 hover:underline">← Kembali ke daftar program</a>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $editing ? 'Edit Program Pendidikan' : 'Tambah Program Pendidikan' }}</h2>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2.5 !px-5 font-bold" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan Program'">
                Simpan Program
            </button>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-800 border border-rose-200">
                Program belum dapat disimpan. Periksa input yang ditandai merah.
            </div>
        @endif

        <div class="mt-6 grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-5">
                <div>
                    <label for="name" class="label text-xs font-bold text-slate-700">Nama Program / Jurusan <span class="text-rose-500">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $program->name) }}" class="input" placeholder="Contoh: Peminatan MIPA (Matematika & IPA), Keagamaan & Turats..." required>
                    @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="category" class="label text-xs font-bold text-slate-700">Kategori / Kelompok Peminatan</label>
                    <input id="category" name="category" type="text" value="{{ old('category', $program->category) }}" class="input" placeholder="Contoh: Sains & Teknologi, Humaniora, Keagamaan...">
                </div>

                <div>
                    <x-rich-editor name="description" label="Deskripsi & Profil Jurusan" :value="$program->description" minHeight="300px" placeholder="Jelaskan fokus studi, prospek lulusan, dan keunggulan peminatan..." />
                </div>
            </section>

            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="icon" class="label text-xs font-bold text-slate-700">Icon Lucide (Opsional)</label>
                        <input id="icon" name="icon" type="text" value="{{ old('icon', $program->icon ?: 'graduation-cap') }}" class="input" placeholder="microscope, book, globe, graduation-cap...">
                    </div>

                    <div>
                        <label for="order" class="label text-xs font-bold text-slate-700">Urutan Tampilan</label>
                        <input id="order" name="order" type="number" min="0" value="{{ old('order', $program->order ?? 0) }}" class="input">
                    </div>

                    <fieldset class="pt-2 border-t border-slate-100">
                        <legend class="label text-xs font-bold text-slate-700">Status Publikasi</legend>
                        <div class="mt-2 flex flex-col gap-2">
                            @foreach(['active' => 'Aktif (Ditampilkan)', 'inactive' => 'Nonaktif (Disembunyikan)'] as $value => $label)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}" class="text-primary-600 focus:ring-primary-500" @checked(old('status', $program->status ?? 'active') === $value)>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                    <label for="cover" class="label text-xs font-bold text-slate-700">Cover Foto Jurusan</label>
                    <input id="cover" name="cover" type="file" accept="image/jpeg,image/png,image/webp" class="input text-xs">
                    <p class="mt-1 text-[11px] text-slate-500">JPG, PNG, atau WebP. Maksimal 3 MB.</p>
                    @error('cover')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

                    @if($program->cover)
                        <div class="mt-4">
                            <p class="text-[11px] text-slate-500 font-semibold mb-1">Cover saat ini:</p>
                            <img src="{{ asset('storage/'.$program->cover) }}" alt="{{ $program->name }}" class="aspect-video w-full rounded-xl object-cover border border-slate-200">
                        </div>
                    @endif
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
