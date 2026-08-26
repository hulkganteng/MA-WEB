<x-layouts.app title="Prestasi & Penghargaan Santri" description="Rekam jejak capaian gemilang santri dan dewan guru MA Ma'arif NU Assa'adah Bungah Gresik di tingkat Kabupaten, Provinsi, Nasional, dan Internasional.">
    <x-page-header eyebrow="Etalase Keunggulan & Juara"
                   title="Prestasi & Penghargaan Santri"
                   description="Bukti dedikasi, kedisiplinan, dan ikhtiar santri mengukir prestasi di bidang olimpiade sains (KSM), riset MYRES, tahfidz, MQK, seni kaligrafi, dan olahraga." />

    <section class="bg-slate-50/60 py-14 sm:py-20">
        <div class="container-app space-y-10">
            {{-- Filter Bar --}}
            <form method="GET" class="grid gap-4 rounded-3xl border border-slate-200/80 bg-white p-5 shadow-soft sm:grid-cols-3">
                <div>
                    <label for="tingkat" class="label text-xs font-bold text-slate-700">Tingkat Kejuaraan</label>
                    <select id="tingkat" name="tingkat" class="input text-xs">
                        <option value="">Semua Tingkat</option>
                        @foreach (\App\Models\Achievement::LEVELS as $level)
                            <option value="{{ $level }}" @selected(request('tingkat') === $level)>{{ ucfirst($level) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="kategori" class="label text-xs font-bold text-slate-700">Bidang / Kategori</label>
                    <select id="kategori" name="kategori" class="input text-xs">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @selected(request('kategori') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tahun" class="label text-xs font-bold text-slate-700">Tahun Capaian</label>
                    <div class="flex gap-2">
                        <select id="tahun" name="tahun" class="input text-xs">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" @selected((string)request('tahun') === (string)$year)>{{ $year }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-primary shrink-0 text-xs">
                            <x-icon name="filter" class="size-3.5" /> Filter
                        </button>
                    </div>
                </div>
            </form>

            {{-- Achievements Grid --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($achievements as $achievement)
                    <article class="interactive-card group flex flex-col justify-between p-6 sm:p-7">
                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-bold text-gold-900 ring-1 ring-gold-500/20">
                                    {{ ucfirst($achievement->level) }}
                                </span>
                                <div class="flex size-10 items-center justify-center rounded-2xl bg-gold-50 text-gold-600 transition group-hover:bg-gold-500 group-hover:text-gold-950 group-hover:rotate-12">
                                    <x-icon name="trophy" class="size-5" />
                                </div>
                            </div>

                            <h2 class="mt-4 text-base font-bold tracking-tight text-slate-950 group-hover:text-primary-800 transition">
                                {{ $achievement->title }}
                            </h2>

                            @if($achievement->participant)
                                <p class="mt-2 text-xs font-semibold text-primary-700 flex items-center gap-1.5">
                                    <x-icon name="user" class="size-3.5 text-primary-500" />
                                    <span>{{ $achievement->participant }}</span>
                                </p>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span class="rounded bg-slate-100 px-2 py-0.5 font-medium">{{ $achievement->category }}</span>
                            <span class="font-mono font-bold text-slate-700">{{ $achievement->year }}</span>
                        </div>
                    </article>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3">
                        <x-empty-state icon="trophy" title="Belum ada data prestasi" description="Data prestasi belum tersedia untuk filter yang dipilih." />
                    </div>
                @endforelse
            </div>

            <div class="mt-8">{{ $achievements->links() }}</div>
        </div>
    </section>
</x-layouts.app>

