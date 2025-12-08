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

    {{-- ✅ TOMBOL EDIT PROFIL ADMIN --}}
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
            <div class="card-body">
                <h3 class="fw-bold">{{ $totalPenelitian }}</h3>
                <small>Total Penelitian</small>
            </div>
        </div>
    </div>

    {{-- TOTAL PENGABDIAN --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#2563eb;">
            <div class="card-body">
                <h3 class="fw-bold">{{ $totalPengabdian }}</h3>
                <small>Total Pengabdian</small>
            </div>
        </div>
    </div>

    {{-- TOTAL DOSEN --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#7c3aed;">
            <div class="card-body">
                <h3 class="fw-bold">{{ $totalDosen }}</h3>
                <small>Total Dosen</small>
            </div>
        </div>
    </div>

    {{-- MENUNGGU VALIDASI --}}
    <div class="col-md-3">
        <div class="card shadow-sm border-0 text-white" style="background:#dc2626;">
            <div class="card-body">
                <h3 class="fw-bold">{{ $menungguValidasi }}</h3>
                <small>Menunggu Validasi</small>
            </div>
        </div>
    </div>
</div>


{{-- AKTIVITAS TERBARU --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white fw-bold">
        Aktivitas Terbaru Dosen
    </div>

    <div class="card-body">

        @forelse($aktivitas as $item)

            <div class="d-flex justify-content-between border-bottom py-3">

                <div>
                    <strong>{{ $item->judul }}</strong><br>
                    <small class="text-muted">
                        {{ $item->nama_dosen }} • {{ $item->jenis }} • {{ $item->tahun }}
                    </small><br>
                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </small>
                </div>

                <div>
                    @if($item->status == 'Menunggu Validasi')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($item->status == 'Disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>

            </div>

        @empty
            <div class="text-center py-5 text-muted">
                Belum ada aktivitas.
            </div>
        @endforelse

    </div>
</div>

@endsection
