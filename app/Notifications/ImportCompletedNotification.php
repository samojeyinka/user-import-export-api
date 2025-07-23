<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('User Import Completed')
                    ->line('Your user import has been completed successfully.')
                    ->line('All users have been imported into the system.')
                    ->action('View Users', url('/users'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'User import completed successfully',
            'type' => 'import_success'
        ];
    }
}
