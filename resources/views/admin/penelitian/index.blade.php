@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Validasi Penelitian</h4>
</div>

{{-- FILTER & SEARCH --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="row g-3">

            {{-- FILTER TAHUN --}}
            <div class="col-md-3">
                <label class="fw-semibold mb-1">Tahun</label>
                <select class="form-select" id="filterTahun">
                    <option value="">Semua Tahun</option>
                    @for($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            {{-- FILTER STATUS --}}
            <div class="col-md-3">
                <label class="fw-semibold mb-1">Status</label>
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Validasi">Menunggu Validasi</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-md-6">
                <label class="fw-semibold mb-1">Pencarian</label>
                <input type="text" class="form-control" id="searchInput"
                       placeholder="Cari judul atau nama dosen...">
            </div>

        </div>
    </div>
</div>


{{-- TABEL --}}
<div class="card shadow-sm border-0">
    <div class="card-body">

        @if($penelitian->count())
        <table class="table table-hover align-middle">

            <thead>
                <tr class="text-secondary">
                    <th width="5%">No</th>
                    <th width="35%">Judul</th>
                    <th width="20%">Dosen</th>
                    <th width="10%">Bidang</th>
                    <th width="10%">Tahun</th>
                    <th width="10%">Status</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($penelitian as $i => $p)
                <tr
                    data-judul="{{ strtolower($p->judul) }}"
                    data-dosen="{{ strtolower($p->dosen->nama) }}"
                    data-tahun="{{ $p->tahun }}"
                    data-status="{{ $p->status }}"
                >
                    <td>{{ $i+1 }}</td>

                    {{-- ✅ JUDUL DIPOTONG --}}
                    <td title="{{ $p->judul }}">
                        {{ \Illuminate\Support\Str::limit($p->judul, 60, '...') }}
                    </td>

                    <td>{{ $p->dosen->nama }}</td>
                    <td>{{ $p->bidang }}</td>
                    <td>{{ $p->tahun }}</td>

                    <td>
                        @if($p->status == 'Menunggu Validasi')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif($p->status == 'Disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>

                    <td class="text-center">

                        {{-- DETAIL --}}
                        <a href="{{ route('admin.penelitian.show', $p->id) }}"
                           class="btn btn-sm btn-outline-primary"
                           title="Detail">
                           <i class="bi bi-eye"></i>
                        </a>

                        @if($p->status == 'Menunggu Validasi')

                        {{-- APPROVE --}}
                        <form action="{{ route('admin.penelitian.approve', $p->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-outline-success"
                              onclick="return confirm('Setujui penelitian ini?')">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </form>

                        {{-- REJECT --}}
                        <form action="{{ route('admin.penelitian.reject', $p->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-outline-danger"
                              onclick="return confirm('Tolak penelitian ini?')">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>

                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div id="noResults" class="text-center text-muted py-5" style="display:none;">
            <i class="bi bi-search fs-1"></i>
            <p class="mt-2">Tidak ada data yang sesuai.</p>
        </div>

        @else
        <div class="text-center py-5 text-muted">
            Belum ada data penelitian.
        </div>
        @endif

    </div>
</div>


{{-- ✅ SCRIPT FILTER --}}
<script>
const searchInput  = document.getElementById('searchInput');
const filterTahun  = document.getElementById('filterTahun');
const filterStatus = document.getElementById('filterStatus');
const tableBody    = document.getElementById('tableBody');
const noResults    = document.getElementById('noResults');

function filterTable() {
    const search = searchInput.value.toLowerCase();
    const tahun  = filterTahun.value;
    const status = filterStatus.value;

    let visible = 0;

    document.querySelectorAll('#tableBody tr').forEach(row => {
        const judul  = row.dataset.judul;
        const dosen  = row.dataset.dosen;
        const rTahun = row.dataset.tahun;
        const rStat  = row.dataset.status;

        const matchSearch = judul.includes(search) || dosen.includes(search);
        const matchTahun  = !tahun || rTahun === tahun;
        const matchStatus = !status || rStat === status;

        if (matchSearch && matchTahun && matchStatus) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    if (visible === 0) {
        tableBody.parentElement.style.display = 'none';
        noResults.style.display = 'block';
    } else {
        tableBody.parentElement.style.display = '';
        noResults.style.display = 'none';
    }
}

searchInput.addEventListener('keyup', filterTable);
filterTahun.addEventListener('change', filterTable);
filterStatus.addEventListener('change', filterTable);
</script>

@endsection
