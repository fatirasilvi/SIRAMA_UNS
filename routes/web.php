<?php

use App\Http\Controllers\AuthDosenController;
use App\Http\Controllers\DosenDashboardController;

Route::get('/dosen/register', [AuthDosenController::class, 'register'])->name('dosen.register');
Route::post('/dosen/register', [AuthDosenController::class, 'registerStore'])->name('dosen.register.store');

Route::get('/dosen/login', [AuthDosenController::class, 'login'])->name('dosen.login');
Route::post('/dosen/login', [AuthDosenController::class, 'loginStore'])->name('dosen.login.store');

Route::middleware(['dosen'])->group(function () {
    Route::get('/dosen/dashboard', [AuthDosenController::class, 'dashboard'])
        ->name('dosen.dashboard');

    Route::post('/dosen/logout', [AuthDosenController::class, 'logout'])->name('dosen.logout');
});

