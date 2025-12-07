<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h3 align="center">Laporan Rekap Dosen {{ $tahun ? 'Tahun '.$tahun : '' }}</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>NIP</th>
            <th>Penelitian</th>
            <th>Pengabdian</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dosen as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->nip }}</td>
            <td>{{ $d->total_penelitian }}</td>
            <td>{{ $d->total_pengabdian }}</td>
            <td>{{ $d->total_penelitian + $d->total_pengabdian }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
