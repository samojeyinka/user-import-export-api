<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\UserExportService;

class DownloadExport extends Controller
{
    public function __invoke(string $filename, UserExportService $exportService)
    {
        return $exportService->download($filename);
    }
}
