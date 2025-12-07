<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanRekapExport implements FromCollection, WithHeadings
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Dosen::withCount([
            'penelitians as total_penelitian' => function ($q) {
                if ($this->tahun) {
                    $q->where('tahun', $this->tahun);
                }
            },
            'pengabdians as total_pengabdian' => function ($q) {
                if ($this->tahun) {
                    $q->where('tahun', $this->tahun);
                }
            }
        ])->get()->map(function ($d) {
            return [
                $d->nama,
                $d->nip,
                $d->total_penelitian,
                $d->total_pengabdian,
                $d->total_penelitian + $d->total_pengabdian
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Dosen', 'NIP', 'Total Penelitian', 'Total Pengabdian', 'Total Keseluruhan'];
    }
}
