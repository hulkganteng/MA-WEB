<x-layouts.app title="Guru & Tenaga Kependidikan" description="Direktori pendidik dan tenaga kependidikan MA Ma'arif NU Assa'adah Bungah Gresik.">
    <x-page-header eyebrow="Sumber Daya Pendidik"
                   title="Guru & Tenaga Kependidikan"
                   description="Mengenal para asatidz, dewan guru bersertifikasi, dan tenaga kependidikan berdedikasi yang mendampingi santri." />

    <section class="bg-slate-50/60 py-14 sm:py-20"
             x-data="{
                 search: '',
                 activeTab: 'all',
                 filterItem(name, position, subject, type) {
                     const q = this.search.toLowerCase();
                     const matchQuery = !q || name.toLowerCase().includes(q) || position.toLowerCase().includes(q) || subject.toLowerCase().includes(q);
                     const matchTab = this.activeTab === 'all' || this.activeTab === type;
                     return matchQuery && matchTab;
                 }
             }">

        <div class="container-app space-y-10">
            {{-- Filter & Search Toolbar --}}
            <div class="flex flex-col gap-4 rounded-3xl border border-slate-200/80 bg-white p-4 shadow-soft sm:flex-row sm:items-center sm:justify-between">
                {{-- Tabs --}}
                <div class="flex flex-wrap items-center gap-1.5">
                    <button type="button"
                            @click="activeTab = 'all'"
                            class="rounded-xl px-4 py-2 text-xs font-bold transition"
                            :class="activeTab === 'all' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                        Semua Pendidik
                    </button>
                    <button type="button"
                            @click="activeTab = 'guru'"
                            class="rounded-xl px-4 py-2 text-xs font-bold transition"
                            :class="activeTab === 'guru' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                        Dewan Guru ({{ $teachers->get('guru', collect())->count() }})
                    </button>
                    <button type="button"
                            @click="activeTab = 'tendik'"
                            class="rounded-xl px-4 py-2 text-xs font-bold transition"
                            :class="activeTab === 'tendik' ? 'bg-primary-600 text-white shadow-soft' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'">
                        Tenaga Kependidikan ({{ $teachers->get('tendik', collect())->count() }})
                    </button>
                </div>

                {{-- Search Input --}}
                <div class="relative w-full sm:w-72">
                    <x-icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 size-4 text-slate-400" />
                    <input type="text"
                           x-model="search"
                           placeholder="Cari nama, mapel, jabatan..."
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-10 pr-4 text-xs text-slate-800 placeholder:text-slate-400 focus:border-primary-500 focus:bg-white focus:outline-none">
                </div>
            </div>

            {{-- Teachers & Staff Grid --}}
            @foreach(['guru' => 'Dewan Guru Madrasah', 'tendik' => 'Tenaga Kependidikan & Tata Usaha'] as $type => $label)
                <div class="space-y-6" x-show="activeTab === 'all' || activeTab === '{{ $type }}'">
                    <div class="flex items-center gap-3">
                        <span class="flex size-8 items-center justify-center rounded-xl {{ $type === 'guru' ? 'bg-emerald-100 text-emerald-800' : 'bg-gold-100 text-gold-800' }} font-bold">
                            <x-icon :name="$type === 'guru' ? 'graduation-cap' : 'briefcase'" class="size-4" />
                        </span>
                        <h2 class="text-xl font-bold tracking-tight text-slate-950">{{ $label }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @forelse($teachers->get($type, collect()) as $teacher)
                            <div class="interactive-card group flex flex-col justify-between p-4 sm:p-5"
                                 x-show="filterItem('{{ addslashes($teacher->name) }}', '{{ addslashes($teacher->position ?? '') }}', '{{ addslashes($teacher->subject ?? '') }}', '{{ $type }}')">
                                <div>
                                    <div class="relative mx-auto aspect-[4/5] w-full overflow-hidden rounded-2xl bg-slate-900 shadow-soft">
                                        @if($teacher->photo)
                                            <img src="{{ asset('storage/'.$teacher->photo) }}" alt="{{ $teacher->name }}"
                                                 loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                        @else
                                            <div class="flex size-full flex-col items-center justify-center bg-gradient-to-br from-primary-900 to-slate-950 text-gold-300">
                                                <x-icon name="user" class="size-12" />
                                                <span class="mt-2 text-xs uppercase font-bold text-primary-200">{{ $type }}</span>
                                            </div>
                                        @endif
                                        @if($teacher->subject)
                                            <span class="absolute bottom-2 left-2 right-2 rounded-lg bg-slate-950/80 px-2 py-1 text-center text-xs font-bold text-white backdrop-blur truncate">
                                                {{ $teacher->subject }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-slate-950 group-hover:text-primary-800 transition line-clamp-2">
                                        {{ $teacher->name }}
                                    </h3>
                                    <p class="mt-1 text-xs text-slate-500">{{ $teacher->position }}</p>
                                </div>

                                @if($teacher->education)
                                    <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs text-slate-400">
                                        <x-icon name="award" class="size-3 text-gold-500 shrink-0" />
                                        <span class="truncate">{{ $teacher->education }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full">
                                <x-empty-state icon="users" :title="'Belum ada data '.strtolower($label)" />
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
