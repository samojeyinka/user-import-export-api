<?php

use App\Http\Controllers\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/export', [UserController::class, 'export']);
Route::post('/users/import', [UserController::class, 'import']);