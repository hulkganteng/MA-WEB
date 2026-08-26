@php $editing = $extracurricular->exists; @endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Ekstrakurikuler'">
    <form method="POST" action="{{ $editing ? route('admin.extracurriculars.update', $extracurricular) : route('admin.extracurriculars.store') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.extracurriculars.index') }}" class="text-xs font-semibold text-primary-700 hover:underline">← Kembali ke daftar ekstrakurikuler</a>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $editing ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler' }}</h2>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2.5 !px-5 font-bold" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan Ekstrakurikuler'">
                Simpan Ekstrakurikuler
            </button>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-800 border border-rose-200">
                Ekstrakurikuler belum dapat disimpan. Periksa input yang ditandai merah.
            </div>
        @endif

        <div class="mt-6 grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-5">
                <div>
                    <label for="name" class="label text-xs font-bold text-slate-700">Nama Ekstrakurikuler <span class="text-rose-500">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $extracurricular->name) }}" class="input" placeholder="Contoh: Robotika & Coding Lab, Tahfidz Club, Paskibra..." required>
                    @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="mentor" class="label text-xs font-bold text-slate-700">Pembina / Pelatih</label>
                        <input id="mentor" name="mentor" type="text" value="{{ old('mentor', $extracurricular->mentor) }}" class="input" placeholder="Nama Guru / Pelatih">
                    </div>
                    <div>
                        <label for="schedule" class="label text-xs font-bold text-slate-700">Jadwal Latihan</label>
                        <input id="schedule" name="schedule" type="text" value="{{ old('schedule', $extracurricular->schedule) }}" class="input" placeholder="Contoh: Setiap Sabtu, 14.00 - 16.30 WIB">
                    </div>
                </div>

                <div>
                    <x-rich-editor name="description" label="Deskripsi & Profil Kegiatan" :value="$extracurricular->description" minHeight="280px" placeholder="Jelaskan tujuan, materi, dan kegiatan ekstrakurikuler..." />
                </div>

                <div>
                    <label for="achievements" class="label text-xs font-bold text-slate-700">Prestasi / Capaian Utama (Opsional)</label>
                    <textarea id="achievements" name="achievements" rows="3" class="input" placeholder="Daftar kejuaraan atau prestasi yang pernah diraih...">{{ old('achievements', $extracurricular->achievements) }}</textarea>
                </div>
            </section>

            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="icon" class="label text-xs font-bold text-slate-700">Icon Lucide (Opsional)</label>
                        <input id="icon" name="icon" type="text" value="{{ old('icon', $extracurricular->icon ?: 'activity') }}" class="input" placeholder="activity, cpu, sparkles, award...">
                    </div>

                    <div>
                        <label for="order" class="label text-xs font-bold text-slate-700">Urutan Tampilan</label>
                        <input id="order" name="order" type="number" min="0" value="{{ old('order', $extracurricular->order ?? 0) }}" class="input">
                    </div>

                    <fieldset class="pt-2 border-t border-slate-100">
                        <legend class="label text-xs font-bold text-slate-700">Status Publikasi</legend>
                        <div class="mt-2 flex flex-col gap-2">
                            @foreach(['active' => 'Aktif (Ditampilkan)', 'inactive' => 'Nonaktif (Disembunyikan)'] as $value => $label)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}" class="text-primary-600 focus:ring-primary-500" @checked(old('status', $extracurricular->status ?? 'active') === $value)>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
                    <label for="photo" class="label text-xs font-bold text-slate-700">Foto Kegiatan / Thumbnail</label>
                    <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="input text-xs">
                    <p class="mt-1 text-[11px] text-slate-500">JPG, PNG, atau WebP. Maksimal 3 MB.</p>
                    @error('photo')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

                    @if($extracurricular->photo)
                        <div class="mt-4">
                            <p class="text-[11px] text-slate-500 font-semibold mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/'.$extracurricular->photo) }}" alt="{{ $extracurricular->name }}" class="aspect-video w-full rounded-xl object-cover border border-slate-200">
                        </div>
                    @endif
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
