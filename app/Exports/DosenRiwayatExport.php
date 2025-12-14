<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DosenRiwayatExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $riwayat;
    protected $dosen;

    public function __construct($riwayat, $dosen)
    {
        $this->riwayat = $riwayat;
        $this->dosen = $dosen;
    }

    public function view(): View
    {
        return view('dosen.riwayat.excel', [
            'riwayat' => $this->riwayat,
            'dosen' => $this->dosen,
            'tanggal' => date('d F Y')
        ]);
    }

    public function title(): string
    {
        return 'Riwayat';
    }
}