<div class="sidebar">

    <div class="sidebar-header text-center">
        <h4 class="fw-bold">SIRAMA</h4>
        <small>Admin Panel</small>
    </div>

    <div class="text-center mt-3">
        <div class="fw-bold">{{ auth()->guard('admin')->user()->nama ?? 'Admin' }}</div>
        <small>{{ auth()->guard('admin')->user()->email ?? '-' }}</small>
    </div>

    <div class="sidebar-divider"></div>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('admin.dosen.index') }}" class="{{ request()->is('admin/dosen*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Data Dosen
    </a>

    <a href="{{ route('admin.prodi.index') }}" class="{{ request()->is('admin/prodi*') ? 'active' : '' }}">
        <i class="bi bi-mortarboard"></i> Data Prodi
    </a>

    <a href="{{ route('admin.research-group.index') }}" class="{{ request()->is('admin/research-group*') ? 'active' : '' }}">
        <i class="bi bi-diagram-3"></i> Research Group
    </a>

    <a href="{{ route('admin.penelitian.index') }}" class="{{ request()->is('admin/penelitian*') ? 'active' : '' }}">
        <i class="bi bi-journal-check"></i> Validasi Penelitian
    </a>

    <a href="{{ route('admin.pengabdian.index') }}" class="{{ request()->is('admin/pengabdian*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Validasi Pengabdian
    </a>

    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph"></i> Laporan Rekap
    </a>

    <div class="sidebar-divider"></div>

    <form action="{{ route('admin.logout') }}" method="POST" class="mt-2">
        @csrf
        <button class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>

</div>
