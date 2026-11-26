@extends('layouts.panel')

@section('title', 'Tambah Guru | PAUD Haqqul Yaqin')
@section('page-title', 'Tambah Guru / Staf')
@section('page-subtitle', 'Daftarkan tenaga pendidik baru')

@section('panel-content')

    <form action="{{ route('admin.guru.store') }}" method="POST" class="mx-auto max-w-3xl">
        @csrf

        <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-100">
            <h2 class="text-lg font-black text-blue-950 mb-1">Formulir Pendaftaran Pendidik</h2>
            <p class="text-sm text-slate-500 mb-6">Akun yang dibuat dapat langsung digunakan guru untuk masuk ke portal.</p>

            <div class="space-y-5">
                <!-- NAMA LENGKAP -->
                <div>
                    <label for="nama_lengkap" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           placeholder="Contoh: Ibu Rina Agustina, S.Pd"
                           class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300 @error('nama_lengkap') border-red-400 bg-red-50 @enderror">
                    @error('nama_lengkap')
                        <p class="mt-1.5 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- KODE LOGIN & PASSWORD -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="kode_login" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kode Login (Username)</label>
                        <input type="text" name="kode_login" id="kode_login" value="{{ old('kode_login') }}" required
                               placeholder="Contoh: rina"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-mono font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300 @error('kode_login') border-red-400 bg-red-50 @enderror">
                        <p class="mt-1 text-[11px] text-slate-400">Huruf kecil, tanpa spasi. Digunakan saat login.</p>
                        @error('kode_login')
                            <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kata Sandi Awal</label>
                        <input type="password" name="password" id="password" required placeholder="Minimal 6 karakter"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300 @error('password') border-red-400 bg-red-50 @enderror">
                        <p class="mt-1 text-[11px] text-slate-400">Berikan kepada guru bersangkutan.</p>
                        @error('password')
                            <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- PERAN -->
                <div>
                    <label for="peran" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Peran / Tanggung Jawab</label>
                    <select name="peran" id="peran" required
                            class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        <option value="guru" {{ old('peran') == 'guru' ? 'selected' : '' }}>Guru / Tenaga Pendidik</option>
                        <option value="admin_guru" {{ old('peran') == 'admin_guru' ? 'selected' : '' }}>Guru & Staf Admin</option>
                    </select>
                </div>
            </div>

            <!-- TOMBOL -->
            <div class="mt-8 flex items-center justify-between border-t border-orange-100 pt-6">
                <a href="{{ route('admin.guru.index') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition cursor-pointer">
                    Simpan
                </button>
            </div>
        </div>
    </form>

@endsection
