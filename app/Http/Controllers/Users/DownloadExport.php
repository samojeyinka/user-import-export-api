<?php
namespace App\Http\Controllers\Users;

use App\Services\UserExportService;
use App\Http\Controllers\Controller;

class DownloadExport extends Controller
{
    public function __invoke(string $filename, UserExportService $exportService)
    {
        return $exportService->download($filename);
    }
}