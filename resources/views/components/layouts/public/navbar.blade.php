@php
    $siteName = setting('site.name', 'MA Ma\'arif NU Assa\'adah');
    $siteTagline = setting('site.tagline', 'Berakhlak Mulia, Cakap, Cendekia, dan Berkarakter Pesantren');
    $logo = setting('site.logo');
    $phone = setting('contact.phone');
    $email = setting('contact.email');
    $social = \App\Models\SocialLink::where('is_active', true)->get();
    $menus = \App\Models\Menu::where('location', 'main')->where('is_active', true)
        ->whereNull('parent_id')->orderBy('order')->get();
@endphp

<header class="sticky top-0 z-50">
    <div class="bg-primary-900 text-primary-100">
        <div class="container-app flex h-9 items-center justify-between text-xs">
            <div class="flex items-center gap-4">
                <a href="mailto:{{ $email }}" class="hidden items-center gap-1.5 hover:text-white sm:flex">
                    <x-icon name="mail" class="h-3.5 w-3.5" /> {{ $email }}
                </a>
                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="flex items-center gap-1.5 hover:text-white">
                    <x-icon name="phone" class="h-3.5 w-3.5" /> {{ $phone }}
                </a>
            </div>
            <div class="flex items-center gap-3">
                @foreach ($social as $link)
                    @php $href = $link->url; @endphp
                    @if ($href)
                        <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($link->platform) }}" class="text-primary-200 hover:text-white">
                            <x-icon name="{{ $link->platform === 'youtube' ? 'youtube' : $link->platform }}" class="h-4 w-4" />
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <nav class="border-b border-slate-200 bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/80"
         x-data="{ open: false, search: false, activeMenu: null }"
         @scroll.window="activeMenu = null">
        <div class="container-app flex h-16 items-center justify-between gap-4 lg:h-[4.5rem]">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if ($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="{{ $siteName }}" class="h-11 w-11 rounded-full object-cover">
                @else
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary-600 text-lg font-bold text-white">M</span>
                @endif
                <span class="leading-tight">
                    <span class="block text-sm font-semibold text-slate-900 sm:text-base">{{ $siteName }}</span>
                    <span class="hidden text-[11px] text-slate-500 sm:block">{{ $siteTagline }}</span>
                </span>
            </a>

            <div class="hidden items-center lg:flex" @mouseleave="activeMenu = null">
                <ul class="flex items-center">
                    @foreach ($menus as $item)
                        @php $hasChildren = $item->children->count() > 0; @endphp
                        <li class="relative" @mouseenter="activeMenu = activeMenu === {{ $item->id }} ? null : {{ $item->id }}">
                            <a href="{{ $item->url ? url($item->url) : '#' }}"
                               target="{{ $item->target }}"
                               class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition hover:text-primary-700">
                                {{ $item->name }}
                                @if ($hasChildren)
                                    <x-icon name="chevron-down" class="h-3.5 w-3.5" />
                                @endif
                            </a>
                            @if ($hasChildren)
                                <div x-show="activeMenu === {{ $item->id }}" x-transition
                                     class="absolute left-0 top-full w-60 rounded-xl border border-slate-100 bg-white p-1.5 shadow-lift"
                                     @click.away="activeMenu = null">
                                    @foreach ($item->children as $child)
                                        <a href="{{ $child->url ? url($child->url) : '#' }}" target="{{ $child->target }}"
                                           class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-primary-50 hover:text-primary-700">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="search = !search" aria-label="Cari" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 hover:text-primary-700">
                    <x-icon name="search" class="h-5 w-5" />
                </button>
                <a href="{{ route('contact') }}" class="btn-primary hidden !px-4 sm:inline-flex">Hubungi Kami</a>
                <button type="button" @click="open = !open" class="rounded-lg p-2 text-slate-700 hover:bg-slate-100 lg:hidden" aria-label="Menu">
                    <x-icon name="menu" class="h-6 w-6" x-show="!open" />
                    <x-icon name="x" class="h-6 w-6" x-show="open" x-cloak />
                </button>
            </div>
        </div>

        <div x-show="search" x-transition class="border-t border-slate-100 bg-white" x-cloak>
            <form action="{{ route('search') }}" method="GET" class="container-app flex items-center gap-2 py-3">
                <x-icon name="search" class="h-5 w-5 text-slate-400" />
                <input type="search" name="q" placeholder="Cari berita, pengumuman, guru, dokumen..." autocomplete="off"
                       class="w-full bg-transparent py-1 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none" required>
                <button type="submit" class="btn-primary !py-1.5">Cari</button>
            </form>
        </div>

        <div x-show="open" x-transition x-cloak class="border-t border-slate-100 bg-white lg:hidden">
            <ul class="container-app space-y-1 py-3">
                @foreach ($menus as $item)
                    @php $hasChildren = $item->children->count() > 0; @endphp
                    <li>
                        @if ($hasChildren)
                            <button type="button" @click="activeMenu = activeMenu === {{ $item->id }} ? null : {{ $item->id }}"
                                    class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                {{ $item->name }}
                                <x-icon name="chevron-down" class="size-4 transition" x-bind:class="{ 'rotate-180': activeMenu === {{ $item->id }} }" />
                            </button>
                            <div x-show="activeMenu === {{ $item->id }}" class="ml-4 mt-1 space-y-1">
                                @foreach ($item->children as $child)
                                    <a href="{{ $child->url ? url($child->url) : '#' }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-primary-50 hover:text-primary-700">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{ $item->url ? url($item->url) : '#' }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                {{ $item->name }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
