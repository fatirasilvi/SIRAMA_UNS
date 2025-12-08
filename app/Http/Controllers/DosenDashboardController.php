<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        // Hitung total penelitian
        $totalPenelitian = DB::table('penelitians')
                            ->where('dosen_id', $dosen->id)
                            ->count();

        // Hitung total pengabdian (jika tabel sudah ada)
        $totalPengabdian = DB::table('pengabdians')
                            ->where('dosen_id', $dosen->id)
                            ->count();

        // Hitung menunggu validasi
        $menungguValidasiPenelitian = DB::table('penelitians')
                                        ->where('dosen_id', $dosen->id)
                                        ->where('status', 'Menunggu Validasi')
                                        ->count();

        $menungguValidasiPengabdian = DB::table('pengabdians')
                                        ->where('dosen_id', $dosen->id)
                                        ->where('status', 'Menunggu Validasi')
                                        ->count();

        $menungguValidasi = $menungguValidasiPenelitian + $menungguValidasiPengabdian;

        // Ambil aktivitas terbaru (10 terakhir)
        $penelitianList = DB::table('penelitians')
                            ->select(
                                'id',
                                'judul',
                                'bidang',
                                'tahun',
                                'status',
                                'created_at'
                            )
                            ->where('dosen_id', $dosen->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get()
                            ->map(function($item) {
                                return [
                                    'id' => $item->id,
                                    'judul' => $item->judul,
                                    'kategori' => $item->bidang ?? '-',
                                    'tahun' => $item->tahun,
                                    'jenis' => 'Penelitian',
                                    'status' => $item->status,
                                    'created_at' => $item->created_at,
                                    'route' => route('dosen.penelitian.show', $item->id),
                                ];
                            });

        $pengabdianList = DB::table('pengabdians')
                            ->select(
                                'id',
                                'judul',
                                'bidang',
                                'tahun',
                                'status',
                                'created_at'
                            )
                            ->where('dosen_id', $dosen->id)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get()
                            ->map(function($item) {
                                return [
                                    'id' => $item->id,
                                    'judul' => $item->judul,
                                    'kategori' => $item->bidang ?? '-',
                                    'tahun' => $item->tahun,
                                    'jenis' => 'Pengabdian',
                                    'status' => $item->status,
                                    'created_at' => $item->created_at,
                                    'route' => route('dosen.pengabdian.show', $item->id),
                                ];
                            });

        // Gabungkan dan ambil 10 terbaru
        $aktivitas = collect($penelitianList)
                        ->concat($pengabdianList)
                        ->sortByDesc('created_at')
                        ->take(10)
                        ->values();

        return view('dosen.index', [
    'title' => 'Dashboard Dosen',
    'totalPenelitian' => $totalPenelitian,
    'totalPengabdian' => $totalPengabdian,
    'menungguValidasi' => $menungguValidasi,
    'aktivitas' => $aktivitas
]);

    }
}