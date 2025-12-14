<!DOCTYPE html>
<html>
<head>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 11px; 
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header p {
            margin: 3px 0;
            font-size: 12px;
            color: #666;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th, td { 
            border: 1px solid #333; 
            padding: 8px 6px;
            text-align: left;
        }
        th { 
            background: #f0f0f0; 
            font-weight: bold;
            text-align: center;
        }
        td.number {
            text-align: center;
        }
        tfoot td {
            background: #e8e8e8;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h3>{{ $judul }}</h3>
    @if($tahun)
        <p>Tahun: {{ $tahun }}</p>
    @else
        <p>Semua Tahun</p>
    @endif
    <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>

            @if($mode === 'dosen')
                <th width="25%">Nama Dosen</th>
                <th width="15%">NIP</th>
                <th width="15%">Prodi</th>
            @else
                <th width="35%">{{ $mode === 'rg' ? 'Research Group' : 'Prodi' }}</th>
                <th width="15%">Jumlah Dosen</th>
            @endif

            <th width="15%">Penelitian</th>
            <th width="15%">Pengabdian</th>
            <th width="10%">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $i => $r)
        <tr>
            <td class="number">{{ $i+1 }}</td>

            @if($mode === 'dosen')
                <td>{{ $r->nama }}</td>
                <td>{{ $r->nip ?? '-' }}</td>
                <td>{{ $r->prodi_nama ?? '-' }}</td>
            @else
                <td>
                    {{ $r->nama }}
                    @if($mode === 'rg' && $r->ketua)
                        <br><small style="color: #666;">Ketua: {{ $r->ketua }}</small>
                    @endif
                </td>
                <td class="number">{{ $r->jumlah_dosen ?? 0 }}</td>
            @endif

            <td class="number">{{ $r->total_penelitian ?? 0 }}</td>
            <td class="number">{{ $r->total_pengabdian ?? 0 }}</td>
            <td class="number">{{ $r->total_keseluruhan ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{{ $mode === 'dosen' ? 4 : 2 }}" style="text-align: right;">TOTAL</td>
            <td class="number">{{ $rows->sum('total_penelitian') }}</td>
            <td class="number">{{ $rows->sum('total_pengabdian') }}</td>
            <td class="number">{{ $rows->sum('total_keseluruhan') }}</td>
        </tr>
    </tfoot>
</table>

</body>
</html>