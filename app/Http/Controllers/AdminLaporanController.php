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
    // INDEX LAPORAN
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

        return view('admin.laporan.index', compact('dosen', 'tahun'));
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function exportPdf(Request $request)
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

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('dosen', 'tahun'))
                    ->setPaper('A4', 'landscape');

        return $pdf->download('laporan_rekap_dosen.pdf');
    }

    // =========================
    // EXPORT EXCEL
    // =========================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanRekapExport($request->tahun),
            'laporan_rekap_dosen.xlsx'
        );
    }
}
