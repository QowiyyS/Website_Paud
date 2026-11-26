@extends('layouts.panel')

@section('title', 'Tambah Periode | PAUD Haqqul Yaqin')
@section('page-title', 'Tambah Periode Rapor')

@section('panel-content')

    <form action="{{ route('admin.periode.store') }}" method="POST" class="mx-auto max-w-xl">
        @csrf

        <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
            <h2 class="text-lg font-black text-blue-950 mb-1">Formulir Periode Rapor Baru</h2>
            <p class="text-xs text-slate-500 mb-6">Pilih triwulan atau semester serta tahun ajaran berjalan.</p>

            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-xs font-bold text-red-700">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-5">
                <div>
                    <label for="nama_periode" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Tahapan / Periode <span class="text-red-500">*</span></label>
                    <select name="nama_periode" id="nama_periode" required
                            class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        <option value="Triwulan 1" {{ old('nama_periode') == 'Triwulan 1' ? 'selected' : '' }}>Triwulan 1</option>
                        <option value="Triwulan 2" {{ old('nama_periode') == 'Triwulan 2' ? 'selected' : '' }}>Triwulan 2</option>
                        <option value="Triwulan 3" {{ old('nama_periode') == 'Triwulan 3' ? 'selected' : '' }}>Triwulan 3</option>
                        <option value="Triwulan 4" {{ old('nama_periode') == 'Triwulan 4' ? 'selected' : '' }}>Triwulan 4</option>
                        <option value="Semester 1" {{ old('nama_periode') == 'Semester 1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="Semester 2" {{ old('nama_periode') == 'Semester 2' ? 'selected' : '' }}>Semester 2</option>
                    </select>
                </div>

                <div>
                    <label for="tahun_ajaran" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', '2026/2027') }}" required
                           placeholder="Contoh: 2026/2027"
                           class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between border-t border-orange-100 pt-6">
                <a href="{{ route('admin.periode.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="rounded-xl bg-orange-500 px-6 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition cursor-pointer">
                    Simpan Periode
                </button>
            </div>
        </div>
    </form>

@endsection
