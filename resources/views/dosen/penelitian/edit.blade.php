@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">
        Edit Penelitian
    </div>

    <div class="card-body">

        {{-- Tampilkan error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('dosen.penelitian.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
                <input type="text" 
                       name="judul" 
                       class="form-control @error('judul') is-invalid @enderror" 
                       value="{{ old('judul', $data->judul) }}"
                       required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
    <label class="form-label">Bidang <span class="text-danger">*</span></label>
    <select name="bidang_id" 
            class="form-select @error('bidang_id') is-invalid @enderror" 
            required>
        <option value="">-- Pilih Bidang --</option>
        @foreach($bidangList as $bidang)
            <option value="{{ $bidang->id }}" 
                    {{ old('bidang_id', $data->bidang_id) == $bidang->id ? 'selected' : '' }}>
                {{ $bidang->nama_bidang }}
            </option>
        @endforeach
    </select>
    @error('bidang_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

            <div class="mb-3">
                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                <input type="number" 
                       name="tahun" 
                       class="form-control @error('tahun') is-invalid @enderror" 
                       value="{{ old('tahun', $data->tahun) }}"
                       min="2000"
                       max="{{ date('Y') + 5 }}"
                       required>
                @error('tahun')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Abstrak</label>
                <textarea name="abstrak" 
                          rows="6" 
                          class="form-control @error('abstrak') is-invalid @enderror"
                          placeholder="Tulis abstrak penelitian Anda di sini...">{{ old('abstrak', $data->abstrak) }}</textarea>
                @error('abstrak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- File Lama --}}
            @if($data->file_path)
                <div class="mb-3">
                    <label class="form-label">File Saat Ini</label>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ asset('storage/' . $data->file_path) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-pdf"></i> Lihat File
                        </a>
                        <small class="text-muted">
                            {{ basename($data->file_path) }}
                        </small>
                    </div>
                </div>
            @endif

            {{-- Upload File Baru --}}
            <div class="mb-3">
                <label class="form-label">
                    Upload File Baru 
                    <span class="text-muted">(Opsional - Kosongkan jika tidak ingin mengganti)</span>
                </label>
                <input type="file" 
                       name="file" 
                       id="fileInput"
                       class="form-control @error('file') is-invalid @enderror"
                       accept=".pdf,.doc,.docx">
                <small class="text-muted d-block mt-1">
                    Format: PDF/DOC/DOCX, maksimal 5MB
                </small>
                <small id="fileInfo" class="text-info d-block mt-1"></small>
                @error('file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('dosen.penelitian.show', $data->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>

        </form>

    </div>
</div>

<script>
document.getElementById('fileInput')?.addEventListener('change', function(e) {
    const fileInfo = document.getElementById('fileInfo');
    
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const fileSize = file.size / 1024 / 1024; // Convert to MB
        const fileName = file.name;
        
        fileInfo.textContent = `File baru: ${fileName} (${fileSize.toFixed(2)} MB)`;
        
        if (fileSize > 5) {
            fileInfo.className = 'text-danger d-block mt-1';
            fileInfo.textContent += ' - File terlalu besar! Maksimal 5MB';
        } else {
            fileInfo.className = 'text-success d-block mt-1';
        }
    }
});
</script>
<script>
// File size checker
document.getElementById('fileInput')?.addEventListener('change', function(e) {
    const fileInfo = document.getElementById('fileInfo');
    
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const fileSize = file.size / 1024 / 1024; // Convert to MB
        const fileName = file.name;
        
        fileInfo.textContent = `File baru: ${fileName} (${fileSize.toFixed(2)} MB)`;
        
        if (fileSize > 5) {
            fileInfo.className = 'text-danger d-block mt-1';
            fileInfo.textContent += ' - File terlalu besar! Maksimal 5MB';
        } else {
            fileInfo.className = 'text-success d-block mt-1';
        }
    }
});

// Form submit dengan loading
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validasi form
    if (!this.checkValidity()) {
        this.reportValidity();
        return;
    }
    
    // Tampilkan loading
    Swal.fire({
        title: 'Menyimpan Perubahan...',
        html: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Submit form
    this.submit();
});
</script>
@endsection