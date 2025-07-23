<?php
namespace App\Http\Controllers\Users;

use App\Services\UserImportService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportUsersRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportUsers extends Controller
{
    public function __invoke(ImportUsersRequest $request, UserImportService $importService)
    {
        try {
            // Get current user for notifications (if authenticated)
            $user = auth()->user();
            
            // Check if user wants to force queuing
            if ($request->boolean('queue', false)) {
                $result = $importService->forceQueue($request->file('file'), $user);
            } else {
                $result = $importService->import($request->file('file'), $user);
            }
            
            return response()->json($result);
        } catch (ValidationException $e) {
            $failures = [];
            foreach ($e->failures() as $failure) {
                $failures[] = [
                    'row' => $failure->row(),
                    'column' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values()
                ];
            }

            return response()->json([
                'success' => false,
                'message' => 'Excel validation failed',
                'failures' => $failures
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
                'error_type' => get_class($e)
            ], 500);
        }
    }
}