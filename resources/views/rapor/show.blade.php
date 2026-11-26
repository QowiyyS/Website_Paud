@extends('layouts.app')

@section('title', 'Laporan Perkembangan Anak | ' . $rapor->anak->nama_anak)

@section('content')
<div class="relative min-h-screen bg-[#FFF8ED] py-8 px-4 sm:px-6">

    <!-- DEKORASI BACKGROUND LEMBUT (DISEMBUNYIKAN SAAT PRINT) -->
    <div class="pointer-events-none fixed -left-20 top-20 -z-0 h-72 w-72 rounded-full bg-blue-200/40 blur-3xl print:hidden"></div>
    <div class="pointer-events-none fixed -right-20 top-1/3 -z-0 h-80 w-80 rounded-full bg-orange-200/50 blur-3xl print:hidden"></div>

    <!-- BAR NAVIGASI & CETAK (DISEMBUNYIKAN SAAT PRINT) -->
    <div class="relative z-10 mx-auto max-w-4xl mb-6 flex flex-wrap items-center justify-between gap-3 print:hidden">
        <a href="{{ url()->previous() ?: route('rapor.index') }}" class="rounded-full bg-white px-5 py-2.5 text-xs font-extrabold text-slate-700 shadow-sm ring-1 ring-orange-200 hover:bg-orange-50 transition">
            ← Kembali
        </a>

        <div class="flex items-center gap-3">
            @if($user->isAdmin() || $user->isGuru())
                <a href="{{ route('rapor.edit', $rapor->id_rapor) }}" class="rounded-full bg-blue-50 px-5 py-2.5 text-xs font-extrabold text-blue-700 ring-1 ring-blue-200 hover:bg-blue-100 transition">
                    ✏️ Edit Rapor Ini
                </a>
            @endif

            <button onclick="window.print()" class="rounded-full bg-orange-500 px-6 py-2.5 text-xs font-extrabold text-white shadow-md shadow-orange-300 hover:bg-orange-600 active:scale-95 transition cursor-pointer flex items-center gap-2">
                <span>🖨️</span> Cetak Rapor (Print / PDF)
            </button>
        </div>
    </div>

    <!-- NOTIFIKASI STATUS PUBLIKASI UNTUK GURU / KEPSEK -->
    @if(!$user->isWali() && $rapor->status_rapor !== 'diterbitkan')
        <div class="relative z-10 mx-auto max-w-4xl mb-6 rounded-[2rem] bg-amber-50 p-5 border-2 border-amber-300 text-xs text-amber-900 print:hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
            <div>
                <span class="font-black text-sm">Status Rapor: {{ strtoupper($rapor->status_rapor) }}</span>
                <p class="mt-0.5 text-amber-800">Rapor ini belum dipublikasikan oleh Kepala Sekolah, sehingga belum dapat dilihat oleh akun wali murid.</p>
            </div>
            @if($user->isAdmin())
                <a href="{{ route('rapor.edit', $rapor->id_rapor) }}" class="shrink-0 rounded-full bg-emerald-600 px-5 py-2 font-extrabold text-white shadow-sm hover:bg-emerald-700 transition">
                    Setujui & Publikasikan Sekarang →
                </a>
            @endif
        </div>
    @endif

    <!-- LEMBAR RAPOR RESMI (A4 STYLE) -->
    <div class="relative z-10 mx-auto max-w-4xl bg-white p-8 sm:p-14 shadow-xl rounded-[2.5rem] ring-1 ring-orange-200/80 print:shadow-none print:border-none print:ring-0 print:p-0 print:rounded-none">

        <!-- KOP SURAT PAUD -->
        <div class="flex items-center justify-between border-b-4 border-orange-400 pb-5">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD" class="h-16 w-16 sm:h-20 sm:w-20 object-contain">
                <div>
                    <h1 class="text-base sm:text-xl font-black tracking-wide text-blue-950 uppercase leading-tight">
                        PAUD HAQQUL YAQIN
                    </h1>
                    <p class="text-xs font-extrabold text-orange-500 uppercase tracking-widest mt-0.5">
                        Kelompok Bermain & Taman Kanak-Kanak
                    </p>
                    <p class="text-[11px] text-slate-500 mt-0.5 font-medium">
                        Izin Operasional Lembaga PAUD • Akreditasi Terdaftar
                    </p>
                </div>
            </div>
            <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan" class="h-16 w-16 sm:h-20 sm:w-20 object-contain hidden sm:block">
        </div>

        <!-- JUDUL LAPORAN -->
        <div class="text-center mt-7">
            <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide">
                LAPORAN CAPAIAN PERKEMBANGAN ANAK
            </h2>
            <p class="text-xs font-black text-blue-800 uppercase mt-1">
                Periode: {{ $rapor->periode->nama_periode }} • Tahun Ajaran {{ $rapor->periode->tahun_ajaran }}
            </p>
        </div>

        <!-- BIODATA ANAK -->
        <div class="mt-6 rounded-2xl bg-[#FFF8ED]/80 p-5 border-2 border-orange-200 text-xs">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2.5 gap-x-6">
                <div class="flex items-center">
                    <span class="w-32 text-slate-500 font-bold">Nama Anak Didik:</span>
                    <span class="font-black text-blue-950 text-sm">{{ $rapor->anak->nama_anak }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-slate-500 font-bold">Nomor Induk (NIS):</span>
                    <span class="font-mono font-black text-slate-800">{{ $rapor->anak->nis }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-slate-500 font-bold">Kelompok Belajar:</span>
                    <span class="font-black text-orange-600">{{ $rapor->anak->kelompok }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-slate-500 font-bold">Jenis Kelamin:</span>
                    <span class="font-bold text-slate-800">{{ $rapor->anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
            </div>
        </div>

        <!-- URAIAN PERKEMBANGAN (4 ASPEK) -->
        <div class="mt-8 space-y-6">
            @foreach($rapor->bagian as $bagian)
                <div class="rounded-2xl border-2 border-orange-100 p-5 sm:p-6 bg-white">
                    <h3 class="text-xs font-black uppercase tracking-wider text-blue-950 border-b border-orange-100 pb-2.5 mb-3 flex items-center gap-2.5">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-orange-500 text-[10px] font-black text-white shadow-sm">
                            {{ $bagian->urutan }}
                        </span>
                        <span>{{ $bagian->judul_bagian }}</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line text-justify font-normal">
                        {{ $bagian->isi_narasi }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- KOLOM TANDA TANGAN GURU & KEPALA SEKOLAH -->
        <div class="mt-14 pt-6 border-t-2 border-orange-200">
            <div class="grid grid-cols-2 text-center text-xs">
                <!-- TANDA TANGAN GURU -->
                <div>
                    <p class="text-slate-500 font-semibold">Guru Pendamping Kelas,</p>
                    <div class="h-20 flex items-center justify-center">
                        <span class="text-slate-300 italic text-[11px]">[ Tanda Tangan ]</span>
                    </div>
                    <p class="font-black text-blue-950 underline text-sm">{{ $rapor->pembuat->nama_lengkap ?? 'Guru Kelas' }}</p>
                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Pendidik PAUD Haqqul Yaqin</p>
                </div>

                <!-- TANDA TANGAN KEPALA SEKOLAH -->
                <div>
                    <p class="text-slate-500 font-semibold">
                        Mengetahui,<br>
                        <strong>Kepala Sekolah PAUD Haqqul Yaqin</strong>
                    </p>
                    <div class="h-16 flex items-center justify-center">
                        @if($rapor->status_rapor === 'diterbitkan' && $rapor->disetujui_oleh)
                            <div class="rounded-full border-2 border-emerald-400 bg-emerald-50 px-4 py-1.5 text-[10px] font-black text-emerald-800 uppercase tracking-widest shadow-sm">
                                ✓ TELAH DISETUJUI & DISAHKAN
                            </div>
                        @else
                            <span class="text-slate-300 italic text-[11px]">[ Belum Disahkan ]</span>
                        @endif
                    </div>
                    <p class="font-black text-blue-950 underline text-sm">{{ $rapor->penyetuju->nama_lengkap ?? 'Hj. Nurul Khotimah' }}</p>
                    <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Kepala Sekolah PAUD Haqqul Yaqin</p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
