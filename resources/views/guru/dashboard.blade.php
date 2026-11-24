@extends('layouts.app')

@section('title', 'Ruang Kerja Guru | PAUD Haqqul Yaqin')

@section('content')
<div class="relative min-h-screen bg-[#FFF8ED] pb-16">

    <!-- DEKORASI BACKGROUND LEMBUT -->
    <div class="pointer-events-none fixed -left-20 top-20 -z-0 h-72 w-72 rounded-full bg-blue-200/40 blur-3xl"></div>
    <div class="pointer-events-none fixed -right-20 top-1/3 -z-0 h-80 w-80 rounded-full bg-orange-200/50 blur-3xl"></div>
    <div class="pointer-events-none fixed bottom-10 left-1/4 -z-0 h-64 w-64 rounded-full bg-amber-200/30 blur-3xl"></div>

    <!-- ================= TOPBAR GURU ================= -->
    <header class="sticky top-0 z-40 border-b-4 border-orange-200 bg-[#FFF8ED]/95 shadow-sm backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
            
            <!-- IDENTITAS SEKOLAH -->
            <a href="{{ route('landing') }}" class="group relative flex shrink-0 items-center gap-3">
                <span class="absolute -right-1 -top-2 text-lg text-orange-400 transition group-hover:rotate-45">✦</span>
                <div class="flex items-center gap-2 rounded-2xl bg-white px-3 py-2 shadow-sm ring-1 ring-blue-100">
                    <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD Haqqul Yaqin" class="h-10 w-10 object-contain">
                    <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan Hidayatullah Haqqul Yaqin" class="h-10 w-10 object-contain">
                </div>
                <div>
                    <h1 class="text-base font-black tracking-wide text-blue-800 leading-tight">PAUD HAQQUL YAQIN</h1>
                    <p class="text-[10px] font-bold tracking-widest text-orange-500">BELAJAR • BERMAIN • BERTUMBUH</p>
                </div>
            </a>

            <!-- MENU & USER INFO -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-orange-200">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-xs text-white font-bold">
                        👩‍🏫
                    </span>
                    <div class="text-left">
                        <p class="text-xs font-extrabold text-blue-950 leading-none">{{ $guru->nama_lengkap }}</p>
                        <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mt-0.5">Pendidik PAUD</p>
                    </div>
                </div>

                <a href="{{ route('landing') }}" class="rounded-full bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm ring-1 ring-orange-200 hover:bg-orange-50 hover:text-orange-700 transition">
                    🌐 Beranda
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-full bg-red-500 px-4 py-2 text-xs font-extrabold text-white shadow-sm hover:bg-red-600 active:scale-95 transition cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>

        </div>
    </header>

    <main class="relative z-10 mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">

        <!-- ================= WELCOME BANNER GURU ================= -->
        <div class="relative overflow-hidden rounded-[2.5rem] border-2 border-orange-200/90 bg-gradient-to-r from-orange-100/90 via-white to-emerald-50/80 p-6 sm:p-8 shadow-sm">
            <span class="pointer-events-none absolute right-6 top-4 text-4xl text-orange-300/40">✦</span>
            <span class="pointer-events-none absolute right-24 bottom-4 text-2xl text-emerald-300/40">✧</span>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-orange-200 bg-white/90 px-4 py-1.5 text-xs font-extrabold text-orange-600 shadow-sm">
                        <span>✦</span>
                        <span>Ruang Kerja Guru & Tenaga Pendidik</span>
                    </div>

                    <h2 class="mt-4 text-2xl sm:text-3xl font-black text-blue-950 leading-tight">
                        Semangat Mengajar, <span class="text-orange-500">{{ $guru->nama_lengkap }}</span>!
                    </h2>

                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Kelola catatan capaian perkembangan buah hati dengan penuh kasih sayang. Catatan triwulan yang telah diinput dapat diajukan kepada Kepala Sekolah untuk proses verifikasi dan penerbitan rapor.
                    </p>
                </div>

                <!-- TOMBOL-TOMBOL AKSI CEPAT -->
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('rapor.index') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-5 py-3 text-xs font-extrabold text-white shadow-md shadow-blue-300 hover:bg-blue-700 active:scale-95 transition">
                        <span>📋</span>
                        <span>Daftar Rapor Triwulan</span>
                    </a>

                    <a href="{{ route('rapor.create') }}" class="inline-flex items-center gap-2 rounded-full bg-orange-500 px-5 py-3 text-xs font-extrabold text-white shadow-md shadow-orange-300 hover:bg-orange-600 active:scale-95 transition">
                        <span>+</span>
                        <span>Input Rapor Baru</span>
                    </a>
                </div>
            </div>
        </div>


        <!-- ================= STATISTIK GURU ================= -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3">

            <div class="group rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-orange-200/80 transition duration-300 hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500">Murid Terdaftar</span>
                        <h3 class="mt-2 text-3xl font-black text-blue-950">{{ $totalSiswa }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-2xl text-orange-500 shadow-sm ring-1 ring-orange-100">
                        👶
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-orange-100 pt-3 text-xs font-bold text-slate-500">
                    <span>Kelompok KB & TK</span>
                    <span class="text-orange-500">T.A 2026/2027</span>
                </div>
            </div>

            <div class="group rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-orange-200/80 transition duration-300 hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500">Rapor Disusun Anda</span>
                        <h3 class="mt-2 text-3xl font-black text-emerald-700">{{ $raporSaya }}</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-2xl text-emerald-600 shadow-sm ring-1 ring-emerald-100">
                        📝
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-orange-100 pt-3 text-xs font-bold text-slate-500">
                    <span>Laporan Narasi Triwulan</span>
                    <span class="text-emerald-700">Terdokumentasi</span>
                </div>
            </div>

            <div class="group rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-orange-200/80 transition duration-300 hover:-translate-y-1 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500">Tahun Pembelajaran</span>
                        <h3 class="mt-2 text-3xl font-black text-blue-950">2026/2027</h3>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-600 shadow-sm ring-1 ring-blue-100">
                        🏫
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between border-t border-orange-100 pt-3 text-xs font-bold text-slate-500">
                    <span>Semester Aktif</span>
                    <span class="text-blue-600">Berjalan</span>
                </div>
            </div>

        </div>


        <!-- ================= DAFTAR ANAK DIDIK & INPUT NILAI ================= -->
        <div class="mt-8 rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500">Anak Didik</span>
                    <h3 class="text-lg font-black text-blue-950">Daftar Anak Didik & Catatan Perkembangan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih salah satu siswa di bawah ini untuk memulai pengisian rapor triwulan.</p>
                </div>

                <a href="{{ route('rapor.index') }}" class="rounded-full bg-orange-50 px-4 py-2 text-xs font-extrabold text-orange-700 ring-1 ring-orange-200 hover:bg-orange-100 transition">
                    Lihat Semua Rapor →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-b-2 border-orange-100 bg-[#FFF8ED] text-blue-950 uppercase font-black tracking-wider">
                        <tr>
                            <th class="py-3.5 px-4 rounded-l-2xl">NIS</th>
                            <th class="py-3.5 px-4">Nama Lengkap Anak Didik</th>
                            <th class="py-3.5 px-4">Kelompok Belajar</th>
                            <th class="py-3.5 px-4">Jenis Kelamin</th>
                            <th class="py-3.5 px-4 text-center rounded-r-2xl">Aksi Pengisian Rapor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-100/70 text-slate-700">
                        @forelse($daftarSiswa as $anak)
                            <tr class="hover:bg-orange-50/40 transition">
                                <td class="py-4 px-4 font-mono font-bold text-slate-500">{{ $anak->nis }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-orange-100 text-sm">
                                            {{ $anak->jenis_kelamin === 'L' ? '👦' : '👧' }}
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-blue-950 text-sm">{{ $anak->nama_anak }}</p>
                                            <p class="text-[10px] text-slate-500">{{ $anak->alamat }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-[11px] font-extrabold text-blue-800">
                                        {{ $anak->kelompok }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-semibold">
                                    {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('rapor.create', ['anak' => $anak->id_anak]) }}" class="inline-flex items-center gap-1.5 rounded-full bg-orange-500 px-4 py-2 font-extrabold text-white shadow-sm shadow-orange-200 hover:bg-orange-600 active:scale-95 transition">
                                        <span>+</span>
                                        <span>Input Rapor</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-bold">
                                    Belum ada data siswa terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>
@endsection
