<?php
namespace App\Http\Controllers\Users;

use App\Services\UserExportService;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportUsers extends Controller
{
    public function __invoke(Request $request, UserExportService $exportService)
    {
        $result = $exportService->export(auth()->user(), $request->boolean('queue', false));
        
        if (!$result['success']) {
            return response()->json($result, 422);
        }
        
        return $result['queued'] 
            ? response()->json($result)
            : Excel::download(new UsersExport(auth()->user()), 'users.xlsx');
    }
}