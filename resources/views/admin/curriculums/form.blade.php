@php $editing = $curriculum->exists; @endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Kurikulum'">
    <form method="POST" action="{{ $editing ? route('admin.curriculums.update', $curriculum) : route('admin.curriculums.store') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.curriculums.index') }}" class="text-xs font-semibold text-primary-700 hover:underline">← Kembali ke daftar kurikulum</a>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $editing ? 'Edit Kurikulum' : 'Tambah Kurikulum' }}</h2>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2.5 !px-5 font-bold" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan Kurikulum'">
                Simpan Kurikulum
            </button>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-800 border border-rose-200">
                Kurikulum belum dapat disimpan. Periksa input yang ditandai merah.
            </div>
        @endif

        <div class="mt-6 grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-5">
                <div>
                    <label for="title" class="label text-xs font-bold text-slate-700">Nama / Judul Kurikulum <span class="text-rose-500">*</span></label>
                    <input id="title" name="title" type="text" value="{{ old('title', $curriculum->title) }}" class="input" placeholder="Contoh: Kurikulum Merdeka Terintegrasi Pesantren, Struktur Mata Pelajaran Peminatan..." required>
                    @error('title')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="academic_year" class="label text-xs font-bold text-slate-700">Tahun Ajaran</label>
                    <input id="academic_year" name="academic_year" type="text" value="{{ old('academic_year', $curriculum->academic_year ?? '2026/2027') }}" class="input" placeholder="Contoh: 2026/2027">
                </div>

                <div>
                    <x-rich-editor name="description" label="Deskripsi & Penjelasan Kurikulum" :value="$curriculum->description" minHeight="300px" placeholder="Jelaskan karakteristik, capaian pembelajaran, mata pelajaran unggulan..." />
                </div>
            </section>

            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="order" class="label text-xs font-bold text-slate-700">Urutan Tampilan</label>
                        <input id="order" name="order" type="number" min="0" value="{{ old('order', $curriculum->order ?? 0) }}" class="input">
                    </div>

                    <fieldset class="pt-2 border-t border-slate-100">
                        <legend class="label text-xs font-bold text-slate-700">Status Publikasi</legend>
                        <div class="mt-2 flex flex-col gap-2">
                            @foreach(['active' => 'Aktif (Ditampilkan)', 'inactive' => 'Nonaktif (Disembunyikan)'] as $value => $label)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}" class="text-primary-600 focus:ring-primary-500" @checked(old('status', $curriculum->status ?? 'active') === $value)>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                    <label for="document" class="label text-xs font-bold text-slate-700">File Dokumen / Silabus (PDF/DOC)</label>
                    <input id="document" name="document" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="input text-xs">
                    <p class="mt-1 text-[11px] text-slate-500">PDF, DOC, DOCX, XLSX. Maksimal 10 MB.</p>
                    @error('document')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

                    @if($curriculum->document)
                        <div class="mt-3 flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <span class="truncate font-medium text-slate-700">{{ $curriculum->document_name ?: 'Dokumen Terlampir' }}</span>
                            <a href="{{ asset('storage/'.$curriculum->document) }}" target="_blank" class="font-bold text-primary-700 hover:underline shrink-0 ml-2">Lihat</a>
                        </div>
                    @endif
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
