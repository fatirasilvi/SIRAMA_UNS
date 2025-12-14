@extends('layouts.main')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Kelola Research Group</h4>
    <a href="{{ route('admin.research-group.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Research Group
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        @if($groups->count() > 0)
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-secondary">
                        <th width="5%">No</th>
                        <th width="25%">Nama Group</th>
                        <th width="30%">Deskripsi</th>
                        <th width="15%">Ketua</th>
                        <th width="10%">Jumlah Pengabdian</th>
                        <th width="5%">Status</th>
                        <th class="text-center" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $index => $group)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $group->nama_group }}</strong></td>
                            <td>{{ $group->deskripsi ?? '-' }}</td>
                            <td>{{ $group->ketua ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $group->pengabdian->count() }} Pengabdian
                                </span>
                            </td>
                            <td>
                                @if($group->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.research-group.edit', $group->id) }}" 
                                       class="btn btn-sm btn-outline-success"
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.research-group.destroy', $group->id) }}"
                                          method="POST" 
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-button" 
                                                data-id="{{ $group->id }}"
                                                data-nama="{{ $group->nama_group }}"
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
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-people fs-1"></i>
                <p class="mt-3">Belum ada Research Group.</p>
                <a href="{{ route('admin.research-group.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Tambah Research Group Pertama
                </a>
            </div>
        @endif

    </div>
</div>

<script>
// Sweet Alert untuk Delete
document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const form = this.closest('form');
        const nama = this.getAttribute('data-nama');
        
        Swal.fire({
            title: 'Hapus Research Group?',
            html: `Apakah Anda yakin ingin menghapus:<br><strong>"${nama}"</strong>?<br><br><small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>`,
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