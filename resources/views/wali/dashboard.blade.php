@extends('layouts.app')

@section('title', 'Portal Wali Murid | PAUD Haqqul Yaqin')

@section('content')
<div class="relative min-h-screen bg-[#FFF8ED] pb-16">

    <!-- DEKORASI BACKGROUND LEMBUT -->
    <div class="pointer-events-none fixed -left-20 top-20 -z-0 h-72 w-72 rounded-full bg-blue-200/40 blur-3xl"></div>
    <div class="pointer-events-none fixed -right-20 top-1/3 -z-0 h-80 w-80 rounded-full bg-orange-200/50 blur-3xl"></div>

    <!-- ================= TOPBAR WALI ================= -->
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
                    <p class="text-[10px] font-bold tracking-widest text-orange-500">PORTAL WALI MURID</p>
                </div>
            </a>

            <!-- MENU & USER INFO -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-sm ring-1 ring-orange-200">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-500 text-xs text-white font-bold">
                        👨‍👩‍👧
                    </span>
                    <div class="text-left">
                        <p class="text-xs font-extrabold text-blue-950 leading-none">{{ $wali->nama_lengkap }}</p>
                        <p class="text-[10px] font-bold text-orange-500 uppercase tracking-wider mt-0.5">Orang Tua / Wali Murid</p>
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

        <!-- ================= WELCOME BANNER WALI MURID ================= -->
        <div class="relative overflow-hidden rounded-[2.5rem] border-2 border-orange-200/90 bg-gradient-to-r from-orange-100/90 via-white to-blue-50/80 p-6 sm:p-8 shadow-sm">
            <span class="pointer-events-none absolute right-6 top-4 text-4xl text-orange-300/40">✦</span>
            <span class="pointer-events-none absolute right-24 bottom-4 text-2xl text-orange-300/40">✧</span>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-orange-200 bg-white/90 px-4 py-1.5 text-xs font-extrabold text-orange-600 shadow-sm">
                        <span>✦</span>
                        <span>Portal Komunikasi Orang Tua & Sekolah</span>
                    </div>

                    <h2 class="mt-4 text-2xl sm:text-3xl font-black text-blue-950 leading-tight">
                        Selamat Datang, <span class="text-orange-500">{{ $wali->nama_lengkap }}</span>!
                    </h2>

                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Terima kasih telah mempercayakan tumbuh kembang ananda kepada PAUD Haqqul Yaqin. Di portal ini, Ayah dan Bunda dapat memantau capaian belajar serta mencetak laporan perkembangan rapor tiap triwulan.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('landing') }}#program" class="rounded-full bg-white border-2 border-orange-200 px-5 py-2.5 text-xs font-extrabold text-blue-950 shadow-sm hover:bg-orange-50 transition">
                        Lihat Program Sekolah
                    </a>
                </div>
            </div>
        </div>

        <!-- ================= DAFTAR ANAK DIDIK SAYA ================= -->
        <div class="mt-8">
            <div class="mb-4">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500">Buah Hati Tercinta</span>
                <h3 class="text-xl font-black text-blue-950">Data Ananda & Laporan Capaian Perkembangan</h3>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @forelse($anakList as $anak)
                    <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80 transition duration-300 hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-orange-100 text-3xl shadow-sm ring-1 ring-orange-200">
                                {{ $anak->jenis_kelamin === 'L' ? '👦' : '👧' }}
                            </div>
                            <div>
                                <span class="rounded-full bg-blue-100 px-3 py-0.5 text-[10px] font-extrabold text-blue-800 uppercase tracking-wider">
                                    {{ $anak->kelompok }}
                                </span>
                                <h4 class="mt-1 text-lg font-black text-blue-950">{{ $anak->nama_anak }}</h4>
                                <p class="text-xs text-slate-500 font-mono">NIS: {{ $anak->nis }} • {{ $anak->alamat }}</p>
                            </div>
                        </div>

                        <div class="mt-6 border-t-2 border-orange-100 pt-5">
                            <p class="text-xs font-extrabold uppercase tracking-wider text-orange-500 mb-3">Laporan Rapor Triwulan:</p>

                            @php
                                $raporTerbit = $anak->rapor->where('status_rapor', 'diterbitkan');
                                $raporPending = $anak->rapor->where('status_rapor', '!=', 'diterbitkan');
                            @endphp

                            @if($raporTerbit->count() > 0)
                                <div class="space-y-2.5">
                                    @foreach($raporTerbit as $rt)
                                        <div class="flex items-center justify-between rounded-2xl bg-emerald-50/90 border-2 border-emerald-200 p-4 text-xs shadow-sm">
                                            <div>
                                                <span class="font-black text-emerald-950 text-sm block">{{ $rt->periode->nama_periode }}</span>
                                                <span class="text-[10px] text-emerald-700 font-bold block mt-0.5">T.A {{ $rt->periode->tahun_ajaran }} • Disahkan Kepala Sekolah</span>
                                            </div>
                                            <a href="{{ route('rapor.show', $rt->id_rapor) }}" class="rounded-full bg-emerald-600 px-4 py-2 font-extrabold text-white shadow-sm hover:bg-emerald-700 active:scale-95 transition">
                                                📄 Buka & Cetak
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($raporPending->count() > 0)
                                <div class="mt-3 rounded-2xl bg-amber-50 border-2 border-amber-200 p-4 text-xs text-amber-900">
                                    <div class="flex items-center gap-2 font-extrabold">
                                        <span class="text-base">⏳</span>
                                        <span>Rapor Triwulan Terbaru Sedang Dalam Pemeriksaan</span>
                                    </div>
                                    <p class="text-[11px] text-amber-800 mt-1 leading-relaxed">
                                        Guru pendamping telah menyusun catatan capaian ananda. Rapor akan otomatis tersedia di sini setelah diverifikasi dan disahkan oleh Kepala Sekolah.
                                    </p>
                                </div>
                            @endif

                            @if($raporTerbit->count() == 0 && $raporPending->count() == 0)
                                <p class="text-xs text-slate-400 font-semibold italic py-2">Belum ada rapor triwulan untuk tahun ajaran ini.</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-[2.5rem] border-2 border-dashed border-orange-200 bg-white p-10 text-center">
                        <div class="text-4xl mb-2">👶</div>
                        <p class="text-sm font-black text-blue-950">Belum ada data anak yang ditautkan ke akun Anda.</p>
                        <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">Silakan hubungi pihak tata usaha atau guru pendamping PAUD Haqqul Yaqin untuk menghubungkan akun wali murid dengan data ananda.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

</div>
@endsection
