@extends('layouts.admin')
@section('title', 'Data Anak')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Data Siswa KB & TK</h3>
    <a href="{{ route('admin.anak.create') }}" class="btn btn-success">+ Tambah Data Anak</a>
</div>

<div class="mb-3">
    <a href="{{ route('admin.anak.index') }}" class="btn btn-sm {{ !request('kelompok') ? 'btn-dark' : 'btn-outline-dark' }}">Semua ({{ $anakList->count() }})</a>
    <a href="{{ route('admin.anak.index', ['kelompok' => 'KB']) }}" class="btn btn-sm {{ request('kelompok') == 'KB' ? 'btn-success' : 'btn-outline-success' }}">Kelompok Bermain (KB)</a>
    <a href="{{ route('admin.anak.index', ['kelompok' => 'TK']) }}" class="btn btn-sm {{ request('kelompok') == 'TK' ? 'btn-primary' : 'btn-outline-primary' }}">Taman Kanak-Kanak (TK)</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelompok</th>
                    <th>L/P</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Wali Terhubung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anakList as $anak)
                <tr>
                    <td class="fw-semibold">{{ $anak->nis }}</td>
                    <td>{{ $anak->nama_anak }}</td>
                    <td>
                        <span class="badge {{ $anak->kelompok == 'KB' ? 'bg-success' : 'bg-primary' }}">
                            {{ $anak->kelompok }}
                        </span>
                    </td>
                    <td>{{ $anak->jenis_kelamin }}</td>
                    <td>
                        {{ $anak->tempat_lahir ?? '-' }}{{ $anak->tanggal_lahir ? ', ' . $anak->tanggal_lahir : '' }}
                    </td>
                    <td>
                        @forelse($anak->wali as $w)
                            <span class="badge bg-secondary">{{ $w->nama_lengkap }} ({{ $w->pivot->hubungan }})</span>
                        @empty
                            <span class="text-muted small">Belum ditautkan</span>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('admin.anak.edit', $anak->id_anak) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.anak.destroy', $anak->id_anak) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data anak ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data anak.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection