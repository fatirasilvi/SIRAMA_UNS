@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white fw-bold">
        Detail Penelitian
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="fw-semibold">Judul</label>
            <p>{{ $data->judul }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Bidang</label>
            <p>{{ $data->bidang }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Tahun</label>
            <p>{{ $data->tahun }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Status</label>
            <p>
                @if($data->status == 'Menunggu Validasi')
                    <span class="badge bg-warning text-dark">Menunggu Validasi</span>
                @elseif($data->status == 'Disetujui')
                    <span class="badge bg-success">Disetujui</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </p>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Abstrak</label>
            <p style="white-space: pre-line">{{ $data->abstrak ?? '-' }}</p>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">File Penelitian</label><br>

            @if($data->file_path)
                <a href="{{ asset('storage/' . $data->file_path) }}" 
                   target="_blank" 
                   class="btn btn-outline-primary btn-sm">
                    Download File
                </a>
            @else
                <p class="text-muted">Tidak ada file diunggah.</p>
            @endif
        </div>

        <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>
</div>

@endsection
