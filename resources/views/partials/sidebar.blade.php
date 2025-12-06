<div class="sidebar">

    <div class="sidebar-header text-center">
        <h4 class="fw-bold">SIRAMA</h4>
    </div>

    <div class="text-center">

        <img 
            src="{{ Auth::guard('dosen')->user()->foto ? asset('storage/dosen/' . Auth::guard('dosen')->user()->foto) : asset('img/user.png') }}"
            class="rounded-circle"
            style="width:50px; height:50px; object-fit:cover;"
        >


        <div>{{ Auth::guard('dosen')->user()->nama }}</div>
        <small>{{ Auth::guard('dosen')->user()->nip }}</small>
    </div>

    <div class="sidebar-divider"></div>

    <a href="/dosen/dashboard" class="{{ request()->is('dosen/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="/dosen/penelitian" class="{{ request()->is('dosen/penelitian*') ? 'active' : '' }}">
        <i class="bi bi-journal-bookmark"></i> Penelitian
    </a>

    <a href="/dosen/pengabdian" class="{{ request()->is('dosen/pengabdian*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Pengabdian
    </a>

    <a href="/dosen/riwayat" class="{{ request()->is('dosen/riwayat') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat & Laporan
    </a>

    <div class="sidebar-divider"></div>

    <a href="/dosen/logout" class="mt-2">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>
