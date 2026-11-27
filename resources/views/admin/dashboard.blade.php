@extends('layouts.panel')

@section('title', 'Dashboard Admin | PAUD Haqqul Yaqin')
@section('page-title', 'Dashboard Utama')

@section('panel-content')

    <!-- SAMBUTAN DENGAN FOTO SEKOLAH (SELARAS BERANDA) -->
    <div class="overflow-hidden rounded-[2rem] border-2 border-orange-200/80 bg-white shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12">

            <div class="flex flex-col justify-center p-6 sm:p-8 lg:col-span-8">
                <span class="w-fit rounded-full border border-orange-200 bg-orange-50 px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-orange-600">
                    Ruang Kerja Pimpinan • Kepala Sekolah & Admin
                </span>
                <h2 class="mt-3 text-2xl sm:text-3xl font-black text-blue-950 leading-tight">
                    Selamat Datang, <span class="text-orange-500">{{ auth()->user()->nama_lengkap }}</span>
                </h2>
                <p class="mt-2 max-w-2xl text-sm text-slate-600 leading-relaxed">
                    Pantau ringkasan data anak didik, tenaga pendidik, akun wali murid, serta proses pemeriksaan dan pengesahan rapor triwulan PAUD Haqqul Yaqin dalam satu sistem terintegrasi.
                </p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('admin.pendaftaran.index') }}" class="rounded-full bg-orange-500 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition">
                        Pendaftaran Masuk (PPDB)
                        @if($totalPendaftaranMenunggu > 0)
                            <span class="ml-1.5 rounded-full bg-white px-2 py-0.5 text-[10px] font-black text-orange-600">{{ $totalPendaftaranMenunggu }}</span>
                        @endif
                    </a>
                    <a href="{{ route('rapor.index') }}" class="rounded-full bg-blue-900 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-blue-950 transition">
                        Kelola Rapor Triwulan
                        @if($raporMenunggu->count() > 0)
                            <span class="ml-1.5 rounded-full bg-orange-500 px-2 py-0.5 text-[10px] font-black text-white">{{ $raporMenunggu->count() }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.anak.index') }}" class="rounded-full bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-700 transition">
                        Data Siswa (KB & TK)
                    </a>
                    <a href="{{ route('admin.pengguna.index') }}" class="rounded-full bg-slate-700 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-slate-800 transition">
                        Akun & Relasi Wali
                    </a>
                </div>
            </div>

            <!-- FOTO SEKOLAH SAMA DENGAN BERANDA -->
            <div class="relative hidden lg:block lg:col-span-4">
                <img src="{{ asset('images/paud-haqqul-yaqin.jpg') }}"
                     alt="Suasana Belajar PAUD Haqqul Yaqin"
                     class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/20 to-transparent"></div>
            </div>

        </div>
    </div>

    <!-- STATISTIK ANGKA UTAMA -->
    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <div class="rounded-2xl border border-orange-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-orange-500">Total Siswa</p>
            <p class="mt-2 text-3xl font-black text-blue-950">{{ $totalSiswa }}</p>
            <p class="mt-2 border-t border-orange-100 pt-2 text-xs font-medium text-slate-500">
                KB: <strong class="text-emerald-700">{{ $totalKB }}</strong> · TK: <strong class="text-blue-700">{{ $totalTK }}</strong>
            </p>
        </div>
        <div class="rounded-2xl border border-orange-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-blue-600">Tenaga Pendidik</p>
            <p class="mt-2 text-3xl font-black text-blue-950">{{ $totalGuru }}</p>
            <p class="mt-2 border-t border-orange-100 pt-2 text-xs font-medium text-slate-500">Guru & Staf Pengajar</p>
        </div>
        <div class="rounded-2xl border border-orange-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-600">Wali Murid</p>
            <p class="mt-2 text-3xl font-black text-blue-950">{{ $totalWali }}</p>
            <p class="mt-2 border-t border-orange-100 pt-2 text-xs font-medium text-slate-500">Akun Terdaftar</p>
        </div>
        <div class="rounded-2xl border border-orange-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-purple-600">Rapor Triwulan</p>
            <p class="mt-2 text-3xl font-black text-blue-950">{{ $totalRapor }}</p>
            <p class="mt-2 border-t border-orange-100 pt-2 text-xs font-medium text-slate-500">Arsip Penilaian</p>
        </div>
    </div>

    <!-- ANTREAN PENDAFTARAN SISWA BARU -->
    @if($totalPendaftaranMenunggu > 0)
        <div class="mt-8 rounded-[2rem] border-2 border-orange-300 bg-orange-50/70 p-6">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h3 class="text-base font-black text-orange-950">Pendaftaran Siswa Baru Menunggu Verifikasi ({{ $totalPendaftaranMenunggu }})</h3>
                    <p class="text-xs text-orange-800">Calon peserta didik baru telah mengisi formulir online dan menunggu konfirmasi verifikasi admin.</p>
                </div>
                <a href="{{ route('admin.pendaftaran.index', ['status' => 'menunggu']) }}" class="rounded-full bg-orange-500 px-4 py-1.5 text-xs font-bold text-white hover:bg-orange-600 transition">
                    Lihat Semua Pendaftar
                </a>
            </div>
            <div class="overflow-hidden rounded-2xl border border-orange-200 bg-white">
                <table class="w-full text-left text-xs sm:text-sm">
                    <tbody class="divide-y divide-orange-100">
                        @foreach($pendaftaranTerbaru->where('status', 'menunggu') as $pt)
                            <tr class="hover:bg-orange-50/40">
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-blue-950">{{ $pt->nama_lengkap }}</p>
                                    <p class="text-xs text-slate-500">Program: {{ $pt->program }} · No. Reg: <span class="font-mono">{{ $pt->nomor_registrasi }}</span> · Wali: {{ $pt->nama_wali_utama }} (+{{ $pt->kontak_utama }})</p>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.pendaftaran.show', $pt->id_pendaftaran) }}" class="rounded-full bg-orange-500 px-4 py-1.5 text-xs font-bold text-white hover:bg-orange-600 transition">
                                        Periksa Berkas
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- ANTREAN PENGESAHAN -->
    @if($raporMenunggu->count() > 0)
        <div class="mt-8 rounded-[2rem] border-2 border-amber-300 bg-amber-50/60 p-6">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h3 class="text-base font-black text-amber-950">Menunggu Pengesahan ({{ $raporMenunggu->count() }})</h3>
                    <p class="text-xs text-amber-800">Rapor telah disusun guru dan siap diperiksa sebelum disahkan dan diterbitkan ke wali murid.</p>
                </div>
                <a href="{{ route('admin.rapor.index', ['status' => 'diajukan']) }}" class="rounded-full bg-white px-4 py-1.5 text-xs font-bold text-amber-900 ring-1 ring-amber-200 hover:bg-amber-100 transition">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-hidden rounded-2xl border border-amber-200 bg-white">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-amber-100">
                        @foreach($raporMenunggu as $rm)
                            <tr class="hover:bg-amber-50/40">
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-blue-950">{{ $rm->anak->nama_anak }}</p>
                                    <p class="text-xs text-slate-500">{{ $rm->anak->kelompok }} · {{ $rm->periode->nama_periode }} ({{ $rm->periode->tahun_ajaran }}) · Penyusun: {{ $rm->pembuat->nama_lengkap ?? 'Guru' }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.rapor.show', $rm->id_rapor) }}" class="rounded-full bg-emerald-600 px-4 py-1.5 text-xs font-bold text-white hover:bg-emerald-700 transition">
                                        Periksa & Setujui
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- DUA KOLOM: DAFTAR GURU & MENU ADMINISTRASI LENGKAP POV ADMIN -->
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">

        <!-- DAFTAR TENAGA PENGAJAR -->
        <div class="rounded-[2rem] border border-orange-200/80 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-orange-500">Tenaga Pengajar</p>
                    <h3 class="text-base font-black text-blue-950">Daftar Guru & Staf</h3>
                </div>
                <a href="{{ route('admin.guru.index') }}" class="rounded-full bg-orange-50 px-3.5 py-1.5 text-xs font-bold text-orange-700 hover:bg-orange-100 transition">
                    Kelola Semua
                </a>
            </div>
            <div class="divide-y divide-orange-100/80">
                @forelse($daftarGuru as $guru)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-bold text-blue-950">{{ $guru->nama_lengkap }}</p>
                            <p class="font-mono text-xs text-slate-500">{{ $guru->kode_login }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-[10px] font-bold uppercase {{ $guru->peran === 'admin' ? 'bg-blue-50 text-blue-700' : 'bg-emerald-50 text-emerald-700' }}">
                            {{ $guru->peran === 'admin' ? 'Kepala Sekolah' : ($guru->peran === 'admin_guru' ? 'Guru & Admin' : 'Pendidik') }}
                        </span>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-slate-400">Belum ada data tenaga pengajar.</p>
                @endforelse
            </div>
        </div>

        <!-- MENU ADMINISTRASI LENGKAP (FITUR POV ADMIN) -->
        <div class="rounded-[2rem] border border-orange-200/80 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-orange-500">Akses Pimpinan</p>
                <h3 class="text-base font-black text-blue-950">Menu Administrasi Master</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <a href="{{ route('admin.anak.index') }}" class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/70 p-4 transition hover:bg-orange-100/60">
                    <p class="text-xs font-bold text-blue-950">Data Siswa (KB & TK)</p>
                    <p class="mt-1 text-[11px] text-slate-500">Kelola identitas, NIS, kelompok kelas.</p>
                </a>
                <a href="{{ route('admin.pengguna.index') }}" class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/70 p-4 transition hover:bg-orange-100/60">
                    <p class="text-xs font-bold text-blue-950">Akun & Relasi Wali</p>
                    <p class="mt-1 text-[11px] text-slate-500">Kelola akun dan hubungkan wali ke anak.</p>
                </a>
                <a href="{{ route('admin.guru.index') }}" class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/70 p-4 transition hover:bg-orange-100/60">
                    <p class="text-xs font-bold text-blue-950">Guru & Staf</p>
                    <p class="mt-1 text-[11px] text-slate-500">Tambah akun pengajar dan reset sandi.</p>
                </a>
                <a href="{{ route('admin.periode.index') }}" class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/70 p-4 transition hover:bg-orange-100/60">
                    <p class="text-xs font-bold text-blue-950">Periode Tahun Ajaran</p>
                    <p class="mt-1 text-[11px] text-slate-500">Kelola semester & triwulan rapor.</p>
                </a>
                <a href="{{ route('admin.rapor.index') }}" class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/70 p-4 transition hover:bg-orange-100/60">
                    <p class="text-xs font-bold text-blue-950">Pengesahan Rapor</p>
                    <p class="mt-1 text-[11px] text-slate-500">Review, setujui, terbitkan, buka revisi.</p>
                </a>
                <a href="{{ route('rapor.index') }}" class="rounded-2xl border border-orange-100 bg-[#FFF8ED]/70 p-4 transition hover:bg-orange-100/60">
                    <p class="text-xs font-bold text-blue-950">Semua Rapor Triwulan</p>
                    <p class="mt-1 text-[11px] text-slate-500">Pantau dan cetak rapor seluruh siswa.</p>
                </a>
            </div>
        </div>

    </div>

@endsection
