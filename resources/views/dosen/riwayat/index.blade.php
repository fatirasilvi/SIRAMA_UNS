@extends('layouts.main')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Riwayat Laporan & Publikasi</h4>

        {{-- EXPORT --}}
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download"></i> Export Laporan
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item"
                       href="{{ route('dosen.riwayat.export.pdf', request()->query()) }}">
                        <i class="bi bi-file-earmark-pdf text-danger"></i> Export PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                       href="{{ route('dosen.riwayat.export.excel', request()->query()) }}">
                        <i class="bi bi-file-earmark-excel text-success"></i> Export Excel
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card mb-3 shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Tahun</label>
                    <select class="form-select" id="filterTahun">
                        <option value="">Semua Tahun</option>
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Bidang</label>
                    <select class="form-select" id="filterBidang">
                        <option value="">Semua Bidang</option>
                        @foreach($bidangList as $bidang)
                            <option value="{{ $bidang->nama_bidang }}">
                                {{ $bidang->nama_bidang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="Disetujui">Disetujui</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="fw-semibold mb-1">Pencarian</label>
                    <input type="text" class="form-control" id="searchInput"
                           placeholder="Cari judul kegiatan...">
                </div>

            </div>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            @if($riwayat->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr class="text-secondary">
                            <th width="5%">No</th>
                            <th width="40%">Judul Kegiatan</th>
                            <th width="15%">Bidang</th>
                            <th width="10%">Tahun</th>
                            <th width="15%">Status</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @foreach ($riwayat as $i => $p)
                        <tr
                            data-judul="{{ strtolower($p->judul) }}"
                            data-tahun="{{ $p->tahun }}"
                            data-bidang="{{ $p->bidang }}"
                            data-status="{{ $p->status }}"
                        >
                            <td>{{ $i + 1 }}</td>

                            <td>
                                <div class="fw-semibold text-wrap">
                                    {{ $p->judul }}
                                </div>
                                <small class="text-muted">
                                    {{ strtoupper($p->tipe) }}
                                </small>
                            </td>

                            <td>{{ $p->bidang }}</td>
                            <td>{{ $p->tahun }}</td>

                            <td>
                                <span class="badge bg-success px-3 py-2">
                                    <i class="bi bi-check-circle"></i> Disetujui
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ $p->tipe === 'penelitian'
                                    ? route('dosen.penelitian.show', $p->id)
                                    : route('dosen.pengabdian.show', $p->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   data-bs-toggle="tooltip"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div id="noResults" class="text-center text-muted py-4 d-none">
                <i class="bi bi-search fs-1"></i>
                <p class="mt-2">Tidak ada data yang sesuai.</p>
            </div>

            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-folder2-open fs-1"></i>
                <p class="mt-3">Belum ada riwayat yang disetujui.</p>
            </div>
            @endif

        </div>
    </div>

</div>

{{-- SCRIPT --}}
<script>
const searchInput  = document.getElementById('searchInput');
const filterTahun  = document.getElementById('filterTahun');
const filterBidang = document.getElementById('filterBidang');
const filterStatus = document.getElementById('filterStatus');
const noResults    = document.getElementById('noResults');

function filterTable() {
    let visible = 0;
    document.querySelectorAll('#tableBody tr').forEach(row => {

        const match =
            (!filterTahun.value  || row.dataset.tahun === filterTahun.value) &&
            (!filterBidang.value || row.dataset.bidang === filterBidang.value) &&
            (!filterStatus.value || row.dataset.status === filterStatus.value) &&
            row.dataset.judul.includes(searchInput.value.toLowerCase());

        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    noResults.classList.toggle('d-none', visible !== 0);
}

[searchInput, filterTahun, filterBidang, filterStatus].forEach(el =>
    el?.addEventListener('input', filterTable)
);

// INIT TOOLTIP
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el =>
    new bootstrap.Tooltip(el)
);
</script>

@endsection
