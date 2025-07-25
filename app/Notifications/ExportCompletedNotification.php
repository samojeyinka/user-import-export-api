<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('User Export Completed')
                    ->line('Your user export has been completed successfully.')
                    ->action('Download Export', url('/users/download/' . $this->filename))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'User export completed successfully',
            'filename' => $this->filename,
            'download_url' => url('/users/download/' . $this->filename),
            'type' => 'export_success'
        ];
    }
}