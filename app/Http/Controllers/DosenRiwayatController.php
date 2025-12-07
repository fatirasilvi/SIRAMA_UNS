<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Models\Bidang;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenRiwayatController extends Controller
{
    // ============================
    // INDEX RIWAYAT & LAPORAN
    // ============================
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        // Ambil penelitian yang disetujui
        $penelitian = Penelitian::where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'penelitian';
                return $item;
            });

        // Ambil pengabdian yang disetujui
        $pengabdian = Pengabdian::where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'pengabdian';
                return $item;
            });

        // Gabungkan keduanya
        $riwayat = $penelitian->merge($pengabdian)->sortByDesc('tahun');

        // Ambil daftar bidang untuk filter
        $bidangList = Bidang::where('is_active', true)
            ->orderBy('nama_bidang')
            ->get();

        return view('dosen.riwayat.index', compact('riwayat', 'bidangList'));
    }

    // ============================
    // EXPORT LAPORAN (CSV)
    // ============================
    public function export()
    {
        $dosen = Auth::guard('dosen')->user();

        $penelitian = Penelitian::where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Penelitian';
                return $item;
            });

        $pengabdian = Pengabdian::where('dosen_id', $dosen->id)
            ->where('status', 'Disetujui')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Pengabdian';
                return $item;
            });

        $riwayat = $penelitian->merge($pengabdian)->sortByDesc('tahun');

        $response = new StreamedResponse(function () use ($riwayat) {
            $handle = fopen('php://output', 'w');

            // Header CSV
            fputcsv($handle, [
                'No',
                'Judul',
                'Bidang',
                'Tahun',
                'Status',
                'Jenis'
            ]);

            $no = 1;
            foreach ($riwayat as $item) {
                fputcsv($handle, [
                    $no++,
                    $item->judul,
                    $item->bidang,
                    $item->tahun,
                    $item->status,
                    $item->tipe,
                ]);
            }

            fclose($handle);
        });

        $filename = 'Riwayat_Penelitian_dan_Pengabdian_' . date('Y-m-d') . '.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }

    public function exportPdf()
{
    $dosen = Auth::guard('dosen')->user();

    $penelitian = Penelitian::where('dosen_id', $dosen->id)
        ->where('status', 'Disetujui')
        ->get()
        ->map(function ($item) {
            $item->tipe = 'Penelitian';
            return $item;
        });

    $pengabdian = Pengabdian::where('dosen_id', $dosen->id)
        ->where('status', 'Disetujui')
        ->get()
        ->map(function ($item) {
            $item->tipe = 'Pengabdian';
            return $item;
        });

    $riwayat = $penelitian->merge($pengabdian)->sortByDesc('tahun');

    $pdf = Pdf::loadView('dosen.riwayat.pdf', [
        'riwayat' => $riwayat,
        'dosen'   => $dosen
    ])->setPaper('A4', 'portrait');

    return $pdf->download('Laporan_Riwayat_Penelitian_Pengabdian.pdf');
}
}
