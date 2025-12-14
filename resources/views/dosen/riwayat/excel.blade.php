<!doctype html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Riwayat</title>
</head>

<body>

<table>
    <tr>
        <th colspan="6" style="text-align: center; font-size: 14px; font-weight: bold;">
            LAPORAN RIWAYAT PENELITIAN & PENGABDIAN
        </th>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center;">
            Universitas Sebelas Maret
        </td>
    </tr>
    <tr><td colspan="6"></td></tr>
    <tr>
        <td><strong>Nama Dosen</strong></td>
        <td colspan="5">: {{ $dosen->nama }}</td>
    </tr>
    <tr>
        <td><strong>NIP</strong></td>
        <td colspan="5">: {{ $dosen->nip }}</td>
    </tr>
    <tr>
        <td><strong>Program Studi</strong></td>
        <td colspan="5">: {{ optional($dosen->prodi)->nama ?? '-' }}</td>
    </tr>
    <tr><td colspan="6"></td></tr>
</table>

<table border="1">
    <thead>
        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <th style="text-align: center;">No</th>
            <th>Judul Kegiatan</th>
            <th style="text-align: center;">Bidang</th>
            <th style="text-align: center;">Tahun</th>
            <th style="text-align: center;">Jenis</th>
            <th style="text-align: center;">Research Group</th>
        </tr>
    </thead>

    <tbody>
        @forelse($riwayat as $i => $item)
        <tr>
            <td style="text-align: center;">{{ $i + 1 }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->bidang_nama ?? '-' }}</td>
            <td style="text-align: center;">{{ $item->tahun }}</td>
            <td style="text-align: center;">{{ strtoupper($item->tipe) }}</td>
            <td>{{ $item->research_group_nama ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center; color: #999;">
                Tidak ada data
            </td>
        </tr>
        @endforelse
    </tbody>

    <tfoot>
        <tr style="background-color: #e8e8e8; font-weight: bold;">
            <td colspan="3" style="text-align: right;">TOTAL</td>
            <td colspan="3" style="text-align: center;">
                {{ $riwayat->where('tipe', 'Penelitian')->count() }} Penelitian,
                {{ $riwayat->where('tipe', 'Pengabdian')->count() }} Pengabdian
            </td>
        </tr>
    </tfoot>
</table>

<table>
    <tr><td colspan="6"></td></tr>
    <tr>
        <td colspan="6" style="text-align: right;">
            Dicetak pada: {{ $tanggal ?? date('d F Y') }}
        </td>
    </tr>
</table>

</body>
</html>
