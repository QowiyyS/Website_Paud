@extends('layouts.panel')

@section('title', 'Pengesahan Rapor | PAUD Haqqul Yaqin')
@section('page-title', 'Pemeriksaan & Pengesahan Rapor')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-xl font-black text-blue-950">Pengesahan Rapor Triwulan</h2>
            <p class="text-xs text-slate-500">Pemeriksaan draf yang diajukan oleh guru sebelum disahkan dan diterbitkan kepada wali murid.</p>
        </div>
        <a href="{{ route('rapor.index') }}" class="rounded-xl border border-orange-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm hover:bg-orange-50 transition">
            Lihat Format Arsip Guru →
        </a>
    </div>

    <!-- FILTER STATUS -->
    <div class="mt-5 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.rapor.index') }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ !request('status') ? 'bg-blue-950 text-white shadow-sm' : 'bg-white text-slate-700 ring-1 ring-orange-200 hover:bg-orange-50' }}">
            Semua ({{ $raporList->count() }})
        </a>
        <a href="{{ route('admin.rapor.index', ['status' => 'diajukan']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('status') == 'diajukan' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-amber-700 ring-1 ring-amber-200 hover:bg-amber-50' }}">
            Menunggu Persetujuan
        </a>
        <a href="{{ route('admin.rapor.index', ['status' => 'disetujui']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('status') == 'disetujui' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-blue-700 ring-1 ring-blue-200 hover:bg-blue-50' }}">
            Siap Terbit (Disetujui)
        </a>
        <a href="{{ route('admin.rapor.index', ['status' => 'diterbitkan']) }}"
           class="rounded-full px-4 py-1.5 text-xs font-bold transition {{ request('status') == 'diterbitkan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-emerald-700 ring-1 ring-emerald-200 hover:bg-emerald-50' }}">
            Diterbitkan ke Wali
        </a>
    </div>

    <!-- TABEL DATA RAPOR -->
    <div class="mt-4 overflow-hidden rounded-2xl border border-orange-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-orange-100 bg-[#FFF8ED]/80 text-[11px] font-black uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-5 py-3.5">Nama Siswa</th>
                        <th class="px-5 py-3.5">Kelompok</th>
                        <th class="px-5 py-3.5">Periode / T.A.</th>
                        <th class="px-5 py-3.5">Penyusun (Guru)</th>
                        <th class="px-5 py-3.5">Status Rapor</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100/60">
                    @forelse($raporList as $r)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="px-5 py-3.5 font-bold text-blue-950">{{ $r->anak->nama_anak ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase {{ ($r->anak->kelompok ?? '') == 'KB' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $r->anak->kelompok ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-slate-700">
                                <strong>{{ $r->periode->nama_periode ?? '-' }}</strong> · {{ $r->periode->tahun_ajaran ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-xs font-semibold text-slate-700">{{ $r->pembuat->nama_lengkap ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                @php
                                    $badge = match($r->status_rapor) {
                                        'draf' => 'bg-slate-100 text-slate-700',
                                        'diajukan' => 'bg-amber-100 text-amber-800 font-black',
                                        'perlu_revisi' => 'bg-red-100 text-red-800 font-bold',
                                        'disetujui' => 'bg-blue-100 text-blue-800 font-bold',
                                        'diterbitkan' => 'bg-emerald-100 text-emerald-800 font-black',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-0.5 text-[10px] uppercase {{ $badge }}">
                                    {{ str_replace('_', ' ', $r->status_rapor) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('admin.rapor.show', $r->id_rapor) }}" class="rounded-lg bg-blue-900 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-blue-950 transition">
                                    Periksa & Sahkan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-400">Belum ada data rapor dalam sistem.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
