@extends('layouts.admin')
@section('title', 'Tautkan Anak ke Wali')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-0">Kelola Anak untuk Wali: {{ $pengguna->nama_lengkap }}</h3>
        <small class="text-muted">Kode Login: <b>{{ $pengguna->kode_login }}</b></small>
    </div>
    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="row g-4">
    <!-- Form Tambah Tautan Anak -->
    <div class="col-md-5">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Tambah Tautan Anak</h5>
            <form action="{{ route('admin.wali-anak.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pengguna" value="{{ $pengguna->id_pengguna }}">
                <div class="mb-3">
                    <label class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                    <select name="id_anak" class="form-select" required>
                        <option value="">-- Pilih Anak --</option>
                        @foreach($anakTersedia as $anak)
                            <option value="{{ $anak->id_anak }}">[{{ $anak->kelompok }}] {{ $anak->nama_anak }} ({{ $anak->nis }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hubungan Keluarga <span class="text-danger">*</span></label>
                    <select name="hubungan" class="form-select" required>
                        <option value="ayah">Ayah</option>
                        <option value="ibu">Ibu</option>
                        <option value="wali">Wali</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Wali Utama <span class="text-danger">*</span></label>
                    <select name="utama" class="form-select" required>
                        <option value="1">Ya (Wali Utama)</option>
                        <option value="0">Tidak (Wali Tambahan)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Hubungkan Anak</button>
            </form>
        </div>
    </div>

    <!-- Daftar Anak yang Sudah Terhubung -->
    <div class="col-md-7">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Daftar Anak Terhubung ({{ $pengguna->anak->count() }})</h5>
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>NIS</th>
                        <th>Nama Anak</th>
                        <th>Kelompok</th>
                        <th>Hubungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengguna->anak as $anak)
                    <tr>
                        <td>{{ $anak->nis }}</td>
                        <td class="fw-semibold">{{ $anak->nama_anak }}</td>
                        <td><span class="badge {{ $anak->kelompok == 'KB' ? 'bg-success' : 'bg-primary' }}">{{ $anak->kelompok }}</span></td>
                        <td>
                            {{ ucfirst($anak->pivot->hubungan) }}
                            @if($anak->pivot->utama)
                                <span class="badge bg-warning text-dark">Utama</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.wali-anak.destroy', [$pengguna->id_pengguna, $anak->id_anak]) }}" method="POST" onsubmit="return confirm('Lepas tautan anak ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Lepas</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada anak yang terhubung ke akun wali ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection