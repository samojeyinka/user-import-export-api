<?php

namespace App\Jobs;

use App\Notifications\ExportCompletedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyExportCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $filename;

    public function __construct($user, $filename)
    {
        $this->user = $user;
        $this->filename = $filename;
    }

    public function handle()
    {
        $this->user->notify(new ExportCompletedNotification($this->filename));
    }
}
