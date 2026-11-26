@extends('layouts.panel')

@section('title', 'Tautkan Wali ke Anak | PAUD Haqqul Yaqin')
@section('page-title', 'Kelola Penautan Anak')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-xl font-black text-blue-950">Wali Murid: {{ $pengguna->nama_lengkap }}</h2>
            <p class="text-xs text-slate-500">Kode Login: <strong class="font-mono text-blue-900">{{ $pengguna->kode_login }}</strong> · Atur anak yang dapat diakses oleh akun orang tua ini.</p>
        </div>
        <a href="{{ route('admin.pengguna.index') }}" class="rounded-xl border border-orange-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm hover:bg-orange-50 transition">
            ← Kembali ke Daftar Akun
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        <!-- FORM TAMBAH TAUTAN ANAK -->
        <div class="lg:col-span-5">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-orange-200/80">
                <h3 class="text-base font-black text-blue-950 mb-1">Tautkan Anak ke Akun Wali</h3>
                <p class="text-xs text-slate-500 mb-5">Pilih anak dari database yang menjadi putra/putri dari wali ini.</p>

                <form action="{{ route('admin.wali-anak.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id_pengguna" value="{{ $pengguna->id_pengguna }}">

                    <div>
                        <label for="id_anak" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Pilih Siswa <span class="text-red-500">*</span></label>
                        <select name="id_anak" id="id_anak" required
                                class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-2.5 text-xs font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="">-- Pilih Anak Didik --</option>
                            @foreach($anakTersedia as $anak)
                                <option value="{{ $anak->id_anak }}">[{{ $anak->kelompok }}] {{ $anak->nama_anak }} (NIS: {{ $anak->nis }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="hubungan" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Hubungan Keluarga <span class="text-red-500">*</span></label>
                        <select name="hubungan" id="hubungan" required
                                class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-2.5 text-xs font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="wali">Wali / Keluarga</option>
                        </select>
                    </div>

                    <div>
                        <label for="utama" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Status Wali Utama <span class="text-red-500">*</span></label>
                        <select name="utama" id="utama" required
                                class="w-full rounded-xl border border-orange-200 bg-orange-50/30 px-4 py-2.5 text-xs font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="1">Ya (Wali Utama)</option>
                            <option value="0">Tidak (Wali Pendamping)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-orange-500 py-3 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition cursor-pointer mt-2">
                        Hubungkan Anak
                    </button>
                </form>
            </div>
        </div>

        <!-- DAFTAR ANAK TERHUBUNG -->
        <div class="lg:col-span-7">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-orange-200/80">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-blue-950">Daftar Anak Terhubung</h3>
                        <p class="text-xs text-slate-500">Buah hati yang terdaftar pada akun wali ini ({{ $pengguna->anak->count() }} anak).</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-orange-100">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-orange-100 bg-[#FFF8ED]/80 text-[11px] font-black uppercase tracking-wider text-slate-600">
                            <tr>
                                <th class="px-4 py-3">NIS</th>
                                <th class="px-4 py-3">Nama Anak</th>
                                <th class="px-4 py-3">Kelompok</th>
                                <th class="px-4 py-3">Hubungan</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-100/60">
                            @forelse($pengguna->anak as $anak)
                                <tr class="hover:bg-orange-50/30 transition">
                                    <td class="px-4 py-3 font-mono text-xs font-bold text-slate-700">{{ $anak->nis }}</td>
                                    <td class="px-4 py-3 font-bold text-blue-950">{{ $anak->nama_anak }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-2 py-0.5 text-[10px] font-black uppercase {{ $anak->kelompok == 'KB' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $anak->kelompok }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-700">
                                        {{ ucfirst($anak->pivot->hubungan) }}
                                        @if($anak->pivot->utama)
                                            <span class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[10px] font-black text-amber-800">Utama</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <form action="{{ route('admin.wali-anak.destroy', [$pengguna->id_pengguna, $anak->id_anak]) }}" method="POST" onsubmit="return confirm('Lepas tautan anak {{ $anak->nama_anak }} dari wali ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600 ring-1 ring-red-200 hover:bg-red-100 transition cursor-pointer">
                                                Lepas
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-xs text-slate-400">Belum ada anak yang terhubung ke akun wali murid ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
