<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenDashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    return view('dashboard.index', [
        'totalPenelitian' => $user->penelitian()->count(),
        'totalPengabdian' => $user->pengabdian()->count(),
        'menungguValidasi' => $user->aktivitas()->where('status','menunggu')->count(),
        'aktivitas' => $user->aktivitas()->latest()->take(5)->get()
    ]);
}

}
