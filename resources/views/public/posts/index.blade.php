<x-layouts.app :title="$title" :description="$description">
    <x-page-header eyebrow="Publikasi & Literasi" :title="$title" :description="$description" />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-10">
            @if ($type === 'berita' && $categories->isNotEmpty())
                <nav aria-label="Filter kategori" class="overflow-x-auto pb-2">
                    <div class="flex min-w-max items-center gap-2 rounded-2xl border border-slate-200/80 bg-white p-2.5 shadow-soft">
                        <a href="{{ route('berita.index') }}"
                           class="rounded-xl px-4 py-2 text-xs font-bold transition {{ !request('kategori') ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                            Semua Berita
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('berita.index', ['kategori' => $category->slug]) }}"
                               class="rounded-xl px-4 py-2 text-xs font-bold transition {{ request('kategori') === $category->slug ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            @endif

            @if ($posts->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="mt-10">{{ $posts->links() }}</div>
            @else
                <x-empty-state icon="newspaper" title="Belum ada {{ strtolower($title) }}" description="Konten akan tampil setelah dipublikasikan melalui CMS madrasah." />
            @endif
        </div>
    </section>
</x-layouts.app>

