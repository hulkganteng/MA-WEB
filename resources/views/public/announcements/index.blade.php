<x-layouts.app title="Pengumuman" description="Informasi resmi dan pemberitahuan terbaru dari madrasah.">
    <x-page-header title="Pengumuman" description="Informasi resmi dan pemberitahuan terbaru dari madrasah." />
    <section class="py-14 sm:py-20"><div class="container-app max-w-5xl">
        <div class="divide-y divide-slate-900/10 rounded-2xl bg-white px-6 ring-1 ring-slate-900/10 sm:px-8">
            @forelse ($announcements as $announcement)
                <article class="flex flex-col gap-4 py-6 sm:flex-row sm:items-start">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-xl {{ $announcement->is_important ? 'bg-gold-100 text-gold-800' : 'bg-primary-50 text-primary-700' }}"><x-icon name="megaphone" class="size-5" /></div>
                    <div class="min-w-0 flex-1"><div class="flex flex-wrap items-center gap-2 text-sm text-slate-500"><time>{{ $announcement->publish_date->translatedFormat('d F Y') }}</time>@if ($announcement->is_important)<span class="rounded-full bg-gold-100 px-2 py-1 font-medium text-gold-900">Penting</span>@endif</div><h2 class="mt-2 text-xl font-semibold tracking-tight text-slate-950"><a href="{{ route('pengumuman.show', $announcement) }}" class="hover:text-primary-700">{{ $announcement->title }}</a></h2></div>
                    <a href="{{ route('pengumuman.show', $announcement) }}" aria-label="Baca {{ $announcement->title }}" class="flex size-10 shrink-0 items-center justify-center rounded-full text-primary-700 hover:bg-primary-50"><x-icon name="arrow-right" class="size-5" /></a>
                </article>
            @empty
                <x-empty-state icon="megaphone" title="Belum ada pengumuman" />
            @endforelse
        </div><div class="mt-10">{{ $announcements->links() }}</div>
    </div></section>
</x-layouts.app>
