<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIRAMA' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #0c2f75;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 20px;
            z-index: 1000;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar-divider {
            border-bottom: 1px solid rgba(255,255,255,0.3);
            margin: 15px 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            font-size: 16px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.12);
            border-radius: 8px;
            padding-left: 15px;
        }

        .sidebar a.active {
            font-weight: bold;
            color: #ffd700;
        }

        /* CONTENT */
        .content {
            margin-left: 250px; /* ✅ INI KUNCI UTAMA POSISI SAMPING */
            padding: 25px;
        }

        .profile-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* STAT */
        .stat {
            color: white;
            padding: 25px;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            min-height: 120px;
        }
        .stat i {
            font-size: 48px;
            position: absolute;
            right: 20px;
            bottom: 15px;
            opacity: 0.25;
        }
        .stat-green { background: #27ae60; }
        .stat-blue { background: #2980b9; }
        .stat-orange { background: #e67e22; }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    @if(request()->is('admin*'))
        @include('partials.sidebar-admin')
    @else
        @include('partials.sidebar')
    @endif

    <div class="content">

        <!-- ✅ TOPBAR OTOMATIS ADMIN / DOSEN -->
        <div class="topbar d-flex justify-content-between align-items-center">
            <h4 class="m-0">
                <i class="bi bi-speedometer2 me-2"></i>
                {{ $title ?? 'Dashboard' }}
            </h4>

            <div class="text-end">
                @if(request()->is('admin*'))
                    <strong>{{ auth()->guard('admin')->user()->nama ?? 'Admin' }}</strong><br>
                    <span>Administrator</span>
                @else
                    <strong>{{ auth()->guard('dosen')->user()->nama }}</strong><br>
                    <span>{{ auth()->guard('dosen')->user()->nip }}</span>
                @endif
            </div>
        </div>

        <!-- Content dari child view -->
        @yield('content')

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
