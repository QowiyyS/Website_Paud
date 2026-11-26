@extends('layouts.panel')

@section('title', 'Akun Pengguna | PAUD Haqqul Yaqin')
@section('page-title', 'Akun Pengguna & Wali Murid')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-xl font-black text-blue-950">Daftar Akun Pengguna</h2>
            <p class="text-xs text-slate-500">Kelola kredensial akun Kepala Sekolah, Guru, serta penautan anak didik untuk Wali Murid.</p>
        </div>
        <a href="{{ route('admin.pengguna.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-orange-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition">
            <span>+</span>
            <span>Buat Akun Baru</span>
        </a>
    </div>

    <!-- FILTER PERAN -->
    <div class="mt-5 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.pengguna.index') }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ !request('peran') ? 'bg-blue-950 text-white shadow-sm' : 'bg-white text-slate-700 ring-1 ring-orange-200 hover:bg-orange-50' }}">
            Semua Akun ({{ $penggunaList->count() }})
        </a>
        <a href="{{ route('admin.pengguna.index', ['peran' => 'admin']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('peran') == 'admin' ? 'bg-blue-700 text-white shadow-sm' : 'bg-white text-blue-700 ring-1 ring-blue-200 hover:bg-blue-50' }}">
            Admin / Kepsek
        </a>
        <a href="{{ route('admin.pengguna.index', ['peran' => 'guru']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('peran') == 'guru' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-emerald-700 ring-1 ring-emerald-200 hover:bg-emerald-50' }}">
            Guru
        </a>
        <a href="{{ route('admin.pengguna.index', ['peran' => 'walimurid']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('peran') == 'walimurid' ? 'bg-orange-500 text-white shadow-sm' : 'bg-white text-orange-600 ring-1 ring-orange-200 hover:bg-orange-50' }}">
            Wali Murid
        </a>
    </div>

    <!-- TABEL DATA PENGGUNA -->
    <div class="mt-4 overflow-hidden rounded-2xl border border-orange-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-orange-100 bg-[#FFF8ED]/80 text-[11px] font-black uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-5 py-3.5">Kode Login</th>
                        <th class="px-5 py-3.5">Nama Lengkap</th>
                        <th class="px-5 py-3.5">Peran</th>
                        <th class="px-5 py-3.5">Anak Terhubung (Khusus Wali)</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100/60">
                    @forelse($penggunaList as $user)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-800">{{ $user->kode_login }}</td>
                            <td class="px-5 py-3.5 font-bold text-blue-950">{{ $user->nama_lengkap }}</td>
                            <td class="px-5 py-3.5">
                                @php
                                    $peranColor = match($user->peran) {
                                        'admin' => 'bg-blue-100 text-blue-800',
                                        'admin_guru' => 'bg-purple-100 text-purple-800',
                                        'guru' => 'bg-emerald-100 text-emerald-800',
                                        'walimurid' => 'bg-orange-100 text-orange-800',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                    $peranLabel = match($user->peran) {
                                        'admin' => 'Kepala Sekolah',
                                        'admin_guru' => 'Guru & Admin',
                                        'guru' => 'Guru / Pendidik',
                                        'walimurid' => 'Wali Murid',
                                        default => $user->peran,
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase {{ $peranColor }}">
                                    {{ $peranLabel }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                @if($user->peran === 'walimurid')
                                    @forelse($user->anak as $a)
                                        <span class="inline-block rounded-lg bg-orange-50 px-2 py-0.5 text-[11px] font-bold text-orange-700 ring-1 ring-orange-200/80 mr-1 mb-1">
                                            {{ $a->nama_anak }} ({{ $a->pivot->hubungan }})
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Belum ada anak ditautkan</span>
                                    @endforelse
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    @if($user->peran === 'walimurid')
                                        <a href="{{ route('admin.pengguna.show', $user->id_pengguna) }}" class="rounded-lg bg-orange-50 px-2.5 py-1 text-xs font-bold text-orange-700 ring-1 ring-orange-200 hover:bg-orange-100 transition">
                                            Tautkan Anak
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.pengguna.edit', $user->id_pengguna) }}" class="rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-amber-200 hover:bg-amber-100 transition">
                                        Ubah
                                    </a>
                                    <form action="{{ route('admin.pengguna.destroy', $user->id_pengguna) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun {{ $user->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600 ring-1 ring-red-200 hover:bg-red-100 transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
