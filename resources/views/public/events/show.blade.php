<x-layouts.app :title="$event->title" :description="$event->description">
    <article class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-4xl space-y-8">
            <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-primary-700 hover:text-primary-800">
                <x-icon name="arrow-left" class="size-4" />
                <span>Kembali ke Semua Agenda</span>
            </a>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-12 shadow-soft space-y-8">
                <header class="space-y-3 pb-6 border-b border-slate-100">
                    <span class="rounded-full bg-primary-100 px-3 py-1 text-xs font-bold text-primary-800">
                        {{ ucfirst($event->category) }}
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-950 leading-tight">
                        {{ $event->title }}
                    </h1>
                </header>

                {{-- Key Information Grid --}}
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tanggal Pelaksanaan</span>
                        <p class="mt-1 font-bold text-slate-900 text-sm flex items-center gap-2">
                            <x-icon name="calendar" class="size-4 text-primary-600" />
                            <span>{{ $event->start_date->translatedFormat('d F Y') }}</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Waktu Acara</span>
                        <p class="mt-1 font-bold text-slate-900 text-sm flex items-center gap-2">
                            <x-icon name="clock" class="size-4 text-gold-600" />
                            <span>{{ $event->start_time ? $event->start_time->format('H:i').' WIB' : 'Menyesuaikan' }}</span>
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Lokasi / Tempat</span>
                        <p class="mt-1 font-bold text-slate-900 text-sm flex items-center gap-2">
                            <x-icon name="map-pin" class="size-4 text-emerald-600" />
                            <span class="truncate">{{ $event->location ?: 'MA Ma\'arif NU Assa\'adah' }}</span>
                        </p>
                    </div>
                </div>

                @if($event->description)
                    <div class="prose-content max-w-none text-slate-700 leading-relaxed text-base pt-2">
                        <p class="whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </article>
</x-layouts.app>

