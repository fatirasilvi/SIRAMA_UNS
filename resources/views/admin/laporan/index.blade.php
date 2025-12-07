@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Laporan Rekap Per Dosen</h4>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.laporan.export.pdf', ['tahun' => request('tahun')]) }}" 
           class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>

        <a href="{{ route('admin.laporan.export.excel', ['tahun' => request('tahun')]) }}" 
           class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
    </div>
</div>

{{-- FILTER --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="fw-semibold">Filter Tahun</label>
                    <select name="tahun" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="card shadow-sm border-0">
    <div class="card-body">

        <input type="text" id="searchInput" class="form-control mb-3"
               placeholder="Cari nama atau NIP dosen...">

        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-secondary">
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>NIP</th>
                    <th>Total Penelitian</th>
                    <th>Total Pengabdian</th>
                    <th>Total Keseluruhan</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($dosen as $i => $d)
                <tr data-search="{{ strtolower($d->nama . ' ' . $d->nip) }}">
                    <td>{{ $i+1 }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->nip }}</td>
                    <td>{{ $d->total_penelitian }}</td>
                    <td>{{ $d->total_pengabdian }}</td>
                    <td class="fw-bold">
                        {{ $d->total_penelitian + $d->total_pengabdian }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(row => {
        const text = row.getAttribute('data-search');
        row.style.display = text.includes(keyword) ? '' : 'none';
    });
});
</script>

@endsection
