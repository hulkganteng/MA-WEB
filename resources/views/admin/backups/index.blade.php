<x-layouts.admin title="Backup Data">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Backup data</h2>
            <p class="mt-2 text-base text-slate-600">Simpan salinan database dan seluruh file unggahan website dalam satu arsip ZIP.</p>
        </div>
        <form method="POST" action="{{ route('admin.backups.store') }}" x-data="{ saving: false }" @submit="saving = true">
            @csrf
            <button type="submit" class="btn-primary shrink-0 !py-2" :disabled="saving" :aria-busy="saving">
                <x-icon name="database-backup" class="size-4" />
                <span x-text="saving ? 'Membuat backup…' : 'Buat backup sekarang'">Buat backup sekarang</span>
            </button>
        </form>
    </div>

    <section class="mt-7 overflow-hidden rounded-2xl bg-white ring-1 ring-slate-900/10">
        <div class="border-b border-slate-900/10 px-6 py-5">
            <h3 class="font-semibold text-slate-950">Riwayat backup</h3>
            <p class="mt-1 text-sm text-slate-500">Unduh arsip ke perangkat lain agar salinan tetap aman jika server bermasalah.</p>
        </div>

        <div class="divide-y divide-slate-900/10">
            @forelse($backups as $backup)
                <article class="flex flex-col justify-between gap-4 px-6 py-5 sm:flex-row sm:items-center">
                    <div class="flex min-w-0 items-center gap-4">
                        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700">
                            <x-icon name="archive" class="size-5" />
                        </span>
                        <div class="min-w-0">
                            <h4 class="truncate font-medium text-slate-950">{{ $backup['filename'] }}</h4>
                            <p class="mt-1 text-sm text-slate-500">{{ $backup['created_at'] }} · {{ $backup['size'] }}</p>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <a href="{{ route('admin.backups.download', $backup['filename']) }}" class="btn-outline !px-3 !py-2">
                            <x-icon name="download" class="size-4" /> Unduh
                        </a>
                        <form method="POST" action="{{ route('admin.backups.destroy', $backup['filename']) }}" onsubmit="return confirm('Hapus file backup ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-rose-700 hover:bg-rose-50">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="px-6 py-12 text-center">
                    <x-icon name="database" class="mx-auto size-8 text-slate-300" />
                    <p class="mt-3 text-base text-slate-500">Belum ada file backup.</p>
                </div>
            @endforelse
        </div>
    </section>
</x-layouts.admin>
