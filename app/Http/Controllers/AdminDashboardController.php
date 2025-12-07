<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{

public function index()
{
    // =========================
    // STATISTIK
    // =========================

    $totalPenelitian  = DB::table('penelitians')->count();
    $totalPengabdian  = DB::table('pengabdians')->count();
    $totalDosen       = DB::table('dosen')->count();

    $menungguValidasiPenelitian = DB::table('penelitians')
        ->where('status', 'Menunggu Validasi')
        ->count();

    $menungguValidasiPengabdian = DB::table('pengabdians')
        ->where('status', 'Menunggu Validasi')
        ->count();

    $menungguValidasi = $menungguValidasiPenelitian + $menungguValidasiPengabdian;

    // =========================
    // AKTIVITAS PENELITIAN
    // =========================

    $penelitian = DB::table('penelitians')
        ->join('dosen', 'penelitians.dosen_id', '=', 'dosen.id')
        ->select(
            'penelitians.judul',
            'penelitians.tahun',
            'penelitians.status',
            'penelitians.created_at',
            'dosen.nama as nama_dosen',
            DB::raw("'Penelitian' as jenis")
        )
        ->orderBy('penelitians.created_at', 'desc')
        ->get();

    // =========================
    // AKTIVITAS PENGABDIAN
    // =========================

    $pengabdian = DB::table('pengabdians')
        ->join('dosen', 'pengabdians.dosen_id', '=', 'dosen.id')
        ->select(
            'pengabdians.judul',
            'pengabdians.tahun',
            'pengabdians.status',
            'pengabdians.created_at',
            'dosen.nama as nama_dosen',
            DB::raw("'Pengabdian' as jenis")
        )
        ->orderBy('pengabdians.created_at', 'desc')
        ->get();

    // =========================
    // GABUNG & AMBIL 10 TERBARU
    // =========================

    $aktivitas = collect($penelitian)
        ->merge($pengabdian)
        ->sortByDesc('created_at')
        ->take(10)
        ->values();

    return view('admin.index', compact(
        'totalPenelitian',
        'totalPengabdian',
        'totalDosen',
        'menungguValidasi',
        'aktivitas'
    ));
}
}