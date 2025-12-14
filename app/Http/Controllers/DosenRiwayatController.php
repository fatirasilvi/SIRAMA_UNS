<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Bidang;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenRiwayatExport;

class DosenRiwayatController extends Controller
{
    // ============================
    // INDEX RIWAYAT & LAPORAN
    // ============================
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        // Ambil penelitian yang disetujui
        $penelitian = Penelitian::with('bidangRelation')
            ->where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'penelitian';
                $item->bidang = $item->bidangRelation->nama_bidang ?? $item->bidang ?? '-';
                return $item;
            });

        // Ambil pengabdian yang disetujui
        $pengabdian = Pengabdian::with('bidangRelation')
            ->where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'pengabdian';
                $item->bidang = $item->bidangRelation->nama_bidang ?? $item->bidang ?? '-';
                return $item;
            });

        // Gabungkan keduanya
        $riwayat = $penelitian->merge($pengabdian)->sortByDesc('tahun');

        // Ambil daftar bidang untuk filter
        $bidangList = Bidang::where('is_active', true)
            ->orderBy('nama_bidang')
            ->get();

        return view('dosen.riwayat.index', [
            'title' => 'Riwayat & Laporan',
            'riwayat' => $riwayat,
            'bidangList' => $bidangList
        ]);
    }

    // ============================
    // EXPORT PDF
    // ============================
    public function exportPdf()
    {
        $dosen = Auth::guard('dosen')->user();

        $penelitian = Penelitian::with('bidangRelation')
            ->where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Penelitian';
                $item->bidang_nama = $item->bidangRelation->nama_bidang ?? $item->bidang ?? '-';
                return $item;
            });

        $pengabdian = Pengabdian::with(['bidangRelation', 'researchGroup'])
            ->where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Pengabdian';
                $item->bidang_nama = $item->bidangRelation->nama_bidang ?? $item->bidang ?? '-';
                $item->research_group_nama = $item->researchGroup->nama_group ?? '-';
                return $item;
            });

        $riwayat = $penelitian->merge($pengabdian)->sortByDesc('tahun');

        $pdf = Pdf::loadView('dosen.riwayat.pdf', [
            'riwayat' => $riwayat,
            'dosen'   => $dosen,
            'tanggal' => date('d F Y')
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Riwayat_' . $dosen->nama . '_' . date('Y-m-d') . '.pdf');
    }

    // ============================
    // EXPORT EXCEL
    // ============================
    public function exportExcel()
{
    $dosen = Auth::guard('dosen')->user()->load('prodi'); // ✅ tambah ini

    $penelitian = Penelitian::with('bidangRelation')
        ->where('dosen_id', $dosen->id)
        ->where('status', 'Disetujui')
        ->get()
        ->map(function ($item) {
            $item->tipe = 'Penelitian';
            $item->bidang_nama = $item->bidangRelation->nama_bidang ?? $item->bidang ?? '-';
            return $item;
        });

    $pengabdian = Pengabdian::with(['bidangRelation', 'researchGroup'])
        ->where('dosen_id', $dosen->id)
        ->where('status', 'Disetujui')
        ->get()
        ->map(function ($item) {
            $item->tipe = 'Pengabdian';
            $item->bidang_nama = $item->bidangRelation->nama_bidang ?? $item->bidang ?? '-';
            $item->research_group_nama = $item->researchGroup->nama_group ?? '-';
            return $item;
        });

    $riwayat = $penelitian->merge($pengabdian)->sortByDesc('tahun');

    return Excel::download(
        new DosenRiwayatExport($riwayat, $dosen),
        'Laporan_Riwayat_' . $dosen->nama . '_' . date('Y-m-d') . '.xlsx'
    );
}

}