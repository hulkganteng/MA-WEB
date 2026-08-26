@php $isEditing = $editing->exists; @endphp
<x-layouts.admin title="Struktur Organisasi">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end"><div><a href="{{ route('admin.profile.index') }}" class="text-sm font-medium text-primary-700">← Kembali ke profil</a><h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">Struktur organisasi</h2><p class="mt-2 text-base text-slate-600">Atur pimpinan utama dan anggota yang berada di bawahnya.</p></div><a href="{{ route('structure') }}" target="_blank" class="btn-outline shrink-0 !py-2">Lihat halaman publik</a></div>

    <div class="mt-7 grid items-start gap-8 xl:grid-cols-[23rem_1fr]">
        <form method="POST" action="{{ $isEditing ? route('admin.profile.structure.update', $editing) : route('admin.profile.structure.store') }}" enctype="multipart/form-data" x-data="{ saving: false }" @submit="saving = true" class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10">
            @csrf @if($isEditing)@method('PUT')@endif
            <div class="flex items-center justify-between gap-3"><h3 class="font-semibold text-slate-950">{{ $isEditing ? 'Edit anggota' : 'Tambah anggota' }}</h3>@if($isEditing)<a href="{{ route('admin.profile.structure.index') }}" class="text-sm font-medium text-slate-600 hover:text-primary-700">Batal</a>@endif</div>
            @if($errors->any())<div class="mt-4 rounded-xl bg-rose-50 p-3 text-base text-rose-800 sm:text-sm">Data belum dapat disimpan. Periksa field yang ditandai.</div>@endif
            <div class="mt-5 flex flex-col gap-5">
                <div><label for="name" class="label">Nama</label><input id="name" name="name" type="text" value="{{ old('name', $editing->name) }}" class="input" required>@error('name')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                <div><label for="position" class="label">Jabatan</label><input id="position" name="position" type="text" value="{{ old('position', $editing->position) }}" class="input" required>@error('position')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                <div><label for="parent_id" class="label">Berada di bawah</label><select id="parent_id" name="parent_id" class="input"><option value="">Tingkat utama</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected((string) old('parent_id', $editing->parent_id) === (string) $parent->id)>{{ $parent->name }} — {{ $parent->position }}</option>@endforeach</select><p class="mt-1 text-sm text-slate-500">Pilih tingkat utama untuk pimpinan atau kepala bidang.</p>@error('parent_id')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                <div><label for="order" class="label">Urutan tampil</label><input id="order" name="order" type="number" min="0" max="9999" value="{{ old('order', $editing->order ?? 0) }}" class="input" required>@error('order')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                <div><label for="photo" class="label">Foto</label><input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" class="input">@error('photo')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror</div>
                <label class="flex items-center gap-3 text-base text-slate-700 sm:text-sm"><input id="is_active" name="is_active" type="checkbox" value="1" class="size-5 rounded border-slate-300 text-primary-600 sm:size-4" @checked(old('is_active', $editing->is_active))> Tampilkan di website</label>
                <button type="submit" class="btn-primary !py-2" :disabled="saving" x-text="saving ? 'Menyimpan…' : @js($isEditing ? 'Simpan anggota' : 'Tambah anggota')">{{ $isEditing ? 'Simpan anggota' : 'Tambah anggota' }}</button>
            </div>
        </form>

        <section>
            <h3 class="font-semibold text-slate-950">Daftar anggota</h3>
            <p class="mt-1 text-base text-slate-600 sm:text-sm">Anggota tingkat utama ditampilkan sebagai kelompok; bawahannya tampil di dalam kelompok tersebut.</p>
            <div class="mt-5 divide-y divide-slate-900/10 border-y border-slate-900/10">
                @forelse($members as $member)
                    <article class="flex flex-col justify-between gap-4 py-5 sm:flex-row sm:items-center">
                        <div class="flex min-w-0 items-center gap-4">@if($member->photo)<img src="{{ asset('storage/'.$member->photo) }}" alt="" class="size-12 shrink-0 rounded-full object-cover outline outline-1 -outline-offset-1 outline-black/5">@else<div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-slate-100"><x-icon name="user-round" class="size-5 text-slate-400" /></div>@endif<div class="min-w-0"><h4 class="truncate font-semibold text-slate-950">{{ $member->name }}</h4><p class="mt-1 text-sm text-slate-500">{{ $member->position }} · {{ $member->parent ? 'Di bawah '.$member->parent->name : 'Tingkat utama' }} · {{ $member->is_active ? 'Aktif' : 'Disembunyikan' }}</p></div></div>
                        <div class="flex shrink-0 gap-2"><a href="{{ route('admin.profile.structure.index', ['edit' => $member->id]) }}" class="relative rounded-lg px-2.5 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-50">Edit<span class="absolute left-1/2 top-1/2 size-[max(100%,3rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden" aria-hidden="true"></span></a><form method="POST" action="{{ route('admin.profile.structure.destroy', $member) }}" onsubmit="return confirm(@js('Hapus '.$member->name.' dari struktur organisasi? Anggota di bawahnya akan dipindahkan ke tingkat utama.'))">@csrf @method('DELETE')<button type="submit" class="relative rounded-lg px-2.5 py-1.5 text-sm font-medium text-rose-700 hover:bg-rose-50">Hapus<span class="absolute left-1/2 top-1/2 size-[max(100%,3rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden" aria-hidden="true"></span></button></form></div>
                    </article>
                @empty
                    <div class="py-12 text-center"><x-icon name="network" class="mx-auto size-8 text-slate-400" /><p class="mt-3 font-medium text-slate-950">Belum ada anggota struktur</p><p class="mt-1 text-base text-slate-500 sm:text-sm">Gunakan formulir di samping untuk menambahkan anggota pertama.</p></div>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.admin>
