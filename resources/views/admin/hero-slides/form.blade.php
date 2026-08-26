@php
    $editing = $slide->exists;
@endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Slide Hero'">
    <form method="POST"
          action="{{ $editing ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}"
          enctype="multipart/form-data"
          x-data="{ saving: false, previewUrl: '{{ $slide->image ? $slide->image_url : '' }}' }"
          @submit="saving = true">
        @csrf
        @if($editing)
            @method('PUT')
        @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.hero-slides.index') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800">
                    ← Kembali ke Hero Slider
                </a>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">
                    {{ $editing ? 'Edit Slide Hero' : 'Tambah Slide Hero' }}
                </h2>
                <p class="mt-2 text-base text-slate-600">
                    Unggah foto resolusi tinggi dan atur informasi yang tampil pada banner halaman utama.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.hero-slides.index') }}" class="btn-outline !py-2">
                    Batal
                </a>
                <button type="submit" class="btn-primary shrink-0 !py-2" :disabled="saving">
                    <span x-text="saving ? 'Menyimpan…' : 'Simpan Slide'">Simpan Slide</span>
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-800 ring-1 ring-rose-200">
                <p class="font-medium">Slide belum dapat disimpan. Periksa kesalahan berikut:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-7 grid gap-7 xl:grid-cols-[2fr_1fr]">
            <div class="flex flex-col gap-6">
                <!-- Foto Banner Besar -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Foto Banner Utama (Resolusi Tinggi) <span class="text-rose-600">*</span></h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Disarankan menggunakan foto landscape beresolusi minimal 1920×1080 px (16:9 atau 21:9) untuk tampilan banner besar yang tajam.
                    </p>

                    <!-- Image Preview -->
                    <div class="mt-4 overflow-hidden rounded-2xl bg-slate-950 ring-1 ring-slate-900/10">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" alt="Pratinjau Foto" class="aspect-[16/9] w-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <div class="flex aspect-[16/9] w-full flex-col items-center justify-center p-8 text-center text-slate-400">
                                <x-icon name="image" class="size-12 text-slate-500" />
                                <p class="mt-3 text-sm font-medium">Belum ada foto yang dipilih</p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-4">
                        <label for="image" class="label">Pilih File Foto Banner</label>
                        <input id="image"
                               name="image"
                               type="file"
                               accept="image/jpeg,image/png,image/webp"
                               class="input"
                               @change="if ($event.target.files.length > 0) previewUrl = URL.createObjectURL($event.target.files[0])"
                               {{ $editing ? '' : 'required' }}>
                        <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, atau WebP. Maksimal 5 MB.</p>
                        @error('image')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </section>

                <!-- Teks & Konten Slide -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Teks & Judul Slide</h3>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="tagline" class="label">Tagline / Eyebrow (Teks Kecil di Atas Judul)</label>
                            <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $slide->tagline) }}" class="input" placeholder="Contoh: Madrasah Aliyah Berbasis Pesantren di Gresik">
                            @error('tagline')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="title" class="label">Judul Utama Slide <span class="text-rose-600">*</span></label>
                            <input id="title" name="title" type="text" value="{{ old('title', $slide->title) }}" class="input" placeholder="Contoh: Menumbuhkan Generasi Berilmu, Berakhlak, dan Berdaya Saing" required>
                            @error('title')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="subtitle" class="label">Subtitle / Deskripsi Singkat</label>
                            <textarea id="subtitle" name="subtitle" rows="3" class="input" placeholder="Tuliskan keterangan pelengkap untuk slide ini...">{{ old('subtitle', $slide->subtitle) }}</textarea>
                            @error('subtitle')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <!-- Tombol Aksi (Call To Action) -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Tombol Aksi (Call To Action)</h3>
                    <p class="mt-1 text-xs text-slate-500">Opsional. Tombol yang dapat diklik pengunjung pada slide ini.</p>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <!-- Tombol Utama -->
                        <div>
                            <label for="button_text" class="label">Teks Tombol Utama</label>
                            <input id="button_text" name="button_text" type="text" value="{{ old('button_text', $slide->button_text) }}" class="input" placeholder="Contoh: Kenali Madrasah">
                        </div>
                        <div>
                            <label for="button_url" class="label">URL / Tautan Tombol Utama</label>
                            <input id="button_url" name="button_url" type="text" value="{{ old('button_url', $slide->button_url) }}" class="input" placeholder="Contoh: /profil atau https://...">
                        </div>

                        <!-- Tombol Sekunder -->
                        <div>
                            <label for="secondary_button_text" class="label">Teks Tombol Sekunder</label>
                            <input id="secondary_button_text" name="secondary_button_text" type="text" value="{{ old('secondary_button_text', $slide->secondary_button_text) }}" class="input" placeholder="Contoh: Program Pendidikan">
                        </div>
                        <div>
                            <label for="secondary_button_url" class="label">URL / Tautan Tombol Sekunder</label>
                            <input id="secondary_button_url" name="secondary_button_url" type="text" value="{{ old('secondary_button_url', $slide->secondary_button_url) }}" class="input" placeholder="Contoh: /program">
                        </div>
                    </div>
                </section>
            </div>

            <!-- Aside: Status & Urutan -->
            <aside class="flex flex-col gap-6">
                <!-- Status Publikasi -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <fieldset>
                        <legend class="font-semibold text-slate-950">Status Publikasi</legend>
                        <div class="mt-4 flex flex-col gap-3">
                            <label class="flex items-center gap-3 text-sm text-slate-700">
                                <input type="radio" name="status" value="published" class="size-4 border-slate-300 text-primary-600" @checked(old('status', $slide->status) === 'published')>
                                <span><strong>Published</strong> — Tampil di slider animasi halaman utama</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700">
                                <input type="radio" name="status" value="draft" class="size-4 border-slate-300 text-primary-600" @checked(old('status', $slide->status) === 'draft')>
                                <span><strong>Draft</strong> — Disimpan sementara</span>
                            </label>
                        </div>
                    </fieldset>
                </section>

                <!-- Urutan Tampilan -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <label for="order" class="label font-semibold text-slate-950">Urutan Slide (*Order*)</label>
                    <p class="mt-1 text-xs text-slate-500">Angka lebih kecil akan ditampilkan lebih dahulu pada urutan slide.</p>
                    <input id="order" name="order" type="number" value="{{ old('order', $slide->order) }}" class="input mt-3 tabular-nums" min="0">
                    @error('order')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
