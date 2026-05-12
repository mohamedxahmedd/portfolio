@extends('themes.reeni.layouts.app')

@php
    $settings = $settings ?? \App\Models\Setting::current();
    $about = $about ?? \App\Models\AboutSection::current();
    $contact = $contact ?? \App\Models\ContactInfo::current();
@endphp

@section('title', $page->title)
@section('description', $page->excerpt)

@section('content')

<article class="pt-32 pb-20 px-6">
    <div class="container-x max-w-3xl">
        <header class="mb-10">
            <h1 class="display text-4xl md:text-6xl tracking-tight">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="mt-4 text-lg text-ink-300">{{ $page->excerpt }}</p>
            @endif
        </header>

        <div class="prose prose-invert prose-lg max-w-none text-ink-200">
            {!! $page->body !!}
        </div>
    </div>
</article>

@endsection
