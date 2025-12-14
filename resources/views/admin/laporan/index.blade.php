@extends('layouts.main')

@section('content')

@php
    $mode = request('mode', 'dosen'); // dosen | rg | prodi
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-bold mb-0">
            @if($mode === 'rg')
                Laporan Rekap Per Research Group
            @elseif($mode === 'prodi')
                Laporan Rekap Per Prodi
            @else
                Laporan Rekap Per Dosen
            @endif
        </h4>
        <small class="text-muted">Ringkasan penelitian & pengabdian</small>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.laporan.export.pdf', ['tahun'=>request('tahun'),'mode'=>$mode]) }}"
           class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>

        <a href="{{ route('admin.laporan.export.excel', ['tahun'=>request('tahun'),'mode'=>$mode]) }}"
           class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>
</div>

{{-- MODE SELECT --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body d-flex justify-content-between align-items-center">

        <div class="btn-group">
            <a href="{{ route('admin.laporan.index',['mode'=>'dosen','tahun'=>request('tahun')]) }}"
               class="btn btn-sm {{ $mode==='dosen' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-person-badge"></i> Per Dosen
            </a>
            <a href="{{ route('admin.laporan.index',['mode'=>'rg','tahun'=>request('tahun')]) }}"
               class="btn btn-sm {{ $mode==='rg' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-diagram-3"></i> Per Research Group
            </a>
            <a href="{{ route('admin.laporan.index',['mode'=>'prodi','tahun'=>request('tahun')]) }}"
               class="btn btn-sm {{ $mode==='prodi' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="bi bi-mortarboard"></i> Per Prodi
            </a>
        </div>

        <form method="GET">
            <input type="hidden" name="mode" value="{{ $mode }}">
            <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Tahun</option>
                @for($y=date('Y');$y>=2020;$y--)
                    <option value="{{ $y }}" {{ request('tahun')==$y?'selected':'' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </form>

    </div>
</div>

{{-- SEARCH --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <input type="text" id="searchInput" class="form-control"
               placeholder="{{ $mode==='dosen' ? 'Cari nama atau NIP dosen...' : 'Cari nama...' }}">
    </div>
</div>

{{-- TABLE --}}
<div class="card shadow-sm border-0">
    <div class="card-body">

        @if($rows->count())
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-secondary">
                    <th width="5%">No</th>

                    @if($mode==='dosen')
                        <th width="25%">Nama Dosen</th>
                        <th width="15%">NIP</th>
                        <th width="15%">Prodi</th>
                    @else
                        <th width="30%">{{ $mode==='rg' ? 'Research Group' : 'Prodi' }}</th>
                        <th width="15%">Jumlah Dosen</th>
                    @endif

                    <th width="15%">Total Penelitian</th>
                    <th width="15%">Total Pengabdian</th>
                    <th width="10%">Total</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($rows as $i=>$r)
                    @php
                        $isDosenMode = ($mode==='dosen');
                        
                        if ($isDosenMode) {
                            $search = strtolower(($r->nama ?? '') . ' ' . ($r->nip ?? '') . ' ' . ($r->prodi_nama ?? ''));
                        } else {
                            $search = strtolower($r->nama ?? '');
                        }
                    @endphp

                    <tr data-search="{{ $search }}">
                        <td>{{ $i+1 }}</td>

                        @if($mode==='dosen')
                            <td class="fw-semibold">{{ $r->nama }}</td>
                            <td>{{ $r->nip ?? '-' }}</td>
                            <td>{{ $r->prodi_nama ?? '-' }}</td>
                        @else
                            <td class="fw-semibold">
                                {{ $r->nama }}
                                @if($mode === 'rg' && $r->ketua)
                                    <br><small class="text-muted">Ketua: {{ $r->ketua }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $r->jumlah_dosen ?? 0 }} Dosen
                                </span>
                            </td>
                        @endif

                        <td>
                            <span class="badge bg-success">
                                {{ $r->total_penelitian ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $r->total_pengabdian ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-dark">
                                {{ $r->total_keseluruhan ?? 0 }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="table-light fw-bold">
                    <td colspan="{{ $mode==='dosen' ? 4 : 2 }}" class="text-end">TOTAL:</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $rows->sum('total_penelitian') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $rows->sum('total_pengabdian') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-dark">
                            {{ $rows->sum('total_keseluruhan') }}
                        </span>
                    </td>
                </tr>
            </tfoot>
        </table>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada data laporan</p>
            </div>
        @endif

    </div>
</div>

<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(row => {
        const searchData = row.dataset.search;
        row.style.display = searchData.includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection