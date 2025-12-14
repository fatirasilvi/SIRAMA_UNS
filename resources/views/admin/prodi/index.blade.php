@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold m-0">Data Prodi</h4>

    <a href="{{ route('admin.prodi.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Prodi
    </a>
</div>

{{-- SEARCH --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <input type="text" id="searchInput" class="form-control"
               placeholder="Cari nama prodi...">
    </div>
</div>

{{-- TABLE --}}
<div class="card shadow-sm border-0">
    <div class="card-body">

        @if($prodis->count() > 0)
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-secondary">
                        <th style="width: 8%;">No</th>
                        <th>Nama Prodi</th>
                        <th class="text-center" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @foreach($prodis as $i => $p)
                    <tr data-search="{{ strtolower($p->nama) }}">
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $p->nama }}</td>

                        <td class="text-center">
                            <a href="{{ route('admin.prodi.edit', $p->id) }}"
                               class="btn btn-sm btn-outline-success">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                            <form action="{{ route('admin.prodi.destroy', $p->id) }}"
                                  method="POST"
                                  class="d-inline formDelete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger btnDelete">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
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
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2 mb-0">Belum ada data prodi.</p>
            </div>
        @endif

    </div>
</div>

{{-- SEARCH FILTER (CLIENT SIDE) --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');
    let visible = 0;

    rows.forEach(row => {
        const text = row.getAttribute('data-search');
        const show = text.includes(keyword);
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const noResults = document.getElementById('noResults');
    if (noResults) noResults.style.display = (visible === 0) ? 'block' : 'none';
});
</script>

{{-- SWEETALERT DELETE --}}
<script>
document.querySelectorAll('.btnDelete').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        const form = this.closest('form');

        Swal.fire({
            title: 'Hapus Prodi?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((res) => {
            if(res.isConfirmed) form.submit();
        });
    });
});
</script>

@endsection
