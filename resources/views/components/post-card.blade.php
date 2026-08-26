@props(['post'])

<article class="group flex h-full flex-col overflow-hidden rounded-2xl bg-white ring-1 ring-slate-900/10">
    <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}" class="relative aspect-[16/10] overflow-hidden bg-primary-950">
        @if ($post->cover)
            <img src="{{ asset('storage/'.$post->cover) }}" alt="" class="size-full object-cover transition duration-300 group-hover:scale-[1.02]">
        @else
            <div class="flex size-full items-end bg-[radial-gradient(circle_at_top_right,_rgba(212,175,55,.3),_transparent_38%),linear-gradient(145deg,#064e3b,#022c22)] p-6">
                <x-icon name="newspaper" class="size-8 text-gold-300" />
            </div>
        @endif
    </a>
    <div class="flex flex-1 flex-col gap-3 p-5">
        <div class="flex items-center gap-2 text-sm text-slate-500">
            @if ($post->category)
                <span class="font-medium text-primary-700">{{ $post->category->name }}</span>
                <span aria-hidden="true">·</span>
            @endif
            <time datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->translatedFormat('d M Y') }}</time>
        </div>
        <h2 class="text-balance text-xl font-semibold tracking-tight text-slate-950">
            <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}" class="hover:text-primary-700">{{ $post->title }}</a>
        </h2>
        <p class="line-clamp-3 text-pretty text-base text-slate-600">{{ $post->excerpt }}</p>
        <a href="{{ route($post->type === 'artikel' ? 'artikel.show' : 'berita.show', $post) }}" class="mt-auto inline-flex items-center gap-2 pt-2 font-medium text-primary-700 hover:text-primary-800">
            Baca selengkapnya <x-icon name="arrow-right" class="size-4 shrink-0" />
        </a>
    </div>
</article>
