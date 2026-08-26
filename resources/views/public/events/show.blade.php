<x-layouts.app :title="$event->title" :description="$event->description">
    <article class="bg-white py-14 sm:py-20"><div class="container-app max-w-5xl">
        <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 font-medium text-primary-700"><x-icon name="arrow-left" class="size-4" /> Kembali ke agenda</a>
        <header class="mt-8 max-w-3xl"><p class="font-medium text-primary-700">{{ ucfirst($event->category) }}</p><h1 class="mt-3 text-pretty text-3xl font-semibold tracking-tight text-slate-950 sm:text-5xl sm:leading-[1.05]">{{ $event->title }}</h1></header>
        <dl class="mt-10 grid gap-6 rounded-2xl bg-primary-50 p-6 sm:grid-cols-3"><div><dt class="font-medium text-primary-900">Tanggal</dt><dd class="mt-1 text-base text-slate-700">{{ $event->start_date->translatedFormat('d F Y') }}</dd></div><div><dt class="font-medium text-primary-900">Waktu</dt><dd class="mt-1 text-base text-slate-700">{{ $event->start_time ? $event->start_time->format('H:i').' WIB' : 'Akan diinformasikan' }}</dd></div><div><dt class="font-medium text-primary-900">Lokasi</dt><dd class="mt-1 text-base text-slate-700">{{ $event->location ?: 'MA Ma’arif NU Assa’adah' }}</dd></div></dl>
        @if($event->description)<p class="mt-10 max-w-[70ch] whitespace-pre-line text-pretty text-base leading-7 text-slate-700">{{ $event->description }}</p>@endif
    </div></article>
</x-layouts.app>
