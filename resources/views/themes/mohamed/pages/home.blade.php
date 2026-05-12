@extends('themes.mohamed.layouts.app')

@php
    $mohamedAsset = fn($p) => asset('themes/mohamed/'.$p);
    $profilePhoto = $about->getFirstMediaUrl('profile_photo') ?: $mohamedAsset('images/avatar/avatar-full.png');
    $headerSocials = \App\Models\SocialLink::active()->ordered()->get();
@endphp

@section('title', $about->name)
@section('description', $settings->site_description)

@section('content')

{{-- 3D video background --}}
<video class="body-overlay" muted autoplay loop playsinline>
    <source src="{{ $mohamedAsset('images/bg-3d/video3.mp4') }}" type="video/mp4">
</video>

{{-- Mobile menu trigger --}}
<div class="tf-btn-menu">
    <img src="{{ $mohamedAsset('icons/dashboard.svg') }}" alt="">
</div>

{{-- Off-canvas mobile sidebar --}}
<div class="tf-sidebar-menu tf-canvas">
    <div class="overlay"></div>
    <div class="sidebar-menu-inner">
        <div class="sidebar-wrap">
            <div class="sidebar-heading">
                <div class="heading text-body-1 dot-before">Menu</div>
                <span class="close-canvas"><i class="icon icon-times-solid"></i></span>
            </div>
            <ul class="sidebar-nav nav-scroll">
                <li><a class="scroll-to active" href="#home"><i class="icon icon-home-solid"></i><span class="text-body-2">Home</span></a></li>
                <li><a class="scroll-to" href="#experience"><i class="icon icon-briefcase-solid"></i><span class="text-body-2">Experience</span></a></li>
                <li><a class="scroll-to" href="#works"><i class="icon icon-tasks-solid"></i><span class="text-body-2">Works</span></a></li>
                <li><a class="scroll-to" href="#services"><i class="icon icon-stream-solid"></i><span class="text-body-2">Services</span></a></li>
                <li><a class="scroll-to" href="#about"><i class="icon icon-user-solid"></i><span class="text-body-2">About</span></a></li>
                <li><a class="scroll-to" href="#testimonial"><i class="icon icon-poll-h-solid"></i><span class="text-body-2">Testimonials</span></a></li>
                <li><a class="scroll-to" href="#contact"><i class="icon icon-envelope-solid"></i><span class="text-body-2">Contact</span></a></li>
            </ul>
        </div>
        <div class="sidebar-social">
            <div class="heading text-body-1 dot-before">Social Network</div>
            <ul class="social-links">
                @foreach($headerSocials as $link)
                    <li><a href="{{ $link->url }}" target="_blank" rel="noopener"><i class="icon icon-{{ $link->platform === 'twitter' ? 'twitter-x' : $link->platform }}"></i></a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- Right-side icon nav --}}
<ul class="right-nav nav-scroll">
    <li><a class="scroll-to active" href="#home"><i class="icon icon-home-solid"></i><span class="tooltip text-body-3">Home</span></a></li>
    <li><a class="scroll-to" href="#experience"><i class="icon icon-briefcase-solid"></i><span class="tooltip text-body-3">Experience</span></a></li>
    <li><a class="scroll-to" href="#works"><i class="icon icon-tasks-solid"></i><span class="tooltip text-body-3">Works</span></a></li>
    <li><a class="scroll-to" href="#services"><i class="icon icon-stream-solid"></i><span class="tooltip text-body-3">Services</span></a></li>
    <li><a class="scroll-to" href="#about"><i class="icon icon-user-solid"></i><span class="tooltip text-body-3">About</span></a></li>
    <li><a class="scroll-to" href="#testimonial"><i class="icon icon-poll-h-solid"></i><span class="tooltip text-body-3">Testimonial</span></a></li>
    <li><a class="scroll-to" href="#contact"><i class="icon icon-envelope-solid"></i><span class="tooltip text-body-3">Contact</span></a></li>
</ul>

{{-- Left profile widget --}}
<div class="left-sidebar">
    <div class="heading">
        <img src="{{ $mohamedAsset('images/logo/logo-1.svg') }}" alt="{{ $about->name }}">
        <div class="box-status">
            <div class="dot"></div>
            <div class="text-body-1">{{ $about->availability ?? 'Available for projects' }}</div>
        </div>
    </div>
    <div class="image">
        <div class="avatar avatar-wrap">
            <img class="lazyload avatar-bg" src="{{ $profilePhoto }}" data-src="{{ $profilePhoto }}" alt="{{ $about->name }}">
        </div>
        <img class="lazyload signature" src="{{ $mohamedAsset('images/section/mohamed-signature.png') }}" data-src="{{ $mohamedAsset('images/section/mohamed-signature.png') }}" alt="">
    </div>
    <div class="infor">
        @if($contact->email)
            <h6 class="mail letter-spacing-0">{{ $contact->email }}</h6>
        @endif
        <div class="text-body-2 address">{{ trim('Based in '.($about->location ?? ''), ' ') }}</div>
    </div>
    <ul class="social-links justify-content-center">
        @foreach($headerSocials as $link)
            <li><a href="{{ $link->url }}" target="_blank" rel="noopener"><i class="icon icon-{{ $link->platform === 'twitter' ? 'twitter-x' : $link->platform }}"></i></a></li>
        @endforeach
    </ul>
    <a href="#contact" class="bot-button">
        <div class="text-body-1 text">Get Started</div>
        <i class="icon icon-arrow-top-right"></i>
    </a>
</div>

