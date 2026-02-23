<?php

declare(strict_types=1);

namespace Modules\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * WelcomeEmail is a notification that is sent to users when they register.
 *
 * It implements ShouldQueue to allow the email to be sent asynchronously.
 *
 * @category Notifications
 */
class WelcomeEmail extends Notification implements ShouldQueue
{
    // Use the Queueable trait to enable queuing of this notification
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable  The entity to be notified
     * @return array The channels through which the notification will be sent
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable  The entity to be notified
     * @return MailMessage The mail message to be sent
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Our Platform')
            ->greeting("Hello {$notifiable->name}!")
            ->line('Welcome to our platform. We are excited to have you aboard.')
            ->line('Your account has been successfully created.')
            ->action('Get Started', url('/'))
            ->line('If you have any questions, feel free to contact us.');
    }
}
