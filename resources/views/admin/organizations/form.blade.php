@php $editing = $organization->exists; @endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Organisasi Siswa'">
    <form method="POST" action="{{ $editing ? route('admin.organizations.update', $organization) : route('admin.organizations.store') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.organizations.index') }}" class="text-xs font-semibold text-primary-700 hover:underline">← Kembali ke daftar organisasi siswa</a>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $editing ? 'Edit Organisasi Siswa' : 'Tambah Organisasi Siswa' }}</h2>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2.5 !px-5 font-bold" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan Organisasi'">
                Simpan Organisasi
            </button>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-800 border border-rose-200">
                Organisasi belum dapat disimpan. Periksa input yang ditandai merah.
            </div>
        @endif

        <div class="mt-6 grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-5">
                <div>
                    <label for="name" class="label text-xs font-bold text-slate-700">Nama Organisasi <span class="text-rose-500">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $organization->name) }}" class="input" placeholder="Contoh: OSIM MA Assa'adah, Pimpinan Ranting IPNU, IPPNU, MPK..." required>
                    @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <x-rich-editor name="description" label="Profil & Deskripsi Singkat" :value="$organization->description" minHeight="240px" placeholder="Jelaskan sejarah, tujuan, dan profil umum organisasi..." />
                </div>

                <div>
                    <label for="structure" class="label text-xs font-bold text-slate-700">Struktur Pengurus Inti</label>
                    <textarea id="structure" name="structure" rows="4" class="input" placeholder="Contoh: Ketua, Wakil Ketua, Sekretaris, Bendahara, Divisi-divisi...">{{ old('structure', $organization->structure) }}</textarea>
                </div>

                <div>
                    <x-rich-editor name="work_program" label="Program Kerja Utama" :value="$organization->work_program" minHeight="240px" placeholder="Daftar agenda dan program kerja unggulan pengurus..." />
                </div>

                <div>
                    <label for="activities" class="label text-xs font-bold text-slate-700">Dokumentasi / Kegiatan Rutin</label>
                    <textarea id="activities" name="activities" rows="3" class="input" placeholder="Kegiatan rutin mingguan, bulanan, atau peringatan hari besar...">{{ old('activities', $organization->activities) }}</textarea>
                </div>
            </section>

            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="order" class="label text-xs font-bold text-slate-700">Urutan Tampilan</label>
                        <input id="order" name="order" type="number" min="0" value="{{ old('order', $organization->order ?? 0) }}" class="input">
                    </div>

                    <fieldset class="pt-2 border-t border-slate-100">
                        <legend class="label text-xs font-bold text-slate-700">Status Publikasi</legend>
                        <div class="mt-2 flex flex-col gap-2">
                            @foreach(['active' => 'Aktif (Ditampilkan)', 'inactive' => 'Nonaktif (Disembunyikan)'] as $value => $label)
                                <label class="flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}" class="text-primary-600 focus:ring-primary-500" @checked(old('status', $organization->status ?? 'active') === $value)>
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="logo" class="label text-xs font-bold text-slate-700">Logo Lambang Organisasi</label>
                        <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/webp,image/svg+xml" class="input text-xs">
                        <p class="mt-1 text-[11px] text-slate-500">PNG transparan atau WebP disarankan. Max 2MB.</p>
                        @error('logo')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

                        @if($organization->logo)
                            <div class="mt-3 flex items-center gap-3 p-2 rounded-xl bg-slate-50 border border-slate-200">
                                <img src="{{ asset('storage/'.$organization->logo) }}" alt="Logo saat ini" class="size-12 object-contain">
                                <span class="text-xs text-slate-500">Logo aktif saat ini</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-100">
                        <label for="photo" class="label text-xs font-bold text-slate-700">Foto Bersama Pengurus</label>
                        <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="input text-xs">
                        <p class="mt-1 text-[11px] text-slate-500">Foto horizontal / landscape. Max 3MB.</p>
                        @error('photo')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror

                        @if($organization->photo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/'.$organization->photo) }}" alt="Foto saat ini" class="aspect-video w-full rounded-xl object-cover border border-slate-200">
                            </div>
                        @endif
                    </div>
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
