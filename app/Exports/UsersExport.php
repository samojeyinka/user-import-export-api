<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, ShouldQueue, WithHeadings
{
    use Exportable;

    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function query()
    {
        return User::query()->select('id', 'full_name', 'created_at');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Full Name',
            'Created At',
        ];
    }

    public $queue = 'exports';

    public $timeout = 300;

    public function failed(\Throwable $exception): void
    {
        \Log::error('User export failed: '.$exception->getMessage());

        if ($this->user) {
            $this->user->notify(new \App\Notifications\ExportFailedNotification);
        }
    }
}
