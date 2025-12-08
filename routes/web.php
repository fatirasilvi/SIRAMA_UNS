<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthDosenController;
use App\Http\Controllers\DosenDashboardController;
use App\Http\Controllers\DosenProfilController;
use App\Http\Controllers\DosenPenelitianController;
use App\Http\Controllers\DosenPengabdianController;
use App\Http\Controllers\DosenRiwayatController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AdminDosenController;
use App\Http\Controllers\AdminPenelitianController;
use App\Http\Controllers\AdminPengabdianController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminProfilController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (DOSEN AUTH)
|--------------------------------------------------------------------------
*/

// ==========================
// REGISTER DOSEN
// ==========================
Route::get('/dosen/register', [AuthDosenController::class, 'register'])
    ->name('dosen.register');

Route::post('/dosen/register', [AuthDosenController::class, 'registerStore'])
    ->name('dosen.register.store');


// ==========================
// LOGIN DOSEN
// ==========================
Route::get('/dosen/login', [AuthDosenController::class, 'login'])
    ->name('dosen.login');

Route::post('/dosen/login', [AuthDosenController::class, 'loginStore'])
    ->name('dosen.login.store');



/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (DOSEN AREA)
|--------------------------------------------------------------------------
*/

Route::prefix('dosen')->middleware('auth:dosen')->name('dosen.')->group(function () {

    // ==========================
    // DASHBOARD & LOGOUT
    // ==========================
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])
    ->name('dashboard');


    Route::post('/logout', [AuthDosenController::class, 'logout'])
        ->name('logout');


    // ==========================
    // PROFIL DOSEN
    // ==========================
    Route::get('/edit-profil', [DosenProfilController::class, 'edit'])
        ->name('edit.profil');

    Route::put('/update-profil', [DosenProfilController::class, 'update'])
        ->name('update.profil');


    // ==========================
    // PENELITIAN DOSEN
    // ==========================
    Route::get('/penelitian', [DosenPenelitianController::class, 'index'])
        ->name('penelitian.index');

    Route::get('/penelitian/create', [DosenPenelitianController::class, 'create'])
        ->name('penelitian.create');

    Route::post('/penelitian', [DosenPenelitianController::class, 'store'])
        ->name('penelitian.store');

    Route::get('/penelitian/{id}', [DosenPenelitianController::class, 'show'])
        ->name('penelitian.show');

    Route::get('/penelitian/{id}/edit', [DosenPenelitianController::class, 'edit'])
        ->name('penelitian.edit');

    Route::put('/penelitian/{id}', [DosenPenelitianController::class, 'update'])
        ->name('penelitian.update');

    Route::delete('/penelitian/{id}', [DosenPenelitianController::class, 'destroy'])
        ->name('penelitian.destroy');
    
        
    // ==========================
    // PENGABDIAN DOSEN
    // ==========================
    Route::get('/pengabdian', [DosenPengabdianController::class, 'index'])
        ->name('pengabdian.index');

    Route::get('/pengabdian/create', [DosenPengabdianController::class, 'create'])
        ->name('pengabdian.create');

    Route::post('/pengabdian', [DosenPengabdianController::class, 'store'])
        ->name('pengabdian.store');

    Route::get('/pengabdian/{id}', [DosenPengabdianController::class, 'show'])
        ->name('pengabdian.show');

    Route::get('/pengabdian/{id}/edit', [DosenPengabdianController::class, 'edit'])
        ->name('pengabdian.edit');

    Route::put('/pengabdian/{id}', [DosenPengabdianController::class, 'update'])
        ->name('pengabdian.update');

    Route::delete('/pengabdian/{id}', [DosenPengabdianController::class, 'destroy'])
        ->name('pengabdian.destroy');

    Route::get('/riwayat', [DosenRiwayatController::class, 'index'])
        ->name('riwayat.index');

    Route::get('/riwayat/export', [DosenRiwayatController::class, 'export'])
        ->name('riwayat.export');
    
    Route::get('/riwayat/pdf', [DosenRiwayatController::class, 'exportPdf'])
    ->name('riwayat.pdf');
});

use App\Http\Controllers\AdminDashboardController;

// ==========================
// ADMIN AREA (FIXED)
// ==========================
Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {

    // ✅ DASHBOARD
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

  // DATA DOSEN
Route::get('/dosen', [AdminDosenController::class, 'index'])
    ->name('dosen.index');

Route::get('/dosen/create', [AdminDosenController::class, 'create'])
    ->name('dosen.create');

Route::post('/dosen', [AdminDosenController::class, 'store'])
    ->name('dosen.store');

Route::get('/dosen/{id}/edit', [AdminDosenController::class, 'edit'])
    ->name('dosen.edit');

Route::put('/dosen/{id}', [AdminDosenController::class, 'update'])
    ->name('dosen.update');

Route::put('/dosen/{id}/toggle-status', [AdminDosenController::class, 'toggleStatus'])
    ->name('dosen.toggle-status');



    // ==========================
// VALIDASI PENELITIAN (ADMIN)
// ==========================
Route::get('/penelitian', [AdminPenelitianController::class, 'index'])
    ->name('penelitian.index');

Route::put('/penelitian/{id}/approve', [AdminPenelitianController::class, 'approve'])
    ->name('penelitian.approve');

Route::put('/penelitian/{id}/reject', [AdminPenelitianController::class, 'reject'])
    ->name('penelitian.reject');

Route::get('/penelitian/{id}', [AdminPenelitianController::class, 'show'])
    ->name('penelitian.show');


    // ==========================
// VALIDASI PENGABDIAN
// ==========================
Route::get('/pengabdian', [AdminPengabdianController::class, 'index'])
    ->name('pengabdian.index');

Route::get('/pengabdian/{id}', [AdminPengabdianController::class, 'show'])
    ->name('pengabdian.show');

Route::put('/pengabdian/{id}/approve', [AdminPengabdianController::class, 'approve'])
    ->name('pengabdian.approve');

Route::put('/pengabdian/{id}/reject', [AdminPengabdianController::class, 'reject'])
    ->name('pengabdian.reject');


    // LAPORAN REKAP
Route::get('/laporan', [AdminLaporanController::class, 'index'])
    ->name('laporan.index');

Route::get('/laporan/export-pdf', [AdminLaporanController::class, 'exportPdf'])
    ->name('laporan.export.pdf');

Route::get('/laporan/export-excel', [AdminLaporanController::class, 'exportExcel'])
    ->name('laporan.export.excel');


    // ✅ EDIT PROFIL ADMIN (INI YANG BIKIN ERROR TADI)
    Route::get('/edit-profil', [AdminProfilController::class, 'edit'])
        ->name('edit.profil');

    Route::put('/update-profil', [AdminProfilController::class, 'update'])
        ->name('update.profil');

    // ✅ LOGOUT ADMIN
    Route::post('/logout', [AuthAdminController::class, 'logout'])
        ->name('logout');
    

});

