<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin PAUD Haqqul Yaqin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --paud-navy: #1e3a8a;
            --paud-navy-dark: #172554;
            --paud-orange: #f97316;
            --paud-cream: #fff8ed;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--paud-cream);
            color: #1e293b;
        }
        .sidebar-paud {
            width: 260px;
            background: linear-gradient(180deg, var(--paud-navy) 0%, var(--paud-navy-dark) 100%);
            box-shadow: 4px 0 15px rgba(30, 58, 138, 0.08);
        }
        .sidebar-paud .brand-sub {
            color: #fdba74;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .sidebar-paud .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            padding: 0.65rem 1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .sidebar-paud .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }
        .sidebar-paud .nav-link.active-paud {
            background-color: var(--paud-orange);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(249, 115, 22, 0.35);
        }
        .card {
            border-radius: 14px;
        }
        .btn-success {
            background-color: var(--paud-orange);
            border-color: var(--paud-orange);
            font-weight: 600;
        }
        .btn-success:hover {
            background-color: #ea580c;
            border-color: #ea580c;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar-paud text-white p-3 vh-100 position-fixed d-flex flex-column justify-content-between">
        <div>
            <div class="px-2 pt-2 pb-3 border-bottom border-white border-opacity-10 mb-3">
                <h5 class="fw-bold mb-1">PAUD Haqqul Yaqin</h5>
                <span class="brand-sub text-uppercase d-block">Panel Admin / Kepsek</span>
            </div>
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-paud' : '' }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.anak.index') }}" class="nav-link {{ request()->routeIs('admin.anak.*') ? 'active-paud' : '' }}">Data Anak (KB & TK)</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pengguna.index') }}" class="nav-link {{ request()->routeIs('admin.pengguna.*') ? 'active-paud' : '' }}">Akun Pengguna & Wali</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.periode.index') }}" class="nav-link {{ request()->routeIs('admin.periode.*') ? 'active-paud' : '' }}">Periode Rapor</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rapor.index') }}" class="nav-link {{ request()->routeIs('admin.rapor.*') ? 'active-paud' : '' }}">Persetujuan Rapor</a>
                </li>
            </ul>
        </div>
        <div class="px-2 pb-2">
            <a href="{{ route('landing') }}" class="btn btn-outline-light btn-sm w-100 rounded-pill">← Ke Beranda Utama</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4" style="margin-left: 260px;">
        @if(session('success'))
            <div class="alert alert-success rounded-3 border-0 shadow-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger rounded-3 border-0 shadow-sm">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger rounded-3 border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>