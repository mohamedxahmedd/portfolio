<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings->site_name ?? 'Mohamed Ahmed') · {{ $settings->site_tagline ?? 'Senior Flutter Developer' }}</title>
    <meta name="description" content="@yield('description', $settings->site_description ?? '')">
    <meta name="theme-color" content="{{ $settings->theme_primary_color ?? '#ff014f' }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=rubik:300,400,500,600,700,800,900|rajdhani:300,400,500,600,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <meta property="og:title" content="@yield('title', $settings->site_name ?? 'Mohamed Ahmed')">
    <meta property="og:description" content="@yield('description', $settings->site_description ?? '')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @yield('head')

    @php
        $about = $about ?? \App\Models\AboutSection::current();
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $about->name,
            'jobTitle' => $about->title,
            'url' => url('/'),
            'address' => $about->location,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
</head>
<body class="bg-ink-900 text-ink-100 antialiased">

{{-- Preloader --}}
<div x-data="preloader" class="preloader">
    <div class="preloader-spinner"></div>
</div>

{{-- Scroll progress bar --}}
<div x-data="scrollProgress" class="scroll-progress" aria-hidden="true"></div>

{{-- Custom cursor (hidden on touch devices via CSS) --}}
<div x-data="cursor" aria-hidden="true">
    <div class="cursor-ring"></div>
    <div class="cursor-dot"></div>
</div>

{{-- Cursor trail — fading pink dots behind the cursor --}}
<div x-data="cursorTrail" class="cursor-trail-layer" aria-hidden="true"></div>

@include('themes.reeni.partials.header')

<main>
    @yield('content')
</main>

@include('themes.reeni.partials.footer')

@livewireScripts
</body>
</html>
