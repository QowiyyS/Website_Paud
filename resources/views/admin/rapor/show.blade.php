@extends('layouts.panel')

@section('title', 'Pemeriksaan Rapor | PAUD Haqqul Yaqin')
@section('page-title', 'Detail & Pengesahan Rapor')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-xl font-black text-blue-950">Rapor: {{ $rapor->anak->nama_anak ?? '-' }}</h2>
            <p class="text-xs text-slate-500">
                Kelompok: <strong>{{ $rapor->anak->kelompok ?? '-' }}</strong> · Periode: <strong>{{ $rapor->periode->nama_periode ?? '' }} ({{ $rapor->periode->tahun_ajaran ?? '' }})</strong> · Guru Penyusun: <strong>{{ $rapor->pembuat->nama_lengkap ?? '-' }}</strong>
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('rapor.show', $rapor->id_rapor) }}" target="_blank" class="rounded-xl border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-900 shadow-sm hover:bg-blue-100 transition">
                🖨️ Cetak / Pratinjau Rapor
            </a>
            <a href="{{ route('admin.rapor.index') }}" class="rounded-xl border border-orange-200 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 shadow-sm hover:bg-orange-50 transition">
                ← Kembali
            </a>
        </div>
    </div>

    <!-- PANEL STATUS & PENGESAHAN -->
    <div class="rounded-3xl border-2 border-orange-200/80 bg-white p-6 shadow-sm mb-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 block mb-1">Status Dokumen Rapor</span>
                <div class="flex items-center gap-2">
                    @php
                        $badgeStyle = match($rapor->status_rapor) {
                            'draf' => 'bg-slate-100 text-slate-700',
                            'diajukan' => 'bg-amber-100 text-amber-900 ring-1 ring-amber-300',
                            'perlu_revisi' => 'bg-red-100 text-red-800 ring-1 ring-red-300',
                            'disetujui' => 'bg-blue-100 text-blue-800 ring-1 ring-blue-300',
                            'diterbitkan' => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-300',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    @endphp
                    <span class="rounded-full px-3 py-1 text-xs font-black uppercase {{ $badgeStyle }}">
                        {{ str_replace('_', ' ', $rapor->status_rapor) }}
                    </span>
                    @if($rapor->disetujui_pada)
                        <span class="text-xs text-slate-500">• Disetujui: {{ $rapor->disetujui_pada }}</span>
                    @endif
                    @if($rapor->diterbitkan_pada)
                        <span class="text-xs font-bold text-emerald-700">• Diterbitkan: {{ $rapor->diterbitkan_pada }}</span>
                    @endif
                </div>
            </div>

            <!-- TOMBOL AKSI PENGESAHAN -->
            <div class="flex flex-wrap items-center gap-2">
                @if($rapor->status_rapor === 'diajukan')
                    <form action="{{ route('admin.rapor.setujui', $rapor->id_rapor) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-blue-700 transition cursor-pointer" onclick="return confirm('Setujui rapor ini? Status akan berubah menjadi Disetujui.')">
                            ✓ Setujui Rapor
                        </button>
                    </form>
                    <a href="{{ route('rapor.edit', $rapor->id_rapor) }}" class="rounded-xl bg-amber-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-amber-600 transition">
                        Edit / Beri Catatan
                    </a>
                @endif

                @if($rapor->status_rapor === 'disetujui')
                    <form action="{{ route('admin.rapor.terbitkan', $rapor->id_rapor) }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 transition cursor-pointer" onclick="return confirm('Terbitkan rapor agar dapat dilihat dan diunduh oleh wali murid?')">
                            🚀 Terbitkan ke Wali Murid
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if($rapor->status_rapor === 'diterbitkan')
            <div class="mt-6 border-t border-orange-100 pt-5">
                <form action="{{ route('admin.rapor.buka-ulang', $rapor->id_rapor) }}" method="POST" class="flex flex-col sm:flex-row items-end gap-3">
                    @csrf
                    <div class="w-full flex-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-red-600 mb-1.5">
                            Buka Ulang Rapor Terbit (Bila ada kesalahan atau revisi nilai mendesak)
                        </label>
                        <input type="text" name="alasan" required placeholder="Tuliskan alasan pembukaan ulang rapor ini..."
                               class="w-full rounded-xl border border-red-200 bg-red-50/30 px-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-300">
                    </div>
                    <button type="submit" class="shrink-0 rounded-xl bg-red-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-red-700 transition cursor-pointer" onclick="return confirm('Buka ulang rapor ini? Status akan dikembalikan ke Perlu Revisi dan tercatat di riwayat.')">
                        Buka Ulang Revisi
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- ISI BLOK NARASI PERKEMBANGAN -->
    <div class="rounded-3xl border border-orange-200/80 bg-white p-6 sm:p-8 shadow-sm mb-6">
        <h3 class="text-base font-black text-blue-950 mb-1">Capaian Perkembangan Anak</h3>
        <p class="text-xs text-slate-500 mb-6">Uraian naratif penilaian hasil belajar triwulan yang diinput guru.</p>

        <div class="space-y-4">
            @forelse($rapor->blok as $blok)
                <div class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/50 p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-orange-500 text-[11px] font-black text-white">
                            {{ $blok->urutan }}
                        </span>
                        <h4 class="text-sm font-black text-blue-950">
                            {{ $blok->judul_bagian ?? ucfirst($blok->jenis_bagian) }}
                        </h4>
                    </div>
                    @if($blok->jenis_bagian === 'narasi')
                        <p class="text-xs text-slate-700 leading-relaxed whitespace-pre-line pl-8">
                            {{ $blok->isi_narasi }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500 pl-8">
                            Lampiran: {{ $blok->lokasi_file }} {{ $blok->caption ? '• ' . $blok->caption : '' }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="py-6 text-center text-xs text-slate-400">Belum ada blok narasi yang diinput.</p>
            @endforelse
        </div>
    </div>

    <!-- RIWAYAT PERUBAHAN -->
    <div class="rounded-3xl border border-orange-200/80 bg-white p-6 shadow-sm">
        <h3 class="text-base font-black text-blue-950 mb-1">Riwayat Perubahan Dokumen</h3>
        <p class="text-xs text-slate-500 mb-4">Catatan otomatis setiap kali narasi diedit atau status rapor dibuka ulang.</p>

        <div class="divide-y divide-orange-100/80">
            @forelse($rapor->riwayat as $log)
                <div class="py-3 text-xs">
                    <div class="flex items-center justify-between text-slate-500 font-mono text-[11px] mb-1">
                        <span>{{ $log->waktu_perubahan }}</span>
                        <span class="font-bold text-orange-600">{{ $log->pengguna->nama_lengkap ?? 'Sistem / Admin' }}</span>
                    </div>
                    <p class="font-semibold text-slate-800">{{ $log->isi_sesudah }}</p>
                </div>
            @empty
                <p class="py-6 text-center text-xs text-slate-400">Belum ada riwayat perubahan yang tercatat.</p>
            @endforelse
        </div>
    </div>

@endsection
