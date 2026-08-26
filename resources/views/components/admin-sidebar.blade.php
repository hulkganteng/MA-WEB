@props(['groups'])
<div class="flex h-full flex-col p-4">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-2 py-3">
        <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-gold-400 font-semibold text-primary-950">MA</span>
        <span class="min-w-0"><span class="block truncate font-semibold text-white">Admin Madrasah</span><span class="block truncate text-xs text-primary-200">Kelola website</span></span>
    </a>
    <nav class="mt-6 flex-1 overflow-y-auto">
        @foreach($groups as $group => $items)
            @php $visible = collect($items)->filter(fn ($item) => is_array($item[3]) ? auth()->user()->hasAnyPermission($item[3]) : auth()->user()->can($item[3])); @endphp
            @if($visible->isNotEmpty())
                <section class="mb-6">
                    <h2 class="px-3 text-xs font-medium text-primary-300">{{ $group }}</h2>
                    <ul role="list" class="mt-2 flex flex-col gap-1">
                        @foreach($visible as $item)
                            @php
                                [$route, $icon, $label, $permission, $params] = $item;
                                $pattern = $item[5] ?? $route;
                                $active = request()->routeIs($pattern)
                                    || ($route === 'admin.profile.index' && request()->routeIs('admin.profile.*'))
                                    || ($route === 'admin.teachers.index' && request()->routeIs('admin.teachers.*'));
                            @endphp
                            <li><a href="{{ route($route, $params) }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium {{ $active ? 'bg-white/10 text-white' : 'text-primary-100 hover:bg-white/5 hover:text-white' }}"><x-icon :name="$icon" class="size-4 shrink-0" />{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </section>
            @endif
        @endforeach
    </nav>
    <div class="border-t border-white/10 pt-4"><form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-primary-100 hover:bg-white/5 hover:text-white"><x-icon name="log-out" class="size-4" />Keluar</button></form></div>
</div>
