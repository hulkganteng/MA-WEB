@props(['title', 'subtitle' => null, 'eyebrow' => null, 'description' => null, 'align' => 'left', 'theme' => 'light', 'icon' => null, 'link' => null, 'linkLabel' => null])

@php
    $alignClass = $align === 'center' ? 'items-center text-center mx-auto' : 'items-start text-left';
    $linkLabel = $linkLabel ?? ($link ? 'Lihat semua' : null);
    $eyebrow = $eyebrow ?? $subtitle;
    $titleClass = $theme === 'dark' ? 'text-white' : 'text-slate-950';
    $descriptionClass = $theme === 'dark' ? 'text-primary-100' : 'text-slate-600';
    $eyebrowClass = $theme === 'dark' ? 'text-gold-300' : 'text-primary-700';
@endphp

<div class="{{ $alignClass }} flex max-w-2xl flex-col">
    @if ($eyebrow)
        <p class="mb-3 font-medium {{ $eyebrowClass }}">{{ $eyebrow }}</p>
    @endif
    <h2 class="text-balance text-2xl font-semibold tracking-tight {{ $titleClass }} sm:text-3xl">{{ $title }}</h2>
    @if ($description || ($slot && trim($slot)))
        <p class="mt-3 max-w-[56ch] text-pretty text-base {{ $descriptionClass }}">{{ $description ?: $slot }}</p>
    @endif
</div>
