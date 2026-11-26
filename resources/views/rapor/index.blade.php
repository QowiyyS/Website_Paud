@extends('layouts.panel')

@section('title', 'Rapor Triwulan | PAUD Haqqul Yaqin')
@section('page-title', 'Rapor Triwulan')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                {{ $user->isAdmin() ? 'Pengesahan rapor' : 'Catatan perkembangan' }}
            </h2>
            <p class="max-w-xl text-sm text-slate-500">
                {{ $user->isAdmin()
                    ? 'Periksa narasi lalu sahkan agar wali murid dapat melihat rapor.'
                    : 'Susun narasi, simpan draf, atau ajukan ke Kepala Sekolah.' }}
            </p>
        </div>
        <a href="{{ route('rapor.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-center text-xs font-semibold text-white hover:bg-slate-800">
            Buat Rapor Baru
        </a>
    </div>

    <form action="{{ route('rapor.index') }}" method="GET" class="mt-5 flex flex-wrap items-center gap-2">
        <select name="periode" onchange="this.form.submit()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-orange-400 focus:outline-none">
            <option value="">Semua triwulan</option>
            @foreach($periodes as $p)
                <option value="{{ $p->id_periode }}" {{ $periodeId == $p->id_periode ? 'selected' : '' }}>
                    {{ $p->nama_periode }} ({{ $p->tahun_ajaran }})
                </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-orange-400 focus:outline-none">
            <option value="">Semua status</option>
            <option value="draf" {{ $status == 'draf' ? 'selected' : '' }}>Draf</option>
            <option value="diajukan" {{ $status == 'diajukan' ? 'selected' : '' }}>Menunggu kepsek</option>
            <option value="perlu_revisi" {{ $status == 'perlu_revisi' ? 'selected' : '' }}>Perlu revisi</option>
            <option value="diterbitkan" {{ $status == 'diterbitkan' ? 'selected' : '' }}>Diterbitkan</option>
        </select>
        @if($periodeId || $status)
            <a href="{{ route('rapor.index') }}" class="text-sm text-red-600 hover:underline">Reset</a>
        @endif
        <span class="ml-auto text-xs text-slate-500">{{ $rapors->total() }} dokumen</span>
    </form>

    <div class="mt-4 overflow-hidden rounded-xl border border-orange-100 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-orange-100 bg-orange-50/40 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Siswa</th>
                        <th class="px-4 py-3 font-semibold">Periode</th>
                        <th class="px-4 py-3 font-semibold">Pendidik</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-50">
                    @forelse($rapors as $r)
                        <tr class="hover:bg-orange-50/30">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ $r->anak->nama_anak }}</p>
                                <p class="text-xs text-slate-500">{{ $r->anak->nis }} · {{ $r->anak->kelompok }}</p>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-700">
                                {{ $r->periode->nama_periode }}
                                <span class="block text-slate-400">{{ $r->periode->tahun_ajaran }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-700">
                                {{ $r->pembuat->nama_lengkap ?? '-' }}
                                <span class="block text-slate-400">{{ substr($r->dibuat_pada, 0, 10) }}</span>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                @if($r->status_rapor === 'diterbitkan')
                                    <span class="font-semibold text-emerald-700">Diterbitkan</span>
                                @elseif($r->status_rapor === 'diajukan')
                                    <span class="font-semibold text-blue-700">Menunggu</span>
                                @elseif($r->status_rapor === 'perlu_revisi')
                                    <span class="font-semibold text-amber-700">Revisi</span>
                                @else
                                    <span class="text-slate-500">Draf</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex gap-3">
                                    <a href="{{ route('rapor.edit', $r->id_rapor) }}" class="text-xs font-semibold text-blue-700 hover:underline">Ubah</a>
                                    <a href="{{ route('rapor.show', $r->id_rapor) }}" class="text-xs font-semibold text-slate-600 hover:underline">Lihat</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada rapor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rapors->hasPages())
            <div class="border-t border-orange-100 px-4 py-3">{{ $rapors->links() }}</div>
        @endif
    </div>

@endsection
