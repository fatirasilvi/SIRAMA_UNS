@extends('layouts.main')

@section('content')

{{-- Profil Box --}}
<div class="profile-box">
    <div class="profile-info">
        <img src="{{ asset('img/user.png') }}" class="profile-photo">

        <div>
            <h3>{{ auth()->user()->name }}</h3>
            <p>NIP. {{ auth()->user()->nip }}</p>
            <p>{{ auth()->user()->prodi ?? 'Pendidikan Teknik Informatika & Komputer' }}</p>
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="stats">
    <div class="stat green">
        <h1>{{ $totalPenelitian ?? 0 }}</h1>
        <p>Total Penelitian</p>
        <a href="/dosen/penelitian">Lihat Detail →</a>
    </div>

    <div class="stat blue">
        <h1>{{ $totalPengabdian ?? 0 }}</h1>
        <p>Total Pengabdian</p>
        <a href="/dosen/pengabdian">Lihat Detail →</a>
    </div>

    <div class="stat orange">
        <h1>{{ $menungguValidasi ?? 0 }}</h1>
        <p>Menunggu Validasi</p>
        <a href="#">Lihat Detail →</a>
    </div>
</div>

{{-- Aktivitas Terbaru --}}
<div class="activity-box">
    <h3>Aktivitas Terbaru Anda</h3>

    @forelse($aktivitas as $item)
        <div class="activity-item">
            <div>
                <h4>{{ $item->judul }}</h4>
                <p>{{ $item->kategori }} – {{ $item->tahun }} ({{ $item->jenis }})</p>
            </div>

            @if($item->status == 'menunggu')
                <span class="status yellow">Menunggu Validasi</span>
            @elseif($item->status == 'disetujui')
                <span class="status green">Disetujui</span>
            @else
                <span class="status grey">Status Tidak Dikenal</span>
            @endif
        </div>
    @empty
        <p>Tidak ada aktivitas terbaru.</p>
    @endforelse

</div>

@endsection
