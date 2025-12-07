@extends('layouts.main')

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Detail Penelitian</span>

        <a href="{{ route('admin.penelitian.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">

        {{-- JUDUL --}}
        <div class="mb-3">
            <label class="fw-semibold">Judul Penelitian</label>
            <p>{{ $data->judul }}</p>
        </div>

        {{-- DOSEN --}}
        <div class="mb-3">
            <label class="fw-semibold">Dosen Pengusul</label>
            <p>{{ $data->dosen->nama }}</p>
        </div>

        {{-- BIDANG --}}
        <div class="mb-3">
            <label class="fw-semibold">Bidang</label>
            <p>{{ $data->bidang }}</p>
        </div>

        {{-- TAHUN --}}
        <div class="mb-3">
            <label class="fw-semibold">Tahun</label>
            <p>{{ $data->tahun }}</p>
        </div>

        {{-- STATUS --}}
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

        {{-- ABSTRAK --}}
        <div class="mb-3">
            <label class="fw-semibold">Abstrak</label>
            <p style="white-space: pre-line">{{ $data->abstrak ?? '-' }}</p>
        </div>

        {{-- FILE --}}
        <div class="mb-4">
            <label class="fw-semibold">File Penelitian</label><br>

            @if($data->file_path)
                <a href="{{ asset('storage/' . $data->file_path) }}"
                   target="_blank"
                   class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-download"></i> Download File
                </a>
            @else
                <p class="text-muted">Tidak ada file diunggah.</p>
            @endif
        </div>

        {{-- ✅ TOMBOL VALIDASI --}}
        @if($data->status == 'Menunggu Validasi')
        <div class="d-flex gap-2">

            {{-- SETUJUI --}}
            <form action="{{ route('admin.penelitian.approve', $data->id) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-success"
                        onclick="return confirm('Setujui penelitian ini?')">
                    <i class="bi bi-check-circle"></i> Setujui
                </button>
            </form>

            {{-- TOLAK --}}
            <form action="{{ route('admin.penelitian.reject', $data->id) }}"
                  method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-danger"
                        onclick="return confirm('Tolak penelitian ini?')">
                    <i class="bi bi-x-circle"></i> Tolak
                </button>
            </form>

        </div>
        @endif

    </div>
</div>

@endsection
