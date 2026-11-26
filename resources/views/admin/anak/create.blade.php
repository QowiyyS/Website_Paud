@extends('layouts.panel')

@section('title', 'Tambah Siswa | PAUD Haqqul Yaqin')
@section('page-title', 'Tambah Siswa Baru')

@section('panel-content')

    <form action="{{ route('admin.anak.store') }}" method="POST" class="mx-auto max-w-3xl">
        @csrf

        <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
            <h2 class="text-lg font-black text-blue-950 mb-1">Formulir Peserta Didik Baru</h2>
            <p class="text-xs text-slate-500 mb-6">Lengkapi data pokok siswa PAUD Haqqul Yaqin untuk keperluan pencatatan dan rapor.</p>

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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nis" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">NIS (Nomor Induk Siswa) <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis') }}" required
                               placeholder="Contoh: KB2026012"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-mono font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="kelompok" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kelompok Kelas <span class="text-red-500">*</span></label>
                        <select name="kelompok" id="kelompok" required
                                class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="KB" {{ old('kelompok') == 'KB' ? 'selected' : '' }}>Kelompok Bermain (KB)</option>
                            <option value="TK" {{ old('kelompok') == 'TK' ? 'selected' : '' }}>Taman Kanak-Kanak (TK)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-2">
                        <label for="nama_anak" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap Anak <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_anak" id="nama_anak" value="{{ old('nama_anak') }}" required
                               placeholder="Nama lengkap anak sesuai akta"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="tempat_lahir" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                               placeholder="Contoh: Magelang"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Alamat Domisili</label>
                    <textarea name="alamat" id="alamat" rows="2"
                              placeholder="Alamat lengkap tempat tinggal siswa"
                              class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">{{ old('alamat') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between border-t border-orange-100 pt-6">
                <a href="{{ route('admin.anak.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="rounded-xl bg-orange-500 px-6 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition cursor-pointer">
                    Simpan Data Siswa
                </button>
            </div>
        </div>
    </form>

@endsection
