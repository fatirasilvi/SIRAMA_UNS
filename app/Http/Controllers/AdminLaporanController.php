<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\ResearchGroup;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanRekapExport;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun');
        $mode  = $request->get('mode', 'dosen'); // dosen | rg | prodi

        // =========================
        // MODE: DOSEN
        // =========================
        if ($mode === 'dosen') {
            $rows = Dosen::query()
                ->with(['prodi:id,nama'])
                ->withCount([
                    'penelitians as total_penelitian' => function ($q) use ($tahun) {
                        if ($tahun) $q->where('tahun', $tahun);
                    },
                    'pengabdians as total_pengabdian' => function ($q) use ($tahun) {
                        if ($tahun) $q->where('tahun', $tahun);
                    },
                ])
                ->orderBy('nama')
                ->get()
                ->map(function ($d) {
                    $d->prodi_nama = optional($d->prodi)->nama;
                    $d->total_keseluruhan = (int)$d->total_penelitian + (int)$d->total_pengabdian;
                    return $d;
                });

            return view('admin.laporan.index', compact('rows', 'tahun', 'mode'));
        }

        // =========================
        // MODE: RESEARCH GROUP
        // =========================
        if ($mode === 'rg') {
            $rows = ResearchGroup::query()
                ->withCount([
                    // Hitung pengabdian yang menggunakan research group ini
                    'pengabdian as total_pengabdian' => function ($q) use ($tahun) {
                        if ($tahun) $q->where('tahun', $tahun);
                    }
                ])
                ->orderBy('nama_group')
                ->get()
                ->map(function ($rg) use ($tahun) {
                    // Hitung jumlah dosen yang terlibat dalam research group ini
                    // (dari pengabdian yang menggunakan research group ini)
                    $dosenIds = DB::table('pengabdians')
                        ->where('research_group_id', $rg->id)
                        ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                        ->distinct()
                        ->pluck('dosen_id');
                    
                    $rg->jumlah_dosen = $dosenIds->count();
                    
                    // Hitung total penelitian dari dosen-dosen yang ada di pengabdian research group ini
                    $rg->total_penelitian = DB::table('penelitians')
                        ->whereIn('dosen_id', $dosenIds)
                        ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                        ->count();
                    
                    $rg->total_keseluruhan = (int)$rg->total_penelitian + (int)$rg->total_pengabdian;
                    $rg->nama = $rg->nama_group; // Untuk konsistensi dengan view
                    
                    return $rg;
                });

            return view('admin.laporan.index', compact('rows', 'tahun', 'mode'));
        }

        // =========================
        // MODE: PRODI
        // =========================
        $rows = Prodi::query()
            ->withCount([
                'dosen as jumlah_dosen'
            ])
            ->orderBy('nama')
            ->get()
            ->map(function ($prodi) use ($tahun) {
                // Hitung penelitian dari dosen-dosen di prodi ini
                $prodi->total_penelitian = DB::table('penelitians')
                    ->join('dosen', 'penelitians.dosen_id', '=', 'dosen.id')
                    ->where('dosen.prodi_id', $prodi->id)
                    ->when($tahun, fn($q) => $q->where('penelitians.tahun', $tahun))
                    ->count();
                
                // Hitung pengabdian dari dosen-dosen di prodi ini
                $prodi->total_pengabdian = DB::table('pengabdians')
                    ->join('dosen', 'pengabdians.dosen_id', '=', 'dosen.id')
                    ->where('dosen.prodi_id', $prodi->id)
                    ->when($tahun, fn($q) => $q->where('pengabdians.tahun', $tahun))
                    ->count();
                
                $prodi->total_keseluruhan = (int)$prodi->total_penelitian + (int)$prodi->total_pengabdian;
                
                return $prodi;
            });

        return view('admin.laporan.index', compact('rows', 'tahun', 'mode'));
    }

    // =========================================================
// EXPORT PDF
// =========================================================
public function exportPdf(Request $request)
{
    $tahun = $request->get('tahun');
    $mode = $request->get('mode', 'dosen');
    
    // Ambil data dengan memanggil index method
    $tempRequest = new Request(['tahun' => $tahun, 'mode' => $mode]);
    $response = $this->index($tempRequest);
    $rows = $response->getData()['rows'];
    
    $judul = match($mode) {
        'rg' => 'Laporan Rekap Per Research Group',
        'prodi' => 'Laporan Rekap Per Prodi',
        default => 'Laporan Rekap Per Dosen',
    };
    
    return Pdf::loadView('admin.laporan.pdf', [
        'rows'  => $rows,
        'judul' => $judul,
        'tahun' => $tahun,
        'mode'  => $mode
    ])
    ->setPaper('A4', 'landscape')
    ->download('laporan_rekap_' . $mode . '_' . ($tahun ?: 'semua') . '.pdf');
}

// =========================================================
// EXPORT EXCEL
// =========================================================
public function exportExcel(Request $request)
{
    $tahun = $request->get('tahun');
    $mode = $request->get('mode', 'dosen');
    
    // Ambil data dengan memanggil index method
    $tempRequest = new Request(['tahun' => $tahun, 'mode' => $mode]);
    $response = $this->index($tempRequest);
    $rows = $response->getData()['rows'];
    
    $judul = match($mode) {
        'rg' => 'Laporan Rekap Per Research Group',
        'prodi' => 'Laporan Rekap Per Prodi',
        default => 'Laporan Rekap Per Dosen',
    };
    
    return Excel::download(
        new LaporanRekapExport($rows, $tahun, $mode, $judul),
        'laporan_rekap_' . $mode . '_' . ($tahun ?: 'semua') . '.xlsx'
    );
}
}