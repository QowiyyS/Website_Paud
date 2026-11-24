@extends('layouts.admin')
@section('title', 'Periode Rapor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold mb-0">Kelola Periode Rapor</h3>
    <a href="{{ route('admin.periode.create') }}" class="btn btn-success">+ Tambah Periode</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Semester / Periode</th>
                    <th>Tahun Ajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periodeList as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-semibold">{{ $p->nama_periode }}</td>
                    <td>{{ $p->tahun_ajaran }}</td>
                    <td>
                        <a href="{{ route('admin.periode.edit', $p->id_periode) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.periode.destroy', $p->id_periode) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus periode rapor ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data periode rapor.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection