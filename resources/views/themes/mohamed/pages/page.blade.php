@extends('themes.mohamed.layouts.app')

@php($mohamedAsset = fn($p) => asset('themes/mohamed/'.$p))

@section('title', $page->title)
@section('description', $page->excerpt)

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
                        <h1 class="title split-text effect-right">{{ $page->title }}</h1>
                        @if($page->excerpt)
                            <div class="text-body-2 text" style="margin-top:16px;">{{ $page->excerpt }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wrapper-content relative overflow-hidden">
        <section class="section-about">
            <div class="tf-container">
                <div class="row">
                    <div class="offset-xxl-5 col-xxl-7 offset-xl-4 col-xl-7 offset-lg-2 col-lg-8">
                        <div class="heading">
                            <div class="text-body-2 text" style="line-height:1.7;">{!! $page->body !!}</div>
                        </div>
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
                <a href="{{ route('home') }}" class="cta">
                    <div class="infiniteslide_wrap cta-infiniteslide style-1">
                        <div class="infiniteslide">
                            @for($i = 0; $i < 6; $i++)
                                <div class="marquee-child-item"><div class="text-display-2">Back to home</div></div>
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
