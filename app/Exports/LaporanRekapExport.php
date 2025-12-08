<?php

namespace App\Exports;

use App\Models\Dosen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanRekapExport implements FromView
{
    protected $tahun;
    protected $tipe; // penelitian / pengabdian

    // ✅ INI YANG BARUSAN KITA BAHAS
    public function __construct($tahun, $tipe)
    {
        $this->tahun = $tahun;
        $this->tipe  = $tipe;
    }

    // ✅ INI TEMPAT IF ($this->tipe === 'penelitian') KAMU TARUH
    public function view(): View
    {
        if ($this->tipe === 'penelitian') {

            $dosen = Dosen::withCount([
                'penelitians as total' => function ($q) {
                    if ($this->tahun) {
                        $q->where('tahun', $this->tahun);
                    }
                }
            ])->get();

            $judul = 'Laporan Rekap Penelitian';

        } else {

            $dosen = Dosen::withCount([
                'pengabdians as total' => function ($q) {
                    if ($this->tahun) {
                        $q->where('tahun', $this->tahun);
                    }
                }
            ])->get();

            $judul = 'Laporan Rekap Pengabdian';
        }

        return view('admin.laporan.excel', compact('dosen', 'judul'));
    }
}
