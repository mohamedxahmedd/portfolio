@php
    $footerSocials = \App\Models\SocialLink::active()->where('show_in_footer', true)->ordered()->get();
    $contactInfo = $contact ?? \App\Models\ContactInfo::current();
    $aboutFooter = $about ?? \App\Models\AboutSection::current();
@endphp

<footer class="border-t border-ink-800 bg-ink-950 mt-20">
    <div class="container-x px-6 py-16 grid md:grid-cols-3 gap-12">
        <div>
            <a href="{{ route('home') }}" class="font-display text-2xl font-bold tracking-wider">
                {{ $settings->site_name ?? 'Mohamed Ahmed' }}<span class="text-brand-500">.</span>
            </a>
            <p class="mt-4 text-ink-400 text-sm leading-relaxed">
                {{ $settings->site_description ?? 'Senior Flutter developer building beautiful cross-platform mobile applications.' }}
            </p>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($footerSocials as $link)
                    <a href="{{ $link->url }}" target="_blank" rel="noopener"
                       class="size-10 grid place-items-center rounded-full border border-ink-700 text-ink-300 hover:border-brand-500 hover:text-brand-500 transition"
                       aria-label="{{ $link->label }}">
                        <i class="{{ $link->icon_class }}"></i>
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="font-display text-lg mb-4 uppercase tracking-wider text-brand-500">Sitemap</h4>
            <ul class="space-y-2 text-sm text-ink-300">
                <li><a href="{{ route('home') }}#about" class="hover:text-brand-500">About</a></li>
                <li><a href="{{ route('home') }}#services" class="hover:text-brand-500">Services</a></li>
                <li><a href="{{ route('projects.index') }}" class="hover:text-brand-500">All Projects</a></li>
                <li><a href="{{ route('home') }}#testimonials" class="hover:text-brand-500">Testimonials</a></li>
                <li><a href="{{ route('home') }}#contact" class="hover:text-brand-500">Contact</a></li>
                <li><a href="{{ url('privacy-policy') }}" class="hover:text-brand-500">Privacy</a></li>
                <li><a href="{{ url('terms') }}" class="hover:text-brand-500">Terms</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-display text-lg mb-4 uppercase tracking-wider text-brand-500">Get in touch</h4>
            <ul class="space-y-3 text-sm text-ink-300">
                @if($contactInfo->email)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-brand-500"></i>
                        <a href="mailto:{{ $contactInfo->email }}" class="hover:text-brand-500">{{ $contactInfo->email }}</a>
                    </li>
                @endif
                @if($contactInfo->phone)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-brand-500"></i>
                        <a href="tel:{{ $contactInfo->phone }}" class="hover:text-brand-500">{{ $contactInfo->phone }}</a>
                    </li>
                @endif
                @if($contactInfo->city || $contactInfo->country)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-brand-500"></i>
                        <span>{{ trim(($contactInfo->city ?? '').', '.($contactInfo->country ?? ''), ', ') }}</span>
                    </li>
                @endif
                @if($contactInfo->working_hours)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-clock text-brand-500"></i>
                        <span>{{ $contactInfo->working_hours }}</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="border-t border-ink-800 py-6 px-6">
        <div class="container-x flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-ink-400">
            <span>© {{ date('Y') }} {{ $aboutFooter->name ?? 'Mohamed Ahmed' }}. All rights reserved.</span>
            <span>Built with <span class="text-brand-500">♥</span> using Laravel + Filament.</span>
        </div>
    </div>
</footer>
