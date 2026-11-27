@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil | PAUD Haqqul Yaqin')

@section('content')
<div class="min-h-screen bg-[#FFF8ED] py-8 px-4 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-2xl">

        <!-- KARTU SUKSES -->
        <div class="overflow-hidden rounded-3xl border-2 border-orange-200 bg-white shadow-xl">

            <!-- HEADER SUKSES -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-7 text-center text-white sm:px-8">
                <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-white/20 text-2xl ring-4 ring-white/30">
                    ✓
                </div>
                <span class="inline-flex rounded-full bg-white/20 px-3 py-0.5 text-[11px] font-bold uppercase tracking-wider text-emerald-100">
                    Formulir Berhasil Terkirim
                </span>
                <h1 class="mt-1 text-xl font-black sm:text-2xl">
                    Alhamdulillah, Pendaftaran Berhasil!
                </h1>
                <p class="mt-1.5 text-xs text-emerald-100 max-w-md mx-auto leading-relaxed">
                    Data calon peserta didik baru telah tersimpan di sistem PAUD Haqqul Yaqin. Simpan Nomor Registrasi Anda di bawah ini.
                </p>
            </div>

            <div class="p-5 sm:p-7 space-y-5">

                <!-- KOTAK NOMOR REGISTRASI -->
                <div class="rounded-2xl border-2 border-dashed border-orange-300 bg-orange-50/70 p-4 text-center">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-orange-600">
                        Nomor Registrasi Pendaftaran
                    </p>
                    <p class="mt-0.5 text-2xl sm:text-3xl font-mono font-black text-blue-950 tracking-wider">
                        {{ $pendaftaran->nomor_registrasi }}
                    </p>
                    <p class="mt-1 text-[11px] text-slate-500">
                        Waktu: {{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB • Program: <strong>{{ $pendaftaran->program === 'KB' ? 'Kelompok Bermain (KB)' : 'Taman Kanak-Kanak (TK)' }}</strong>
                    </p>
                </div>

                <!-- RINGKASAN DATA PENDAFTAR -->
                <div class="rounded-2xl border border-orange-100 bg-slate-50/70 p-4 text-xs">
                    <h3 class="font-extrabold text-blue-950 border-b border-slate-200 pb-2 mb-2.5">
                        Ringkasan Data Calon Siswa
                    </h3>
                    <dl class="space-y-1.5 text-slate-700">
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Nama Lengkap</dt>
                            <dd class="font-bold text-blue-950">{{ $pendaftaran->nama_lengkap }} ({{ $pendaftaran->nama_panggilan ?: '-' }})</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Jenis Kelamin / Usia</dt>
                            <dd class="font-semibold">{{ $pendaftaran->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} • {{ $pendaftaran->usia ?: '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Tempat, Tgl Lahir</dt>
                            <dd class="font-semibold">
                                {{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Orang Tua (Ayah / Ibu)</dt>
                            <dd class="font-semibold">{{ $pendaftaran->nama_ayah ?: '-' }} / {{ $pendaftaran->nama_ibu ?: '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Kontak WhatsApp</dt>
                            <dd class="font-semibold text-emerald-700">+{{ $pendaftaran->kontak_utama }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-slate-500">Alamat</dt>
                            <dd class="font-semibold text-right max-w-xs truncate">{{ $pendaftaran->alamat }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- LANGKAH SELANJUTNYA: KONFIRMASI WA -->
                <div class="rounded-2xl border border-blue-200 bg-blue-50/70 p-4 text-center sm:text-left">
                    <h4 class="font-black text-blue-950 text-xs sm:text-sm flex items-center justify-center sm:justify-start gap-1.5">
                        <span>📲</span> Konfirmasi Pendaftaran ke Panitia PPDB
                    </h4>
                    <p class="mt-1 text-xs text-blue-800 leading-relaxed">
                        Klik tombol di bawah ini untuk mengirimkan konfirmasi pendaftaran secara langsung ke WhatsApp Admin PAUD Haqqul Yaqin agar berkas pendaftaran segera diverifikasi.
                    </p>

                    <a href="{{ $waUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-xs sm:text-sm font-black text-white shadow-md shadow-emerald-600/30 transition hover:bg-emerald-700">
                        <span>💬 Konfirmasi via WhatsApp Sekarang</span>
                    </a>
                </div>

                <!-- TOMBOL NAVIGASI & CETAK -->
                <div class="flex flex-col gap-2.5 pt-1 sm:flex-row sm:items-center sm:justify-between">
                    <button onclick="window.print()"
                            type="button"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-orange-300 bg-white px-4 py-2 text-xs font-bold text-orange-700 hover:bg-orange-50 transition cursor-pointer">
                        <span>🖨 Cetak Bukti Pendaftaran</span>
                    </button>

                    <a href="{{ route('landing') }}"
                       class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-blue-950 px-5 py-2 text-xs font-bold text-white hover:bg-blue-900 transition">
                        <span>← Kembali ke Halaman Utama</span>
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection
