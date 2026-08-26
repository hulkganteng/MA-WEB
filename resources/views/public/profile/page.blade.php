<x-layouts.app :title="$page?->seo_title ?: $title" :description="$page?->seo_description ?: $description" :image="$page?->cover">
    <x-page-header eyebrow="Profil" :title="$page?->title ?: $title" :description="$description" />
    <section class="bg-white py-14 sm:py-20"><div class="container-app grid gap-10 lg:grid-cols-[2fr_1fr]">
        <article>
            @if($page?->cover)<img src="{{ asset('storage/'.$page->cover) }}" alt="" class="mb-10 aspect-[16/8] w-full rounded-[min(2vw,1rem)] object-cover outline outline-1 -outline-offset-1 outline-black/5">@endif
            @if($page?->body)<div class="prose-content max-w-[72ch] text-base leading-7">{!! clean($page->body) !!}</div>@else<x-empty-state icon="file-text" title="Konten profil sedang dilengkapi" description="Pengelola dapat menambahkan konten halaman ini melalui CMS." />@endif
        </article>
        <aside class="h-fit rounded-2xl bg-primary-50 p-6"><h2 class="text-xl font-semibold text-primary-950">Profil madrasah</h2><nav class="mt-5 flex flex-col gap-1">@foreach([['about','Tentang madrasah'],['sejarah','Sejarah'],['visi-misi','Visi dan misi'],['sambutan','Sambutan kepala'],['structure','Struktur organisasi'],['guru.index','Guru dan tendik'],['facilities','Sarana dan prasarana']] as [$route,$label])<a href="{{ route($route) }}" class="rounded-lg px-3 py-2 font-medium {{ request()->routeIs($route) ? 'bg-white text-primary-800 ring-1 ring-primary-900/10' : 'text-slate-700 hover:bg-white/70' }}">{{ $label }}</a>@endforeach</nav></aside>
    </div></section>
</x-layouts.app>
