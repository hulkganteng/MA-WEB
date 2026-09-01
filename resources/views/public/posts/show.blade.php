@php
    $routeName = $post->type === 'artikel' ? 'artikel.index' : 'berita.index';
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => $post->type === 'berita' ? 'NewsArticle' : 'Article',
        '@id' => url()->current().'#article',
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
        'headline' => $post->title,
        'description' => strip_tags($post->seo_description ?: $post->excerpt),
        'image' => $post->og_image || $post->cover
            ? [filter_var($post->og_image ?: $post->cover, FILTER_VALIDATE_URL) ? ($post->og_image ?: $post->cover) : asset('storage/'.($post->og_image ?: $post->cover))]
            : [],
        'datePublished' => optional($post->published_at)->toIso8601String(),
        'dateModified' => $post->updated_at->toIso8601String(),
        'author' => ['@type' => 'Person', 'name' => $post->author?->name ?: setting('site.name')],
        'publisher' => ['@id' => url('/').'#organization'],
        'isPartOf' => ['@id' => url('/').'#website'],
        'inLanguage' => 'id-ID',
    ];
@endphp
<x-layouts.app :title="$post->seo_title ?: $post->title" :description="$post->seo_description ?: $post->excerpt" :image="$post->og_image ?: $post->cover" type="article" :schema="$schema">
    <article class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app max-w-4xl space-y-8">
            {{-- Breadcrumb Navigation --}}
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-slate-500 font-semibold">
                <a href="{{ route('home') }}" class="hover:text-primary-700">Beranda</a>
                <x-icon name="chevron-right" class="size-3.5 text-slate-400 shrink-0" />
                <a href="{{ route($routeName) }}" class="hover:text-primary-700">{{ $section }}</a>
                @if ($post->category)
                    <x-icon name="chevron-right" class="size-3.5 text-slate-400 shrink-0" />
                    <span class="text-primary-700">{{ $post->category->name }}</span>
                @endif
            </nav>

            {{-- Main Post Content Card --}}
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-12 shadow-soft space-y-8">
                <header class="space-y-4">
                    @if ($post->category)
                        <span class="inline-block rounded-full bg-primary-100 px-3 py-1 text-xs font-bold text-primary-800">
                            {{ $post->category->name }}
                        </span>
                    @endif

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-950 leading-tight">
                        {{ $post->title }}
                    </h1>

                    {{-- Meta Badges --}}
                    <div class="flex flex-wrap items-center gap-4 pt-2 border-t border-slate-100 text-xs text-slate-500">
                        <span class="flex items-center gap-1.5 font-medium">
                            <x-icon name="calendar" class="size-3.5 text-slate-400" />
                            <time datetime="{{ optional($post->published_at)->toDateString() }}">
                                {{ optional($post->published_at)->translatedFormat('d F Y') }}
                            </time>
                        </span>
                        <span class="flex items-center gap-1.5 font-medium">
                            <x-icon name="clock" class="size-3.5 text-slate-400" />
                            <span>{{ $post->reading_time }} menit baca</span>
                        </span>
                        <span class="flex items-center gap-1.5 font-medium">
                            <x-icon name="eye" class="size-3.5 text-slate-400" />
                            <span>{{ number_format($post->views) }} kali dibaca</span>
                        </span>
                        @if($post->author)
                            <span class="flex items-center gap-1.5 font-medium text-slate-700">
                                <x-icon name="user" class="size-3.5 text-primary-600" />
                                <span>Oleh: {{ $post->author->name }}</span>
                            </span>
                        @endif
                    </div>
                </header>

                @if ($post->cover)
                    <div class="relative overflow-hidden rounded-2xl border border-slate-100">
                        <img src="{{ asset('storage/'.$post->cover) }}" alt="{{ $post->title }}"
                             loading="eager" decoding="async" fetchpriority="high"
                             class="aspect-[16/9] w-full object-cover">
                    </div>
                @endif

                {{-- Post Body --}}
                <div class="prose-content max-w-none text-slate-700 leading-relaxed text-base">
                    {!! clean($post->body) !!}
                </div>

                {{-- Tags --}}
                @if ($post->tags->isNotEmpty())
                    <div class="pt-6 border-t border-slate-100">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2.5">Topik Terkait:</p>
                        <ul role="list" class="flex flex-wrap gap-2">
                            @foreach ($post->tags as $tag)
                                <li class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-primary-50 hover:text-primary-800 transition">
                                    #{{ $tag->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Share Toolbar --}}
                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        <x-icon name="share-2" class="size-4 text-slate-500" />
                        <span>Bagikan Informasi:</span>
                    </span>

                    <div class="flex items-center gap-2">
                        <a href="https://wa.me/?text={{ urlencode($post->title.' - '.request()->url()) }}"
                           target="_blank" rel="noopener"
                           class="flex items-center gap-1.5 rounded-xl bg-[#25D366] px-3 py-1.5 text-xs font-bold text-white shadow-soft hover:brightness-105 transition">
                            <x-icon name="message-circle" class="size-3.5" /> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank" rel="noopener"
                           class="flex items-center gap-1.5 rounded-xl bg-[#1877F2] px-3 py-1.5 text-xs font-bold text-white shadow-soft hover:brightness-105 transition">
                            Facebook
                        </a>
                        <button type="button"
                                @click="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!')"
                                class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                            <x-icon name="copy" class="size-3.5" /> Salin Tautan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </article>

    {{-- Related Posts --}}
    @if ($related->isNotEmpty())
        <section class="bg-white py-16">
            <div class="container-app space-y-8">
                <x-section-header eyebrow="Kabar Lainnya" title="Bacaan Terkait" />
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($related as $item)
                        <x-post-card :post="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
