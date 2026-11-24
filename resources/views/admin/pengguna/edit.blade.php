@extends('layouts.admin')
@section('title', 'Edit Akun Pengguna')

@section('content')
<h3 class="fw-bold mb-3">Edit Akun: {{ $pengguna->nama_lengkap }}</h3>
<div class="card border-0 shadow-sm p-4" style="max-width: 600px;">
    <form action="{{ route('admin.pengguna.update', $pengguna->id_pengguna) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Peran Akun <span class="text-danger">*</span></label>
            <select name="peran" class="form-select" required>
                <option value="walimurid" {{ old('peran', $pengguna->peran) == 'walimurid' ? 'selected' : '' }}>Wali Murid (walimurid)</option>
                <option value="guru" {{ old('peran', $pengguna->peran) == 'guru' ? 'selected' : '' }}>Guru Kelas (guru)</option>
                <option value="admin" {{ old('peran', $pengguna->peran) == 'admin' ? 'selected' : '' }}>Admin / Kepala Sekolah (admin)</option>
                <option value="admin_guru" {{ old('peran', $pengguna->peran) == 'admin_guru' ? 'selected' : '' }}>Admin & Guru (admin_guru)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kode Login Unik <span class="text-danger">*</span></label>
            <input type="text" name="kode_login" class="form-control" value="{{ old('kode_login', $pengguna->kode_login) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kata Sandi Baru (Opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
        </div>
        <button type="submit" class="btn btn-success">Update Akun</button>
        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection