<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'SIRAMA UNS' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>

<div class="sidebar">
    <div class="sidebar-header">
        <h4>SIRAMA</h4>
        <p>{{ auth()->user()->name ?? '' }}</p>
    </div>

    <a href="{{ route('dosen.dashboard') }}">Dashboard</a>
    <a href="#">Penelitian</a>
    <a href="#">Pengabdian</a>
    <a href="#">Riwayat & Laporan</a>

    <form action="{{ route('dosen.logout') }}" method="POST">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>
</div>

<div class="content">
    <div class="topbar">
        <h3>{{ $title }}</h3>
        <p>{{ auth()->user()->name }} ({{ auth()->user()->nip }})</p>
    </div>

    <div class="content-body">
        @yield('content')
    </div>
</div>

</body>
</html>
