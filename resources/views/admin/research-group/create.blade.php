@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">
        Tambah Research Group
    </div>

    <div class="card-body">

        <form action="{{ route('admin.research-group.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Research Group <span class="text-danger">*</span></label>
                <input type="text" 
                       name="nama_group" 
                       class="form-control @error('nama_group') is-invalid @enderror" 
                       value="{{ old('nama_group') }}"
                       required>
                @error('nama_group')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" 
                          rows="4" 
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Deskripsi singkat tentang research group...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Ketua Research Group</label>
                <input type="text" 
                       name="ketua" 
                       class="form-control @error('ketua') is-invalid @enderror" 
                       value="{{ old('ketua') }}"
                       placeholder="Nama ketua research group">
                @error('ketua')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('admin.research-group.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!this.checkValidity()) {
        this.reportValidity();
        return;
    }
    
    Swal.fire({
        title: 'Menyimpan Data...',
        html: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    this.submit();
});
</script>

@endsection