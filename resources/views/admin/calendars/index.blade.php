<x-layouts.admin title="Kalender Akademik">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-950">Kalender Akademik (Kaldik)</h2>
            <p class="mt-1 text-sm text-slate-600">Atur agenda kegiatan akademik, jadwal ujian, libur santri, dan rapat.</p>
        </div>
        @can('calendars.create')
            <a href="{{ route('admin.calendars.create') }}" class="btn-primary shrink-0 !py-2 !pr-3 !pl-2.5">
                <x-icon name="plus" class="size-4" />
                <span>Tambah Agenda Kaldik</span>
            </a>
        @endcan
    </div>

    {{-- Filter & Search Form --}}
    <form method="GET" class="mt-6 grid gap-3 sm:grid-cols-[minmax(0,1fr)_12rem_auto]">
        <div>
            <label for="q" class="sr-only">Cari agenda</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" class="input !py-2 text-sm" placeholder="Cari nama agenda kegiatan...">
        </div>
        <div>
            <label for="category" class="sr-only">Kategori</label>
            <select id="category" name="category" class="input !py-2 text-sm">
                <option value="">Semua kategori</option>
                @foreach(\App\Models\AcademicCalendar::CATEGORIES as $cat)
                    <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-outline !py-2 text-sm">Terapkan</button>
    </form>

    {{-- Items List --}}
    <div class="mt-6 divide-y divide-slate-200 border-y border-slate-200 bg-white rounded-2xl shadow-sm overflow-hidden">
        @forelse($calendars as $item)
            @php
                $badgeColors = match($item->category) {
                    'ujian' => 'bg-rose-100 text-rose-800',
                    'libur' => 'bg-amber-100 text-amber-800',
                    'lomba' => 'bg-purple-100 text-purple-800',
                    'rapat' => 'bg-sky-100 text-sky-800',
                    default => 'bg-emerald-100 text-emerald-800',
                };
            @endphp
            <article class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center hover:bg-slate-50/70 transition">
                <div class="flex min-w-0 items-center gap-4">
                    <time class="flex size-14 shrink-0 flex-col items-center justify-center rounded-xl bg-[#006437] text-white shadow-sm border border-[#00923F]/30">
                        <span class="text-base font-extrabold leading-tight">{{ $item->start_date?->format('d') }}</span>
                        <span class="text-[10px] font-bold text-gold-300 uppercase leading-tight">{{ $item->start_date?->translatedFormat('M') }}</span>
                    </time>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="truncate font-bold text-slate-900 text-base">{{ $item->title }}</h3>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase {{ $badgeColors }}">
                                {{ ucfirst($item->category) }}
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500 truncate">
                            Periode: <span class="font-semibold text-slate-700">
                                {{ $item->start_date?->translatedFormat('d F Y') }}
                                @if($item->end_date && $item->end_date->ne($item->start_date))
                                    s.d. {{ $item->end_date->translatedFormat('d F Y') }}
                                @endif
                            </span>
                            @if($item->academic_year)
                                · TA {{ $item->academic_year }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 gap-2 items-center">
                    @can('calendars.update')
                        <a href="{{ route('admin.calendars.edit', $item) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-primary-700 hover:bg-primary-50 transition border border-primary-200">
                            Edit
                        </a>
                    @endcan
                    @can('calendars.delete')
                        <form method="POST" action="{{ route('admin.calendars.destroy', $item) }}" onsubmit="return confirm(@js('Hapus agenda '.$item->title.'?'))">
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
            <p class="py-12 text-center text-sm text-slate-500">Belum ada agenda kalender akademik yang ditambahkan.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $calendars->links() }}</div>
</x-layouts.admin>
