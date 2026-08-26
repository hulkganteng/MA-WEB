<x-layouts.admin title="Galeri Video">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Kelola galeri video</h2>
            <p class="mt-2 text-base text-slate-600">Tambah dan kelola video dokumentasi kegiatan dan profil madrasah.</p>
        </div>
        @can('videos.create')
            <a href="{{ route('admin.gallery.videos.create') }}" class="btn-primary shrink-0 !py-2 !pr-3 !pl-2">
                <x-icon name="plus" class="size-4" />Tambah Video
            </a>
        @endcan
    </div>

    <form method="GET" class="mt-7 flex flex-col gap-3 sm:flex-row">
        <div class="min-w-0 flex-1">
            <label for="q" class="sr-only">Cari video</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" class="input !py-2" placeholder="Cari judul video, deskripsi, atau kategori...">
        </div>
        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="input !py-2">
                <option value="">Semua status</option>
                @foreach(\App\Models\Video::STATUSES as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-outline !py-2">Terapkan filter</button>
    </form>

    <div class="-mx-4 -my-2 mt-7 overflow-x-auto whitespace-nowrap sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full px-4 py-2 align-middle sm:px-6 lg:px-8">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-900/10 text-left text-sm text-slate-500">
                        <th class="whitespace-nowrap py-3 pr-4 font-medium">Video</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Platform</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Tanggal</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Status</th>
                        <th class="py-3 pl-4 text-right font-medium"><span class="sr-only">Tindakan</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-900/10">
                    @forelse($videos as $video)
                        <tr>
                            <td class="max-w-md py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    @if($video->thumbnail)
                                        <div class="relative size-16 shrink-0 overflow-hidden rounded-lg bg-slate-900 ring-1 ring-slate-900/10">
                                            <img src="{{ $video->thumbnail }}" alt="" class="size-full object-cover">
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                                                <x-icon name="play" class="size-5 text-white" />
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex size-16 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 ring-1 ring-slate-900/10">
                                            <x-icon name="video" class="size-6" />
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-slate-950">{{ $video->title }}</p>
                                        <div class="mt-1 flex items-center gap-2">
                                            <span class="rounded bg-slate-100 px-1.5 py-0.5 text-xs font-medium text-slate-600">{{ $video->category ?: 'Video' }}</span>
                                            <a href="{{ $video->url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-primary-700 hover:underline">
                                                Buka Tautan ↗
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-600">
                                <span class="inline-flex items-center gap-1.5 rounded-md bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700">
                                    <x-icon name="youtube" class="size-3.5" />
                                    {{ ucfirst($video->provider ?: 'YouTube') }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm tabular-nums text-slate-600">
                                {{ optional($video->video_date)->translatedFormat('d F Y') ?: '—' }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $video->status === 'published' ? 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-600/20' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($video->status) }}
                                </span>
                            </td>
                            <td class="py-4 pl-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @can('videos.update')
                                        <a href="{{ route('admin.gallery.videos.edit', $video) }}" class="rounded-lg px-2.5 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-50">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('videos.delete')
                                        <form method="POST" action="{{ route('admin.gallery.videos.destroy', $video) }}" onsubmit="return confirm('Pindahkan video ini ke sampah?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg px-2.5 py-1.5 text-sm font-medium text-rose-700 hover:bg-rose-50">
                                                Hapus
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-base text-slate-500">
                                Belum ada video galeri. Klik tombol "Tambah Video" untuk menambahkan video baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-7">
        {{ $videos->links() }}
    </div>
</x-layouts.admin>
