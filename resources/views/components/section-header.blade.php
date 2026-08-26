@props(['title', 'subtitle' => null, 'eyebrow' => null, 'description' => null, 'align' => 'left', 'theme' => 'light', 'icon' => null, 'link' => null, 'linkLabel' => null])

@php
    $alignClass = $align === 'center' ? 'items-center text-center mx-auto' : 'items-start text-left';
    $linkLabel = $linkLabel ?? ($link ? 'Lihat semua' : null);
    $eyebrow = $eyebrow ?? $subtitle;
    $titleClass = $theme === 'dark' ? 'text-white' : 'text-[#1F1A17]';
    $descriptionClass = $theme === 'dark' ? 'text-primary-100' : 'text-slate-600';
    $eyebrowClass = $theme === 'dark' ? 'text-gold-300 font-bold' : 'text-primary-700 font-bold';
@endphp

<div class="{{ $alignClass }} flex max-w-2xl flex-col">
    @if ($eyebrow)
        <p class="mb-2 text-xs uppercase tracking-wider {{ $eyebrowClass }}">{{ $eyebrow }}</p>
    @endif
    <h2 class="text-balance text-2xl font-extrabold tracking-tight {{ $titleClass }} sm:text-3xl lg:text-4xl">{{ $title }}</h2>
    @if ($description || ($slot && trim($slot)))
        <p class="mt-3 max-w-[56ch] text-pretty text-base {{ $descriptionClass }}">{{ $description ?: $slot }}</p>
    @endif
</div>
