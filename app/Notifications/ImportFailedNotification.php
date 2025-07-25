<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('User Import Failed')
            ->error()
            ->line('Your user import has failed.');

        if (isset($this->data['error'])) {
            $message->line('Error: ' . $this->data['error']);
        }

        return $message
            ->line('Please check the file format and try again.')
            ->action('Try Again', url('/import'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'User import failed',
            'type' => 'import_failed',
            'error' => $this->data['error'] ?? null,
            'timestamp' => now()
        ];
    }
}