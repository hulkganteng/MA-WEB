@props(['items' => []])
@php $homeUrl = route('home'); @endphp

<nav aria-label="Breadcrumb" class="mb-6">
    <ol class="flex flex-wrap items-center gap-1.5 text-sm text-slate-500">
        <li><a href="{{ $homeUrl }}" class="hover:text-primary-700">Beranda</a></li>
        @foreach ($items as $item)
            <li class="flex items-center gap-1.5">
                <x-icon name="chevron-right" class="h-3.5 w-3.5 text-slate-300" />
                @if (isset($item['url']) && $item['url'])
                    <a href="{{ $item['url'] }}" class="hover:text-primary-700">{{ $item['label'] }}</a>
                @else
                    <span class="font-medium text-slate-800" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
