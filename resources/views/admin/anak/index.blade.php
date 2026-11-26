@extends('layouts.panel')

@section('title', 'Data Siswa | PAUD Haqqul Yaqin')
@section('page-title', 'Data Siswa KB & TK')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-xl font-black text-blue-950">Daftar Anak Didik</h2>
            <p class="text-xs text-slate-500">Kelola identitas peserta didik Kelompok Bermain (KB) dan Taman Kanak-Kanak (TK).</p>
        </div>
        <a href="{{ route('admin.anak.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-orange-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition">
            <span>+</span>
            <span>Tambah Data Siswa</span>
        </a>
    </div>

    <!-- FILTER KELOMPOK KELAS -->
    <div class="mt-5 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.anak.index') }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ !request('kelompok') ? 'bg-blue-950 text-white shadow-sm' : 'bg-white text-slate-700 ring-1 ring-orange-200 hover:bg-orange-50' }}">
            Semua Murid ({{ $anakList->count() }})
        </a>
        <a href="{{ route('admin.anak.index', ['kelompok' => 'KB']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('kelompok') == 'KB' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-emerald-700 ring-1 ring-emerald-200 hover:bg-emerald-50' }}">
            Kelompok Bermain (KB)
        </a>
        <a href="{{ route('admin.anak.index', ['kelompok' => 'TK']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('kelompok') == 'TK' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-blue-700 ring-1 ring-blue-200 hover:bg-blue-50' }}">
            Taman Kanak-Kanak (TK)
        </a>
    </div>

    <!-- TABEL DATA ANAK -->
    <div class="mt-4 overflow-hidden rounded-2xl border border-orange-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-orange-100 bg-[#FFF8ED]/80 text-[11px] font-black uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-5 py-3.5">NIS</th>
                        <th class="px-5 py-3.5">Nama Lengkap</th>
                        <th class="px-5 py-3.5">Kelompok</th>
                        <th class="px-5 py-3.5">L/P</th>
                        <th class="px-5 py-3.5">Tempat & Tgl Lahir</th>
                        <th class="px-5 py-3.5">Wali Terhubung</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100/60">
                    @forelse($anakList as $anak)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-700">{{ $anak->nis }}</td>
                            <td class="px-5 py-3.5 font-bold text-blue-950">{{ $anak->nama_anak }}</td>
                            <td class="px-5 py-3.5">
                                <span class="rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase {{ $anak->kelompok == 'KB' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $anak->kelompok }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs font-bold text-slate-600">{{ $anak->jenis_kelamin }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">
                                {{ $anak->tempat_lahir ?? '-' }}{{ $anak->tanggal_lahir ? ', ' . $anak->tanggal_lahir : '' }}
                            </td>
                            <td class="px-5 py-3.5 text-xs">
                                @forelse($anak->wali as $w)
                                    <span class="inline-block rounded-lg bg-orange-50 px-2 py-0.5 text-[11px] font-bold text-orange-700 ring-1 ring-orange-200/80 mr-1 mb-1">
                                        {{ $w->nama_lengkap }} ({{ $w->pivot->hubungan }})
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400 italic">Belum ditautkan</span>
                                @endforelse
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.anak.edit', $anak->id_anak) }}" class="rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-amber-200 hover:bg-amber-100 transition">
                                        Ubah
                                    </a>
                                    <form action="{{ route('admin.anak.destroy', $anak->id_anak) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data siswa {{ $anak->nama_anak }}?')">
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
                            <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-400">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
