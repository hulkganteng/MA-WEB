<x-layouts.admin title="Profil Madrasah">
    <div class="max-w-5xl">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Kelola profil madrasah</h2>
                <p class="mt-2 text-base text-slate-600">Pilih bagian yang ingin diperbarui. Perubahan yang dipublikasikan langsung digunakan oleh website.</p>
            </div>
            <a href="{{ route('about') }}" target="_blank" class="btn-outline shrink-0 !py-2">Lihat profil publik</a>
        </div>

        <div class="mt-8 divide-y divide-slate-900/10 border-y border-slate-900/10">
            @foreach($sections as $item)
                @can('pages.update')
                    <a href="{{ route('admin.profile.pages.edit', $item['key']) }}" class="group flex items-center justify-between gap-5 py-5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                        <span class="min-w-0">
                            <span class="block font-semibold text-slate-950 group-hover:text-primary-700">{{ $item['title'] }}</span>
                            <span class="mt-1 block text-base text-slate-600 sm:text-sm">Konten halaman /profil/{{ $item['key'] === 'tentang' ? '' : $item['key'] }}</span>
                        </span>
                        <span class="flex shrink-0 items-center gap-3 text-sm text-slate-500">
                            <span class="hidden sm:inline">{{ $item['page']?->status === 'published' ? 'Dipublikasikan' : 'Belum dipublikasikan' }}</span>
                            <x-icon name="chevron-right" class="size-5 sm:size-4" />
                        </span>
                    </a>
                @endcan
            @endforeach

            @can('settings.manage')
                <a href="{{ route('admin.profile.principal.edit') }}" class="group flex items-center justify-between gap-5 py-5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    <span class="min-w-0"><span class="block font-semibold text-slate-950 group-hover:text-primary-700">Sambutan Kepala Madrasah</span><span class="mt-1 block text-base text-slate-600 sm:text-sm">Nama, jabatan, foto, dan isi sambutan kepala madrasah</span></span>
                    <span class="flex shrink-0 items-center gap-3 text-sm text-slate-500"><span class="hidden sm:inline">{{ $principalComplete ? 'Sudah dilengkapi' : 'Perlu dilengkapi' }}</span><x-icon name="chevron-right" class="size-5 sm:size-4" /></span>
                </a>
            @endcan

            @can('structure.manage')
                <a href="{{ route('admin.profile.structure.index') }}" class="group flex items-center justify-between gap-5 py-5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                    <span class="min-w-0"><span class="block font-semibold text-slate-950 group-hover:text-primary-700">Struktur Organisasi</span><span class="mt-1 block text-base text-slate-600 sm:text-sm">Susunan pimpinan, bidang, dan hubungan antaranggota</span></span>
                    <span class="flex shrink-0 items-center gap-3 text-sm text-slate-500"><span class="hidden sm:inline">{{ $memberCount }} anggota</span><x-icon name="chevron-right" class="size-5 sm:size-4" /></span>
                </a>
            @endcan
        </div>
    </div>
</x-layouts.admin>
