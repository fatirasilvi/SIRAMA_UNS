<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanRekapExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $rows;
    protected $tahun;
    protected $mode;
    protected $judul;

    public function __construct($rows, $tahun, $mode, $judul)
    {
        $this->rows = $rows;
        $this->tahun = $tahun;
        $this->mode = $mode;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('admin.laporan.excel', [
            'rows' => $this->rows,
            'tahun' => $this->tahun,
            'mode' => $this->mode,
            'judul' => $this->judul,
        ]);
    }

    public function title(): string
    {
        return 'Laporan Rekap';
    }
}