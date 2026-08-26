<x-layouts.app :title="$title" :description="$description">
    <x-page-header :title="$title" :description="$description" />
    <section class="py-14 sm:py-20">
        <div class="container-app">
            @if ($type === 'berita' && $categories->isNotEmpty())
                <nav aria-label="Filter kategori" class="mb-8 overflow-x-auto pb-2">
                    <div class="flex min-w-max gap-2">
                        <a href="{{ route('berita.index') }}" class="rounded-full px-4 py-2 font-medium {{ request('kategori') ? 'bg-white text-slate-700 ring-1 ring-slate-900/10' : 'bg-primary-700 text-white' }}">Semua</a>
                        @foreach ($categories as $category)
                            <a href="{{ route('berita.index', ['kategori' => $category->slug]) }}" class="rounded-full px-4 py-2 font-medium {{ request('kategori') === $category->slug ? 'bg-primary-700 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-900/10' }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </nav>
            @endif

            @if ($posts->isNotEmpty())
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">@foreach ($posts as $post)<x-post-card :post="$post" />@endforeach</div>
                <div class="mt-10">{{ $posts->links() }}</div>
            @else
                <x-empty-state icon="newspaper" title="Belum ada {{ strtolower($title) }}" description="Konten akan tampil setelah dipublikasikan." />
            @endif
        </div>
    </section>
</x-layouts.app>
