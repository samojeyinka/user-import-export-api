<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportUsersRequest;
use App\Services\UserImportService;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportUsers extends Controller
{
    public function __invoke(ImportUsersRequest $request, UserImportService $importService)
    {
        try {
            $result = $request->boolean('queue', false)
                ? $importService->forceQueue($request->file('file'), auth()->user())
                : $importService->import($request->file('file'), auth()->user());

            return response()->json($result);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Excel validation failed',
                'failures' => collect($e->failures())->map(fn ($failure) => [
                    'row' => $failure->row(),
                    'column' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values(),
                ]),
            ], 422);
        }

    }
}
