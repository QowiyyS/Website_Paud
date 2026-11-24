@extends('layouts.admin')
@section('title', 'Edit Data Anak')

@section('content')
<h3 class="fw-bold mb-3">Edit Data Siswa: {{ $anak->nama_anak }}</h3>
<div class="card border-0 shadow-sm p-4" style="max-width: 700px;">
    <form action="{{ route('admin.anak.update', $anak->id_anak) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">NIS <span class="text-danger">*</span></label>
                <input type="text" name="nis" class="form-control" value="{{ old('nis', $anak->nis) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kelompok <span class="text-danger">*</span></label>
                <select name="kelompok" class="form-select" required>
                    <option value="KB" {{ old('kelompok', $anak->kelompok) == 'KB' ? 'selected' : '' }}>KB (Kelompok Bermain)</option>
                    <option value="TK" {{ old('kelompok', $anak->kelompok) == 'TK' ? 'selected' : '' }}>TK (Taman Kanak-Kanak)</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Nama Lengkap Anak <span class="text-danger">*</span></label>
                <input type="text" name="nama_anak" class="form-control" value="{{ old('nama_anak', $anak->nama_anak) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="L" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                    <option value="P" {{ old('jenis_kelamin', $anak->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $anak->tempat_lahir) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $anak->tanggal_lahir) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $anak->alamat) }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update Data</button>
            <a href="{{ route('admin.anak.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection