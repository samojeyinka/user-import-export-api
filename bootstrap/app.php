<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Maatwebsite\Excel\Validators\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
   
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
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
            }
        });

    
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->expectsJson() && str_contains($request->getPathInfo(), 'import')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Import failed: ' . $e->getMessage(),
                ], 500);
            }
        });

    })->create();