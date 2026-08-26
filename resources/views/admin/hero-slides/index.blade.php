<x-layouts.admin title="Hero Slider Landing Page">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Kelola Hero Slider</h2>
            <p class="mt-2 text-base text-slate-600">Atur banner foto besar, judul, tombol aksi, dan animasi geser pada halaman utama.</p>
        </div>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn-primary shrink-0 !py-2 !pr-3 !pl-2">
            <x-icon name="plus" class="size-4" />Tambah Slide Hero
        </a>
    </div>

    <!-- Info Box -->
    <div class="mt-6 flex items-start gap-3 rounded-xl bg-emerald-50 p-4 text-sm text-emerald-900 ring-1 ring-emerald-200">
        <x-icon name="info" class="size-5 shrink-0 text-emerald-600 mt-0.5" />
        <div>
            <p class="font-medium">Animasi Geser Otomatis di Halaman Utama</p>
            <p class="mt-0.5 text-xs text-emerald-800">
                Slide dengan status <strong>Published</strong> akan berganti secara otomatis setiap beberapa detik di halaman depan dan dilengkapi tombol interaktif untuk memperbesar foto (*modal view*).
            </p>
        </div>
    </div>

    <form method="GET" class="mt-6 flex flex-col gap-3 sm:flex-row">
        <div class="min-w-0 flex-1">
            <label for="q" class="sr-only">Cari slide</label>
            <input id="q" name="q" type="search" value="{{ request('q') }}" class="input !py-2" placeholder="Cari judul slide, subtitle, atau tagline...">
        </div>
        <div>
            <label for="status" class="sr-only">Status</label>
            <select id="status" name="status" class="input !py-2">
                <option value="">Semua status</option>
                @foreach(\App\Models\HeroSlide::STATUSES as $status)
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
                        <th class="whitespace-nowrap py-3 pr-4 font-medium">Banner Foto & Judul</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Tombol Aksi</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium text-center">Urutan</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Status</th>
                        <th class="py-3 pl-4 text-right font-medium"><span class="sr-only">Tindakan</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-900/10">
                    @forelse($slides as $slide)
                        <tr>
                            <td class="max-w-md py-4 pr-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="relative size-16 shrink-0 overflow-hidden rounded-xl bg-slate-900 ring-1 ring-slate-900/10">
                                        <img src="{{ $slide->image_url }}" alt="" class="size-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        @if($slide->tagline)
                                            <span class="inline-block rounded bg-primary-50 px-1.5 py-0.5 text-[11px] font-semibold text-primary-700 ring-1 ring-primary-600/20">
                                                {{ $slide->tagline }}
                                            </span>
                                        @endif
                                        <p class="truncate font-semibold text-slate-950 text-sm mt-0.5">{{ $slide->title }}</p>
                                        @if($slide->subtitle)
                                            <p class="truncate text-xs text-slate-500 mt-0.5">{{ $slide->subtitle }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-600">
                                @if($slide->button_text)
                                    <div class="flex items-center gap-1 font-medium text-slate-800">
                                        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $slide->button_text }}</span>
                                        <span class="text-slate-400">→ {{ $slide->button_url ?: '#' }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm font-semibold tabular-nums text-center text-slate-700">
                                {{ $slide->order }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $slide->status === 'published' ? 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-600/20' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($slide->status) }}
                                </span>
                            </td>
                            <td class="py-4 pl-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="rounded-lg px-2.5 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-50">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide) }}" onsubmit="return confirm('Hapus slide hero ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg px-2.5 py-1.5 text-sm font-medium text-rose-700 hover:bg-rose-50 cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-base text-slate-500">
                                Belum ada slide hero. Klik tombol "Tambah Slide Hero" untuk membuat slide banner pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-7">
        {{ $slides->links() }}
    </div>
</x-layouts.admin>
