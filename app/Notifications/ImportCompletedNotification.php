<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportCompletedNotification extends Notification implements ShouldQueue
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
        $hasFailures = $this->data['has_failures'] ?? false;
        $failureCount = $this->data['failure_count'] ?? 0;

        $message = (new MailMessage)
            ->subject($hasFailures ? 'User Import Completed with Issues' : 'User Import Completed')
            ->line('Your user import has been completed.');

        if ($hasFailures) {
            $message->line("However, {$failureCount} rows failed to import due to validation errors.")
                   ->line('The valid rows have been successfully imported.')
                   ->line('Please review and correct the failed rows, then re-import if needed.');
        } else {
            $message->line('All users have been imported successfully into the system.');
        }

        return $message->action('View Users', url('/users'));
    }

    public function toDatabase($notifiable)
    {
        $hasFailures = $this->data['has_failures'] ?? false;
        $failureCount = $this->data['failure_count'] ?? 0;

        return [
            'message' => $hasFailures 
                ? "User import completed with {$failureCount} failures" 
                : 'User import completed successfully',
            'type' => $hasFailures ? 'import_partial' : 'import_success',
            'has_failures' => $hasFailures,
            'failure_count' => $failureCount,
            'failures' => $this->data['failures'] ?? null,
            'timestamp' => now()
        ];
    }
}