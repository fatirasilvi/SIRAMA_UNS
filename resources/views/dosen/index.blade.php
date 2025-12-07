@extends('layouts.main')

@section('content')

{{-- HEADER PROFIL DOSEN --}}
<div class="p-4 mb-4 rounded shadow-sm d-flex align-items-center" 
     style="background:#163e97; color:white;">

    {{-- Foto Profil --}}
    <img src="{{ Auth::guard('dosen')->user()->foto 
            ? asset('storage/dosen/'.Auth::guard('dosen')->user()->foto) 
            : asset('img/user.png') }}" 
        class="rounded-circle me-4 border"
        style="width:100px; height:100px; object-fit:cover;">

    {{-- Informasi Dosen --}}
    <div>
        <h4 class="m-0 fw-bold">{{ Auth::guard('dosen')->user()->nama }}</h4>
        <p class="m-0">NIP. {{ Auth::guard('dosen')->user()->nip }}</p>
        <small>{{ Auth::guard('dosen')->user()->prodi ?? 'Pendidikan Teknik Informatika & Komputer' }}</small>
    </div>

    {{-- Tombol Edit --}}
    <div class="ms-auto">
        <a href="{{ route('dosen.edit.profil') }}" class="btn btn-light fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Profil
        </a>
    </div>
</div>


{{-- STATISTIK --}}
<div class="row mb-4">

    {{-- TOTAL PENELITIAN --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-white" style="background:#2e8b57;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-journal-bookmark-fill fs-1 me-3"></i>
                <div>
                    <h2 class="m-0 fw-bold">{{ $totalPenelitian }}</h2>
                    <p class="m-0">Total Penelitian</p>
                    <a href="{{ route('dosen.penelitian.index') }}" class="text-white text-decoration-underline">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL PENGABDIAN --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-white" style="background:#1e56a0;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-people-fill fs-1 me-3"></i>
                <div>
                    <h2 class="m-0 fw-bold">{{ $totalPengabdian }}</h2>
                    <p class="m-0">Total Pengabdian</p>
                    <a href="{{ route('dosen.pengabdian.index') }}" class="text-white text-decoration-underline">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MENUNGGU VALIDASI --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-white" style="background:#d97706;">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-hourglass-split fs-1 me-3"></i>
                <div>
                    <h2 class="m-0 fw-bold">{{ $menungguValidasi }}</h2>
                    <p class="m-0">Menunggu Validasi</p>
                    <small class="text-white opacity-75">
                        Penelitian + Pengabdian
                    </small>
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
            Aktivitas Terbaru Anda
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
                    Mulai tambahkan penelitian atau pengabdian Anda untuk melihat aktivitas di sini
                </small>
            </div>
        @endforelse

    </div>

    @if(count($aktivitas) > 0)
        <div class="card-footer bg-white text-center">
            <div class="btn-group" role="group">
                <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-journal-bookmark"></i> Lihat Semua Penelitian
                </a>
                <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-people"></i> Lihat Semua Pengabdian
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