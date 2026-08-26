<x-layouts.app title="Prestasi" description="Capaian peserta didik dan warga madrasah.">
    <x-page-header title="Prestasi madrasah" description="Capaian akademik dan nonakademik yang lahir dari kerja keras, disiplin, dan dukungan bersama." />
    <section class="py-14 sm:py-20"><div class="container-app">
        <form method="GET" class="mb-8 grid gap-4 rounded-2xl bg-white p-5 ring-1 ring-slate-900/10 sm:grid-cols-3"><div><label for="tingkat" class="label">Tingkat</label><select id="tingkat" name="tingkat" class="input"><option value="">Semua tingkat</option>@foreach (\App\Models\Achievement::LEVELS as $level)<option value="{{ $level }}" @selected(request('tingkat') === $level)>{{ ucfirst($level) }}</option>@endforeach</select></div><div><label for="kategori" class="label">Kategori</label><select id="kategori" name="kategori" class="input"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(request('kategori') === $category)>{{ $category }}</option>@endforeach</select></div><div><label for="tahun" class="label">Tahun</label><div class="flex gap-2"><select id="tahun" name="tahun" class="input"><option value="">Semua tahun</option>@foreach($years as $year)<option value="{{ $year }}" @selected((string)request('tahun') === (string)$year)>{{ $year }}</option>@endforeach</select><button type="submit" class="btn-outline shrink-0">Terapkan</button></div></div></form>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($achievements as $achievement)
                <article class="rounded-2xl bg-white p-6 ring-1 ring-slate-900/10"><div class="flex items-center justify-between gap-4"><span class="rounded-full bg-gold-100 px-3 py-1 text-sm font-medium text-gold-900">{{ ucfirst($achievement->level) }}</span><x-icon name="trophy" class="size-6 text-gold-600" /></div><h2 class="mt-5 text-balance text-xl font-semibold tracking-tight text-slate-950">{{ $achievement->title }}</h2>@if($achievement->participant)<p class="mt-3 font-medium text-primary-700">{{ $achievement->participant }}</p>@endif<div class="mt-5 flex items-center justify-between gap-4 text-base text-slate-500"><span>{{ $achievement->category }}</span><span class="tabular-nums">{{ $achievement->year }}</span></div></article>
            @empty
                <div class="md:col-span-2 lg:col-span-3"><x-empty-state icon="trophy" title="Belum ada prestasi" /></div>
            @endforelse
        </div><div class="mt-10">{{ $achievements->links() }}</div>
    </div></section>
</x-layouts.app>
