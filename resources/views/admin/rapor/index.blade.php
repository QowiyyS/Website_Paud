@extends('layouts.admin')
@section('title', 'Persetujuan & Penerbitan Rapor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Persetujuan & Penerbitan Rapor</h3>
</div>

<div class="mb-3">
    <a href="{{ route('admin.rapor.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
    <a href="{{ route('admin.rapor.index', ['status' => 'diajukan']) }}" class="btn btn-sm {{ request('status') == 'diajukan' ? 'btn-warning' : 'btn-outline-warning' }}">Menunggu Persetujuan (Diajukan)</a>
    <a href="{{ route('admin.rapor.index', ['status' => 'disetujui']) }}" class="btn btn-sm {{ request('status') == 'disetujui' ? 'btn-info text-white' : 'btn-outline-info' }}">Siap Terbit (Disetujui)</a>
    <a href="{{ route('admin.rapor.index', ['status' => 'diterbitkan']) }}" class="btn btn-sm {{ request('status') == 'diterbitkan' ? 'btn-success' : 'btn-outline-success' }}">Diterbitkan</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelompok</th>
                    <th>Periode</th>
                    <th>Penyusun (Guru)</th>
                    <th>Status Rapor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($raporList as $r)
                <tr>
                    <td class="fw-semibold">{{ $r->anak->nama_anak ?? '-' }}</td>
                    <td><span class="badge {{ ($r->anak->kelompok ?? '') == 'KB' ? 'bg-success' : 'bg-primary' }}">{{ $r->anak->kelompok ?? '-' }}</span></td>
                    <td>{{ $r->periode->nama_periode ?? '' }} ({{ $r->periode->tahun_ajaran ?? '' }})</td>
                    <td>{{ $r->pembuat->nama_lengkap ?? '-' }}</td>
                    <td>
                        @php
                            $badge = match($r->status_rapor) {
                                'draf' => 'bg-secondary',
                                'diajukan' => 'bg-warning text-dark',
                                'perlu_revisi' => 'bg-danger',
                                'disetujui' => 'bg-info text-dark',
                                'diterbitkan' => 'bg-success',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ strtoupper(str_replace('_', ' ', $r->status_rapor)) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.rapor.show', $r->id_rapor) }}" class="btn btn-sm btn-primary">Periksa / Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data rapor yang masuk dari guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection