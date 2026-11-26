@extends('layouts.panel')

@section('title', 'Ubah Akun | PAUD Haqqul Yaqin')
@section('page-title', 'Ubah Akun Pengguna')

@section('panel-content')

    <form action="{{ route('admin.pengguna.update', $pengguna->id_pengguna) }}" method="POST" class="mx-auto max-w-2xl">
        @csrf
        @method('PUT')

        <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
            <h2 class="text-lg font-black text-blue-950 mb-1">Perbarui Akun: {{ $pengguna->nama_lengkap }}</h2>
            <p class="text-xs text-slate-500 mb-6">Kosongkan kolom kata sandi jika tidak ingin mengganti kata sandi lama.</p>

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
                    <label for="nama_lengkap" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}" required
                           class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="kode_login" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kode Login (Username) <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_login" id="kode_login" value="{{ old('kode_login', $pengguna->kode_login) }}" required
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-mono font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Kata Sandi Baru (Opsional)</label>
                        <input type="password" name="password" id="password"
                               placeholder="Biarkan kosong jika tetap"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div>
                    <label for="peran" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Peran Pengguna <span class="text-red-500">*</span></label>
                    <select name="peran" id="peran" required
                            class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-3 text-sm font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        <option value="walimurid" {{ old('peran', $pengguna->peran) == 'walimurid' ? 'selected' : '' }}>Wali Murid / Orang Tua</option>
                        <option value="guru" {{ old('peran', $pengguna->peran) == 'guru' ? 'selected' : '' }}>Guru / Tenaga Pendidik</option>
                        <option value="admin_guru" {{ old('peran', $pengguna->peran) == 'admin_guru' ? 'selected' : '' }}>Guru & Staf Admin</option>
                        <option value="admin" {{ old('peran', $pengguna->peran) == 'admin' ? 'selected' : '' }}>Admin / Kepala Sekolah</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-between border-t border-orange-100 pt-6">
                <a href="{{ route('admin.pengguna.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">Batal</a>
                <button type="submit" class="rounded-xl bg-orange-500 px-6 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition cursor-pointer">
                    Perbarui Akun
                </button>
            </div>
        </div>
    </form>

@endsection
