@php($cover = $project->coverUrl('card'))
<a href="{{ route('projects.show', $project) }}"
   x-data="cardFx(6)"
   data-cursor-text="View →"
   class="tilt card lift glow-border group block p-0 overflow-hidden relative">
    <div x-reveal class="img-zoom clip-reveal aspect-[4/3] bg-gradient-to-br from-ink-800 to-ink-700 relative overflow-hidden">
        @if($cover)
            <img src="{{ $cover }}" alt="{{ $project->title }}"
                 class="w-full h-full object-cover img-blur-up"
                 x-data="imgLoad" loading="lazy">
        @else
            <x-project-placeholder :title="$project->title" :subtitle="$project->subtitle" />
        @endif
        {{-- Hover overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/40 to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-500"></div>
        {{-- Hover arrow --}}
        <div class="absolute top-3 left-3 size-10 rounded-full bg-brand-500 grid place-items-center text-white opacity-0 group-hover:opacity-100 -translate-y-2 group-hover:translate-y-0 transition-all duration-500">
            <i class="fas fa-arrow-right"></i>
        </div>
        @if($project->is_featured)
            <span class="absolute top-3 right-3 pill bg-brand-500/30 border-brand-500/60 text-white backdrop-blur">
                <i class="fas fa-star"></i> Featured
            </span>
        @endif
    </div>
    <div class="p-6 tilt-inner">
        <h3 class="font-display text-xl text-white group-hover:text-brand-500 transition-colors duration-300">{{ $project->title }}</h3>
        @if($project->subtitle)
            <p class="text-sm text-ink-400 mt-1">{{ $project->subtitle }}</p>
        @endif
        <p class="text-sm text-ink-300 mt-3 line-clamp-2">{{ $project->description }}</p>

        <div class="flex flex-wrap gap-1.5 mt-4">
            @foreach($project->technologies->take(3) as $tech)
                <span class="pill">{{ $tech->name }}</span>
            @endforeach
            @if($project->technologies->count() > 3)
                <span class="pill">+{{ $project->technologies->count() - 3 }}</span>
            @endif
        </div>

        @if($project->app_store_url || $project->play_store_url)
            <div class="mt-4 flex gap-2">
                @if($project->app_store_url)
                    <span class="pill bg-ink-900 border-ink-600 text-ink-300 text-xs">
                        <i class="fab fa-apple"></i> iOS
                    </span>
                @endif
                @if($project->play_store_url)
                    <span class="pill bg-ink-900 border-ink-600 text-ink-300 text-xs">
                        <i class="fab fa-google-play"></i> Android
                    </span>
                @endif
            </div>
        @endif
    </div>
</a>
