<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthDosenController;
use App\Http\Controllers\DosenProfilController;
use App\Http\Controllers\DosenPenelitianController;

// ==========================
// PUBLIC ROUTES
// ==========================

// Halaman register dosen
Route::get('/dosen/register', [AuthDosenController::class, 'register'])
    ->name('dosen.register');
Route::post('/dosen/register', [AuthDosenController::class, 'registerStore'])
    ->name('dosen.register.store');

// Halaman login dosen
Route::get('/dosen/login', [AuthDosenController::class, 'login'])
    ->name('dosen.login');
Route::post('/dosen/login', [AuthDosenController::class, 'loginStore'])
    ->name('dosen.login.store');

// ==========================
// PROTECTED ROUTES (auth:dosen)
// ==========================
Route::middleware(['auth:dosen'])->group(function () {

    // Dashboard dosen
    Route::get('/dosen/dashboard', [AuthDosenController::class, 'dashboard'])
        ->name('dosen.dashboard');

    // Logout dosen
    Route::post('/dosen/logout', [AuthDosenController::class, 'logout'])
        ->name('dosen.logout');

    // ==========================
    // PROFIL DOSEN
    // ==========================

    // Halaman edit profil
    Route::get('/dosen/edit-profil', [DosenProfilController::class, 'edit'])
        ->name('dosen.edit.profil');

    // Update profil (PUT)
    Route::put('/dosen/update-profil', [DosenProfilController::class, 'update'])
        ->name('dosen.update.profil');
});

Route::prefix('dosen')->middleware('auth:dosen')->group(function () {

    // Halaman daftar penelitian
    Route::get('/penelitian', 
        [DosenPenelitianController::class, 'index']
    )->name('dosen.penelitian.index');

    // Tambah penelitian
    Route::get('/penelitian/create', 
        [DosenPenelitianController::class, 'create']
    )->name('dosen.penelitian.create');

    Route::post('/penelitian/store', 
        [DosenPenelitianController::class, 'store']
    )->name('dosen.penelitian.store');

    // Lihat detail
    Route::get('/penelitian/{id}', 
        [DosenPenelitianController::class, 'show']
    )->name('dosen.penelitian.show');

    // Edit
    Route::get('/penelitian/{id}/edit', 
        [DosenPenelitianController::class, 'edit']
    )->name('dosen.penelitian.edit');

    Route::put('/penelitian/{id}', 
        [DosenPenelitianController::class, 'update']
    )->name('dosen.penelitian.update');

    // Hapus
    Route::delete('/penelitian/{id}', 
        [DosenPenelitianController::class, 'destroy']
    )->name('dosen.penelitian.destroy');



});