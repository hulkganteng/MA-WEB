<x-layouts.app :title="$page?->seo_title ?: $title" :description="$page?->seo_description ?: $description" :image="$page?->cover">
    <x-page-header eyebrow="Profil Madrasah" :title="$page?->title ?: $title" :description="$description" />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app grid gap-10 lg:grid-cols-12">
            {{-- Main Content Column --}}
            <article class="lg:col-span-8 space-y-8">
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-soft">
                    @if($page?->cover)
                        <div class="relative mb-8 overflow-hidden rounded-2xl border border-slate-100">
                            <img src="{{ asset('storage/'.$page->cover) }}" alt="{{ $page->title }}"
                                 class="aspect-[16/8] w-full object-cover">
                        </div>
                    @endif

                    @if($page?->body)
                        <div class="prose-content max-w-none text-slate-700 leading-relaxed">
                            {!! clean($page->body) !!}
                        </div>
                    @else
                        <x-empty-state icon="file-text" title="Konten profil sedang dilengkapi" description="Informasi resmi madrasah akan segera diperbarui." />
                    @endif
                </div>

                {{-- Interactive Accreditation Seal --}}
                <div class="rounded-3xl border border-white/20 bg-primary-800 p-6 text-white shadow-lift flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl bg-gold-400 text-[#1F1A17] font-bold">
                            <x-icon name="shield-check" class="size-6" />
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-white">Akreditasi A BAN-S/M Unggul</h4>
                            <p class="text-xs text-primary-100">MA Ma'arif NU Assa'adah Bungah Gresik · NPSN: 20580225</p>
                        </div>
                    </div>
                    <button type="button" @click="$store.spmbCalc.open()" class="btn-gold font-bold shrink-0 shadow-soft">
                        <x-icon name="sparkles" class="size-4" /> Simulasi SPMB
                    </button>
                </div>
            </article>

            {{-- Sidebar Navigation Column --}}
            <aside class="lg:col-span-4 space-y-6">
                <div class="sticky top-28 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-soft">
                    <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                        <span class="flex size-8 items-center justify-center rounded-xl bg-primary-100 text-primary-700 font-bold">
                            <x-icon name="compass" class="size-4" />
                        </span>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Navigasi Profil</h3>
                    </div>

                    <nav class="mt-4 flex flex-col gap-1.5">
                        @foreach([
                            ['about', 'Tentang Madrasah', 'school'],
                            ['sejarah', 'Sejarah Pesantren & MA (1972)', 'history'],
                            ['visi-misi', 'Visi, Misi & Karakter', 'target'],
                            ['sambutan', 'Sambutan Kepala Madrasah', 'user'],
                            ['structure', 'Struktur Organisasi', 'network'],
                            ['guru.index', 'Direktori Guru & Tendik', 'users'],
                            ['facilities', 'Sarana & Prasarana', 'building'],
                        ] as [$route, $label, $icon])
                            <a href="{{ route($route) }}"
                               class="group flex items-center justify-between rounded-xl px-3.5 py-3 text-xs font-semibold transition {{ request()->routeIs($route) ? 'border border-primary-500/30 bg-primary-50 text-primary-900 shadow-soft' : 'text-slate-700 hover:bg-slate-50 hover:text-primary-700' }}">
                                <div class="flex items-center gap-2.5">
                                    <x-icon :name="$icon" class="size-4 {{ request()->routeIs($route) ? 'text-primary-600' : 'text-slate-400 group-hover:text-primary-600' }}" />
                                    <span>{{ $label }}</span>
                                </div>
                                <x-icon name="chevron-right" class="size-3.5 {{ request()->routeIs($route) ? 'text-primary-600' : 'text-slate-300' }} transition group-hover:translate-x-0.5" />
                            </a>
                        @endforeach
                    </nav>

                    <div class="mt-6 pt-5 border-t border-slate-100">
                        <div class="rounded-2xl border border-gold-400/30 bg-gold-50/70 p-4 text-xs">
                            <span class="font-bold text-gold-950 flex items-center gap-1.5">
                                <x-icon name="landmark" class="size-4 text-gold-700" />
                                <span>Pondok Pesantren Qomaruddin</span>
                            </span>
                            <p class="mt-1 text-slate-600 leading-relaxed">
                                Pesantren tertua di Bungah Gresik yang didirikan oleh K.H. Qomaruddin pada tahun 1775 M.
                            </p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
