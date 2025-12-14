<table>
    <tr>
        <th colspan="7" style="text-align: center; font-size: 14px; font-weight: bold;">
            {{ $judul }}
        </th>
    </tr>
    <tr>
        <td colspan="7" style="text-align: center;">
            @if($tahun)
                Tahun: {{ $tahun }}
            @else
                Semua Tahun
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="7"></td>
    </tr>
</table>

<table border="1">
    <thead>
        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <th style="text-align: center;">No</th>

            @if($mode === 'dosen')
                <th>Nama Dosen</th>
                <th>NIP</th>
                <th>Prodi</th>
            @else
                <th>{{ $mode === 'rg' ? 'Research Group' : 'Prodi' }}</th>
                <th style="text-align: center;">Jumlah Dosen</th>
            @endif

            <th style="text-align: center;">Total Penelitian</th>
            <th style="text-align: center;">Total Pengabdian</th>
            <th style="text-align: center;">Total Keseluruhan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($rows as $i => $r)
        <tr>
            <td style="text-align: center;">{{ $i + 1 }}</td>

            @if($mode === 'dosen')
                <td>{{ $r->nama }}</td>
                <td>{{ $r->nip ?? '-' }}</td>
                <td>{{ $r->prodi_nama ?? '-' }}</td>
            @else
                <td>
                    {{ $r->nama }}
                    @if($mode === 'rg' && $r->ketua)
                        (Ketua: {{ $r->ketua }})
                    @endif
                </td>
                <td style="text-align: center;">{{ $r->jumlah_dosen ?? 0 }}</td>
            @endif

            <td style="text-align: center;">{{ $r->total_penelitian ?? 0 }}</td>
            <td style="text-align: center;">{{ $r->total_pengabdian ?? 0 }}</td>
            <td style="text-align: center;">{{ $r->total_keseluruhan ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr style="background-color: #e8e8e8; font-weight: bold;">
            <td colspan="{{ $mode === 'dosen' ? 4 : 2 }}" style="text-align: right;">TOTAL</td>
            <td style="text-align: center;">{{ $rows->sum('total_penelitian') }}</td>
            <td style="text-align: center;">{{ $rows->sum('total_pengabdian') }}</td>
            <td style="text-align: center;">{{ $rows->sum('total_keseluruhan') }}</td>
        </tr>
    </tfoot>
</table>