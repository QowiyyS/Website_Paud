@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<h3 class="mb-4 fw-bold">Dashboard Admin — PAUD Haqqul Yaqin</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Siswa Kelompok Bermain (KB)</small>
                <h2 class="fw-bold text-success mb-0">{{ $totalKB }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Siswa Taman Kanak-Kanak (TK)</small>
                <h2 class="fw-bold text-primary mb-0">{{ $totalTK }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Akun Guru / Wali Murid</small>
                <h2 class="fw-bold text-dark mb-0">{{ $totalGuru }} / {{ $totalWali }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Rapor Menunggu Proses</small>
                <h2 class="fw-bold text-warning mb-0">{{ $raporMenunggu }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection