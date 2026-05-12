@extends('themes.mohamed.layouts.app')

@php($mohamedAsset = fn($p) => asset('themes/mohamed/'.$p))
@php($about = \App\Models\AboutSection::current())

@section('title', 'All Projects')
@section('description', 'Flutter mobile apps and projects built by '.$about->name.'.')

@section('content')

<video class="body-overlay" muted autoplay loop playsinline>
    <source src="{{ $mohamedAsset('images/bg-3d/video3.mp4') }}" type="video/mp4">
</video>

<div class="main-content relative">

    <section class="section-hero" id="home">
        <div class="tf-container">
            <div class="row">
                <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                    <div class="main-title">
                        <div class="text-body-1 dot-before subtitle">Portfolio</div>
                        <h1 class="title split-text effect-right">Mobile apps &amp; projects</h1>
                        <div class="text-body-2 text">Flutter apps shipped to the App Store and Google Play, plus open-source experiments.</div>
                    </div>

                    {{-- Tech filter --}}
                    @if($technologies->isNotEmpty())
                        <div class="indicators" style="margin-top:24px;">
                            <ul class="list-tags" style="display:flex;flex-wrap:wrap;gap:8px;list-style:none;padding:0;">
                                <li><a class="text-body-2 {{ ! $activeTech ? 'active' : '' }}" href="{{ route('projects.index') }}" style="padding:8px 16px;border:1px solid {{ ! $activeTech ? 'var(--primary,#F3500F)' : 'rgba(255,255,255,.2)' }};border-radius:99px;color:inherit;background:{{ ! $activeTech ? 'var(--primary,#F3500F)' : 'transparent' }};{{ ! $activeTech ? 'color:#fff;' : '' }}">All</a></li>
                                @foreach($technologies as $tech)
                                    <li>
                                        <a class="text-body-2 {{ $activeTech === $tech->slug ? 'active' : '' }}" href="{{ route('projects.index', ['tech' => $tech->slug]) }}"
                                           style="padding:8px 16px;border:1px solid {{ $activeTech === $tech->slug ? 'var(--primary,#F3500F)' : 'rgba(255,255,255,.2)' }};border-radius:99px;color:inherit;background:{{ $activeTech === $tech->slug ? 'var(--primary,#F3500F)' : 'transparent' }};{{ $activeTech === $tech->slug ? 'color:#fff;' : '' }}">
                                            {{ $tech->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="wrapper-content relative overflow-hidden">
        <section class="section-selected-works" id="works">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        @if($projects->isEmpty())
                            <div class="text-body-2 text" style="padding:80px 0;text-align:center;opacity:.7;">No projects found{{ $activeTech ? ' for this filter' : '' }}.</div>
                        @else
                            <div class="works-wrap">
                                @foreach($projects as $project)
                                    @php($cover = $project->coverUrl() ?: $mohamedAsset('images/section/works-'.((($loop->index % 3) + 1)).'.jpg'))
                                    <div class="works-item scrolling-effect effectLeft">
                                        <a class="image" href="{{ route('projects.show', $project) }}">
                                            <img class="lazyload" src="{{ $cover }}" data-src="{{ $cover }}" alt="{{ $project->title }}">
                                        </a>
                                        <div class="content">
                                            <div class="infor">
                                                @if($project->subtitle)
                                                    <div class="sub-heading sub">{{ $project->subtitle }}</div>
                                                @else
                                                    <div class="sub-heading sub">{{ $project->platform ?? 'Mobile App' }}</div>
                                                @endif
                                                <h3 class="title">
                                                    <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                                                </h3>
                                                <a href="{{ route('projects.show', $project) }}" class="link date text-body-2 type-tags">
                                                    {{ optional($project->published_at)->format('M Y') ?? ($project->year ?? '') }}
                                                </a>
                                            </div>
                                            <a href="{{ route('projects.show', $project) }}" class="btn-links">
                                                <i class="icon icon-arrow-top-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<footer class="tf-footer style-1">
    <div class="tf-container">
        <div class="row">
            <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                <a href="{{ route('home') }}#contact" class="cta">
                    <div class="infiniteslide_wrap cta-infiniteslide style-1">
                        <div class="infiniteslide">
                            @for($i = 0; $i < 6; $i++)
                                <div class="marquee-child-item"><div class="text-display-2">Book A Call</div></div>
                                <div class="marquee-child-item"><div class="dot"></div></div>
                            @endfor
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>

@endsection
