@extends('themes.mohamed.layouts.app')

@php
    $mohamedAsset = fn($p) => asset('themes/mohamed/'.$p);
    $cover = $project->coverUrl();
    $screenshots = $project->getMedia('screenshots');
@endphp

@section('title', $project->title)
@section('description', $project->description)

@section('head')
    @if($cover)<meta property="og:image" content="{{ $cover }}">@endif
@endsection

@section('content')

<video class="body-overlay" muted autoplay loop playsinline>
    <source src="{{ $mohamedAsset('images/bg-3d/video3.mp4') }}" type="video/mp4">
</video>

<div class="main-content relative">

    <section class="section-hero" id="home">
        <div class="tf-container">
            <div class="row">
                <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                    <a href="{{ route('projects.index') }}" class="text-body-1 dot-before subtitle" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;margin-bottom:24px;">
                        <i class="icon icon-angle-left-solid"></i> All projects
                    </a>
                    <div class="main-title">
                        <div class="text-body-1 dot-before subtitle">{{ $project->year ?? '' }} · {{ $project->platform ?? 'Mobile' }}</div>
                        <h1 class="title split-text effect-right">{{ $project->title }}</h1>
                        @if($project->subtitle)
                            <div class="text-body-2 text" style="margin-top:16px;">{{ $project->subtitle }}</div>
                        @endif
                        <div class="text-body-2 text" style="margin-top:24px;max-width:560px;">{{ $project->description }}</div>
                    </div>

                    {{-- App Store + Play Store + repo links --}}
                    @if($project->app_store_url || $project->play_store_url || $project->github_url || $project->live_demo_url)
                        <div class="indicators" style="margin-top:32px;">
                            <ul class="list-tags" style="display:flex;flex-wrap:wrap;gap:12px;list-style:none;padding:0;">
                                @if($project->app_store_url)
                                    <li>
                                        <a class="text-body-2" href="{{ $project->app_store_url }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;padding:12px 20px;background:var(--primary,#F3500F);color:#fff;border-radius:99px;">
                                            <span style="font-size:24px;">&#xf179;</span>
                                            <span style="display:flex;flex-direction:column;line-height:1.1;">
                                                <small style="opacity:.8;font-size:10px;">Download on the</small>
                                                <strong>App Store</strong>
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                @if($project->play_store_url)
                                    <li>
                                        <a class="text-body-2" href="{{ $project->play_store_url }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;padding:12px 20px;background:var(--primary,#F3500F);color:#fff;border-radius:99px;">
                                            <span style="font-size:24px;">&#xf3ab;</span>
                                            <span style="display:flex;flex-direction:column;line-height:1.1;">
                                                <small style="opacity:.8;font-size:10px;">Get it on</small>
                                                <strong>Google Play</strong>
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                @if($project->github_url)
                                    <li><a class="text-body-2" href="{{ $project->github_url }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;padding:12px 20px;border:1px solid currentColor;border-radius:99px;color:inherit;">View source</a></li>
                                @endif
                                @if($project->live_demo_url)
                                    <li><a class="text-body-2" href="{{ $project->live_demo_url }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:8px;padding:12px 20px;border:1px solid currentColor;border-radius:99px;color:inherit;">Live demo</a></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="wrapper-content relative overflow-hidden">

        @if($cover)
            <section class="section-selected-works">
                <div class="tf-container">
                    <div class="row">
                        <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                            <a class="image" href="{{ $cover }}" data-lightbox="cover" style="display:block;border-radius:24px;overflow:hidden;">
                                <img class="lazyload" src="{{ $cover }}" data-src="{{ $cover }}" alt="{{ $project->title }}" style="width:100%;height:auto;">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Description body --}}
        <section class="section-about">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="heading">
                            @if($project->body)
                                <div class="text-body-2 text">{!! nl2br(e(strip_tags($project->body))) !!}</div>
                            @endif

                            @if($project->problem)
                                <div style="margin-top:32px;">
                                    <div class="text-body-2 dot-before subtitle fw-medium">The problem</div>
                                    <div class="text-body-2 text">{{ $project->problem }}</div>
                                </div>
                            @endif

                            @if($project->solution)
                                <div style="margin-top:24px;">
                                    <div class="text-body-2 dot-before subtitle fw-medium">The solution</div>
                                    <div class="text-body-2 text">{{ $project->solution }}</div>
                                </div>
                            @endif

                            @if(is_array($project->features) && count($project->features))
                                <div style="margin-top:32px;">
                                    <div class="text-body-2 dot-before subtitle fw-medium">Key features</div>
                                    <div class="experiences-wrap">
                                        @foreach($project->features as $feature)
                                            <div class="item scrolling-effect effectLeft">
                                                <div class="sub-heading text">{{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }}</div>
                                                <div class="job-title">
                                                    <h6 class="title">{{ $feature }}</h6>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($project->technologies->isNotEmpty())
                                <div style="margin-top:32px;">
                                    <div class="text-body-2 dot-before subtitle fw-medium">Tech stack</div>
                                    <ul class="list-tags" style="display:flex;flex-wrap:wrap;gap:8px;list-style:none;padding:0;">
                                        @foreach($project->technologies as $tech)
                                            <li><a class="text-body-2" href="#" style="padding:8px 16px;border:1px solid rgba(255,255,255,.2);border-radius:99px;color:inherit;">{{ $tech->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Screenshots --}}
        @if($screenshots->isNotEmpty())
            <section class="section-selected-works">
                <div class="tf-container">
                    <div class="row">
                        <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                            <div class="text-body-2 dot-before subtitle fw-medium">Screens</div>
                            <div class="works-wrap" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
                                @foreach($screenshots as $shot)
                                    <a class="image" href="{{ $shot->getUrl() }}" data-lightbox="screens" style="display:block;border-radius:16px;overflow:hidden;aspect-ratio:9/16;">
                                        <img class="lazyload" src="{{ $shot->getUrl() }}" data-src="{{ $shot->getUrl() }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Related projects --}}
        @if($related->isNotEmpty())
            <section class="section-selected-works">
                <div class="tf-container">
                    <div class="row">
                        <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                            <div class="text-body-2 dot-before subtitle fw-medium">Related projects</div>
                            <div class="works-wrap">
                                @foreach($related as $other)
                                    @php($oc = $other->coverUrl())
                                    <div class="works-item scrolling-effect effectLeft">
                                        @if($oc)
                                            <a class="image" href="{{ route('projects.show', $other) }}">
                                                <img class="lazyload" src="{{ $oc }}" data-src="{{ $oc }}" alt="{{ $other->title }}">
                                            </a>
                                        @endif
                                        <div class="content">
                                            <div class="infor">
                                                <h3 class="title">
                                                    <a href="{{ route('projects.show', $other) }}">{{ $other->title }}</a>
                                                </h3>
                                                <a href="{{ route('projects.show', $other) }}" class="link date text-body-2 type-tags">View →</a>
                                            </div>
                                            <a href="{{ route('projects.show', $other) }}" class="btn-links"><i class="icon icon-arrow-top-right"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

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
