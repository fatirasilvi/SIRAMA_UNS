@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Tambah Prodi</span>
        <a href="{{ route('admin.prodi.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <form id="formCreate" action="{{ route('admin.prodi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="fw-semibold mb-1">Nama Prodi</label>
                <input type="text" name="nama" class="form-control"
                       placeholder="Contoh: Pendidikan Teknik Informatika"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('formCreate').addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Simpan Prodi?',
        text: 'Pastikan nama prodi sudah benar.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((res) => {
        if(res.isConfirmed) this.submit();
    });
});
</script>

@endsection
