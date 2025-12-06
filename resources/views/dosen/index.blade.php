@extends('layouts.main')

@section('content')

{{-- HEADER PROFIL DOSEN --}}
<div class="p-4 mb-4 rounded shadow-sm d-flex align-items-center" 
     style="background:#163e97; color:white;">

    {{-- Foto Profil --}}
    <img src="{{ auth()->user()->foto 
            ? asset('storage/dosen/'.auth()->user()->foto) 
            : asset('img/user.png') }}" 
        class="rounded-circle me-4 border"
        style="width:100px; height:100px; object-fit:cover;">

    {{-- Informasi Dosen --}}
    <div>
        <h4 class="m-0 fw-bold">{{ auth()->user()->name }}</h4>
        
        <div>{{ Auth::guard('dosen')->user()->nama }}</div>
        <p class="m-0">NIP. {{ auth()->user()->nip }}</p>
        <small>{{ auth()->user()->prodi ?? 'Pendidikan Teknik Informatika & Komputer' }}</small>
    </div>

    {{-- Tombol Edit --}}
    <div class="ms-auto">
        <a href="/dosen/edit-profil" class="btn btn-light fw-bold">Edit Profil</a>
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
                    <a href="/dosen/penelitian" class="text-white text-decoration-underline">Lihat Detail →</a>
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
                    <a href="/dosen/pengabdian" class="text-white text-decoration-underline">Lihat Detail →</a>
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
                    <a href="#" class="text-white text-decoration-underline">Lihat Detail →</a>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- AKTIVITAS TERBARU --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        Aktivitas Terbaru Anda
    </div>

    <div class="card-body">

        @forelse ($aktivitas as $item)

            <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                <div>
                    <strong>{{ $item->judul }}</strong><br>
                    <small>{{ $item->kategori }} – {{ $item->tahun }} ({{ $item->jenis }})</small>
                </div>

                {{-- BADGE STATUS --}}
                @if ($item->status == 'menunggu')
                    <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                    </span>
                @elseif ($item->status == 'disetujui')
                    <span class="badge bg-success px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i> Disetujui
                    </span>
                @else
                    <span class="badge bg-secondary px-3 py-2">Tidak Dikenal</span>
                @endif

            </div>

        @empty
            <p class="text-muted m-0">Tidak ada aktivitas terbaru.</p>
        @endforelse

    </div>
</div>

@endsection
