@extends('layouts.main')

@section('content')

{{-- HEADER ADMIN --}}
<div class="p-4 mb-4 rounded shadow-sm d-flex align-items-center justify-content-between"
     style="background:#1e40af; color:white;">

    <div>
        <h4 class="m-0 fw-bold">
            Hai, {{ auth()->guard('admin')->user()->nama ?? 'Admin' }}!
        </h4>
        <p class="m-0">NIP: {{ auth()->guard('admin')->user()->nip }}</p>
        <p class="m-0">Sistem Informasi Riset & Pengabdian</p>
        <small>Universitas Sebelas Maret</small>
    </div>

    {{-- TOMBOL EDIT PROFIL ADMIN --}}
    <div>
        <a href="{{ route('admin.edit.profil') }}" class="btn btn-light fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Profil
        </a>
    </div>

</div>


{{-- STATISTIK --}}
<div class="row mb-4">

    {{-- TOTAL PENELITIAN --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#16a34a;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-journal-bookmark-fill fs-1 me-3"></i>
                <div>
                    <h3 class="fw-bold m-0">{{ $totalPenelitian }}</h3>
                    <small>Total Penelitian</small>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL PENGABDIAN --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#2563eb;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-people-fill fs-1 me-3"></i>
                <div>
                    <h3 class="fw-bold m-0">{{ $totalPengabdian }}</h3>
                    <small>Total Pengabdian</small>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL DOSEN --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#7c3aed;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-person-badge-fill fs-1 me-3"></i>
                <div>
                    <h3 class="fw-bold m-0">{{ $totalDosen }}</h3>
                    <small>Total Dosen</small>
                </div>
            </div>
        </div>
    </div>

    {{-- MENUNGGU VALIDASI --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#dc2626;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-hourglass-split fs-1 me-3"></i>
                <div>
                    <h3 class="fw-bold m-0">{{ $menungguValidasi }}</h3>
                    <small>Menunggu Validasi</small>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- AKTIVITAS TERBARU --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-clock-history me-2"></i>
            Aktivitas Terbaru Dosen
        </span>
        <span class="badge bg-primary">{{ count($aktivitas) }} Aktivitas</span>
    </div>

    <div class="card-body">

        @forelse ($aktivitas as $item)

            <div class="d-flex justify-content-between align-items-center border-bottom py-3 hover-item">

                <div class="flex-grow-1">
                    <a href="{{ $item['route'] }}" class="text-decoration-none">
                        <strong class="text-dark">{{ $item['judul'] }}</strong>
                    </a>
                    <br>
                    <small class="text-muted">
                        <i class="bi bi-person"></i> {{ $item['nama_dosen'] }} •
                        <i class="bi bi-tag"></i> {{ $item['kategori'] }} •
                        <i class="bi bi-calendar"></i> {{ $item['tahun'] }} •
                        <span class="badge bg-secondary">{{ $item['jenis'] }}</span>
                    </small>
                    <br>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i>
                        {{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                    </small>
                </div>

                {{-- BADGE STATUS --}}
                <div class="ms-3">
                    @if ($item['status'] == 'Menunggu Validasi')
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="bi bi-hourglass-split me-1"></i> Menunggu Validasi
                        </span>
                    @elseif ($item['status'] == 'Disetujui')
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i> Disetujui
                        </span>
                    @elseif ($item['status'] == 'Ditolak')
                        <span class="badge bg-danger px-3 py-2">
                            <i class="bi bi-x-circle me-1"></i> Ditolak
                        </span>
                    @else
                        <span class="badge bg-secondary px-3 py-2">{{ $item['status'] }}</span>
                    @endif
                </div>

            </div>

        @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3 mb-2">Belum ada aktivitas</p>
                <small class="text-muted">
                    Aktivitas dosen akan muncul ketika ada penelitian/pengabdian yang ditambahkan.
                </small>
            </div>
        @endforelse

    </div>

    @if(count($aktivitas) > 0)
        <div class="card-footer bg-white text-center">
            <div class="btn-group" role="group">
                <a href="{{ route('admin.penelitian.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-journal-check"></i> Lihat Validasi Penelitian
                </a>
                <a href="{{ route('admin.pengabdian.index') }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-people-fill"></i> Lihat Validasi Pengabdian
                </a>
            </div>
        </div>
    @endif

</div>

<style>
.hover-item {
    transition: background-color 0.2s;
}
.hover-item:hover {
    background-color: #f8f9fa;
}
</style>

@endsection
