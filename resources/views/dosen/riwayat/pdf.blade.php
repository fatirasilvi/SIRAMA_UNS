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
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header p {
            margin: 3px 0;
            font-size: 11px;
        }
        .info-dosen {
            margin-bottom: 15px;
            padding: 10px;
            background: #f5f5f5;
        }
        .info-dosen table {
            border: none;
        }
        .info-dosen td {
            border: none;
            padding: 3px 5px;
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
            background: #e8e8e8; 
            font-weight: bold;
            text-align: center;
        }
        td.number {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-penelitian {
            background: #d4edda;
            color: #155724;
        }
        .badge-pengabdian {
            background: #d1ecf1;
            color: #0c5460;
        }
        tfoot td {
            background: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h3>LAPORAN RIWAYAT PENELITIAN & PENGABDIAN</h3>
    <p>Universitas Sebelas Maret</p>
    <p>Dicetak pada: {{ $tanggal }}</p>
</div>

<div class="info-dosen">
    <table>
        <tr>
            <td width="20%"><strong>Nama Dosen</strong></td>
            <td width="2%">:</td>
            <td>{{ $dosen->nama }}</td>
        </tr>
        <tr>
            <td><strong>NIP</strong></td>
            <td>:</td>
            <td>{{ $dosen->nip }}</td>
        </tr>
        <tr>
            <td><strong>Program Studi</strong></td>
            <td>:</td>
            <td>{{ $dosen->prodi->nama ?? '-' }}</td>
        </tr>
    </table>
</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="40%">Judul Kegiatan</th>
            <th width="15%">Bidang</th>
            <th width="10%">Tahun</th>
            <th width="15%">Jenis</th>
            <th width="15%">Research Group</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $i => $item)
        <tr>
            <td class="number">{{ $i + 1 }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ $item->bidang_nama }}</td>
            <td class="number">{{ $item->tahun }}</td>
            <td class="number">
                <span class="badge badge-{{ strtolower($item->tipe) }}">
                    {{ strtoupper($item->tipe) }}
                </span>
            </td>
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
        <tr>
            <td colspan="3" style="text-align: right;">TOTAL</td>
            <td colspan="3" class="number">
                {{ $riwayat->where('tipe', 'Penelitian')->count() }} Penelitian, 
                {{ $riwayat->where('tipe', 'Pengabdian')->count() }} Pengabdian
            </td>
        </tr>
    </tfoot>
</table>

<div style="margin-top: 30px; text-align: right;">
    <p style="margin-bottom: 60px;">
        Surakarta, {{ $tanggal }}
    </p>
    <p style="border-top: 1px solid #333; display: inline-block; padding-top: 5px; min-width: 200px;">
        {{ $dosen->nama }}<br>
        NIP. {{ $dosen->nip }}
    </p>
</div>

</body>
</html>