@php
    $routeName = $post->type === 'artikel' ? 'artikel.index' : 'berita.index';
    $schema = ['@context' => 'https://schema.org', '@type' => $post->type === 'berita' ? 'NewsArticle' : 'Article', 'headline' => $post->title, 'datePublished' => optional($post->published_at)->toIso8601String(), 'dateModified' => $post->updated_at->toIso8601String()];
@endphp
<x-layouts.app :title="$post->seo_title ?: $post->title" :description="$post->seo_description ?: $post->excerpt" :image="$post->og_image ?: $post->cover" type="article" :schema="$schema">
    <article class="bg-white py-14 sm:py-20">
        <div class="container-app">
            <nav aria-label="Breadcrumb" class="mb-7 flex items-center gap-2 text-base text-slate-500"><a href="{{ route('home') }}" class="hover:text-primary-700">Beranda</a><x-icon name="chevron-right" class="size-4 shrink-0" /><a href="{{ route($routeName) }}" class="hover:text-primary-700">{{ $section }}</a></nav>
            <header class="max-w-4xl">
                @if ($post->category)<p class="font-medium text-primary-700">{{ $post->category->name }}</p>@endif
                <h1 class="mt-3 max-w-[24ch] text-pretty text-3xl font-semibold tracking-tight text-slate-950 sm:text-5xl sm:leading-[1.05]">{{ $post->title }}</h1>
                <div class="mt-6 flex flex-wrap items-center gap-3 text-base text-slate-500">
                    <time datetime="{{ optional($post->published_at)->toDateString() }}">{{ optional($post->published_at)->translatedFormat('d F Y') }}</time><span aria-hidden="true">·</span><span>{{ $post->reading_time }} menit baca</span><span aria-hidden="true">·</span><span>{{ number_format($post->views) }} kali dilihat</span>
                </div>
            </header>
            @if ($post->cover)<img src="{{ asset('storage/'.$post->cover) }}" alt="" class="mt-10 aspect-[16/8] w-full rounded-[min(2vw,1rem)] object-cover outline outline-1 -outline-offset-1 outline-black/5">@endif
            <div class="prose-content mt-10 max-w-[70ch] text-base leading-7">{!! clean($post->body) !!}</div>
            @if ($post->tags->isNotEmpty())
                <ul role="list" class="mt-10 flex flex-wrap gap-2">@foreach ($post->tags as $tag)<li class="rounded-full bg-primary-50 px-3 py-1 text-sm font-medium text-primary-800">{{ $tag->name }}</li>@endforeach</ul>
            @endif
        </div>
    </article>
    @if ($related->isNotEmpty())
        <section class="py-14 sm:py-20"><div class="container-app"><x-section-header title="Bacaan lainnya" /><div class="mt-8 grid gap-6 md:grid-cols-3">@foreach ($related as $item)<x-post-card :post="$item" />@endforeach</div></div></section>
    @endif
</x-layouts.app>
