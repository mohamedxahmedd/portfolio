@php
    $about = $about ?? \App\Models\AboutSection::current();
    $settings = $settings ?? \App\Models\Setting::current();
    $contact = $contact ?? \App\Models\ContactInfo::current();
    $mohamedAsset = fn($p) => asset('themes/mohamed/'.$p);
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <title>@yield('title', $about->name) · {{ $settings->site_tagline ?? $about->title }}</title>
    <meta name="description" content="@yield('description', $settings->site_description)">
    <meta name="author" content="{{ $about->name }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/odometer.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ $mohamedAsset('font/fonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ $mohamedAsset('icons/icomoon/style.css') }}">

    <link rel="shortcut icon" href="{{ $mohamedAsset('images/logo/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ $mohamedAsset('images/logo/favicon.png') }}">

    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type'    => 'Person',
            'name'     => $about->name,
            'jobTitle' => $about->title,
            'url'      => url('/'),
            'address'  => $about->location,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    @yield('head')

    @livewireStyles

    {{-- Theme-tweaks: hide the template's built-in color/3D switcher (we manage themes via admin instead) --}}
    <style>
        .tf-setting-color { display: none !important; }
    </style>
</head>

<body class="counter-scroll">

<!-- Start Wrapper -->
<div id="wrapper">

    @yield('content')

</div>
<!-- End Wrapper -->

<script src="{{ $mohamedAsset('js/bootstrap.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/jquery.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/jquery.validate.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/lazysize.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/wow.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/swiper-bundle.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/swiper.js') }}"></script>
<script src="{{ $mohamedAsset('js/gsap.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/Splitetext.js') }}"></script>
<script src="{{ $mohamedAsset('js/ScrollTrigger.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/ScrollSmooth.js') }}"></script>
<script src="{{ $mohamedAsset('js/handleeffectgsap.js') }}"></script>
<script src="{{ $mohamedAsset('js/odometer.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/counter.js') }}"></script>
<script src="{{ $mohamedAsset('js/infinityslide.js') }}"></script>
<script src="{{ $mohamedAsset('js/plugin.js') }}"></script>
<script src="{{ $mohamedAsset('js/lightbox.min.js') }}"></script>
<script src="{{ $mohamedAsset('js/main.js') }}"></script>

@livewireScripts

</body>
</html>
