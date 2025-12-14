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
        $totalPenelitian = DB::table('penelitians')->count();
        $totalPengabdian = DB::table('pengabdians')->count();
        $totalDosen      = DB::table('dosen')->count();

        $menungguValidasiPenelitian = DB::table('penelitians')
            ->where('status', 'Menunggu Validasi')
            ->count();

        $menungguValidasiPengabdian = DB::table('pengabdians')
            ->where('status', 'Menunggu Validasi')
            ->count();

        $menungguValidasi = $menungguValidasiPenelitian + $menungguValidasiPengabdian;

        // =========================
        // AKTIVITAS PENELITIAN (5 terakhir)
        // =========================
        $penelitian = DB::table('penelitians')
            ->join('dosen', 'penelitians.dosen_id', '=', 'dosen.id')
            ->select(
                'penelitians.id',
                'penelitians.judul',
                'penelitians.bidang',
                'penelitians.tahun',
                'penelitians.status',
                'penelitians.created_at',
                'dosen.nama as nama_dosen'
            )
            ->orderBy('penelitians.created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'judul'      => $item->judul,
                    'nama_dosen' => $item->nama_dosen,
                    'kategori'   => $item->bidang ?? '-',
                    'tahun'      => $item->tahun,
                    'jenis'      => 'Penelitian',
                    'status'     => $item->status,
                    'created_at' => $item->created_at,
                    'route'      => route('admin.penelitian.show', $item->id),
                ];
            });

        // =========================
        // AKTIVITAS PENGABDIAN (5 terakhir)
        // =========================
        $pengabdian = DB::table('pengabdians')
            ->join('dosen', 'pengabdians.dosen_id', '=', 'dosen.id')
            ->select(
                'pengabdians.id',
                'pengabdians.judul',
                'pengabdians.bidang',
                'pengabdians.tahun',
                'pengabdians.status',
                'pengabdians.created_at',
                'dosen.nama as nama_dosen'
            )
            ->orderBy('pengabdians.created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'judul'      => $item->judul,
                    'nama_dosen' => $item->nama_dosen,
                    'kategori'   => $item->bidang ?? '-',
                    'tahun'      => $item->tahun,
                    'jenis'      => 'Pengabdian',
                    'status'     => $item->status,
                    'created_at' => $item->created_at,
                    'route'      => route('admin.pengabdian.show', $item->id),
                ];
            });

        // =========================
        // GABUNG & AMBIL 10 TERBARU
        // =========================
        $aktivitas = collect($penelitian)
            ->concat($pengabdian)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        return view('admin.index', [
            'title'           => 'Dashboard Admin',
            'totalPenelitian' => $totalPenelitian,
            'totalPengabdian' => $totalPengabdian,
            'totalDosen'      => $totalDosen,
            'menungguValidasi'=> $menungguValidasi,
            'aktivitas'       => $aktivitas,
        ]);
    }
}
