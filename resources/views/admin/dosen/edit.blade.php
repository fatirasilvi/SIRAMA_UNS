@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">Edit Dosen</div>

    <div class="card-body">
        <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ $dosen->nama }}" required>
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control"
                       value="{{ $dosen->nip }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ $dosen->email }}">
            </div>

            <div class="mb-3">
                <label>Prodi</label>
                <input type="text" name="prodi" class="form-control"
                       value="{{ $dosen->prodi }}">
            </div>

            <div class="mb-3">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control"
                       value="{{ $dosen->jabatan }}">
            </div>

            <button type="submit" class="btn btn-primary px-4" id="btnUpdate">
    <i class="bi bi-save"></i> Update
</button>

            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
document.getElementById('btnUpdate').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Simpan Perubahan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a'
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
