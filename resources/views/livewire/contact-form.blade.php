<div>
    @if($sent)
        <div class="text-center py-10">
            <div class="size-16 mx-auto rounded-full bg-brand-500/10 grid place-items-center text-brand-500 mb-4">
                <i class="fas fa-check text-2xl"></i>
            </div>
            <h3 class="font-display text-2xl text-white">Message sent!</h3>
            <p class="text-ink-300 mt-2">Thanks for reaching out — I'll respond within 24 hours.</p>
            <button wire:click="$set('sent', false)" class="mt-6 btn-ghost text-sm">Send another</button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider text-ink-400 mb-2">Name *</label>
                    <input wire:model="name" type="text" required
                           class="w-full bg-ink-900 border border-ink-700 rounded-lg px-4 py-3 text-ink-100 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition">
                    @error('name')<p class="text-xs text-brand-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-ink-400 mb-2">Email *</label>
                    <input wire:model="email" type="email" required
                           class="w-full bg-ink-900 border border-ink-700 rounded-lg px-4 py-3 text-ink-100 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition">
                    @error('email')<p class="text-xs text-brand-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider text-ink-400 mb-2">Phone</label>
                    <input wire:model="phone" type="tel"
                           class="w-full bg-ink-900 border border-ink-700 rounded-lg px-4 py-3 text-ink-100 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-wider text-ink-400 mb-2">Subject</label>
                    <input wire:model="subject" type="text"
                           class="w-full bg-ink-900 border border-ink-700 rounded-lg px-4 py-3 text-ink-100 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs uppercase tracking-wider text-ink-400 mb-2">Message *</label>
                <textarea wire:model="message" required rows="5"
                          class="w-full bg-ink-900 border border-ink-700 rounded-lg px-4 py-3 text-ink-100 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 outline-none transition resize-none"></textarea>
                @error('message')<p class="text-xs text-brand-500 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Honeypot --}}
            <div class="hidden" aria-hidden="true">
                <label>Website</label>
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <button type="submit" class="btn-primary w-full"
                    wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit"><i class="fas fa-paper-plane"></i> Send message</span>
                <span wire:loading wire:target="submit"><i class="fas fa-spinner fa-spin"></i> Sending…</span>
            </button>
        </form>
    @endif
</div>
