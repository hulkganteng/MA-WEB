<x-layouts.app title="Kalender Akademik 2026/2027" description="Jadwal agenda, ujian, masa ta'aruf, dan kalender pendidikan MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Jadwal & Agenda Pendidikan"
                   title="Kalender Akademik 2026/2027"
                   description="Jadwal kegiatan belajar mengajar, asesmen sumatif, ujian CBT, masa ta'aruf santri, dan libur pesantren." />

    <section class="bg-slate-50/60 py-14 sm:py-20"
             x-data="{
                 filterCategory: 'all',
                 matchItem(cat) {
                     return this.filterCategory === 'all' || this.filterCategory === cat;
                 }
             }">

        <div class="container-app max-w-5xl space-y-8">
            {{-- Category Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-3 shadow-soft">
                <button type="button" @click="filterCategory = 'all'"
                        class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition"
                        :class="filterCategory === 'all' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                    Semua Agenda
                </button>
                <button type="button" @click="filterCategory = 'kegiatan'"
                        class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition"
                        :class="filterCategory === 'kegiatan' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                    Kegiatan Santri
                </button>
                <button type="button" @click="filterCategory = 'ujian'"
                        class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition"
                        :class="filterCategory === 'ujian' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                    Ujian / Asesmen
                </button>
                <button type="button" @click="filterCategory = 'libur'"
                        class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition"
                        :class="filterCategory === 'libur' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                    Libur Madrasah
                </button>
                <button type="button" @click="filterCategory = 'rapat'"
                        class="rounded-xl px-3.5 py-1.5 text-xs font-bold transition"
                        :class="filterCategory === 'rapat' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                    Rapat & Evaluasi
                </button>
            </div>

            {{-- Events Timeline List --}}
            <div class="space-y-4">
                @forelse($events as $event)
                    <article class="interactive-card flex flex-col sm:flex-row items-start sm:items-center gap-6 p-6"
                             x-show="matchItem('{{ $event->category }}')">
                        {{-- Date Badge Block --}}
                        <div class="flex size-16 shrink-0 flex-col items-center justify-center rounded-2xl bg-gradient-to-br from-primary-800 to-primary-950 p-2 text-center text-white shadow-soft">
                            <span class="font-mono text-xl font-extrabold leading-none text-gold-300">{{ $event->start_date->format('d') }}</span>
                            <span class="text-[10px] uppercase font-bold text-primary-200 mt-0.5">{{ $event->start_date->translatedFormat('M Y') }}</span>
                        </div>

                        {{-- Event Info --}}
                        <div class="min-w-0 flex-1 space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-primary-100 px-2.5 py-0.5 text-[10px] font-bold text-primary-800 uppercase tracking-wider">
                                    {{ ucfirst($event->category) }}
                                </span>
                                @if($event->end_date && !$event->end_date->equalTo($event->start_date))
                                    <span class="text-xs text-slate-500 font-medium">
                                        s.d. {{ $event->end_date->translatedFormat('d F Y') }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-base font-bold text-slate-950">
                                {{ $event->title }}
                            </h2>

                            @if($event->description)
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ $event->description }}
                                </p>
                            @endif
                        </div>
                    </article>
                @empty
                    <x-empty-state icon="calendar-days" title="Kalender akademik belum tersedia" description="Jadwal kalender pendidikan sedang diperbarui." />
                @endforelse
            </div>

            <div class="mt-8">{{ $events->links() }}</div>
        </div>
    </section>
</x-layouts.app>
