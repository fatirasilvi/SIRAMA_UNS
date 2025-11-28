<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.dosen.register');
});
Route::get('/tes', function () {
    return "BERHASIL";
});
