<?php

namespace App\Services;

use App\Imports\QueuedUsersImport;
use App\Imports\UsersImport;
use App\Jobs\NotifyImportCompleted;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class UserImportService
{
    public function import(UploadedFile $file, $user = null): array
    {
        $shouldQueue = $file->getSize() > (5 * 1024 * 1024);

        return $shouldQueue
            ? $this->queueImport($file, $user)
            : $this->syncImport($file);
    }

    protected function syncImport(UploadedFile $file): array
    {
        Excel::import(new UsersImport, $file);

        return [
            'success' => true,
            'message' => 'Users imported successfully',
            'queued' => false,
        ];
    }

    protected function queueImport(UploadedFile $file, $user = null): array
    {
        $import = new QueuedUsersImport($user);
        $pendingDispatch = $import->queue($file);

        if ($user) {
            $pendingDispatch->chain([
                new NotifyImportCompleted($user),
            ]);
        }

        return [
            'success' => true,
            'message' => 'Large file detected. Import has been queued and will be processed in the background.',
            'queued' => true,
            'notification' => $user ? 'You will be notified when the import completes.' : null,
        ];
    }

    public function forceQueue(UploadedFile $file, $user = null): array
    {
        return $this->queueImport($file, $user);
    }
}
