<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use App\Notifications\NewContactSubmissionNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|min:2|max:120')]
    public string $name = '';

    #[Validate('required|email|max:160')]
    public string $email = '';

    #[Validate('nullable|max:40')]
    public string $phone = '';

    #[Validate('nullable|max:200')]
    public string $subject = '';

    #[Validate('required|min:10|max:5000')]
    public string $message = '';

    // Honeypot — must remain empty
    public string $website = '';

    public bool $sent = false;

    public function submit(): void
    {
        if (filled($this->website)) {
            $this->sent = true;

            return;
        }

        $key = 'contact:'.request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('message', 'Too many attempts. Please try again later.');

            return;
        }
        RateLimiter::hit($key, 600);

        $this->validate();

        $submission = ContactSubmission::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'subject' => $this->subject ?: null,
            'message' => $this->message,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 255),
        ]);

        if ($contactEmail = \App\Models\ContactInfo::current()->email) {
            Notification::route('mail', $contactEmail)
                ->notify(new NewContactSubmissionNotification($submission));
        }

        $this->sent = true;
        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
