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
    Route::get('/export', ExportUsers::class)->name('users.export');
    Route::post('/import', ImportUsers::class)->name('users.import');
});
