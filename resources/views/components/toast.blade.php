@props(['type' => 'success', 'message' => ''])

@php
    $styles = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        'info' => 'border-sky-200 bg-sky-50 text-sky-800',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
        'error' => 'border-rose-200 bg-rose-50 text-rose-800',
    ][$type] ?? 'border-slate-200 bg-white text-slate-800';

    $icons = ['success' => 'check-circle-2', 'info' => 'info', 'warning' => 'alert-triangle', 'error' => 'x-circle'];
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)"
     x-show="show" x-transition x-cloak
     role="alert"
     class="pointer-events-none fixed right-4 top-20 z-[60] w-80 max-w-[calc(100vw-2rem)]">
    <div class="pointer-events-auto flex items-start gap-3 rounded-xl border px-4 py-3 shadow-lift {{ $styles }}">
        <x-icon name="{{ $icons[$type] ?? 'info' }}" class="mt-0.5 h-5 w-5 shrink-0" />
        <p class="flex-1 text-sm font-medium">{{ $message }}</p>
        <button type="button" @click="show = false" class="shrink-0 text-slate-400 hover:text-slate-600" aria-label="Tutup">
            <x-icon name="x" class="h-4 w-4" />
        </button>
    </div>
</div>
