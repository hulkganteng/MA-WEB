<x-layouts.app title="Struktur Organisasi Pimpinan" description="Struktur pengelola dan dewan pimpinan MA Ma’arif NU Assa’adah Bungah Gresik.">
    <x-page-header eyebrow="Profil Kepemimpinan"
                   title="Struktur Organisasi Madrasah"
                   description="Bagan susunan pimpinan, dewan masyayikh, wakil kepala madrasah, dan kepala unit penunjang pendidikan." />

    <section class="bg-slate-50/60 py-14 sm:py-20 overflow-x-auto">
        <div class="container-app">
            @if($members->isNotEmpty())
                <div class="org-chart min-w-[800px]">
                    @foreach($members as $member)
                        @include('public.profile.partials.org-node', ['member' => $member])
                    @endforeach
                </div>
            @else
                <x-empty-state icon="network" title="Struktur organisasi belum tersedia" description="Bagan susunan pimpinan akan segera diperbarui oleh administrator." />
            @endif
        </div>
    </section>
</x-layouts.app>
