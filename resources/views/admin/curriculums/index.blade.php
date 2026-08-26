<x-layouts.admin title="Kurikulum & Pembelajaran">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-950">Kelola Kurikulum</h2>
            <p class="mt-1 text-sm text-slate-600">Atur dokumen kurikulum merdeka, muatan lokal pesantren, dan struktur pembelajaran.</p>
        </div>
        @can('curriculums.create')
            <a href="{{ route('admin.curriculums.create') }}" class="btn-primary shrink-0 !py-2 !pr-3 !pl-2.5">
                <x-icon name="plus" class="size-4" />
                <span>Tambah Kurikulum</span>
            </a>
        @endcan
    </div>

    {{-- Filter & Search Form --}}
    <form method="GET" class="mt-6 grid gap-3 sm:grid-cols-[minmax(0,1fr)_12rem_auto]">
        <div>
            <label for="q" class="sr-only">Cari kurikulum</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" class="input !py-2 text-sm" placeholder="Cari nama atau judul kurikulum...">
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
        @forelse($curriculums as $item)
            <article class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center hover:bg-slate-50/70 transition">
                <div class="flex min-w-0 items-center gap-4">
                    <div class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700 font-bold border border-primary-200">
                        <x-icon name="book-open" class="size-6" />
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="truncate font-bold text-slate-900 text-base">{{ $item->title }}</h3>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase {{ $item->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                {{ $item->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500 truncate">
                            Tahun Ajaran: <span class="font-semibold text-slate-700">{{ $item->academic_year ?: '-' }}</span>
                            @if($item->document)
                                · Dokumen: <span class="text-primary-700 font-medium">{{ $item->document_name ?: 'Download PDF' }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 gap-2 items-center">
                    @if($item->document)
                        <a href="{{ asset('storage/'.$item->document) }}" target="_blank" class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition border border-slate-200" title="Unduh Dokumen">
                            <x-icon name="download" class="size-3.5" />
                        </a>
                    @endif
                    @can('curriculums.update')
                        <a href="{{ route('admin.curriculums.edit', $item) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-primary-700 hover:bg-primary-50 transition border border-primary-200">
                            Edit
                        </a>
                    @endcan
                    @can('curriculums.delete')
                        <form method="POST" action="{{ route('admin.curriculums.destroy', $item) }}" onsubmit="return confirm(@js('Hapus kurikulum '.$item->title.'?'))">
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
            <p class="py-12 text-center text-sm text-slate-500">Belum ada kurikulum yang ditambahkan.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $curriculums->links() }}</div>
</x-layouts.admin>
