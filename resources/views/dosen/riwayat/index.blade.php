@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Riwayat Laporan & Publikasi</h4>

        {{-- EXPORT --}}
        <a href="{{ route('dosen.riwayat.export') }}" class="btn btn-success px-4">
            <i class="bi bi-download"></i> Export Laporan
        </a>
    </div>

    {{-- FILTER ROW --}}
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
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari judul...">
                </div>

            </div>

        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            @if($riwayat->count() > 0)
                <table class="table table-hover align-middle">

                    <thead>
                        <tr class="text-secondary">
                            <th style="width: 5%;">No</th>
                            <th style="width: 40%;">Judul Kegiatan</th>
                            <th style="width: 15%;">Bidang</th>
                            <th style="width: 10%;">Tahun</th>
                            <th style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @foreach ($riwayat as $index => $p)
                            <tr data-tahun="{{ $p->tahun }}" 
                                data-bidang="{{ $p->bidang }}" 
                                data-status="{{ $p->status }}" 
                                data-judul="{{ strtolower($p->judul) }}">

                                <td>{{ $index + 1 }}</td>

                                <td style="max-width: 350px;">
                                    <span class="fw-semibold">
                                        {{ $p->judul }}
                                    </span>
                                    <div class="small text-muted">
                                        {{ strtoupper($p->tipe) }} {{-- PENELITIAN / PENGABDIAN --}}
                                    </div>
                                </td>

                                <td>{{ $p->bidang }}</td>
                                <td>{{ $p->tahun }}</td>

                                <td>
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bi bi-check-circle"></i> Disetujui
                                    </span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group" role="group">

                                        {{-- DETAIL --}}
                                        <a href="{{ $p->tipe == 'penelitian' 
                                            ? route('dosen.penelitian.show', $p->id) 
                                            : route('dosen.pengabdian.show', $p->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div id="noResults" class="text-center text-muted py-4" style="display: none;">
                    <i class="bi bi-search fs-1"></i>
                    <p class="mt-2">Tidak ada data yang sesuai dengan pencarian.</p>
                </div>

            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-folder2-open fs-1"></i>
                    <p class="mt-3">Belum ada riwayat penelitian atau pengabdian yang disetujui.</p>
                </div>
            @endif

        </div>
    </div>

</div>

{{-- SCRIPT FILTER --}}
<script>
const searchInput = document.getElementById('searchInput');
const filterTahun = document.getElementById('filterTahun');
const filterBidang = document.getElementById('filterBidang');
const filterStatus = document.getElementById('filterStatus');
const tableBody = document.getElementById('tableBody');
const noResults = document.getElementById('noResults');

function filterTable() {
    const searchTerm = searchInput?.value.toLowerCase() || '';
    const tahun = filterTahun?.value || '';
    const bidang = filterBidang?.value || '';
    const status = filterStatus?.value || '';
    
    let visibleCount = 0;
    
    document.querySelectorAll('#tableBody tr').forEach(row => {
        const rowJudul = row.getAttribute('data-judul') || '';
        const rowTahun = row.getAttribute('data-tahun') || '';
        const rowBidang = row.getAttribute('data-bidang') || '';
        const rowStatus = row.getAttribute('data-status') || '';
        
        const matchSearch = rowJudul.includes(searchTerm);
        const matchTahun = !tahun || rowTahun === tahun;
        const matchBidang = !bidang || rowBidang === bidang;
        const matchStatus = !status || rowStatus === status;
        
        if (matchSearch && matchTahun && matchBidang && matchStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    if (visibleCount === 0) {
        tableBody.parentElement.style.display = 'none';
        noResults.style.display = 'block';
    } else {
        tableBody.parentElement.style.display = '';
        noResults.style.display = 'none';
    }
}

searchInput?.addEventListener('keyup', filterTable);
filterTahun?.addEventListener('change', filterTable);
filterBidang?.addEventListener('change', filterTable);
filterStatus?.addEventListener('change', filterTable);
</script>

@endsection
