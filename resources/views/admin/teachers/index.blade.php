<x-layouts.admin title="Guru & Tendik">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div><h2 class="text-2xl font-semibold tracking-tight text-slate-950">Kelola guru dan tenaga kependidikan</h2><p class="mt-2 text-base text-slate-600">Data yang aktif dan publik langsung tampil di direktori website.</p></div>
        @can('teachers.create')<a href="{{ route('admin.teachers.create', ['type' => request('type')]) }}" class="btn-primary shrink-0 !py-2 !pr-3 !pl-2"><x-icon name="user-plus" class="size-4" />Tambah data</a>@endcan
    </div>

    <form method="GET" class="mt-7 grid gap-3 sm:grid-cols-[minmax(0,1fr)_12rem_12rem_auto]">
        <div><label for="q" class="sr-only">Cari nama, jabatan, atau mata pelajaran</label><input id="q" name="q" type="search" value="{{ request('q') }}" class="input !py-2" placeholder="Cari nama, jabatan, atau mapel"></div>
        <div><label for="type" class="sr-only">Jenis tenaga</label><div><select id="type" name="type" class="input !py-2"><option value="">Semua jenis</option><option value="guru" @selected(request('type') === 'guru')>Guru</option><option value="tendik" @selected(request('type') === 'tendik')>Tenaga kependidikan</option></select></div></div>
        <div><label for="status" class="sr-only">Status tampil</label><div><select id="status" name="status" class="input !py-2"><option value="">Semua status</option><option value="published" @selected(request('status') === 'published')>Tampil di website</option><option value="hidden" @selected(request('status') === 'hidden')>Disembunyikan</option><option value="trash" @selected(request('status') === 'trash')>Sampah</option></select></div></div>
        <button type="submit" class="btn-outline !py-2">Terapkan</button>
    </form>

    <div class="mt-7 divide-y divide-slate-900/10 border-y border-slate-900/10">
        @forelse($teachers as $teacher)
            <article class="flex flex-col justify-between gap-4 py-5 sm:flex-row sm:items-center">
                <div class="flex min-w-0 items-center gap-4">
                    @if($teacher->photo)<img src="{{ asset('storage/'.$teacher->photo) }}" alt="" class="size-14 shrink-0 rounded-xl object-cover outline outline-1 -outline-offset-1 outline-black/5">@else<div class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-primary-50"><x-icon name="user-round" class="size-6 text-primary-300" /></div>@endif
                    <div class="min-w-0"><h3 class="truncate font-semibold text-slate-950">{{ $teacher->name }}</h3><p class="mt-1 text-base text-slate-600 sm:text-sm">{{ $teacher->type === 'guru' ? 'Guru' : 'Tenaga kependidikan' }}{{ $teacher->position ? ' · '.$teacher->position : '' }}{{ $teacher->subject ? ' · '.$teacher->subject : '' }}</p><p class="mt-1 text-sm text-slate-500">Urutan {{ $teacher->order }} · @if($teacher->trashed())Di sampah @elseif($teacher->is_active && $teacher->is_public)Tampil di website @else Disembunyikan @endif</p></div>
                </div>
                <div class="flex shrink-0 gap-2">
                    @if($teacher->trashed())
                        @can('teachers.delete')<form method="POST" action="{{ route('admin.teachers.restore', $teacher->id) }}">@csrf<button type="submit" class="relative rounded-lg px-2.5 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-50">Pulihkan<span class="absolute left-1/2 top-1/2 size-[max(100%,3rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden" aria-hidden="true"></span></button></form>@endcan
                    @else
                        @can('teachers.update')<a href="{{ route('admin.teachers.edit', $teacher) }}" class="relative rounded-lg px-2.5 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-50">Edit<span class="absolute left-1/2 top-1/2 size-[max(100%,3rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden" aria-hidden="true"></span></a>@endcan
                        @can('teachers.delete')<form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" onsubmit="return confirm(@js('Pindahkan '.$teacher->name.' ke sampah? Data ini tidak akan tampil di website dan dapat dipulihkan.'))">@csrf @method('DELETE')<button type="submit" class="relative rounded-lg px-2.5 py-1.5 text-sm font-medium text-rose-700 hover:bg-rose-50">Hapus<span class="absolute left-1/2 top-1/2 size-[max(100%,3rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden" aria-hidden="true"></span></button></form>@endcan
                    @endif
                </div>
            </article>
        @empty
            <div class="py-12 text-center">
                <x-icon name="users" class="mx-auto size-8 text-slate-400" />
                <p class="mt-3 font-medium text-slate-950">{{ request()->filled('q') || request()->filled('type') || request()->filled('status') ? 'Tidak ada data yang cocok' : 'Belum ada data guru dan tendik' }}</p>
                <p class="mt-1 text-base text-slate-500 sm:text-sm">{{ request()->filled('q') || request()->filled('type') || request()->filled('status') ? 'Ubah atau hapus filter untuk melihat data lainnya.' : 'Tambahkan data pertama agar dapat ditampilkan di website.' }}</p>
                @can('teachers.create')
                    @if(!request()->filled('q') && !request()->filled('type') && !request()->filled('status'))
                        <a href="{{ route('admin.teachers.create') }}" class="mt-4 inline-flex text-sm font-medium text-primary-700">Tambah data pertama</a>
                    @endif
                @endcan
            </div>
        @endforelse
    </div>
    <div class="mt-7">{{ $teachers->links() }}</div>
</x-layouts.admin>
