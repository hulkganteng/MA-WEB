@props(['eyebrow' => null, 'title', 'description' => null, 'breadcrumbs' => null])

<section class="relative overflow-hidden bg-gradient-to-r from-[#006437] via-[#007a34] to-[#006437] py-14 text-white sm:py-20 border-b border-[#00923F]/40 shadow-sm">
    {{-- Islamic Decorative Background --}}
    <div class="pointer-events-none absolute inset-0 bg-islamic-stars opacity-35"></div>
    <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-gold-400/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-20 -bottom-20 size-80 rounded-full bg-primary-400/15 blur-3xl"></div>

    {{-- Subtle Arabic Watermark --}}
    <div class="pointer-events-none absolute right-4 bottom-2 select-none text-right font-arabic text-4xl sm:text-6xl font-bold text-white/[0.06] leading-none" dir="rtl">
        بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
    </div>

    <div class="relative container-app">
        {{-- Breadcrumb Navigation --}}
        <nav aria-label="Breadcrumb" class="mb-4 flex items-center gap-2 text-xs text-primary-100">
            <a href="{{ route('home') }}" class="flex items-center gap-1 hover:text-gold-300 transition">
                <x-icon name="home" class="size-3.5" />
                <span>Beranda</span>
            </a>
            <x-icon name="chevron-right" class="size-3 text-primary-300" />
            <span class="text-white font-semibold truncate max-w-[200px] sm:max-w-none">{{ $title }}</span>
        </nav>

        {{-- Eyebrow Badge --}}
        @if ($eyebrow)
            <div class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-gold-400/15 px-3.5 py-1 text-xs font-bold text-gold-300 backdrop-blur">
                <span class="size-1.5 rounded-full bg-gold-400"></span>
                <span>{{ $eyebrow }}</span>
            </div>
        @endif

        {{-- Title --}}
        <h1 class="mt-3 max-w-[28ch] text-balance text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-tight">
            {{ $title }}
        </h1>

        {{-- Description --}}
        @if ($description)
            <p class="mt-4 max-w-[68ch] text-pretty text-sm leading-relaxed text-primary-50 sm:text-base">
                {{ $description }}
            </p>
        @endif
    </div>
</section>

