@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white">
        Tambah Pengabdian
    </div>

    <div class="card-body">

        {{-- Tampilkan semua error --}}
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

        <form action="{{ route('dosen.pengabdian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-3">
                <label class="form-label">Judul Pengabdian <span class="text-danger">*</span></label>
                <input type="text" 
                       name="judul" 
                       class="form-control @error('judul') is-invalid @enderror" 
                       value="{{ old('judul') }}"
                       required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- BIDANG --}}
            <div class="mb-3">
                <label class="form-label">Bidang <span class="text-danger">*</span></label>
                <select name="bidang_id" 
                        class="form-select @error('bidang_id') is-invalid @enderror" 
                        required>
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangList as $bidang)
                        <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                            {{ $bidang->nama_bidang }}
                        </option>
                    @endforeach
                </select>
                @error('bidang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- RESEARCH GROUP --}}
            <div class="mb-3">
                <label class="form-label">
                    Research Group (Tim Pengabdian)
                    <span class="text-muted">(Opsional)</span>
                </label>
                <select name="research_group_id" 
                        class="form-select @error('research_group_id') is-invalid @enderror">
                    <option value="">-- Pilih Research Group (Jika Ada) --</option>
                    @foreach($researchGroups as $group)
                        <option value="{{ $group->id }}" {{ old('research_group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->nama_group }}
                            @if($group->ketua)
                                (Ketua: {{ $group->ketua }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <small class="text-muted d-block mt-1">
                    <i class="bi bi-info-circle"></i> 
                    Pilih research group jika pengabdian ini merupakan bagian dari tim tertentu
                </small>
                @error('research_group_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- TAHUN --}}
            <div class="mb-3">
                <label class="form-label">Tahun <span class="text-danger">*</span></label>
                <input type="number" 
                       name="tahun" 
                       class="form-control @error('tahun') is-invalid @enderror" 
                       value="{{ old('tahun', date('Y')) }}"
                       min="2000"
                       max="{{ date('Y') + 5 }}"
                       required>
                @error('tahun')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ABSTRAK --}}
            <div class="mb-3">
                <label class="form-label">Abstrak Pengabdian</label>
                <textarea name="abstrak" 
                          rows="6" 
                          class="form-control @error('abstrak') is-invalid @enderror"
                          placeholder="Tulis abstrak pengabdian Anda di sini...">{{ old('abstrak') }}</textarea>
                @error('abstrak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- FILE --}}
            <div class="mb-3">
                <label class="form-label">Upload File Pengabdian</label>
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

            {{-- BUTTON --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>
</div>

{{-- INFO FILE --}}
<script>
document.getElementById('fileInput')?.addEventListener('change', function(e) {
    const fileInfo = document.getElementById('fileInfo');
    
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const fileSize = file.size / 1024 / 1024;
        const fileName = file.name;
        
        fileInfo.textContent = `File: ${fileName} (${fileSize.toFixed(2)} MB)`;
        
        if (fileSize > 5) {
            fileInfo.className = 'text-danger d-block mt-1';
            fileInfo.textContent += ' - File terlalu besar! Maksimal 5MB';
        } else {
            fileInfo.className = 'text-success d-block mt-1';
        }
    }
});
</script>

{{-- LOADING SAAT SUBMIT --}}
<script>
document.querySelector('form')?.addEventListener('submit', function(e) {
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