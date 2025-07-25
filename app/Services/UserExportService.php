<?php

namespace App\Services;

use App\Exports\UsersExport;
use App\Jobs\NotifyExportCompleted;

class UserExportService
{
    public function export($user = null, bool $forceQueue = false): array
    {
        $userCount = \App\Models\User::count();
        $shouldQueue = $userCount > 1000 || $forceQueue; 

        return $shouldQueue ? $this->queueExport($user) : $this->syncExport();
    }

    protected function syncExport(): array
    {
        return [
            'success' => true,
            'message' => 'Export ready for download',
            'queued' => false
        ];
    }

    protected function queueExport($user = null): array
    {
        $filename = 'users_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $export = new UsersExport($user);

        $pendingDispatch = $export->queue($filename, 'public');

        if ($user) {
            $pendingDispatch->chain([
                new NotifyExportCompleted($user, $filename)
            ]);
        }

        return [
            'success' => true,
            'message' => 'Large dataset detected. Export has been queued and will be processed in the background.',
            'filename' => $filename,
            'queued' => true,
            'notification' => $user ? 'You will be notified when the export completes.' : null
        ];
    }

    public function download(string $filename)
    {
        $path = storage_path('app/public/' . $filename);

        abort_unless(file_exists($path), 404, 'Export file not found');

        return response()->download($path)->deleteFileAfterSend();
    }
}