@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Data Dosen</h4>
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
                        <form action="{{ route('admin.dosen.toggle-status', $d->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')

                            @if($d->is_active)
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Nonaktifkan dosen ini?')">
                                    <i class="bi bi-x-circle"></i> Nonaktifkan
                                </button>
                            @else
                                <button class="btn btn-sm btn-outline-success"
                                    onclick="return confirm('Aktifkan kembali dosen ini?')">
                                    <i class="bi bi-check-circle"></i> Aktifkan
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

@endsection
