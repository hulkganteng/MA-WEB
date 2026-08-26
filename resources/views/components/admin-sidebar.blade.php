@props(['groups'])
<div class="flex h-full flex-col bg-gradient-to-b from-primary-950 via-[#03251d] to-[#011c16] text-white select-none">
    <!-- Header Brand & Collapse Button -->
    <div class="px-4 pt-4 pb-2 shrink-0">
        <div class="flex items-center justify-between gap-2">
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-2xl bg-white/[0.04] p-2.5 ring-1 ring-white/10 hover:bg-white/[0.08] hover:ring-white/20 transition-all duration-200 shadow-sm flex-1 min-w-0">
                <div class="relative flex size-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-gold-400 via-gold-500 to-gold-600 font-bold text-primary-950 shadow-md shadow-gold-500/20">
                    <span class="text-xs tracking-tight font-extrabold">MA</span>
                    <span class="absolute -top-0.5 -right-0.5 size-2 rounded-full bg-emerald-400 ring-2 ring-primary-950"></span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold text-white group-hover:text-emerald-300 transition-colors text-xs leading-tight">MA Assa'adah</p>
                    <p class="truncate text-[10px] text-emerald-300/70 leading-tight mt-0.5">Admin CMS</p>
                </div>
            </a>

            <!-- Collapse / Hide Button -->
            <button type="button"
                    @click="window.innerWidth >= 1024 ? toggleDesktop() : (mobileOpen = false)"
                    class="flex size-8 shrink-0 items-center justify-center rounded-xl bg-white/[0.04] text-slate-300 hover:bg-white/10 hover:text-white ring-1 ring-white/10 transition-all cursor-pointer"
                    title="Sembunyikan Sidebar (Hide)">
                <x-icon name="panel-left-close" class="size-4" />
                <span class="sr-only">Sembunyikan sidebar</span>
            </button>
        </div>

        <!-- Quick Website Link -->
        <a href="{{ route('home') }}" target="_blank" class="mt-2.5 flex items-center justify-between gap-2 rounded-xl bg-white/[0.03] px-3 py-1.5 text-xs font-medium text-emerald-300/80 hover:bg-white/[0.07] hover:text-white ring-1 ring-white/5 transition-all">
            <span class="flex items-center gap-2">
                <x-icon name="globe" class="size-3.5 text-emerald-400" />
                <span>Lihat Website Publik</span>
            </span>
            <x-icon name="arrow-up-right" class="size-3 text-emerald-400/60" />
        </a>
    </div>

    <!-- Navigation List -->
    <nav class="flex-1 overflow-y-auto px-3 py-3 custom-scrollbar space-y-5">
        @foreach($groups as $group => $items)
            @php
                $visible = collect($items)->filter(fn ($item) => is_array($item[3]) ? auth()->user()->hasAnyPermission($item[3]) : auth()->user()->can($item[3]));
            @endphp
            @if($visible->isNotEmpty())
                <div>
                    <div class="flex items-center justify-between px-3 mb-1.5">
                        <h2 class="text-[10px] font-bold uppercase tracking-wider text-emerald-400/60">{{ $group }}</h2>
                    </div>
                    <ul role="list" class="space-y-1">
                        @foreach($visible as $item)
                            @php
                                [$route, $icon, $label, $permission, $params] = $item;
                                $pattern = $item[5] ?? $route;
                                $active = request()->routeIs($pattern)
                                    || ($route === 'admin.profile.index' && request()->routeIs('admin.profile.*'))
                                    || ($route === 'admin.teachers.index' && request()->routeIs('admin.teachers.*'));
                            @endphp
                            <li>
                                <a href="{{ route($route, $params) }}"
                                   class="group relative flex items-center justify-between gap-3 rounded-xl px-3 py-2 text-sm font-medium transition-all duration-150 {{ $active ? 'bg-gradient-to-r from-primary-600 to-emerald-600 text-white font-semibold shadow-sm shadow-primary-950/40 ring-1 ring-white/20' : 'text-slate-300 hover:bg-white/[0.07] hover:text-white' }}">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <x-icon :name="$icon" class="size-4 shrink-0 transition-colors {{ $active ? 'text-white' : 'text-emerald-400/80 group-hover:text-emerald-300' }}" />
                                        <span class="truncate">{{ $label }}</span>
                                    </div>
                                    @if($active)
                                        <span class="size-1.5 rounded-full bg-gold-300 ring-2 ring-white/30"></span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>

    <!-- Bottom User Profile Card -->
    <div class="p-3 border-t border-white/[0.08] bg-primary-950/80 backdrop-blur-sm shrink-0">
        <div class="flex items-center justify-between gap-2.5 rounded-xl bg-white/[0.04] p-2.5 ring-1 ring-white/5">
            <a href="{{ route('admin.account.edit') }}" class="flex items-center gap-2.5 min-w-0 flex-1 group">
                <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-primary-700 text-xs font-bold text-white shadow-sm ring-1 ring-white/20">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1 text-left">
                    <p class="truncate text-xs font-semibold text-white group-hover:text-emerald-300 transition-colors">{{ auth()->user()->name }}</p>
                    <p class="truncate text-[10px] text-emerald-300/70">{{ auth()->user()->roles->first()?->name ?? 'Administrator' }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari panel admin?')">
                @csrf
                <button type="submit"
                        title="Keluar dari sesi"
                        class="flex size-8 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-rose-500/20 hover:text-rose-300 transition-colors">
                    <x-icon name="log-out" class="size-4" />
                    <span class="sr-only">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>
