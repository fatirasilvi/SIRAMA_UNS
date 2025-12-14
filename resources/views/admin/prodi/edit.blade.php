@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Edit Prodi</span>
        <a href="{{ route('admin.prodi.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <form id="formEdit" action="{{ route('admin.prodi.update', $prodi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="fw-semibold mb-1">Nama Prodi</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ $prodi->nama }}" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Update
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('formEdit').addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Update Prodi?',
        text: 'Perubahan akan disimpan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Update',
        cancelButtonText: 'Batal'
    }).then((res) => {
        if(res.isConfirmed) this.submit();
    });
});
</script>

@endsection
