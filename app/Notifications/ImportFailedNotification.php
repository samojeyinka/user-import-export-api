<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('User Import Failed')
                    ->line('Your user import has failed.')
                    ->line('Please check the file format and try again.')
                    ->action('Try Again', url('/import'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'User import failed',
            'type' => 'import_failed'
        ];
    }
}