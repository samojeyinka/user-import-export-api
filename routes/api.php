<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\IndexUser;
use App\Http\Controllers\Users\StoreUser;
use App\Http\Controllers\Users\RegisterUser;
use App\Http\Controllers\Users\ImportUsers;
use App\Http\Controllers\Users\ExportUsers;

Route::prefix('users')->group(function () {
    Route::get('/', IndexUser::class)->name('users.index');
    Route::post('/', StoreUser::class)->name('users.store');
    Route::post('/register', RegisterUser::class)->name('users.register');
    Route::post('/import', ImportUsers::class)->name('users.import');
Route::get('/export', App\Http\Controllers\Users\ExportUsers::class);
Route::get('/download/{filename}', App\Http\Controllers\Users\DownloadExport::class);
});
