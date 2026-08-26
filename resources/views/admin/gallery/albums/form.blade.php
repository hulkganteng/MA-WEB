@php
    $editing = $album->exists;
@endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Album Foto'">
    <form method="POST"
          action="{{ $editing ? route('admin.gallery.albums.update', $album) : route('admin.gallery.albums.store') }}"
          enctype="multipart/form-data"
          x-data="galleryAlbumForm()"
          @submit="saving = true">
        @csrf
        @if($editing)
            @method('PUT')
        @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.gallery.albums.index') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800">
                    ← Kembali ke galeri foto
                </a>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">
                    {{ $editing ? 'Edit Album Foto' : 'Tambah Album Foto' }}
                </h2>
                <p class="mt-2 text-base text-slate-600">
                    Lengkapi detail album dan unggah foto-foto dokumentasi.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.gallery.albums.index') }}" class="btn-outline !py-2">
                    Batal
                </a>
                <button type="submit" class="btn-primary shrink-0 !py-2" :disabled="saving">
                    <span x-text="saving ? 'Menyimpan…' : 'Simpan Album'">Simpan Album</span>
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-800 ring-1 ring-rose-200">
                <p class="font-medium">Album belum dapat disimpan. Periksa kesalahan berikut:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-7 grid gap-7 xl:grid-cols-[2fr_1fr]">
            <div class="flex flex-col gap-6">
                <!-- Data Utama Album -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Informasi Album</h3>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="label">Nama Album <span class="text-rose-600">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name', $album->name) }}" class="input" placeholder="Contoh: Peringatan Hari Santri Nasional 2026" required>
                            @error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="slug" class="label">Slug URL</label>
                            <input id="slug" name="slug" type="text" value="{{ old('slug', $album->slug) }}" class="input" placeholder="Dibuat otomatis jika kosong">
                            <p class="mt-1 text-xs text-slate-500">Gunakan huruf kecil dan tanda hubung (-).</p>
                            @error('slug')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="category" class="label">Kategori</label>
                            <input id="category" name="category" type="text" value="{{ old('category', $album->category ?? 'Kegiatan') }}" class="input" placeholder="Kegiatan / Prestasi / Fasilitas" list="category-options">
                            <datalist id="category-options">
                                <option value="Kegiatan">
                                <option value="Pembelajaran">
                                <option value="Keagamaan">
                                <option value="Prestasi">
                                <option value="Fasilitas">
                                <option value="Kesiswaan">
                            </datalist>
                            @error('category')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="album_date" class="label">Tanggal Kegiatan</label>
                            <input id="album_date" name="album_date" type="date" value="{{ old('album_date', optional($album->album_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="input">
                            @error('album_date')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="label">Deskripsi Album</label>
                            <textarea id="description" name="description" rows="3" class="input" placeholder="Tuliskan keterangan singkat mengenai dokumentasi album ini...">{{ old('description', $album->description) }}</textarea>
                            @error('description')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                @if($editing)
                    <!-- Foto Yang Sudah Ada (Mode Edit) -->
                    <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-slate-950">Foto dalam Album ({{ $album->photos->count() }})</h3>
                                <p class="mt-1 text-sm text-slate-500">Kelola keterangan (caption), urutan foto, atau hapus foto.</p>
                            </div>
                        </div>

                        @if($album->photos->isNotEmpty())
                            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($album->photos as $photo)
                                    <div class="relative flex flex-col rounded-xl bg-slate-50 p-3 ring-1 ring-slate-900/10 transition"
                                         :class="{ 'opacity-40 grayscale': isMarkedForDeletion({{ $photo->id }}) }">
                                        <div class="aspect-[4/3] w-full overflow-hidden rounded-lg bg-slate-200">
                                            <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" class="size-full object-cover">
                                        </div>

                                        <div class="mt-3 flex flex-col gap-2">
                                            <div>
                                                <label class="sr-only">Keterangan Foto</label>
                                                <input type="text"
                                                       name="existing_captions[{{ $photo->id }}]"
                                                       value="{{ old('existing_captions.'.$photo->id, $photo->caption) }}"
                                                       placeholder="Caption foto..."
                                                       class="input !py-1 !text-xs"
                                                       :disabled="isMarkedForDeletion({{ $photo->id }})">
                                            </div>
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-1">
                                                    <label class="text-[11px] text-slate-500">Urutan:</label>
                                                    <input type="number"
                                                           name="existing_orders[{{ $photo->id }}]"
                                                           value="{{ old('existing_orders.'.$photo->id, $photo->order) }}"
                                                           class="input !w-14 !py-0.5 !px-1.5 !text-xs tabular-nums text-center"
                                                           min="0"
                                                           :disabled="isMarkedForDeletion({{ $photo->id }})">
                                                </div>
                                                <button type="button"
                                                        @click="toggleDeletePhoto({{ $photo->id }})"
                                                        class="rounded px-2 py-1 text-xs font-medium"
                                                        :class="isMarkedForDeletion({{ $photo->id }}) ? 'bg-amber-100 text-amber-800' : 'text-rose-700 hover:bg-rose-50'">
                                                    <span x-text="isMarkedForDeletion({{ $photo->id }}) ? 'Batalkan Hapus' : 'Hapus Foto'">Hapus</span>
                                                </button>
                                            </div>
                                        </div>

                                        <template x-if="isMarkedForDeletion({{ $photo->id }})">
                                            <input type="hidden" name="delete_photos[]" value="{{ $photo->id }}">
                                        </template>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-5 rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">
                                Album ini belum memiliki foto. Unggah foto pada bagian di bawah ini.
                            </div>
                        @endif

                        <!-- Tambah Foto Baru di Mode Edit -->
                        <div class="mt-8 border-t border-slate-200 pt-6">
                            <h4 class="font-medium text-slate-900">Tambah Foto Baru</h4>
                            <p class="mt-1 text-xs text-slate-500">Pilih satu atau lebih file foto untuk ditambahkan ke album ini.</p>

                            <div class="mt-4">
                                <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center hover:bg-slate-100/80 transition">
                                    <x-icon name="upload-cloud" class="size-8 text-primary-600" />
                                    <span class="mt-2 text-sm font-semibold text-primary-900">Klik untuk memilih foto baru</span>
                                    <span class="mt-1 text-xs text-slate-500">JPG, PNG, atau WebP (Maks. 5 MB per foto) · Dapat pilih banyak foto sekaligus</span>
                                    <input type="file"
                                           name="new_photos[]"
                                           multiple
                                           accept="image/jpeg,image/png,image/webp"
                                           class="sr-only"
                                         x-ref="newPhotos"
                                           @change="handleNewFiles($event)">
                                </label>
                            </div>

                            <!-- Preview Foto Baru -->
                            <div x-show="newFiles.length > 0" class="mt-5">
                                <p class="text-xs font-semibold text-slate-700" x-text="`${newFiles.length} foto baru dipilih untuk diunggah:`"></p>
                                <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                    <template x-for="(fileItem, index) in newFiles" :key="index">
                                        <div class="relative flex flex-col rounded-xl bg-slate-50 p-2.5 ring-1 ring-slate-900/10">
                                            <div class="aspect-[4/3] w-full overflow-hidden rounded-lg bg-slate-200">
                                                <img :src="fileItem.previewUrl" alt="" class="size-full object-cover">
                                            </div>
                                            <div class="mt-2">
                                                <p class="truncate text-xs font-medium text-slate-700" x-text="fileItem.name"></p>
                                                <input type="text"
                                                       :name="`new_captions[${index}]`"
                                                       placeholder="Caption foto (opsional)..."
                                                       class="input mt-1.5 !py-1 !text-xs">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <!-- Upload Foto Sekaligus (Mode Create) -->
                    <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-slate-950">Foto Dokumentasi</h3>
                                <p class="mt-1 text-sm text-slate-500">Pilih foto-foto yang ingin dimasukkan ke dalam album ini.</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center hover:bg-slate-100/80 transition">
                                <div class="flex size-12 items-center justify-center rounded-full bg-primary-100 text-primary-700">
                                    <x-icon name="upload-cloud" class="size-6" />
                                </div>
                                <span class="mt-3 text-sm font-semibold text-primary-900">Klik untuk memilih foto-foto album</span>
                                <span class="mt-1 text-xs text-slate-500">JPG, PNG, atau WebP (Maks. 5 MB per foto) · Dapat memilih beberapa file sekaligus</span>
                                <input type="file"
                                       name="photos[]"
                                       multiple
                                       accept="image/jpeg,image/png,image/webp"
                                       class="sr-only"
                                        x-ref="newPhotos"
                                       @change="handleNewFiles($event)">
                            </label>
                        </div>

                        <!-- Preview Foto Upload -->
                        <div x-show="newFiles.length > 0" class="mt-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-slate-900" x-text="`${newFiles.length} foto dipilih:`"></p>
                                <button type="button" @click="clearFiles()" class="text-xs text-rose-600 hover:underline">Hapus Semua Pilihan</button>
                            </div>
                            <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <template x-for="(fileItem, index) in newFiles" :key="index">
                                    <div class="relative flex flex-col rounded-xl bg-slate-50 p-3 ring-1 ring-slate-900/10">
                                        <div class="aspect-[4/3] w-full overflow-hidden rounded-lg bg-slate-200">
                                            <img :src="fileItem.previewUrl" alt="" class="size-full object-cover">
                                        </div>
                                        <div class="mt-2.5">
                                            <p class="truncate text-xs font-medium text-slate-700" x-text="fileItem.name"></p>
                                            <p class="text-[11px] text-slate-400" x-text="fileItem.sizeFormatted"></p>
                                            <input type="text"
                                                   :name="`captions[${index}]`"
                                                   placeholder="Keterangan foto (opsional)..."
                                                   class="input mt-1.5 !py-1 !text-xs">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </section>
                @endif
            </div>

            <!-- Aside: Status & Cover -->
            <aside class="flex flex-col gap-6">
                <!-- Status Publikasi -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <fieldset>
                        <legend class="font-semibold text-slate-950">Status Publikasi</legend>
                        <div class="mt-4 flex flex-col gap-3">
                            <label class="flex items-center gap-3 text-sm text-slate-700">
                                <input type="radio" name="status" value="published" class="size-4 border-slate-300 text-primary-600" @checked(old('status', $album->status) === 'published')>
                                <span><strong>Published</strong> — Tampil di website publik</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700">
                                <input type="radio" name="status" value="draft" class="size-4 border-slate-300 text-primary-600" @checked(old('status', $album->status) === 'draft')>
                                <span><strong>Draft</strong> — Disimpan sementara</span>
                            </label>
                        </div>
                    </fieldset>
                </section>

                <!-- Cover Album -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Cover Album</h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Foto sampul album. Jika tidak dipilih, foto pertama yang diunggah akan otomatis dijadikan cover.
                    </p>

                    @if($album->cover)
                        <div class="mt-4 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-900/10">
                            <img src="{{ asset('storage/'.$album->cover) }}" alt="Cover saat ini" class="aspect-[16/10] w-full object-cover">
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Unggah file baru di bawah untuk mengganti cover saat ini.</p>
                    @endif

                    <div class="mt-4">
                        <label for="cover" class="label">Pilih Foto Cover</label>
                        <input id="cover" name="cover" type="file" accept="image/jpeg,image/png,image/webp" class="input">
                        <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, atau WebP. Maksimal 3 MB.</p>
                        @error('cover')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </section>
            </aside>
        </div>
    </form>

    @push('scripts')
    <script>
        function galleryAlbumForm() {
            return {
                saving: false,
                deletedPhotoIds: [],
                newFiles: [],
                toggleDeletePhoto(id) {
                    const idx = this.deletedPhotoIds.indexOf(id);
                    if (idx > -1) {
                        this.deletedPhotoIds.splice(idx, 1);
                    } else {
                        this.deletedPhotoIds.push(id);
                    }
                },
                isMarkedForDeletion(id) {
                    return this.deletedPhotoIds.includes(id);
                },
                handleNewFiles(event) {
                    const files = event.target.files;
                    if (!files || files.length === 0) return;

                    this.newFiles = [];
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const previewUrl = URL.createObjectURL(file);
                        this.newFiles.push({
                            file: file,
                            name: file.name,
                            sizeFormatted: this.formatBytes(file.size),
                            previewUrl: previewUrl
                        });
                    }
                },
                clearFiles() {
                    this.newFiles.forEach(fileItem => URL.revokeObjectURL(fileItem.previewUrl));
                    this.newFiles = [];
                    this.$root.querySelectorAll('input[type="file"]').forEach(input => input.value = '');
                },
                formatBytes(bytes) {
                    if (bytes === 0) return '0 B';
                    const k = 1024;
                    const sizes = ['B', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
                }
            }
        }
    </script>
    @endpush
</x-layouts.admin>
