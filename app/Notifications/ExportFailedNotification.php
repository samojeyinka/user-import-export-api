<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('User Export Failed')
                    ->line('Your user export has failed.')
                    ->line('Please try again or contact support if the issue persists.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'User export failed',
            'type' => 'export_failed'
        ];
    }
}