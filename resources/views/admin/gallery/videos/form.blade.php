@php
    $editing = $video->exists;
@endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Video Galeri'">
    <form method="POST"
          action="{{ $editing ? route('admin.gallery.videos.update', $video) : route('admin.gallery.videos.store') }}"
          enctype="multipart/form-data"
          x-data="galleryVideoForm(@js($video->url ?? ''))"
          @submit="saving = true">
        @csrf
        @if($editing)
            @method('PUT')
        @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.gallery.videos.index') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800">
                    ← Kembali ke galeri video
                </a>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">
                    {{ $editing ? 'Edit Video Galeri' : 'Tambah Video Galeri' }}
                </h2>
                <p class="mt-2 text-base text-slate-600">
                    Masukkan URL video YouTube atau tautan video lainnya beserta informasinya.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.gallery.videos.index') }}" class="btn-outline !py-2">
                    Batal
                </a>
                <button type="submit" class="btn-primary shrink-0 !py-2" :disabled="saving">
                    <span x-text="saving ? 'Menyimpan…' : 'Simpan Video'">Simpan Video</span>
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-xl bg-rose-50 p-4 text-sm text-rose-800 ring-1 ring-rose-200">
                <p class="font-medium">Video belum dapat disimpan. Periksa kesalahan berikut:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-7 grid gap-7 xl:grid-cols-[2fr_1fr]">
            <div class="flex flex-col gap-6">
                <!-- Informasi Video -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Informasi Video</h3>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="title" class="label">Judul Video <span class="text-rose-600">*</span></label>
                            <input id="title" name="title" type="text" value="{{ old('title', $video->title) }}" class="input" placeholder="Contoh: Profil MA Ma'arif NU Assa'adah 2026" required>
                            @error('title')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="url" class="label">URL Video (YouTube / Link) <span class="text-rose-600">*</span></label>
                            <input id="url"
                                   name="url"
                                   type="url"
                                   x-model="videoUrl"
                                   @input="updateEmbed()"
                                   value="{{ old('url', $video->url) }}"
                                   class="input"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   required>
                            <p class="mt-1 text-xs text-slate-500">Mendukung link YouTube standar (watch?v=...), tautan pendek (youtu.be/...), atau YouTube Shorts.</p>
                            @error('url')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="slug" class="label">Slug URL</label>
                            <input id="slug" name="slug" type="text" value="{{ old('slug', $video->slug) }}" class="input" placeholder="Dibuat otomatis jika kosong">
                            <p class="mt-1 text-xs text-slate-500">Gunakan huruf kecil dan tanda hubung (-).</p>
                            @error('slug')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="category" class="label">Kategori</label>
                            <input id="category" name="category" type="text" value="{{ old('category', $video->category ?? 'Kegiatan') }}" class="input" placeholder="Kegiatan / Profil / Prestasi" list="video-categories">
                            <datalist id="video-categories">
                                <option value="Kegiatan">
                                <option value="Profil Madrasah">
                                <option value="Pembelajaran">
                                <option value="Kesiswaan">
                                <option value="Prestasi">
                                <option value="Dokumentasi">
                            </datalist>
                            @error('category')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="video_date" class="label">Tanggal Video</label>
                            <input id="video_date" name="video_date" type="date" value="{{ old('video_date', optional($video->video_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="input">
                            @error('video_date')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="label">Deskripsi Video</label>
                            <textarea id="description" name="description" rows="4" class="input" placeholder="Keterangan atau ringkasan isi video...">{{ old('description', $video->description) }}</textarea>
                            @error('description')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <!-- Live Video Preview Section -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Pratinjau Video</h3>
                    <p class="mt-1 text-xs text-slate-500">Tampilan pratinjau pemutar video berdasarkan URL yang dimasukkan.</p>

                    <div class="mt-4">
                        <template x-if="embedUrl">
                            <div class="aspect-video w-full overflow-hidden rounded-xl bg-slate-950 ring-1 ring-slate-900/10">
                                <iframe :src="embedUrl"
                                        title="Preview Video"
                                        class="size-full"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>
                        </template>
                        <template x-if="!embedUrl">
                            <div class="flex aspect-video w-full flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center text-slate-400">
                                <x-icon name="video" class="size-10 text-slate-300" />
                                <span class="mt-2 text-sm font-medium">Masukkan URL YouTube di atas untuk melihat pratinjau pemutar video</span>
                            </div>
                        </template>
                    </div>
                </section>
            </div>

            <!-- Aside: Status, Platform, Thumbnail -->
            <aside class="flex flex-col gap-6">
                <!-- Status Publikasi -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <fieldset>
                        <legend class="font-semibold text-slate-950">Status Publikasi</legend>
                        <div class="mt-4 flex flex-col gap-3">
                            <label class="flex items-center gap-3 text-sm text-slate-700">
                                <input type="radio" name="status" value="published" class="size-4 border-slate-300 text-primary-600" @checked(old('status', $video->status) === 'published')>
                                <span><strong>Published</strong> — Tampil di galeri video website</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-700">
                                <input type="radio" name="status" value="draft" class="size-4 border-slate-300 text-primary-600" @checked(old('status', $video->status) === 'draft')>
                                <span><strong>Draft</strong> — Disimpan sementara</span>
                            </label>
                        </div>
                    </fieldset>
                </section>

                <!-- Platform Provider -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <label for="provider" class="label">Platform Video</label>
                    <select id="provider" name="provider" class="input">
                        <option value="youtube" @selected(old('provider', $video->provider ?? 'youtube') === 'youtube')>YouTube</option>
                        <option value="other" @selected(old('provider', $video->provider) === 'other')>Lainnya (Tautan Langsung / Embed)</option>
                    </select>
                </section>

                <!-- Thumbnail Kustom -->
                <section class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
                    <h3 class="font-semibold text-slate-950">Thumbnail Video</h3>
                    <p class="mt-1 text-xs text-slate-500">
                        Opsi gambar thumbnail kustom. Jika dikosongkan, thumbnail akan otomatis diambil dari YouTube.
                    </p>

                    @if($video->thumbnail)
                        <div class="mt-4 overflow-hidden rounded-xl bg-slate-100 ring-1 ring-slate-900/10">
                            <img src="{{ $video->thumbnail }}" alt="Thumbnail saat ini" class="aspect-video w-full object-cover">
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Gambar thumbnail yang aktif saat ini.</p>
                    @endif

                    <div class="mt-4">
                        <label for="thumbnail" class="label">Unggah Gambar Thumbnail Baru</label>
                        <input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/webp" class="input">
                        <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WebP. Maksimal 3 MB.</p>
                        @error('thumbnail')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </section>
            </aside>
        </div>
    </form>

    @push('scripts')
    <script>
        function galleryVideoForm(initialUrl = '') {
            return {
                saving: false,
                videoUrl: initialUrl,
                embedUrl: '',
                init() {
                    this.updateEmbed();
                },
                updateEmbed() {
                    if (!this.videoUrl) {
                        this.embedUrl = '';
                        return;
                    }

                    const ytMatch = this.videoUrl.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([\w-]{11})/);
                    if (ytMatch && ytMatch[1]) {
                        this.embedUrl = 'https://www.youtube.com/embed/' + ytMatch[1];
                    } else if (this.videoUrl.startsWith('http://') || this.videoUrl.startsWith('https://')) {
                        this.embedUrl = this.videoUrl;
                    } else {
                        this.embedUrl = '';
                    }
                }
            }
        }
    </script>
    @endpush
</x-layouts.admin>
