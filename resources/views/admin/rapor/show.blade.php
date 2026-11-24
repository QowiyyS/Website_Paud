@extends('layouts.admin')
@section('title', 'Detail & Pengesahan Rapor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-0">Rapor: {{ $rapor->anak->nama_anak ?? '-' }}</h3>
        <small class="text-muted">{{ $rapor->periode->nama_periode ?? '' }} — {{ $rapor->periode->tahun_ajaran ?? '' }}</small>
    </div>
    <a href="{{ route('admin.rapor.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<!-- Panel Status & Tindakan Pengesahan -->
<div class="card border-0 shadow-sm p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <span class="text-muted d-block small">Status Saat Ini:</span>
            <span class="fs-5 fw-bold text-uppercase">{{ str_replace('_', ' ', $rapor->status_rapor) }}</span>
            @if($rapor->disetujui_pada)
                <small class="d-block text-muted">Disetujui pada: {{ $rapor->disetujui_pada }}</small>
            @endif
            @if($rapor->diterbitkan_pada)
                <small class="d-block text-success">Diterbitkan pada: {{ $rapor->diterbitkan_pada }}</small>
            @endif
        </div>

        <div class="d-flex gap-2">
            @if($rapor->status_rapor === 'diajukan')
                <form action="{{ route('admin.rapor.setujui', $rapor->id_rapor) }}" method="POST">
                    @csrf
                    <button class="btn btn-info text-white fw-semibold" onclick="return confirm('Setujui rapor ini?')">Setujui Rapor</button>
                </form>
            @endif

            @if($rapor->status_rapor === 'disetujui')
                <form action="{{ route('admin.rapor.terbitkan', $rapor->id_rapor) }}" method="POST">
                    @csrf
                    <button class="btn btn-success fw-semibold" onclick="return confirm('Terbitkan rapor agar bisa dilihat Wali Murid?')">Terbitkan Rapor</button>
                </form>
            @endif
        </div>
    </div>

    @if($rapor->status_rapor === 'diterbitkan')
        <hr>
        <form action="{{ route('admin.rapor.buka-ulang', $rapor->id_rapor) }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-8">
                <label class="form-label small fw-bold text-danger">Buka Ulang Rapor Terbit (Jika ada koreksi mendesak)</label>
                <input type="text" name="alasan" class="form-control form-control-sm" placeholder="Tuliskan alasan pembukaan ulang rapor..." required>
            </div>
            <div class="col-md-4">
                <button class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Buka ulang rapor ini untuk revisi?')">Buka Ulang untuk Revisi</button>
            </div>
        </form>
    @endif
</div>

<!-- Isi Narasi & Dokumentasi Rapor -->
<div class="card border-0 shadow-sm p-4 mb-4">
    <h5 class="fw-bold mb-3">Isi Narasi Perkembangan Anak</h5>
    @forelse($rapor->blok as $blok)
        <div class="border rounded p-3 mb-3">
            <h6 class="fw-bold text-success">{{ $blok->urutan }}. {{ $blok->judul_bagian ?? ucfirst($blok->jenis_bagian) }}</h6>
            @if($blok->jenis_bagian === 'narasi')
                <p class="mb-0" style="white-space: pre-line;">{{ $blok->isi_narasi }}</p>
            @else
                <p class="text-muted small mb-1">Lampiran Dokumentasi: {{ $blok->lokasi_file }}</p>
                @if($blok->caption)<small>{{ $blok->caption }}</small>@endif
            @endif
        </div>
    @empty
        <p class="text-muted mb-0">Belum ada blok narasi pada rapor ini.</p>
    @endforelse
</div>

<!-- Riwayat Perubahan -->
<div class="card border-0 shadow-sm p-4">
    <h5 class="fw-bold mb-3">Riwayat Perubahan</h5>
    <ul class="list-group list-group-flush">
        @forelse($rapor->riwayat as $log)
            <li class="list-group-item px-0">
                <small class="text-muted">{{ $log->waktu_perubahan }} — {{ $log->pengguna->nama_lengkap ?? 'Admin' }}</small>
                <div>{{ $log->isi_sesudah }}</div>
            </li>
        @empty
            <li class="list-group-item px-0 text-muted">Belum ada catatan riwayat perubahan.</li>
        @endforelse
    </ul>
</div>
@endsection