{{-- Main content --}}
<div class="main-content relative">

    {{-- ════════════════════════ HERO ════════════════════════ --}}
    <section class="section-hero" id="home">
        <div class="tf-container">
            <div class="row">
                <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                    <div class="text-body-1 infor split-text split-lines-transform">{{ $about->location ?? '' }}</div>
                    <div class="main-title">
                        <div class="text-body-1 dot-before subtitle">Introduction</div>
                        <h1 class="title split-text effect-right">{{ $about->subtitle ?? 'Building Amazing Mobile Apps with Flutter' }}</h1>
                        <div class="text-body-2 text">{{ $about->short_bio ?? 'Flutter Developer delivering exceptional mobile applications.' }}</div>
                    </div>
                    <div class="indicators">
                        <ul class="list-tags">
                            @foreach(\App\Models\Service::where('is_active', true)->orderBy('display_order')->limit(4)->get() as $i => $svc)
                                <li><a class="text-body-2 wow fadeInUp" @if($i > 0) data-wow-delay="0.{{ $i }}s" @endif href="#services">{{ $svc->title }}</a></li>
                            @endforeach
                        </ul>
                        <div class="indicators-wrap">
                            <div class="indicators-item wow fadeInUp">
                                <div class="text-body-1 dot-before indicators-title">Years of Experience</div>
                                <div class="wg-counter style-1">
                                    <div class="flex align-items-center justify-content-end">
                                        <div class="odometer text-display-2" data-number="{{ $about->years_experience }}">0</div>
                                        <span class="sub-odo text-display-2">+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="indicators-item type-1 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="text-body-1 dot-before indicators-title">Projects Shipped</div>
                                <div class="wg-counter style-1">
                                    <div class="flex align-items-center justify-content-end">
                                        <div class="odometer text-display-2" data-number="{{ $about->projects_completed }}">0</div>
                                        <span class="sub-odo text-display-2">+</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wrapper-content relative overflow-hidden">

        {{-- ════════════════════════ EXPERIENCE ════════════════════════ --}}
        <section class="section-experiences" id="experience">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="text-body-2 dot-before subtitle">Experience</div>
                        <h2 class="desc text-color-change text-tab">
                            <span></span> {{ $about->bio ? \Illuminate\Support\Str::limit(strip_tags($about->bio), 180) : 'Senior Flutter developer crafting mobile applications that solve real problems for real users.' }}
                        </h2>
                        <div class="experiences-wrap">
                            @foreach($experiences as $exp)
                                <div class="item scrolling-effect effectLeft">
                                    <div class="sub-heading text">{{ $exp->company }}</div>
                                    <div class="job-title">
                                        <h6 class="title">{{ $exp->job_title }}</h6>
                                        <div class="text-body-2 time-line type-tags">
                                            {{ $exp->start_date->format('Y') }} —
                                            {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('Y') ?? '—') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════ WORKS / PROJECTS ════════════════════════ --}}
        <section class="section-selected-works" id="works">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="banner-slider">
                            <div class="text-container scroll-banners effect-right">
                                @for($i = 0; $i < 6; $i++)
                                    <span class="banner-text text-display-2 fw-medium">Selected Work</span>
                                    <span class="banner-img"><span class="dot-circle"></span></span>
                                @endfor
                            </div>
                        </div>
                        <div class="works-wrap">
                            @foreach($projects as $project)
                                @php($cover = $project->coverUrl() ?: $mohamedAsset('images/section/works-'.((($loop->index % 3) + 1)).'.jpg'))
                                <div class="works-item scrolling-effect effectLeft">
                                    <a class="image" href="{{ $cover }}" data-lightbox="example-1">
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
                                                {{ optional($project->published_at)->format('M Y') ?? ($project->year ?? date('Y')) }}
                                            </a>
                                        </div>
                                        <a href="{{ route('projects.show', $project) }}" class="btn-links">
                                            <i class="icon icon-arrow-top-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="box-gradient1 img_bg-1"></div>

        {{-- ════════════════════════ SERVICES (accordion) ════════════════════════ --}}
        <div class="section-services" id="services">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="section-services-inner">
                            <div class="text-body-2 dot-before subtitle">My Services</div>
                            <div class="services-wrap accordion-wrap" id="accordion-services">
                                @php($svcIcons = ['icon-pen-nib-solid','icon-ribbon-solid','icon-crop-alt-solid','icon-chess-knight-solid'])
                                @foreach($services as $svc)
                                    <div class="item accordion-item {{ $loop->first ? 'active' : 'collapsed' }}" data-bs-toggle="collapse" role="button"
                                         data-bs-target="#collapse-services-{{ $svc->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-services-{{ $svc->id }}">
                                        <div class="heading accordion-head">
                                            <div class="icon">
                                                <i class="{{ $svcIcons[$loop->index % count($svcIcons)] }}"></i>
                                            </div>
                                            <div class="text-display-2 title fw-medium">
                                                <div class="split-text effect-right">{{ $svc->title }}</div>
                                                <span class="text-body-1">({{ str_pad((string) ($loop->index + 1), 2, '0', STR_PAD_LEFT) }})</span>
                                            </div>
                                        </div>
                                        <div id="collapse-services-{{ $svc->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordion-services">
                                            <div class="list-text">
                                                @if(is_array($svc->features) && count($svc->features))
                                                    @foreach($svc->features as $feature)
                                                        <div class="text sub-heading">{{ $feature }}</div>
                                                    @endforeach
                                                @else
                                                    <div class="text sub-heading">{{ $svc->short_description ?: $svc->description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="more-infor">
                                <div class="worldwide text-body-2">
                                    <i class="icon icon-global"></i>
                                    Available to <span>Worldwide</span>
                                </div>
                                <a class="text-body-1 link" href="#contact">
                                    Contact me
                                    <i class="icon icon-arrow-top-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-gradient1 img_bg-2"></div>

        {{-- ════════════════════════ ABOUT ════════════════════════ --}}
        <section class="section-about" id="about">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="heading">
                            <div class="text-body-2 dot-before subtitle fw-medium">About Me</div>
                            <div>
                                <h2 class="fw-medium title text-color-change">{{ $about->subtitle ?? 'Behind every great app is a deep commitment to craft.' }}</h2>
                                <div class="text-body-2 text">{{ $about->bio ? \Illuminate\Support\Str::limit(strip_tags($about->bio), 380) : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════ TECH STACK ════════════════════════ --}}
        @php($techList = \App\Models\Technology::orderBy('display_order')->get())
        @if($techList->isNotEmpty())
            <section class="section-tech-stack">
                <div class="tf-container">
                    <div class="row">
                        <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                            <div class="text-display-2 fw-medium heading split-text effect-right">Tech Stack</div>
                            <div class="swiper slider-tech-stack">
                                <div class="swiper-wrapper">
                                    @foreach($techList as $tech)
                                        <div class="swiper-slide">
                                            <div class="tech-stack-item">
                                                <h3 class="fw-medium title">{{ $tech->name }}</h3>
                                                <div class="image" style="display:grid;place-items:center;height:140px;">
                                                    <i class="{{ $tech->icon ?? 'icon icon-stream-solid' }}" style="font-size:64px;color:{{ $tech->color ?? '#F3500F' }};"></i>
                                                </div>
                                                <div class="text-body-1">Used in {{ $tech->projects()->count() }} {{ \Illuminate\Support\Str::plural('project', $tech->projects()->count()) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination pagination-tech-stack"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ════════════════════════ TESTIMONIALS ════════════════════════ --}}
        @if($testimonials->isNotEmpty())
            <section class="section-testimonial" id="testimonial">
                <div class="tf-container">
                    <div class="row">
                        <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                            <div class="section-testimonial-inner">
                                <div class="text-body-2 dot-before subtitle fw-medium">Testimonial</div>
                                <div class="testimonial-wrap">
                                    <div class="swiper slider-testimonial">
                                        <div class="swiper-wrapper">
                                            @foreach($testimonials as $t)
                                                <div class="swiper-slide">
                                                    <h3 class="fw-medium text">&ldquo; {{ $t->content }} &rdquo;</h3>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="box-nav style-2">
                                            <div class="nav-sw navigation-prev-testimonial">
                                                <span class="icon icon-angle-left-solid"></span>
                                            </div>
                                            <div class="swiper-pagination pagination-testimonial"></div>
                                            <div class="nav-sw navigation-next-testimonial">
                                                <span class="icon icon-angle-right-solid"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="customer-wrap">
                                    <div class="swiper slider-customer">
                                        <div class="swiper-wrapper">
                                            @foreach($testimonials as $t)
                                                <div class="swiper-slide">
                                                    <div class="customer-info">
                                                        <div class="image">
                                                            <img class="lazyload" src="{{ $t->avatar_url }}" data-src="{{ $t->avatar_url }}" alt="{{ $t->client_name }}">
                                                        </div>
                                                        <div class="content">
                                                            <h6 class="name fw-medium">
                                                                <a href="#" class="link">{{ $t->client_name }}</a>
                                                            </h6>
                                                            <div class="text-body-2 info">{{ $t->client_title }}{{ $t->client_company ? ' · '.$t->client_company : '' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ════════════════════════ CONTACT ════════════════════════ --}}
        <section class="section-contact" id="contact">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="text-body-2 dot-before subtitle fw-medium">Contact</div>
                        <h2 class="title text-color-change fw-medium">Got a project? <br> Let's build something amazing together.</h2>
                        <div class="contact-wrap">
                            @livewire('contact-form')
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

{{-- Footer --}}
<footer class="tf-footer style-1">
    <div class="tf-container">
        <div class="row">
            <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                <a href="#contact" class="cta">
                    <img class="lazyload signature" src="{{ $mohamedAsset('images/section/mohamed-signature.png') }}" data-src="{{ $mohamedAsset('images/section/mohamed-signature.png') }}" alt="">
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
    <img src="{{ $mohamedAsset('images/section/img-bg-2.png') }}" alt="" class="map">
    <div class="box-gradient2"></div>
</footer>

@endsection
