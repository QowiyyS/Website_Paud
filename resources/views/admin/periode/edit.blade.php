@extends('layouts.admin')
@section('title', 'Edit Periode Rapor')

@section('content')
<h3 class="fw-bold mb-3">Edit Periode Rapor</h3>
<div class="card border-0 shadow-sm p-4" style="max-width: 500px;">
    <form action="{{ route('admin.periode.update', $periode->id_periode) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Semester / Nama Periode <span class="text-danger">*</span></label>
            <select name="nama_periode" class="form-select" required>
                <option value="Semester 1" {{ old('nama_periode', $periode->nama_periode) == 'Semester 1' ? 'selected' : '' }}>Semester 1</option>
                <option value="Semester 2" {{ old('nama_periode', $periode->nama_periode) == 'Semester 2' ? 'selected' : '' }}>Semester 2</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
            <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $periode->tahun_ajaran) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.periode.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection