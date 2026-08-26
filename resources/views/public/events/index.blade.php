<x-layouts.app title="Agenda & Kegiatan Madrasah" description="Jadwal kegiatan akademik, keagamaan, lomba, dan peringatan hari besar Islam di MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Kalender Kegiatan"
                   title="Agenda & Jadwal Kegiatan"
                   description="Informasi waktu pelaksanaan agenda madrasah, peringatan hari besar Islam, seminar, dan perlombaan." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-4xl space-y-6">
            <div class="space-y-4">
                @forelse ($events as $event)
                    <article class="interactive-card group flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 p-6 bg-white border border-slate-200/90">
                        <div class="flex items-start gap-4 min-w-0">
                            {{-- Date Block --}}
                            <time class="flex size-14 shrink-0 flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-primary-600 via-primary-700 to-[#006437] p-1.5 text-center text-white shadow-soft"
                                  datetime="{{ $event->start_date->toDateString() }}">
                                <span class="font-mono text-xl font-bold leading-none text-gold-300">{{ $event->start_date->format('d') }}</span>
                                <span class="text-[10px] uppercase font-bold text-primary-100 mt-0.5">{{ $event->start_date->translatedFormat('M') }}</span>
                            </time>

                            <div class="space-y-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="rounded-full bg-primary-50 px-2.5 py-0.5 text-[10px] font-bold text-primary-800 uppercase tracking-wider">
                                        {{ ucfirst($event->category) }}
                                    </span>
                                </div>

                                <h2 class="text-base font-bold tracking-tight text-[#1F1A17] group-hover:text-primary-700 transition">
                                    <a href="{{ route('agenda.show', $event) }}">
                                        {{ $event->title }}
                                    </a>
                                </h2>

                                <p class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <x-icon name="map-pin" class="size-3.5 text-slate-400 shrink-0" />
                                    <span>{{ $event->location ?: 'Kompleks Pesantren Qomaruddin' }}</span>
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('agenda.show', $event) }}"
                           class="btn-outline shrink-0 !py-2 !px-4 text-xs font-semibold self-end sm:self-center">
                            <span>Detail Agenda</span>
                            <x-icon name="arrow-right" class="size-3.5" />
                        </a>
                    </article>
                @empty
                    <x-empty-state icon="calendar-days" title="Belum ada agenda" description="Agenda kegiatan madrasah akan tampil di halaman ini." />
                @endforelse
            </div>

            <div class="mt-8">{{ $events->links() }}</div>
        </div>
    </section>
</x-layouts.app>

