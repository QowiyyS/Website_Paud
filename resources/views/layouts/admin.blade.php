<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin PAUD Haqqul Yaqin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-success text-white p-3 vh-100 position-fixed" style="width: 250px;">
        <h5 class="fw-bold mb-1">PAUD Haqqul Yaqin</h5>
        <small class="text-white-50 d-block mb-4">Panel Admin / Kepsek</small>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-dark rounded' : '' }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.anak.index') }}" class="nav-link text-white {{ request()->routeIs('admin.anak.*') ? 'bg-dark rounded' : '' }}">Data Anak (KB & TK)</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.pengguna.index') }}" class="nav-link text-white {{ request()->routeIs('admin.pengguna.*') ? 'bg-dark rounded' : '' }}">Akun Pengguna & Wali</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.periode.index') }}" class="nav-link text-white {{ request()->routeIs('admin.periode.*') ? 'bg-dark rounded' : '' }}">Periode Rapor</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.rapor.index') }}" class="nav-link text-white {{ request()->routeIs('admin.rapor.*') ? 'bg-dark rounded' : '' }}">Persetujuan Rapor</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4" style="margin-left: 250px;">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
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