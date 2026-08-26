@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'robots' => 'index, follow',
    'type' => 'website',
    'schema' => null,
])

@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $siteTagline = setting('site.tagline', 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren');
    $defaultSeo = setting('seo.default_title', $siteName);
    $metaTitle = $title ? "{$title} — {$siteName}" : $defaultSeo;
    $metaDescription = $description ?: setting('seo.default_description', $siteTagline);
    $ogImage = $image ?: setting('seo.default_image');
    $canonicalUrl = $canonical ?: url()->current();
    $favicon = setting('site.favicon') ? asset('storage/'.setting('site.favicon')) : asset('storage/'.(setting('site.logo') ?? ''));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:type" content="{{ $type }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:alt" content="{{ $metaTitle }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if ($ogImage)
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    <link rel="icon" href="{{ $favicon }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        $orgSchema = json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'EducationalOrganization',
            'name' => $siteName,
            'slogan' => $siteTagline,
            'url' => url('/'),
            'email' => setting('contact.email'),
            'telephone' => setting('contact.phone'),
            'address' => ['@type' => 'PostalAddress', 'streetAddress' => setting('contact.address')],
        ]);
    @endphp
    <script type="application/ld+json">{!! $orgSchema !!}</script>
    @if ($schema)
        <script type="application/ld+json">{!! is_string($schema) ? $schema : json_encode($schema) !!}</script>
    @endif

    @stack('head')
</head>
<body class="min-h-screen antialiased">
    <x-layouts.public.navbar />

    <main id="main" class="isolate">
        {{ $slot }}
    </main>

    <x-layouts.public.footer />

    <x-layouts.public.whatsapp />

    @if (session('flash'))
        <x-toast type="{{ session('flash.type', 'success') }}" message="{{ session('flash.message') }}" />
    @endif

    @stack('scripts')
</body>
</html>
