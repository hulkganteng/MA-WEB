@props(['eyebrow' => null, 'title', 'description' => null])

<section class="bg-primary-950 py-14 text-white sm:py-16">
    <div class="container-app">
        @if ($eyebrow)
            <p class="font-medium text-gold-300">{{ $eyebrow }}</p>
        @endif
        <h1 class="max-w-[24ch] text-balance text-3xl font-semibold tracking-tight sm:text-4xl">{{ $title }}</h1>
        @if ($description)
            <p class="mt-4 max-w-[65ch] text-pretty text-base text-primary-100">{{ $description }}</p>
        @endif
    </div>
</section>
