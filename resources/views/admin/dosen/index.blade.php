@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Data Dosen</h4>

    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Dosen
    </a>
</div>

{{-- SEARCH --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama / NIP dosen...">
    </div>
</div>

{{-- TABEL --}}
<div class="card shadow-sm border-0">
    <div class="card-body">

        @if($dosen->count() > 0)
        <table class="table table-hover align-middle">

            <thead>
                <tr class="text-secondary">
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Prodi</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($dosen as $i => $d)
                <tr data-search="{{ strtolower($d->nama . ' ' . $d->nip) }}">

                    <td>{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $d->nama }}</td>
                    <td>{{ $d->nip }}</td>
                    <td>{{ $d->prodi ?? '-' }}</td>
                    <td>{{ $d->jabatan ?? '-' }}</td>

                    {{-- STATUS --}}
                    <td>
                        @if($d->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
<td class="text-center">

    {{-- ✅ TOMBOL EDIT --}}
    <a href="{{ route('admin.dosen.edit', $d->id) }}"
       class="btn btn-sm btn-outline-primary me-1">
        <i class="bi bi-pencil"></i>
    </a>

    {{-- ✅ FORM AKTIF / NONAKTIF --}}
    <form action="{{ route('admin.dosen.toggle-status', $d->id) }}"
          method="POST"
          class="d-inline toggle-form"
          data-nama="{{ $d->nama }}"
          data-status="{{ $d->is_active ? 'nonaktifkan' : 'aktifkan' }}">
        @csrf
        @method('PUT')

        @if($d->is_active)
            <button type="button" class="btn btn-sm btn-outline-danger toggle-btn">
                <i class="bi bi-x-circle"></i>
            </button>
        @else
            <button type="button" class="btn btn-sm btn-outline-success toggle-btn">
                <i class="bi bi-check-circle"></i>
            </button>
        @endif

    </form>

</td>


                </tr>
                @endforeach
            </tbody>

        </table>

        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people fs-1"></i>
                <p class="mt-2">Belum ada data dosen</p>
            </div>
        @endif

    </div>
</div>

{{-- SCRIPT SEARCH --}}
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
<script>
document.querySelectorAll('.toggle-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        const form = this.closest('form');
        const nama = form.dataset.nama;
        const status = form.dataset.status;

        Swal.fire({
            title: status === 'aktifkan' ? 'Aktifkan Dosen?' : 'Nonaktifkan Dosen?',
            html: `Yakin ingin <b>${status}</b> dosen:<br><strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: status === 'aktifkan' ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: status === 'aktifkan' ? '#16a34a' : '#dc2626',
            cancelButtonColor: '#6c757d',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                form.submit();
            }
        });
    });
});
</script>

@endsection
