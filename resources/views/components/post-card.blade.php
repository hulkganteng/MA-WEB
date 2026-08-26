@props(['post'])

<article class="interactive-card group flex h-full flex-col">
    <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}"
       class="relative aspect-[16/10] overflow-hidden bg-slate-900">
        @if ($post->cover)
            <img src="{{ asset('storage/'.$post->cover) }}" alt="{{ $post->title }}"
                 class="size-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="flex size-full flex-col justify-between bg-gradient-to-br from-[#006437] via-[#007a34] to-[#00923F] p-6">
                <div class="flex items-center justify-between">
                    <span class="inline-flex size-10 items-center justify-center rounded-xl bg-gold-400 text-[#1F1A17] font-bold">
                        <x-icon name="{{ $post->type === 'artikel' ? 'file-text' : 'newspaper' }}" class="size-5" />
                    </span>
                    <span class="font-arabic text-xl text-white/30 select-none">العلم نور</span>
                </div>
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gold-300">MA Assa'adah Bungah</span>
                    <p class="text-xs text-white/90 line-clamp-1 font-medium">{{ $post->title }}</p>
                </div>
            </div>
        @endif

        {{-- Type / Category Floating Badge --}}
        <div class="absolute top-3 left-3 flex items-center gap-1.5">
            @if ($post->category)
                <span class="rounded-full bg-[#006437]/90 px-2.5 py-1 text-[11px] font-bold text-white backdrop-blur border border-white/20">
                    {{ $post->category->name }}
                </span>
            @endif
            <span class="rounded-full {{ $post->type === 'artikel' ? 'bg-gold-400 text-[#1F1A17]' : 'bg-primary-600 text-white' }} px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider shadow">
                {{ $post->type }}
            </span>
        </div>
    </a>

    <div class="flex flex-1 flex-col justify-between p-6">
        <div class="space-y-3">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                <x-icon name="calendar" class="size-3.5 text-primary-600" />
                <time datetime="{{ optional($post->published_at)->toDateString() }}">
                    {{ optional($post->published_at)->translatedFormat('d F Y') }}
                </time>
                <span>·</span>
                <span class="flex items-center gap-1">
                    <x-icon name="clock" class="size-3.5 text-slate-400" />
                    <span>{{ max(1, ceil(str_word_count(strip_tags($post->content ?? $post->excerpt ?? '')) / 200)) }} mnt baca</span>
                </span>
            </div>

            <h2 class="text-lg font-bold tracking-tight text-[#1F1A17] group-hover:text-primary-700 transition line-clamp-2">
                <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="line-clamp-3 text-sm leading-relaxed text-slate-600">
                {{ $post->excerpt }}
            </p>
        </div>

        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-primary-700 transition group-hover:text-primary-800">
                <span>Baca Lengkap</span>
                <x-icon name="arrow-right" class="size-3.5 transition group-hover:translate-x-1" />
            </a>
            <span class="text-[11px] font-medium text-slate-400">
                {{ optional($post->author)->name ?? 'Humas MA Assa\'adah' }}
            </span>
        </div>
    </div>
</article>

