<div class="sidebar">

    {{-- HEADER --}}
    <div class="sidebar-header text-center">
        <h4 class="fw-bold">SIRAMA</h4>
        <small>Dosen</small>
    </div>

    {{-- FOTO & IDENTITAS DOSEN --}}
    <div class="text-center mb-3">

        <img 
            src="{{ Auth::guard('dosen')->user()->foto 
                ? asset('storage/dosen/' . Auth::guard('dosen')->user()->foto) 
                : asset('img/user.png') }}"
            class="rounded-circle"
            style="width:55px; height:55px; object-fit:cover;"
        >

        <div class="mt-2 fw-semibold">
            {{ Auth::guard('dosen')->user()->nama }}
        </div>

        <small>
            {{ Auth::guard('dosen')->user()->nip }}
        </small>
    </div>

    <div class="sidebar-divider"></div>

    {{-- DASHBOARD --}}
    <a href="{{ route('dosen.dashboard') }}"
       class="{{ request()->is('dosen/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    {{-- PENELITIAN --}}
    <a href="{{ route('dosen.penelitian.index') }}"
       class="{{ request()->is('dosen/penelitian*') ? 'active' : '' }}">
        <i class="bi bi-journal-bookmark"></i> Penelitian
    </a>

    {{-- PENGABDIAN --}}
    <a href="{{ route('dosen.pengabdian.index') }}"
       class="{{ request()->is('dosen/pengabdian*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Pengabdian
    </a>

    {{-- RIWAYAT --}}
    <a href="{{ route('dosen.riwayat.index') }}"
       class="{{ request()->is('dosen/riwayat*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat & Laporan
    </a>

    <div class="sidebar-divider"></div>

    {{-- LOGOUT --}}
    <form action="{{ route('dosen.logout') }}" method="POST" class="mt-2">
        @csrf
        <button class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>

</div>
