@php($member ??= null)

<div class="flex flex-col items-center">
    <div class="org-node">
        <div class="relative mx-auto size-16 overflow-hidden rounded-full border-2 border-gold-400/40 bg-[#006437] shadow-soft">
            @if($member->photo)
                <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" class="size-full rounded-full object-cover">
            @else
                <div class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-primary-600 via-primary-700 to-[#006437] text-gold-300 font-bold text-xl">
                    {{ substr($member->name, 0, 1) }}
                </div>
            @endif
        </div>
        <span class="mt-3 inline-block rounded-full bg-gold-100 px-3 py-0.5 text-[11px] font-bold text-[#1F1A17] ring-1 ring-gold-500/30">
            {{ $member->position }}
        </span>
        <h3 class="mt-1.5 text-sm font-bold text-[#1F1A17]">{{ $member->name }}</h3>
    </div>

    @if($member->children->isNotEmpty())
        <div class="org-children">
            @foreach($member->children as $child)
                <div class="org-child">
                    @include('public.profile.partials.org-node', ['member' => $child])
                </div>
            @endforeach
        </div>
    @endif
</div>
