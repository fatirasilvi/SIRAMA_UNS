<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanRekapExport;

class AdminLaporanController extends Controller
{
    // =========================
    // INDEX LAPORAN (REKAP PER DOSEN)
    // =========================
    public function index(Request $request)
    {
        $tahun = $request->tahun;

        $dosen = Dosen::withCount([
            'penelitians as total_penelitian' => function ($q) use ($tahun) {
                if ($tahun) {
                    $q->where('tahun', $tahun);
                }
            },
            'pengabdians as total_pengabdian' => function ($q) use ($tahun) {
                if ($tahun) {
                    $q->where('tahun', $tahun);
                }
            }
        ])->get();

        return view('admin.laporan.index', [
    'title' => 'Laporan Rekap',
    'dosen' => $dosen
]);

    }

    // =========================
    // EXPORT PDF (PENELITIAN / PENGABDIAN)
    // =========================
    public function exportPdf(Request $request)
    {
        $tahun = $request->tahun;
        $tipe  = $request->tipe; // penelitian / pengabdian

        if ($tipe === 'penelitian') {
            $dosen = Dosen::withCount([
                'penelitians as total' => function ($q) use ($tahun) {
                    if ($tahun) {
                        $q->where('tahun', $tahun);
                    }
                }
            ])->get();

            $judul = 'Laporan Rekap Penelitian';

        } else {
            $dosen = Dosen::withCount([
                'pengabdians as total' => function ($q) use ($tahun) {
                    if ($tahun) {
                        $q->where('tahun', $tahun);
                    }
                }
            ])->get();

            $judul = 'Laporan Rekap Pengabdian';
        }

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('dosen', 'tahun', 'tipe', 'judul'))
                    ->setPaper('A4', 'landscape');

        return $pdf->download(strtolower(str_replace(' ', '_', $judul)) . '.pdf');
    }

    // =========================
    // EXPORT EXCEL (PENELITIAN / PENGABDIAN)
    // =========================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanRekapExport($request->tahun, $request->tipe),
            'laporan_rekap_' . $request->tipe . '.xlsx'
        );
    }
}
