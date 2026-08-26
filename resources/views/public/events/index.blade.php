<x-layouts.app title="Agenda" description="Jadwal kegiatan akademik dan kesiswaan madrasah.">
    <x-page-header title="Agenda madrasah" description="Jadwal kegiatan akademik, keagamaan, dan kesiswaan." />
    <section class="py-14 sm:py-20"><div class="container-app max-w-5xl">
        <div class="flex flex-col gap-4">
            @forelse ($events as $event)
                <article class="flex flex-col gap-5 rounded-2xl bg-white p-6 ring-1 ring-slate-900/10 sm:flex-row sm:items-center">
                    <time class="flex size-16 shrink-0 flex-col items-center justify-center rounded-xl bg-primary-950 text-center text-white" datetime="{{ $event->start_date->toDateString() }}"><span class="text-2xl font-semibold tabular-nums">{{ $event->start_date->format('d') }}</span><span class="text-sm text-primary-200">{{ $event->start_date->translatedFormat('M') }}</span></time>
                    <div class="min-w-0 flex-1"><p class="font-medium text-primary-700">{{ ucfirst($event->category) }}</p><h2 class="mt-1 text-xl font-semibold tracking-tight text-slate-950"><a href="{{ route('agenda.show', $event) }}" class="hover:text-primary-700">{{ $event->title }}</a></h2><p class="mt-2 flex items-center gap-2 text-base text-slate-500"><x-icon name="map-pin" class="size-4 shrink-0" />{{ $event->location ?: 'MA Ma’arif NU Assa’adah' }}</p></div>
                    <a href="{{ route('agenda.show', $event) }}" class="inline-flex items-center gap-2 font-medium text-primary-700">Lihat detail <x-icon name="arrow-right" class="size-4" /></a>
                </article>
            @empty
                <x-empty-state icon="calendar-days" title="Belum ada agenda" description="Agenda kegiatan akan tampil di halaman ini." />
            @endforelse
        </div><div class="mt-10">{{ $events->links() }}</div>
    </div></section>
</x-layouts.app>
