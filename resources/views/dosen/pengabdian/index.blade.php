@extends('layouts.main')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Kelola Pengabdian Anda</h4>

        <a href="{{ route('dosen.pengabdian.create') }}" class="btn btn-primary px-4">
            <i class="bi bi-plus-circle"></i> Tambah Pengabdian
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
                        <option value="Menunggu Validasi">Menunggu Validasi</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
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

            @if($pengabdian->count() > 0)
                <table class="table table-hover align-middle">

                    <thead>
                        <tr class="text-secondary">
                            <th style="width: 5%;">No</th>
                            <th style="width: 40%;">Judul</th>
                            <th style="width: 15%;">Bidang</th>
                            <th style="width: 10%;">Tahun</th>
                            <th style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @foreach ($pengabdian as $index => $p)
                            <tr data-tahun="{{ $p->tahun }}" 
                                data-bidang="{{ $p->bidang }}" 
                                data-status="{{ $p->status }}" 
                                data-judul="{{ strtolower($p->judul) }}">

                                <td>{{ $index + 1 }}</td>

                                <td style="max-width: 350px;">
                                    <a href="{{ route('dosen.pengabdian.show', $p->id) }}" 
                                       class="fw-semibold text-decoration-none text-dark">
                                        {{ $p->judul }}
                                    </a>
                                </td>

                                <td>{{ $p->bidang }}</td>
                                <td>{{ $p->tahun }}</td>

                                <td>
                                    @if ($p->status == 'Menunggu Validasi')
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="bi bi-clock"></i> Menunggu Validasi
                                        </span>
                                    @elseif ($p->status == 'Disetujui')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-check-circle"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="bi bi-x-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="btn-group" role="group">

                                        {{-- DETAIL --}}
                                        <a href="{{ route('dosen.pengabdian.show', $p->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('dosen.pengabdian.edit', $p->id) }}" 
                                           class="btn btn-sm btn-outline-success"
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('dosen.pengabdian.destroy', $p->id) }}"
                                              method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger delete-button" 
                                                    data-id="{{ $p->id }}"
                                                    data-judul="{{ $p->judul }}"
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

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
                    <p class="mt-3">Belum ada pengabdian yang diajukan.</p>
                    <a href="{{ route('dosen.pengabdian.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle"></i> Tambah Pengabdian Pertama
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>

{{-- SCRIPT FILTER + SWEETALERT SAMA PERSIS --}}
<script>
document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const form = this.closest('form');
        const judul = this.getAttribute('data-judul');
        
        Swal.fire({
            title: 'Hapus Pengabdian?',
            html: `Apakah Anda yakin ingin menghapus pengabdian:<br><strong>"${judul}"</strong>?<br><br><small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
            cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
});

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
