@extends('themes.reeni.layouts.app')

@php
    $settings = $settings ?? \App\Models\Setting::current();
    $about = $about ?? \App\Models\AboutSection::current();
    $contact = $contact ?? \App\Models\ContactInfo::current();
    $cover = $project->coverUrl('hero');
    $screenshots = $project->getMedia('screenshots');
@endphp

@section('title', $project->title)
@section('description', $project->description)

@section('head')
    @if($cover)
        <meta property="og:image" content="{{ $cover }}">
    @endif
@endsection

@section('content')

<article class="pt-32 relative">
    {{-- Ambient background --}}
    <div class="absolute inset-x-0 top-0 h-[60vh] -z-10 overflow-hidden pointer-events-none">
        <div class="orb top-0 -right-40 size-[40rem] bg-brand-500/15"></div>
        <div class="orb top-1/3 -left-40 size-[30rem] bg-brand-700/10" style="animation-delay: -5s"></div>
    </div>

    {{-- Hero --}}
    <header class="px-6 py-16">
        <div class="container-x max-w-5xl">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-sm text-ink-400 hover:text-brand-500 mb-8 transition group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> All projects
            </a>

            <div x-reveal class="reveal">
                <p class="section-eyebrow">{{ $project->year ?? '' }} · {{ $project->platform ?? 'Mobile' }}</p>
                <h1 x-data="wordReveal" class="display text-4xl md:text-7xl tracking-tight">{{ $project->title }}</h1>
                @if($project->subtitle)
                    <p class="mt-3 text-xl text-ink-300">{{ $project->subtitle }}</p>
                @endif

                <p class="mt-6 text-lg text-ink-300 max-w-3xl leading-relaxed">{{ $project->description }}</p>
            </div>

            {{-- Mobile store + repo links (your explicit requirement) --}}
            @if($project->app_store_url || $project->play_store_url || $project->github_url || $project->live_demo_url)
                <div x-reveal class="reveal stagger mt-8 flex flex-wrap gap-3">
                    @if($project->app_store_url)
                        <a href="{{ $project->app_store_url }}" target="_blank" rel="noopener"
                           class="btn-primary" x-data="magnetic(0.18)">
                            <span class="flex items-center gap-2">
                                <i class="fab fa-apple text-xl"></i>
                                <span class="text-left leading-tight">
                                    <span class="block text-xs font-normal opacity-80">Download on the</span>
                                    <span class="block">App Store</span>
                                </span>
                            </span>
                        </a>
                    @endif
                    @if($project->play_store_url)
                        <a href="{{ $project->play_store_url }}" target="_blank" rel="noopener"
                           class="btn-primary" x-data="magnetic(0.18)">
                            <span class="flex items-center gap-2">
                                <i class="fab fa-google-play text-xl"></i>
                                <span class="text-left leading-tight">
                                    <span class="block text-xs font-normal opacity-80">Get it on</span>
                                    <span class="block">Google Play</span>
                                </span>
                            </span>
                        </a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-ghost" x-data="magnetic(0.15)">
                            <span><i class="fab fa-github"></i> View source</span>
                        </a>
                    @endif
                    @if($project->live_demo_url)
                        <a href="{{ $project->live_demo_url }}" target="_blank" rel="noopener" class="btn-ghost" x-data="magnetic(0.15)">
                            <span><i class="fas fa-globe"></i> Live demo</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </header>

    {{-- Cover --}}
    <div x-reveal class="reveal reveal-scale container-x px-6 mb-16">
        <div class="img-zoom rounded-3xl overflow-hidden aspect-[16/8]">
            @if($cover)
                <img src="{{ $cover }}" alt="{{ $project->title }}" class="rounded-3xl w-full h-full object-cover img-blur-up" x-data="imgLoad">
            @else
                <x-project-placeholder :title="$project->title" :subtitle="$project->subtitle" class="rounded-3xl" />
            @endif
        </div>
    </div>

    {{-- Meta + Description --}}
    <div class="container-x px-6 max-w-5xl grid lg:grid-cols-[1fr,260px] gap-10 mb-16">
        <div x-reveal class="reveal prose prose-invert max-w-none">
            @if($project->body)
                {!! nl2br(e(strip_tags($project->body, '<p><br><strong><em><a><ul><ol><li><h2><h3><h4><blockquote><code>'))) !!}
            @endif

            @if($project->problem)
                <h3 class="font-display text-2xl text-white mt-10 mb-3">The problem</h3>
                <p class="text-ink-300 leading-relaxed">{{ $project->problem }}</p>
            @endif

            @if($project->solution)
                <h3 class="font-display text-2xl text-white mt-8 mb-3">The solution</h3>
                <p class="text-ink-300 leading-relaxed">{{ $project->solution }}</p>
            @endif

            @if($project->features)
                <h3 class="font-display text-2xl text-white mt-10 mb-4">Key features</h3>
                <ul class="grid sm:grid-cols-2 gap-3 list-none p-0">
                    @foreach((array) $project->features as $feature)
                        <li class="flex items-start gap-3 text-ink-300">
                            <i class="fas fa-check-circle text-brand-500 mt-1"></i>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <aside x-reveal class="reveal reveal-right space-y-4">
            <div class="card lift text-sm">
                <h4 class="font-display text-base text-white mb-4 uppercase tracking-wider text-brand-500">Project details</h4>
                <dl class="space-y-3">
                    @if($project->client)
                        <div class="flex justify-between"><dt class="text-ink-400">Client</dt><dd class="text-white">{{ $project->client }}</dd></div>
                    @endif
                    @if($project->role)
                        <div class="flex justify-between gap-3"><dt class="text-ink-400">Role</dt><dd class="text-white text-right">{{ $project->role }}</dd></div>
                    @endif
                    @if($project->duration)
                        <div class="flex justify-between"><dt class="text-ink-400">Duration</dt><dd class="text-white">{{ $project->duration }}</dd></div>
                    @endif
                    @if($project->year)
                        <div class="flex justify-between"><dt class="text-ink-400">Year</dt><dd class="text-white">{{ $project->year }}</dd></div>
                    @endif
                    @if($project->platform)
                        <div class="flex justify-between"><dt class="text-ink-400">Platform</dt><dd class="text-white">{{ $project->platform }}</dd></div>
                    @endif
                </dl>
            </div>

            @if($project->technologies->isNotEmpty())
                <div class="card lift text-sm">
                    <h4 class="font-display text-base text-white mb-4 uppercase tracking-wider text-brand-500">Tech stack</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                            <span class="pill">{{ $tech->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>

    {{-- Screenshots gallery --}}
    @if($screenshots->isNotEmpty())
        <section class="bg-ink-950 py-16 px-6 relative overflow-hidden">
            <div class="orb top-0 right-0 size-[24rem] bg-brand-500/10"></div>
            <div class="container-x relative">
                <div x-reveal class="reveal text-center">
                    <p class="section-eyebrow">Screens</p>
                    <h2 x-data="wordReveal" class="section-title mb-10">Inside the <span class="text-gradient-brand">app</span></h2>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 stagger" x-reveal
                     x-data="{ open: false, src: '' }">
                    @foreach($screenshots as $shot)
                        <button type="button"
                                @click="open = true; src = '{{ $shot->getUrl() }}'"
                                class="img-zoom group relative overflow-hidden rounded-2xl bg-ink-800 aspect-[9/16] border border-ink-700 hover:border-brand-500 transition-colors">
                            <img src="{{ $shot->getUrl() }}"
                                 alt="{{ $project->title }} screenshot"
                                 loading="lazy"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-ink-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 grid place-items-end p-4">
                                <span class="size-10 rounded-full bg-brand-500 grid place-items-center text-white">
                                    <i class="fas fa-expand"></i>
                                </span>
                            </div>
                        </button>
                    @endforeach

                    <div x-show="open" x-cloak @keydown.escape.window="open = false"
                         x-transition.opacity.duration.300ms
                         class="fixed inset-0 z-50 bg-ink-950/95 backdrop-blur grid place-items-center p-6"
                         @click.self="open = false">
                        <button @click="open = false" class="absolute top-6 right-6 size-12 grid place-items-center rounded-full bg-ink-800 text-white hover:bg-brand-500 hover:rotate-90 transition-all duration-300">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                        <img :src="src" alt="" class="max-h-[90vh] rounded-2xl shadow-2xl"
                             x-transition.scale.duration.300ms>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Related projects --}}
    @if($related->isNotEmpty())
        <section class="section">
            <div class="container-x">
                <h2 x-data="wordReveal" class="section-title mb-10">Related <span class="text-gradient-brand">projects</span></h2>
                <div class="grid md:grid-cols-3 gap-6 stagger" x-reveal>
                    @foreach($related as $other)
                        @php($oc = $other->coverUrl('card'))
                        <a href="{{ route('projects.show', $other) }}"
                           x-data="cardFx(5)"
                           data-cursor-text="View →"
                           class="tilt card lift glow-border p-0 overflow-hidden group block">
                            <div class="img-zoom aspect-[4/3] bg-ink-800 overflow-hidden">
                                @if($oc)
                                    <img src="{{ $oc }}" alt="{{ $other->title }}" class="w-full h-full object-cover img-blur-up" x-data="imgLoad" loading="lazy">
                                @else
                                    <x-project-placeholder :title="$other->title" :subtitle="$other->subtitle" />
                                @endif
                            </div>
                            <div class="p-5 tilt-inner">
                                <h3 class="font-display text-lg text-white group-hover:text-brand-500 transition-colors duration-300">{{ $other->title }}</h3>
                                <p class="text-sm text-ink-400 line-clamp-2 mt-2">{{ $other->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</article>

@endsection
