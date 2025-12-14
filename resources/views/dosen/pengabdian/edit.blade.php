@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header fw-bold bg-white d-flex justify-content-between align-items-center">
        <span><i class="bi bi-pencil-square me-2"></i> Edit Pengabdian</span>
        <a href="{{ route('dosen.pengabdian.show', $data->id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Detail
        </a>
    </div>

    <div class="card-body">

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong><i class="bi bi-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('dosen.pengabdian.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
            @csrf
            @method('PUT')

            {{-- Section: Informasi Dasar --}}
            <div class="mb-4">
                <h6 class="text-secondary mb-3">
                    <i class="bi bi-info-circle me-2"></i>Informasi Dasar
                </h6>
                
                {{-- JUDUL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Judul Pengabdian <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           value="{{ old('judul', $data->judul) }}"
                           placeholder="Masukkan judul pengabdian"
                           required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- BIDANG --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Bidang <span class="text-danger">*</span>
                        </label>
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

                    {{-- TAHUN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Tahun <span class="text-danger">*</span>
                        </label>
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
                </div>
            </div>

            <hr>

            {{-- Section: Tim & Kolaborasi --}}
            <div class="mb-4">
                <h6 class="text-secondary mb-3">
                    <i class="bi bi-people-fill me-2"></i>Tim & Kolaborasi
                </h6>

                {{-- RESEARCH GROUP --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Research Group (Tim Pengabdian)
                        <span class="badge bg-secondary text-white ms-1">Opsional</span>
                    </label>
                    <select name="research_group_id" 
                            class="form-select @error('research_group_id') is-invalid @enderror">
                        <option value="">-- Tidak Ada / Individu --</option>
                        @foreach($researchGroups as $group)
                            <option value="{{ $group->id }}" 
                                    {{ old('research_group_id', $data->research_group_id) == $group->id ? 'selected' : '' }}>
                                <i class="bi bi-people"></i> {{ $group->nama_group }}
                                @if($group->ketua)
                                    - Ketua: {{ $group->ketua }}
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
            </div>

            <hr>

            {{-- Section: Deskripsi --}}
            <div class="mb-4">
                <h6 class="text-secondary mb-3">
                    <i class="bi bi-file-text me-2"></i>Deskripsi
                </h6>

                {{-- ABSTRAK --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Abstrak Pengabdian</label>
                    <textarea name="abstrak" 
                              rows="6" 
                              class="form-control @error('abstrak') is-invalid @enderror"
                              placeholder="Tulis abstrak pengabdian Anda di sini...">{{ old('abstrak', $data->abstrak) }}</textarea>
                    <small class="text-muted d-block mt-1">
                        Jelaskan secara singkat tujuan, metode, dan hasil pengabdian
                    </small>
                    @error('abstrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>

            {{-- Section: Dokumen --}}
            <div class="mb-4">
                <h6 class="text-secondary mb-3">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Dokumen Pendukung
                </h6>

                {{-- FILE LAMA --}}
                @if($data->file_path)
                    <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                        <i class="bi bi-file-earmark-check fs-4 me-3"></i>
                        <div class="flex-grow-1">
                            <strong>File Saat Ini:</strong>
                            <p class="mb-0 small">{{ basename($data->file_path) }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $data->file_path) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                @else
                    <div class="alert alert-warning d-flex align-items-center mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <span>Belum ada file yang diupload</span>
                    </div>
                @endif

                {{-- FILE BARU --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Upload File Baru
                        <span class="badge bg-secondary text-white ms-1">Opsional</span>
                    </label>
                    <input type="file" 
                           name="file" 
                           id="fileInput"
                           class="form-control @error('file') is-invalid @enderror"
                           accept=".pdf,.doc,.docx">
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> 
                        Format: PDF/DOC/DOCX, maksimal 5MB. Kosongkan jika tidak ingin mengganti file
                    </small>
                    <small id="fileInfo" class="d-block mt-1"></small>
                    @error('file')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="d-flex gap-2 pt-3 border-top">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('dosen.pengabdian.show', $data->id) }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>

        </form>

    </div>
</div>

{{-- SCRIPT FILE INFO --}}
<script>
document.getElementById('fileInput')?.addEventListener('change', function(e) {
    const fileInfo = document.getElementById('fileInfo');
    
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const fileSize = file.size / 1024 / 1024; // Convert to MB
        const fileName = file.name;
        
        fileInfo.innerHTML = `
            <div class="alert alert-${fileSize > 5 ? 'danger' : 'success'} py-2 px-3 mb-0">
                <i class="bi bi-file-earmark-arrow-up me-2"></i>
                <strong>File baru:</strong> ${fileName} (${fileSize.toFixed(2)} MB)
                ${fileSize > 5 ? '<br><small><i class="bi bi-exclamation-triangle"></i> File terlalu besar! Maksimal 5MB</small>' : ''}
            </div>
        `;
    }
});
</script>

{{-- SCRIPT SUBMIT WITH LOADING --}}
<script>
document.getElementById('editForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validasi form
    if (!this.checkValidity()) {
        this.reportValidity();
        return;
    }
    
    // Tampilkan loading dengan Sweet Alert
    Swal.fire({
        title: 'Menyimpan Perubahan...',
        html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3 mb-0">Mohon tunggu sebentar</p>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Submit form
    this.submit();
});
</script>

@endsection