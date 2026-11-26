@extends('layouts.panel')

@section('title', 'Periode Rapor | PAUD Haqqul Yaqin')
@section('page-title', 'Periode Rapor & Tahun Ajaran')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-xl font-black text-blue-950">Daftar Periode Penilaian</h2>
            <p class="text-xs text-slate-500">Kelola tahun ajaran aktif serta triwulan atau semester pelaporan rapor anak didik.</p>
        </div>
        <a href="{{ route('admin.periode.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-orange-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition">
            <span>+</span>
            <span>Tambah Periode Baru</span>
        </a>
    </div>

    <!-- TABEL PERIODE -->
    <div class="mt-5 overflow-hidden rounded-2xl border border-orange-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-orange-100 bg-[#FFF8ED]/80 text-[11px] font-black uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-5 py-3.5">No</th>
                        <th class="px-5 py-3.5">Nama Periode / Tahapan</th>
                        <th class="px-5 py-3.5">Tahun Ajaran</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100/60">
                    @forelse($periodeList as $index => $p)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="px-5 py-3.5 text-xs font-bold text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-blue-950">
                                <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700 ring-1 ring-orange-200">
                                    {{ $p->nama_periode }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-700">{{ $p->tahun_ajaran }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.periode.edit', $p->id_periode) }}" class="rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-amber-200 hover:bg-amber-100 transition">
                                        Ubah
                                    </a>
                                    <form action="{{ route('admin.periode.destroy', $p->id_periode) }}" method="POST" class="inline" onsubmit="return confirm('Hapus periode {{ $p->nama_periode }} {{ $p->tahun_ajaran }}?')">
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
                            <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-400">Belum ada periode rapor yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
