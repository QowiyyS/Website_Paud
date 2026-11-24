@extends('layouts.admin')
@section('title', 'Akun Pengguna & Wali')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Kelola Akun Pengguna & Wali Murid</h3>
    <a href="{{ route('admin.pengguna.create') }}" class="btn btn-success">+ Buat Akun Baru</a>
</div>

<div class="mb-3">
    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-sm {{ !request('peran') ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
    <a href="{{ route('admin.pengguna.index', ['peran' => 'admin']) }}" class="btn btn-sm {{ request('peran') == 'admin' ? 'btn-danger' : 'btn-outline-danger' }}">Admin / Kepsek</a>
    <a href="{{ route('admin.pengguna.index', ['peran' => 'guru']) }}" class="btn btn-sm {{ request('peran') == 'guru' ? 'btn-primary' : 'btn-outline-primary' }}">Guru</a>
    <a href="{{ route('admin.pengguna.index', ['peran' => 'walimurid']) }}" class="btn btn-sm {{ request('peran') == 'walimurid' ? 'btn-success' : 'btn-outline-success' }}">Wali Murid</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode Login</th>
                    <th>Nama Lengkap</th>
                    <th>Peran</th>
                    <th>Anak Terhubung (Khusus Wali)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penggunaList as $user)
                <tr>
                    <td class="fw-bold">{{ $user->kode_login }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>
                        <span class="badge {{ $user->peran == 'admin' ? 'bg-danger' : ($user->peran == 'guru' ? 'bg-primary' : 'bg-success') }}">
                            {{ strtoupper($user->peran) }}
                        </span>
                    </td>
                    <td>
                        @if($user->peran === 'walimurid')
                            @forelse($user->anak as $a)
                                <span class="badge bg-secondary">{{ $a->nama_anak }} ({{ $a->pivot->hubungan }})</span>
                            @empty
                                <span class="text-muted small">Belum ada anak ditautkan</span>
                            @endforelse
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        @if($user->peran === 'walimurid')
                            <a href="{{ route('admin.pengguna.show', $user->id_pengguna) }}" class="btn btn-sm btn-info text-white">Tautkan Anak</a>
                        @endif
                        <a href="{{ route('admin.pengguna.edit', $user->id_pengguna) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.pengguna.destroy', $user->id_pengguna) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus akun pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data akun pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection