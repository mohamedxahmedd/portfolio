@props(['title' => 'Project', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'relative w-full h-full overflow-hidden']) }}>
    {{-- Brand gradient backdrop --}}
    <div class="absolute inset-0 bg-gradient-to-br from-brand-700 via-brand-500 to-brand-700"></div>

    {{-- Decorative blurred orbs --}}
    <div class="absolute -top-12 -right-12 size-48 rounded-full bg-white/15 blur-2xl"></div>
    <div class="absolute -bottom-12 -left-12 size-48 rounded-full bg-black/30 blur-2xl"></div>

    {{-- Subtle dot grid --}}
    <div class="absolute inset-0 opacity-[0.15]"
         style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 18px 18px;"></div>

    {{-- Mobile phone outline silhouette --}}
    <svg class="absolute right-4 bottom-4 w-24 h-32 text-white/15" viewBox="0 0 24 32" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
        <rect x="2" y="2" width="20" height="28" rx="3" ry="3"/>
        <line x1="9" y1="27" x2="15" y2="27"/>
    </svg>

    {{-- Title --}}
    <div class="relative h-full flex flex-col justify-center p-6 text-white">
        <span class="text-xs uppercase tracking-[0.3em] opacity-80 mb-2">Mobile App</span>
        <span class="font-display font-bold text-2xl md:text-3xl leading-tight tracking-tight drop-shadow">{{ $title }}</span>
        @if($subtitle)
            <span class="text-sm mt-2 opacity-90">{{ $subtitle }}</span>
        @endif
    </div>
</div>
