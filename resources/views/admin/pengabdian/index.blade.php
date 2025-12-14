@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Validasi Pengabdian</h4>
</div>

{{-- FILTER & SEARCH --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <div class="row g-3">

            {{-- FILTER TAHUN --}}
            <div class="col-md-2">
                <label class="fw-semibold mb-1">Tahun</label>
                <select class="form-select" id="filterTahun">
                    <option value="">Semua Tahun</option>
                    @for($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            {{-- FILTER RESEARCH GROUP --}}
            <div class="col-md-3">
                <label class="fw-semibold mb-1">Research Group</label>
                <select class="form-select" id="filterGroup">
                    <option value="">Semua Group</option>
                    @foreach(App\Models\ResearchGroup::where('is_active', true)->orderBy('nama_group')->get() as $rg)
                        <option value="{{ $rg->nama_group }}">{{ $rg->nama_group }}</option>
                    @endforeach
                </select>
            </div>

            {{-- FILTER STATUS --}}
            <div class="col-md-2">
                <label class="fw-semibold mb-1">Status</label>
                <select class="form-select" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Validasi">Menunggu Validasi</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>

            {{-- SEARCH --}}
            <div class="col-md-5">
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

        @if($pengabdian->count())
        <table class="table table-hover align-middle">

            <thead>
                <tr class="text-secondary">
                    <th width="3%">No</th>
                    <th width="30%">Judul</th>
                    <th width="15%">Dosen</th>
                    <th width="12%">Research Group</th>
                    <th width="10%">Bidang</th>
                    <th width="7%">Tahun</th>
                    <th width="10%">Status</th>
                    <th class="text-center" width="13%">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($pengabdian as $i => $p)
                <tr
                    data-judul="{{ strtolower($p->judul) }}"
                    data-dosen="{{ strtolower($p->dosen->nama) }}"
                    data-group="{{ $p->researchGroup ? strtolower($p->researchGroup->nama_group) : '' }}"
                    data-tahun="{{ $p->tahun }}"
                    data-status="{{ $p->status }}"
                >
                    <td>{{ $i+1 }}</td>

                    <td title="{{ $p->judul }}">
                        {{ \Illuminate\Support\Str::limit($p->judul, 50, '...') }}
                    </td>

                    <td>{{ $p->dosen->nama }}</td>

                    <td>
                        @if($p->researchGroup)
                            <span class="badge bg-info text-dark">
                                {{ $p->researchGroup->nama_group }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td>{{ $p->bidangRelation->nama_bidang ?? $p->bidang ?? '-' }}</td>
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
                        <a href="{{ route('admin.pengabdian.show', $p->id) }}"
                           class="btn btn-sm btn-outline-primary"
                           title="Detail">
                           <i class="bi bi-eye"></i>
                        </a>

                        @if($p->status == 'Menunggu Validasi')

                        {{-- APPROVE --}}
                        <form action="{{ route('admin.pengabdian.approve', $p->id) }}"
                              method="POST" class="d-inline approve-form">
                            @csrf
                            @method('PUT')
                            <button type="button" 
                                    class="btn btn-sm btn-outline-success approve-button"
                                    data-judul="{{ $p->judul }}">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </form>

                        {{-- REJECT --}}
                        <form action="{{ route('admin.pengabdian.reject', $p->id) }}"
                              method="POST" class="d-inline reject-form">
                            @csrf
                            @method('PUT')
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger reject-button"
                                    data-judul="{{ $p->judul }}">
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
            Belum ada data pengabdian.
        </div>
        @endif

    </div>
</div>


<script>
// Sweet Alert Approve
document.querySelectorAll('.approve-button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const judul = this.getAttribute('data-judul');
        
        Swal.fire({
            title: 'Setujui Pengabdian?',
            html: `Apakah Anda yakin ingin menyetujui:<br><strong>"${judul}"</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-circle"></i> Ya, Setujui!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                form.submit();
            }
        });
    });
});

// Sweet Alert Reject
document.querySelectorAll('.reject-button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const judul = this.getAttribute('data-judul');
        
        Swal.fire({
            title: 'Tolak Pengabdian?',
            html: `Apakah Anda yakin ingin menolak:<br><strong>"${judul}"</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-x-circle"></i> Ya, Tolak!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                form.submit();
            }
        });
    });
});

// Filter
const searchInput  = document.getElementById('searchInput');
const filterTahun  = document.getElementById('filterTahun');
const filterGroup  = document.getElementById('filterGroup');
const filterStatus = document.getElementById('filterStatus');
const tableBody    = document.getElementById('tableBody');
const noResults    = document.getElementById('noResults');

function filterTable() {
    const search = searchInput.value.toLowerCase();
    const tahun  = filterTahun.value;
    const group  = filterGroup.value.toLowerCase();
    const status = filterStatus.value;

    let visible = 0;

    document.querySelectorAll('#tableBody tr').forEach(row => {
        const judul  = row.dataset.judul;
        const dosen  = row.dataset.dosen;
        const rGroup = row.dataset.group;
        const rTahun = row.dataset.tahun;
        const rStat  = row.dataset.status;

        const matchSearch = judul.includes(search) || dosen.includes(search);
        const matchTahun  = !tahun || rTahun === tahun;
        const matchGroup  = !group || rGroup.includes(group);
        const matchStatus = !status || rStat === status;

        if (matchSearch && matchTahun && matchGroup && matchStatus) {
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
filterGroup.addEventListener('change', filterTable);
filterStatus.addEventListener('change', filterTable);
</script>

@endsection