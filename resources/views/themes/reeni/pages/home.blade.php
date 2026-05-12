@extends('themes.reeni.layouts.app')

@section('title', $about->name)
@section('description', $settings->site_description)

@section('content')

{{-- ════════════════════════ HERO ════════════════════════ --}}
<section x-data="parallax" class="relative min-h-screen flex items-center pt-32 pb-20 px-6 overflow-hidden">
    {{-- Animated mesh background with mouse parallax --}}
    <div class="absolute inset-0 -z-10">
        <div class="orb top-1/4 -right-32 size-[28rem] bg-brand-500/25" style="animation-delay: -2s" data-parallax="0.04"></div>
        <div class="orb bottom-0 -left-32 size-[26rem] bg-brand-700/20" style="animation-delay: -7s" data-parallax="0.06"></div>
        <div class="orb top-1/2 left-1/3 size-[18rem] bg-brand-400/15" style="animation-delay: -4s" data-parallax="0.03"></div>

        {{-- subtle grid overlay --}}
        <div class="absolute inset-0 opacity-[0.05]"
             style="background-image: linear-gradient(rgba(255,255,255,0.4) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.4) 1px, transparent 1px); background-size: 64px 64px;"></div>
    </div>

    <div class="container-x grid lg:grid-cols-2 gap-12 items-center">
        <div x-reveal>
            <p class="section-eyebrow inline-flex items-center gap-2 pulse-glow rounded-full bg-brand-500/10 px-3 py-1 mb-4">
                <span class="size-2 rounded-full bg-brand-500"></span>
                {{ $about->availability ?? 'Available for projects' }}
            </p>

            <h1 class="display text-5xl md:text-7xl leading-[1.05] tracking-tight">
                <span class="block text-ink-300 text-2xl md:text-3xl font-medium mb-3">Hi, I'm</span>
                <span class="text-gradient-brand block" x-data="letterReveal(200)">{{ $about->name }}</span>
                <span class="text-ink-200 text-3xl md:text-5xl block mt-3 font-semibold caret"
                      x-data="typewriter([
                          'Senior Flutter Developer.',
                          'Cross-platform App Builder.',
                          'State Management Expert.',
                          'Firebase Architect.',
                      ])"
                      x-text="text"></span>
            </h1>

            <p class="mt-6 text-lg text-ink-300 max-w-xl leading-relaxed">{{ $about->short_bio }}</p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="#projects" class="btn-primary" x-data="magnetic(0.18)">
                    <span><i class="fas fa-rocket"></i> View my work</span>
                </a>
                <a href="#contact" class="btn-ghost" x-data="magnetic(0.18)">
                    <span><i class="fas fa-paper-plane"></i> Get in touch</span>
                </a>
                @if($about->cv_download_url)
                    <a href="{{ $about->cv_download_url }}" download="{{ $about->name }}-CV.pdf" target="_blank" rel="noopener" class="btn-ghost">
                        <span><i class="fas fa-download"></i> Download CV</span>
                    </a>
                @endif
            </div>

            <div class="mt-12 grid grid-cols-3 gap-6 max-w-md stagger" x-reveal>
                <div x-data="counter({{ $about->years_experience }})" x-intersect.once="run">
                    <div class="text-4xl md:text-5xl font-display font-bold text-gradient-brand" x-text="value + '+'"></div>
                    <p class="text-xs uppercase tracking-wider text-ink-400 mt-1">Years experience</p>
                </div>
                <div x-data="counter({{ $about->projects_completed }})" x-intersect.once="run">
                    <div class="text-4xl md:text-5xl font-display font-bold text-gradient-brand" x-text="value + '+'"></div>
                    <p class="text-xs uppercase tracking-wider text-ink-400 mt-1">Projects shipped</p>
                </div>
                <div x-data="counter({{ count($services) }})" x-intersect.once="run">
                    <div class="text-4xl md:text-5xl font-display font-bold text-gradient-brand" x-text="value"></div>
                    <p class="text-xs uppercase tracking-wider text-ink-400 mt-1">Core services</p>
                </div>
            </div>
        </div>

        <div x-reveal class="relative reveal reveal-right">
            @php($photo = $about->getFirstMediaUrl('profile_photo', 'hero'))
            <div class="relative float">
                {{-- Decorative spinning ring --}}
                <div class="absolute -inset-8 rounded-full opacity-30 hidden md:block"
                     style="background: conic-gradient(from 0deg, transparent, var(--color-brand-500), transparent); animation: spinSlow 16s linear infinite;"
                     data-parallax="0.05"></div>
                {{-- Brand glow halo (parallax slowly behind) --}}
                <div class="absolute inset-0 -m-6 rounded-3xl bg-gradient-to-tr from-brand-500/40 via-brand-700/20 to-transparent blur-3xl"
                     data-parallax="0.04"></div>

                @if($photo)
                    {{-- Photo parallaxes subtly --}}
                    <div data-parallax="0.08">
                        <img src="{{ $photo }}" alt="{{ $about->name }}" class="relative rounded-3xl w-full max-w-md mx-auto img-blur-up" x-data="imgLoad">
                    </div>
                @else
                    <div data-parallax="0.08">
                        <div class="relative rounded-3xl bg-ink-800 border border-ink-700 w-full max-w-md aspect-[4/5] mx-auto grid place-items-center">
                            <div class="text-center">
                                <i class="fas fa-user-circle text-8xl text-ink-700"></i>
                                <p class="mt-4 text-ink-500 text-sm">Upload profile photo in admin</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Floating tech badges — bigger parallax depth (pop out more) --}}
                <div class="absolute -top-4 -left-4" data-parallax="0.20">
                    <div class="size-16 rounded-2xl bg-ink-800/90 backdrop-blur border border-ink-700 grid place-items-center text-brand-500 text-2xl shadow-2xl">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4" data-parallax="0.24">
                    <div class="size-16 rounded-2xl bg-ink-800/90 backdrop-blur border border-ink-700 grid place-items-center text-brand-500 text-2xl shadow-2xl">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
                <div class="absolute top-1/3 -right-8" data-parallax="0.18">
                    <div class="size-14 rounded-2xl bg-ink-800/90 backdrop-blur border border-ink-700 grid place-items-center text-brand-500 text-xl shadow-2xl">
                        <i class="fas fa-code"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll cue --}}
    <a href="#about" class="absolute left-1/2 -translate-x-1/2 bottom-8 text-ink-500 hover:text-brand-500 transition-colors group" aria-label="Scroll down">
        <span class="text-xs uppercase tracking-[0.3em] block mb-2 group-hover:text-brand-500 transition-colors">Scroll</span>
        <span class="block size-10 mx-auto rounded-full border border-ink-700 group-hover:border-brand-500 grid place-items-center transition-colors">
            <i class="fas fa-chevron-down animate-bounce"></i>
        </span>
    </a>
