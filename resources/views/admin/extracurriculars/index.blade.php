<x-layouts.admin title="Ekstrakurikuler">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-950">Kelola Ekstrakurikuler</h2>
            <p class="mt-1 text-sm text-slate-600">Atur kegiatan pengembangan minat dan bakat santri madrasah.</p>
        </div>
        @can('extracurriculars.create')
            <a href="{{ route('admin.extracurriculars.create') }}" class="btn-primary shrink-0 !py-2 !pr-3 !pl-2.5">
                <x-icon name="plus" class="size-4" />
                <span>Tambah Ekstrakurikuler</span>
            </a>
        @endcan
    </div>

    {{-- Filter & Search Form --}}
    <form method="GET" class="mt-6 grid gap-3 sm:grid-cols-[minmax(0,1fr)_12rem_auto]">
        <div>
            <label for="q" class="sr-only">Cari ekstrakurikuler</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" class="input !py-2 text-sm" placeholder="Cari nama atau pembina...">
        </div>
        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="input !py-2 text-sm">
                <option value="">Semua status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn-outline !py-2 text-sm">Terapkan</button>
    </form>

    {{-- Items List --}}
    <div class="mt-6 divide-y divide-slate-200 border-y border-slate-200 bg-white rounded-2xl shadow-sm overflow-hidden">
        @forelse($extracurriculars as $item)
            <article class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center hover:bg-slate-50/70 transition">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700 font-bold overflow-hidden border border-primary-200">
                        @if($item->photo)
                            <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}" class="size-full object-cover">
                        @else
                            <x-icon name="{{ $item->icon ?: 'activity' }}" class="size-6" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="truncate font-bold text-slate-900 text-base">{{ $item->name }}</h3>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase {{ $item->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $item->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500 truncate">
                            Pembina: <span class="font-medium text-slate-700">{{ $item->mentor ?: 'Belum ditentukan' }}</span>
                            @if($item->schedule)
                                · Jadwal: <span class="font-medium text-slate-700">{{ $item->schedule }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 gap-2 items-center">
                    @can('extracurriculars.update')
                        <a href="{{ route('admin.extracurriculars.edit', $item) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-primary-700 hover:bg-primary-50 transition border border-primary-200">
                            Edit
                        </a>
                    @endcan
                    @can('extracurriculars.delete')
                        <form method="POST" action="{{ route('admin.extracurriculars.destroy', $item) }}" onsubmit="return confirm(@js('Hapus ekstrakurikuler '.$item->name.'?'))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50 transition border border-rose-200">
                                Hapus
                            </button>
                        </form>
                    @endcan
                </div>
            </article>
        @empty
            <p class="py-12 text-center text-sm text-slate-500">Belum ada ekstrakurikuler yang ditambahkan.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $extracurriculars->links() }}</div>
</x-layouts.admin>
