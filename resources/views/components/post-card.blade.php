@props(['post'])

<article class="group flex h-full flex-col overflow-hidden rounded-xl bg-white border border-slate-200 shadow-sm hover:border-primary-500 hover:shadow-md transition-all duration-200">
    <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}" class="relative aspect-[16/10] overflow-hidden bg-primary-950">
        @if ($post->cover)
            <img src="{{ asset('storage/'.$post->cover) }}" alt="{{ $post->title }}" class="size-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex size-full items-center justify-center bg-primary-950 p-6">
                <x-icon name="newspaper" class="size-8 text-primary-400" />
            </div>
        @endif
    </a>
    <div class="flex flex-1 flex-col gap-2.5 p-5">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            @if ($post->category)
                <span class="font-semibold text-primary-700">{{ $post->category->name }}</span>
                <span aria-hidden="true">·</span>
            @endif
            <time datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->translatedFormat('d M Y') }}</time>
        </div>
        <h2 class="text-base sm:text-lg font-bold tracking-tight text-slate-900 group-hover:text-primary-700 transition-colors line-clamp-2">
            <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}">{{ $post->title }}</a>
        </h2>
        <p class="line-clamp-2 text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $post->excerpt }}</p>
        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-primary-700">
            <span>Baca selengkapnya</span>
            <x-icon name="arrow-right" class="size-3.5 transform transition group-hover:translate-x-1" />
        </div>
    </div>
</article>
