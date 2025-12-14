@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">
        Edit Research Group
    </div>

    <div class="card-body">

        <form action="{{ route('admin.research-group.update', $group->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Research Group <span class="text-danger">*</span></label>
                <input type="text" 
                       name="nama_group" 
                       class="form-control @error('nama_group') is-invalid @enderror" 
                       value="{{ old('nama_group', $group->nama_group) }}"
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
                          placeholder="Deskripsi singkat tentang research group...">{{ old('deskripsi', $group->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Ketua Research Group</label>
                <input type="text" 
                       name="ketua" 
                       class="form-control @error('ketua') is-invalid @enderror" 
                       value="{{ old('ketua', $group->ketua) }}"
                       placeholder="Nama ketua research group">
                @error('ketua')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                    <option value="1" {{ old('is_active', $group->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $group->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
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
        title: 'Menyimpan Perubahan...',
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