</section>

{{-- ════════════════════════ ABOUT ════════════════════════ --}}
<section id="about" class="section">
    <div class="container-x grid lg:grid-cols-2 gap-12 items-start">
        <div x-reveal class="reveal reveal-left">
            <p class="section-eyebrow">About me</p>
            <h2 x-data="wordReveal" class="section-title">Crafting mobile experiences <span class="text-gradient-brand">that matter</span></h2>
        </div>
        <div x-reveal class="reveal reveal-right text-ink-300 leading-relaxed text-base whitespace-pre-line">{{ $about->bio }}</div>
    </div>
</section>

{{-- ════════════════════════ EXPERIENCE + EDUCATION ════════════════════════ --}}
<section class="section bg-ink-950 relative overflow-hidden">
    <div class="orb top-1/4 -left-40 size-96 bg-brand-500/10" style="animation-delay: -3s"></div>
    <div class="container-x grid lg:grid-cols-2 gap-12 relative">
        <div>
            <div x-reveal class="reveal mb-10">
                <p class="section-eyebrow">Career</p>
                <h2 x-data="wordReveal" class="section-title">My Experience</h2>
            </div>
            <div class="space-y-6 stagger" x-reveal>
                @foreach($experiences as $exp)
                    <div x-data="cardFx(4)" class="tilt card lift glow-border">
                        <div class="flex items-start justify-between gap-4 tilt-inner">
                            <div>
                                <h3 class="font-display text-xl text-white">{{ $exp->job_title }}</h3>
                                <p class="text-brand-500 text-sm font-semibold mt-1">{{ $exp->company }}</p>
                            </div>
                            <span class="pill text-ink-400 whitespace-nowrap">
                                {{ $exp->start_date->format('Y') }} —
                                {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('Y') ?? '—') }}
                            </span>
                        </div>
                        @if($exp->description)
                            <p class="mt-3 text-sm text-ink-300 leading-relaxed">{{ $exp->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div x-reveal class="reveal mb-10">
                <p class="section-eyebrow">Learning</p>
                <h2 x-data="wordReveal" class="section-title">Education</h2>
            </div>
            <div class="space-y-6 stagger" x-reveal>
                @foreach($educations as $edu)
                    <div x-data="cardFx(4)" class="tilt card lift glow-border">
                        <div class="flex items-start justify-between gap-4 tilt-inner">
                            <div>
                                <h3 class="font-display text-xl text-white">{{ $edu->degree }}</h3>
                                <p class="text-brand-500 text-sm font-semibold mt-1">{{ $edu->institution }}</p>
                            </div>
                            <span class="pill text-ink-400 whitespace-nowrap">
                                {{ $edu->start_date->format('Y') }} —
                                {{ $edu->is_current ? 'Present' : ($edu->end_date?->format('Y') ?? '—') }}
                            </span>
                        </div>
                        @if($edu->description)
                            <p class="mt-3 text-sm text-ink-300 leading-relaxed">{{ $edu->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════ SKILLS ════════════════════════ --}}
<section id="skills" class="section">
    <div class="container-x">
        <div x-reveal class="text-center mb-14 reveal">
            <p class="section-eyebrow">My toolkit</p>
            <h2 x-data="wordReveal" class="section-title">Skills & <span class="text-gradient-brand">Expertise</span></h2>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 stagger" x-reveal>
            @foreach($skillCategories as $category)
                <div x-data="cardFx(5)" class="tilt card lift glow-border">
                    <div class="flex items-center gap-3 mb-6 tilt-inner">
                        @if($category->icon)
                            <div class="size-12 rounded-xl bg-brand-500/10 grid place-items-center text-brand-500 text-xl depth-2">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                        @endif
                        <h3 class="font-display text-2xl text-white">{{ $category->name }}</h3>
                    </div>
                    <div class="space-y-5">
                        @foreach($category->skills as $skill)
                            <div x-intersect.once="$refs['bar' + {{ $skill->id }}].style.width = '{{ $skill->proficiency }}%'; $refs['pct' + {{ $skill->id }}].dataset.target = '{{ $skill->proficiency }}'">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-ink-200 font-medium flex items-center gap-2">
                                        @if($skill->icon)<i class="{{ $skill->icon }} text-brand-500"></i>@endif
                                        {{ $skill->name }}
                                    </span>
                                    <span class="text-brand-500 text-sm font-semibold tabular-nums" x-ref="pct{{ $skill->id }}">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="progress-bar-track">
                                    <div x-ref="bar{{ $skill->id }}" class="progress-bar-fill" style="width: 0%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════ SERVICES ════════════════════════ --}}
<section id="services" class="section bg-ink-950 relative overflow-hidden">
    <div class="orb bottom-0 right-0 size-[30rem] bg-brand-500/10" style="animation-delay: -5s"></div>
    <div class="container-x relative">
        <div x-reveal class="text-center mb-14 reveal">
            <p class="section-eyebrow">What I do</p>
            <h2 x-data="wordReveal" class="section-title">My <span class="text-gradient-brand">Services</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6 stagger" x-reveal>
            @foreach($services as $service)
                <div x-data="cardFx(7)" class="tilt card lift glow-border group relative overflow-hidden">
                    <div class="relative tilt-inner">
                        <div class="size-14 rounded-2xl bg-brand-500/10 grid place-items-center text-brand-500 text-2xl mb-5 depth-3 group-hover:bg-brand-500 group-hover:text-white group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                            <i class="{{ $service->icon ?? 'fas fa-cube' }}"></i>
                        </div>
                        <h3 class="font-display text-xl text-white mb-2 depth-2 group-hover:text-brand-500 transition-colors">{{ $service->title }}</h3>
                        @if($service->short_description)
                            <p class="text-brand-500 text-sm font-semibold mb-3">{{ $service->short_description }}</p>
                        @endif
                        <p class="text-sm text-ink-300 leading-relaxed">{{ $service->description }}</p>

                        @if($service->features)
                            <ul class="mt-5 space-y-2">
                                @foreach((array) $service->features as $feature)
                                    <li class="flex items-center gap-2 text-sm text-ink-300">
                                        <i class="fas fa-check-circle text-brand-500"></i> {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════ TECH MARQUEE ════════════════════════ --}}
@php($techList = \App\Models\Technology::orderBy('display_order')->get())
@if($techList->isNotEmpty())
    <section class="py-12 border-y border-ink-800 bg-ink-950">
        <div class="container-x">
            <p class="text-center text-xs uppercase tracking-[0.4em] text-ink-500 mb-8">Tech Stack & Tools</p>
            <div x-data="marqueeAccel(35)" class="marquee">
                <div class="marquee-track">
                    @foreach($techList as $t)
                        <span class="flex items-center gap-3 text-ink-300 whitespace-nowrap">
                            @if($t->icon)<i class="{{ $t->icon }} text-2xl text-brand-500"></i>@endif
                            <span class="font-display text-2xl tracking-wide">{{ $t->name }}</span>
                        </span>
                    @endforeach
                    @foreach($techList as $t)
                        <span class="flex items-center gap-3 text-ink-300 whitespace-nowrap">
                            @if($t->icon)<i class="{{ $t->icon }} text-2xl text-brand-500"></i>@endif
                            <span class="font-display text-2xl tracking-wide">{{ $t->name }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

{{-- ════════════════════════ PROJECTS ════════════════════════ --}}
<section id="projects" class="section">
    <div class="container-x">
        <div x-reveal class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-14 reveal">
            <div>
                <p class="section-eyebrow">Selected work</p>
                <h2 x-data="wordReveal" class="section-title">Mobile Apps Built with <span class="text-gradient-brand">Flutter</span></h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn-ghost" x-data="magnetic(0.15)">
                <span>View all projects <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 stagger" x-reveal>
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project) }}"
                   x-data="cardFx(6)"
                   data-cursor-text="View →"
                   class="tilt card lift glow-border group block p-0 overflow-hidden relative">
                    @php($cover = $project->coverUrl('card'))
                    <div x-reveal class="img-zoom clip-reveal aspect-[4/3] bg-gradient-to-br from-ink-800 to-ink-700 relative overflow-hidden">
                        @if($cover)
                            <img src="{{ $cover }}" alt="{{ $project->title }}" class="w-full h-full object-cover img-blur-up" x-data="imgLoad" loading="lazy">
                        @else
                            <x-project-placeholder :title="$project->title" :subtitle="$project->subtitle" />
                        @endif
                        {{-- Overlay on hover --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-950 via-ink-950/40 to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-500"></div>
                        {{-- View arrow --}}
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
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════ HOW I WORK ════════════════════════ --}}
<section class="section">
    <div class="container-x">
        <div class="text-center mb-14" x-reveal>
            <p class="section-eyebrow">My Process</p>
            <h2 x-data="wordReveal" class="section-title">How I <span class="text-gradient-brand">work</span></h2>
            <p class="mt-4 text-ink-300 max-w-2xl mx-auto">A clear, transparent process from initial chat to App Store launch — built to ship beautiful apps on time.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 stagger" x-reveal>
            @foreach([
                ['n' => '01', 'icon' => 'fas fa-comments',           'title' => 'Discover',  'text' => 'We talk through your idea, users, constraints, and what success looks like — no fluff, just clarity.'],
                ['n' => '02', 'icon' => 'fas fa-pencil-ruler',       'title' => 'Design',    'text' => 'Wireframes & high-fidelity Figma mocks so you can see and feel the app before we build a screen.'],
                ['n' => '03', 'icon' => 'fas fa-code',               'title' => 'Build',     'text' => 'Production-grade Flutter with BLoC/Riverpod state, Firebase backend, and weekly demo builds.'],
                ['n' => '04', 'icon' => 'fas fa-rocket',             'title' => 'Launch',    'text' => 'App Store + Play Store submission, post-launch monitoring, and a 30-day support window included.'],
            ] as $step)
                <div x-data="cardFx(6)" class="tilt card lift glow-border relative group">
                    <span class="absolute -top-4 -right-4 size-12 rounded-full bg-brand-500/15 border border-brand-500/30 grid place-items-center text-brand-500 font-display font-bold text-sm tracking-wider depth-3">{{ $step['n'] }}</span>
                    <div class="tilt-inner">
                        <div class="size-14 rounded-2xl bg-brand-500/10 grid place-items-center text-brand-500 text-2xl mb-5 depth-3 group-hover:bg-brand-500 group-hover:text-white group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                            <i class="{{ $step['icon'] }}"></i>
                        </div>
                        <h3 class="font-display text-xl text-white mb-2 depth-2 group-hover:text-brand-500 transition-colors">{{ $step['title'] }}</h3>
                        <p class="text-sm text-ink-300 leading-relaxed">{{ $step['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════ TESTIMONIALS ════════════════════════ --}}
<section id="testimonials" class="section bg-ink-950 relative overflow-hidden">
    <div class="orb top-1/4 right-0 size-[24rem] bg-brand-700/15" style="animation-delay: -6s"></div>
    <div class="container-x relative">
        <div x-reveal class="text-center mb-14 reveal">
            <p class="section-eyebrow">Kind words</p>
            <h2 x-data="wordReveal" class="section-title">What Clients <span class="text-gradient-brand">Say</span></h2>
        </div>

        @if($testimonials->isEmpty())
            <p class="text-center text-ink-500">Add testimonials in the admin panel.</p>
        @else
            <div x-data="testimonials" class="relative" x-reveal>
                <div x-ref="swiper" class="overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach($testimonials as $t)
                            <div class="swiper-slide pb-2">
                                <div x-data="cardFx(4)" class="tilt card lift glow-border h-full flex flex-col relative">
                                    <i class="fas fa-quote-left text-4xl text-brand-500/20 absolute top-4 right-4"></i>
                                    <div class="flex text-brand-500 gap-1 mb-3">
                                        @for($i = 0; $i < $t->rating; $i++)<i class="fas fa-star text-sm"></i>@endfor
                                    </div>
                                    <p class="text-ink-200 leading-relaxed flex-1">"{{ $t->content }}"</p>
                                    <div class="mt-6 flex items-center gap-3">
                                        @php($avatar = $t->getFirstMediaUrl('avatar', 'thumb'))
                                        @php($fallback = 'https://ui-avatars.com/api/?name='.urlencode($t->client_name).'&background=ff014f&color=fff&bold=true&size=200&font-size=0.4')
                                        <div class="size-12 rounded-full bg-ink-700 overflow-hidden grid place-items-center ring-2 ring-brand-500/30">
                                            <img src="{{ $avatar ?: $fallback }}" alt="{{ $t->client_name }}" class="w-full h-full object-cover" loading="lazy">
                                        </div>
                                        <div>
                                            <p class="font-semibold text-white text-sm">{{ $t->client_name }}</p>
                                            <p class="text-xs text-ink-400">
                                                {{ $t->client_title }}{{ $t->client_company ? ' · '.$t->client_company : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center justify-center gap-3 mt-8">
                    <button x-ref="prev" class="size-12 grid place-items-center rounded-full border border-ink-700 hover:border-brand-500 hover:text-brand-500 hover:scale-110 transition-all duration-300" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div x-ref="pagination" class="flex gap-2"></div>
                    <button x-ref="next" class="size-12 grid place-items-center rounded-full border border-ink-700 hover:border-brand-500 hover:text-brand-500 hover:scale-110 transition-all duration-300" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- ════════════════════════ CTA BANNER ════════════════════════ --}}
<section class="px-6 py-20">
    <div class="container-x">
        <div x-reveal class="reveal reveal-scale relative overflow-hidden rounded-3xl border border-brand-500/30 bg-gradient-to-br from-ink-900 via-ink-950 to-ink-900 p-10 md:p-16">
            {{-- Decorative orbs --}}
            <div class="absolute -top-32 -right-32 size-96 rounded-full bg-brand-500/30 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 size-96 rounded-full bg-brand-700/20 blur-3xl"></div>
            {{-- Brand color accent line --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-brand-500 to-transparent"></div>

            <div class="relative grid md:grid-cols-[1fr,auto] gap-8 items-center">
                <div>
                    <p class="section-eyebrow">Ready to start?</p>
                    <h2 x-data="wordReveal" class="section-title">Let's build something <span class="text-gradient-brand">amazing</span> together.</h2>
                    <p class="mt-4 text-ink-300 max-w-xl text-lg leading-relaxed">
                        Got a Flutter app idea, an existing codebase that needs love, or just a question about mobile-app architecture? Drop me a line — I respond within 24 hours.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row md:flex-col gap-3">
                    <a href="#contact" class="btn-primary" x-data="magnetic(0.18)">
                        <span><i class="fas fa-paper-plane"></i> Start a project</span>
                    </a>
                    @if($contact->email)
                        <a href="mailto:{{ $contact->email }}" class="btn-ghost" x-data="magnetic(0.15)">
                            <span><i class="fas fa-envelope"></i> Email directly</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════ CONTACT ════════════════════════ --}}
<section id="contact" class="section relative overflow-hidden">
    <div class="orb top-0 left-0 size-[30rem] bg-brand-500/15" style="animation-delay: -8s"></div>
    <div class="container-x grid lg:grid-cols-2 gap-12 items-start relative">
        <div x-reveal class="reveal reveal-left">
            <p class="section-eyebrow">Get in touch</p>
            <h2 x-data="wordReveal" class="section-title">Got a project? <span class="text-gradient-brand">Let's talk.</span></h2>
            <p class="mt-6 text-ink-300 leading-relaxed">
                I'm always open to discussing new opportunities, freelance work, or just chatting about Flutter and mobile-app architecture. Drop me a message and I'll respond within 24 hours.
            </p>

            <div class="mt-8 space-y-4 stagger" x-reveal>
                @if($contact->email)
                    <a href="mailto:{{ $contact->email }}" class="flex items-center gap-4 group">
                        <div class="size-12 rounded-full bg-brand-500/10 grid place-items-center text-brand-500 group-hover:bg-brand-500 group-hover:text-white group-hover:rotate-6 transition-all duration-300">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-ink-500">Email</p>
                            <p class="text-white group-hover:text-brand-500 transition-colors">{{ $contact->email }}</p>
                        </div>
                    </a>
                @endif
                @if($contact->phone)
                    <a href="tel:{{ $contact->phone }}" class="flex items-center gap-4 group">
                        <div class="size-12 rounded-full bg-brand-500/10 grid place-items-center text-brand-500 group-hover:bg-brand-500 group-hover:text-white group-hover:rotate-6 transition-all duration-300">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-ink-500">Phone</p>
                            <p class="text-white group-hover:text-brand-500 transition-colors">{{ $contact->phone }}</p>
                        </div>
                    </a>
                @endif
                @if($contact->city || $contact->country)
                    <div class="flex items-center gap-4">
                        <div class="size-12 rounded-full bg-brand-500/10 grid place-items-center text-brand-500">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-ink-500">Location</p>
                            <p class="text-white">{{ trim(($contact->city ?? '').', '.($contact->country ?? ''), ', ') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div x-reveal class="card lift reveal reveal-right">
            @livewire('contact-form')
        </div>
    </div>
</section>

@endsection
