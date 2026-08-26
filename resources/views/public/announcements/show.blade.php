<x-layouts.app :title="$announcement->seo_title ?: $announcement->title" :description="$announcement->seo_description">
    <article class="bg-white py-14 sm:py-20"><div class="container-app max-w-5xl">
        <a href="{{ route('pengumuman.index') }}" class="inline-flex items-center gap-2 font-medium text-primary-700"><x-icon name="arrow-left" class="size-4" /> Kembali ke pengumuman</a>
        <header class="mt-8 max-w-3xl"><div class="flex items-center gap-3 text-base text-slate-500"><time>{{ $announcement->publish_date->translatedFormat('d F Y') }}</time>@if($announcement->is_important)<span class="rounded-full bg-gold-100 px-3 py-1 font-medium text-gold-900">Penting</span>@endif</div><h1 class="mt-4 text-pretty text-3xl font-semibold tracking-tight text-slate-950 sm:text-5xl sm:leading-[1.05]">{{ $announcement->title }}</h1></header>
        <div class="prose-content mt-10 max-w-[70ch] text-base leading-7">{!! clean($announcement->body) !!}</div>
        @if($announcement->attachment)<a href="{{ asset('storage/'.$announcement->attachment) }}" class="btn-outline mt-10" download><x-icon name="download" class="size-4" /> Unduh lampiran</a>@endif
    </div></article>
</x-layouts.app>
