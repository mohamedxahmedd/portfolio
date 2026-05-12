@php
    $headerSocials = \App\Models\SocialLink::active()->where('show_in_header', true)->ordered()->get();
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 12)"
    :class="scrolled ? 'bg-ink-950/90 backdrop-blur border-ink-800' : 'bg-transparent border-transparent'"
    class="fixed top-0 inset-x-0 z-50 border-b transition"
>
    <div class="container-x flex items-center justify-between py-4 px-6">
        <a href="{{ route('home') }}" class="font-display text-2xl font-bold tracking-wider group">
            <span class="inline-block transition-transform duration-300 group-hover:-translate-y-0.5">
                {{ $settings->site_name ?? 'Mohamed Ahmed' }}<span class="text-brand-500 inline-block transition-transform duration-300 group-hover:scale-150 origin-bottom-left">.</span>
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
            <a href="{{ route('home') }}#about" class="nav-link">About</a>
            <a href="{{ route('home') }}#services" class="nav-link">Services</a>
            <a href="{{ route('projects.index') }}" class="nav-link">Projects</a>
            <a href="{{ route('home') }}#testimonials" class="nav-link">Testimonials</a>
            <a href="{{ route('home') }}#contact" class="nav-link">Contact</a>
        </nav>

        <div class="hidden md:flex items-center gap-3">
            @foreach($headerSocials as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener"
                   class="size-9 grid place-items-center rounded-full border border-ink-700 text-ink-300 hover:border-brand-500 hover:text-brand-500 hover:scale-110 transition-all duration-300"
                   aria-label="{{ $link->label }}">
                    <i class="{{ $link->icon_class }}"></i>
                </a>
            @endforeach
            <a href="{{ route('home') }}#contact" x-data="magnetic(0.18)" class="btn-primary text-sm">
                <span><i class="fas fa-paper-plane"></i> Hire me</span>
            </a>
        </div>

        <button @click="open = !open" class="md:hidden size-10 grid place-items-center" aria-label="Toggle menu">
            <i class="fas" :class="open ? 'fa-times' : 'fa-bars'"></i>
        </button>
    </div>

    <div x-show="open" x-transition x-cloak class="md:hidden bg-ink-950 border-t border-ink-800">
        <nav class="container-x px-6 py-4 flex flex-col gap-3 text-sm">
            <a href="{{ route('home') }}#about" @click="open = false" class="py-2 hover:text-brand-500">About</a>
            <a href="{{ route('home') }}#services" @click="open = false" class="py-2 hover:text-brand-500">Services</a>
            <a href="{{ route('projects.index') }}" @click="open = false" class="py-2 hover:text-brand-500">Projects</a>
            <a href="{{ route('home') }}#testimonials" @click="open = false" class="py-2 hover:text-brand-500">Testimonials</a>
            <a href="{{ route('home') }}#contact" @click="open = false" class="py-2 hover:text-brand-500">Contact</a>
            <a href="{{ route('home') }}#contact" @click="open = false" class="btn-primary mt-2 text-sm">Hire me</a>
        </nav>
    </div>
</header>
