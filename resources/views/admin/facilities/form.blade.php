@php $editing = $facility->exists; @endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Fasilitas Sarpras'">
    <form method="POST" action="{{ $editing ? route('admin.facilities.update', $facility) : route('admin.facilities.store') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.facilities.index') }}" class="text-xs font-semibold text-primary-700 hover:underline">← Kembali ke daftar fasilitas sarpras</a>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $editing ? 'Edit Fasilitas' : 'Tambah Fasilitas' }}</h2>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2.5 !px-5 font-bold" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan Fasilitas'">
                Simpan Fasilitas
            </button>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-800 border border-rose-200">
                Fasilitas belum dapat disimpan. Periksa input yang ditandai merah.
            </div>
        @endif

        <div class="mt-6 grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-5">
                <div>
                    <label for="name" class="label text-xs font-bold text-slate-700">Nama Fasilitas / Sarana <span class="text-rose-500">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $facility->name) }}" class="input" placeholder="Contoh: Gedung Laboratorium Komputer & AI, Asrama Santri, Masjid Jami'..." required>
                    @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <x-rich-editor name="description" label="Deskripsi & Spesifikasi Fasilitas" :value="$facility->description" minHeight="280px" placeholder="Jelaskan kapasitas, kelengkapan alat, pendingin ruangan, dan fungsi ruangan..." />
                </div>
            </section>

            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="icon" class="label text-xs font-bold text-slate-700">Icon Lucide (Opsional)</label>
                        <input id="icon" name="icon" type="text" value="{{ old('icon', $facility->icon ?: 'building') }}" class="input" placeholder="building, laptop, book, wifi...">
                    </div>

                    <div>
                        <label for="order" class="label text-xs font-bold text-slate-700">Urutan Tampilan</label>
                        <input id="order" name="order" type="number" min="0" value="{{ old('order', $facility->order ?? 0) }}" class="input">
                    </div>

                    <fieldset class="pt-2 border-t border-slate-100">
                        <legend class="label text-xs font-bold text-slate-700">Status Fasilitas</legend>
                        <div class="mt-2 flex flex-col gap-2">
                            <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer">
                                <input type="radio" name="is_active" value="1" class="text-primary-600 focus:ring-primary-500" @checked(old('is_active', $facility->is_active ?? true) == 1)>
                                <span>Aktif (Ditampilkan)</span>
                            </label>
                            <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer">
                                <input type="radio" name="is_active" value="0" class="text-primary-600 focus:ring-primary-500" @checked(old('is_active', $facility->is_active ?? true) == 0)>
                                <span>Nonaktif (Disembunyikan)</span>
                            </label>
                        </div>
                    </fieldset>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                    <label for="thumbnail" class="label text-xs font-bold text-slate-700">Foto Fasilitas (Thumbnail)</label>
                    <input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/webp" class="input text-xs">
                    <p class="mt-1 text-[11px] text-slate-500">JPG, PNG, atau WebP. Maksimal 3 MB.</p>
                    @error('thumbnail')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

                    @if($facility->thumbnail)
                        <div class="mt-4">
                            <p class="text-[11px] text-slate-500 font-semibold mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/'.$facility->thumbnail) }}" alt="{{ $facility->name }}" class="aspect-video w-full rounded-xl object-cover border border-slate-200">
                        </div>
                    @endif
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
