@extends('themes.reeni.layouts.app')

@php
    $settings = $settings ?? \App\Models\Setting::current();
    $about = $about ?? \App\Models\AboutSection::current();
    $contact = $contact ?? \App\Models\ContactInfo::current();
@endphp

@section('title', 'All Projects')
@section('description', 'Flutter mobile apps and projects built by Mohamed Ahmed.')

@section('content')

<section class="pt-32 pb-20 px-6 relative overflow-hidden">
    {{-- Ambient background --}}
    <div class="absolute inset-x-0 top-0 h-[60vh] -z-10 pointer-events-none">
        <div class="orb top-0 -right-40 size-[36rem] bg-brand-500/15"></div>
        <div class="orb top-1/3 -left-40 size-[24rem] bg-brand-700/10" style="animation-delay: -5s"></div>
    </div>

    <div class="container-x">
        <header x-reveal class="reveal text-center mb-14 max-w-3xl mx-auto">
            <p class="section-eyebrow">Portfolio</p>
            <h1 x-data="wordReveal" class="display text-5xl md:text-7xl tracking-tight">Mobile apps & <span class="text-gradient-brand">projects</span></h1>
            <p class="mt-4 text-ink-300">Flutter apps shipped to the App Store and Google Play, plus open-source experiments.</p>
        </header>

        <div x-reveal class="reveal flex flex-wrap items-center justify-center gap-2 mb-10">
            <a href="{{ route('projects.index') }}"
               class="pill transition-all duration-300 hover:scale-105 {{ ! $activeTech ? 'bg-brand-500 text-white border-brand-500' : '' }}">All</a>
            @foreach($technologies as $tech)
                <a href="{{ route('projects.index', ['tech' => $tech->slug]) }}"
                   class="pill transition-all duration-300 hover:scale-105 {{ $activeTech === $tech->slug ? 'bg-brand-500 text-white border-brand-500' : '' }}">
                    {{ $tech->name }}
                </a>
            @endforeach
        </div>

        @if($projects->isEmpty())
            <p class="text-center text-ink-400 py-20">No projects found{{ $activeTech ? ' for this filter' : '' }}.</p>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 stagger" x-reveal>
                @foreach($projects as $project)
                    @include('themes.reeni.partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
