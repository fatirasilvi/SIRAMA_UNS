@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">Tambah Dosen</div>

    <div class="card-body">
        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Prodi</label>
                <input type="text" name="prodi" class="form-control">
            </div>

            <div class="mb-3">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary px-4" id="btnSubmit">
    <i class="bi bi-save"></i> Simpan
</button>
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<script>
document.getElementById('btnSubmit').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Simpan Data?',
        text: 'Pastikan data sudah benar.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563eb'
    }).then((result) => {
        if (result.isConfirmed) {

            Swal.fire({
                title: 'Menyimpan...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            this.closest('form').submit();
        }
    });
});
</script>

@endsection
