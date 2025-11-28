<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthDosenController;

Route::get('/register-dosen', [AuthDosenController::class, 'register'])->name('dosen.register');

Route::post('/register-dosen', [AuthDosenController::class, 'registerStore'])->name('dosen.register.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tes', function () {
    return "BERHASIL";
});
