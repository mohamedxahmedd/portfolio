<?php

namespace App\Notifications;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactSubmissionNotification extends Notification
{
    use Queueable;

    public function __construct(public ContactSubmission $submission) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $s = $this->submission;

        $mail = (new MailMessage)
            ->subject('New contact form submission — '.($s->subject ?: 'No subject'))
            ->greeting('You have a new portfolio enquiry.')
            ->line('**From:** '.$s->name.' <'.$s->email.'>');

        if ($s->phone) {
            $mail->line('**Phone:** '.$s->phone);
        }

        return $mail
            ->line('**Subject:** '.($s->subject ?: '—'))
            ->line('**Message:**')
            ->line($s->message)
            ->action('Open in admin', url('/admin/contact-submissions/'.$s->id.'/edit'))
            ->salutation('— Reeni CMS');
    }
}
