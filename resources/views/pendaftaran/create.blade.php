@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Siswa Baru | PAUD Haqqul Yaqin')

@section('content')
<div class="min-h-screen bg-[#FFF8ED]">

    <!-- ================= NAVBAR / HEADER ================= -->
    <header class="sticky top-0 z-40 border-b-2 border-orange-200/80 bg-[#FFF8ED]/95 px-4 py-3.5 shadow-sm backdrop-blur-md sm:px-8">
        <div class="mx-auto flex max-w-5xl items-center justify-between">
            <a href="{{ route('landing') }}" class="group flex items-center gap-3">
                <div class="flex items-center gap-1.5 rounded-xl bg-white px-2 py-1.5 shadow-sm ring-1 ring-blue-100">
                    <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD Haqqul Yaqin" class="h-9 w-9 object-contain">
                    <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan" class="h-9 w-9 object-contain">
                </div>
                <div>
                    <h1 class="text-xs font-black tracking-wide text-blue-900 sm:text-sm">PAUD HAQQUL YAQIN</h1>
                    <p class="text-[9px] font-bold tracking-widest text-orange-500 uppercase">Formulir Pendaftaran Siswa Baru</p>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ asset('documents/formulir_pendaftaran.pdf') }}"
                   target="_blank"
                   download="formulir_pendaftaran_paud_haqqul_yaqin.pdf"
                   class="inline-flex items-center gap-1.5 rounded-full border border-orange-300 bg-white px-3.5 py-1.5 text-xs font-bold text-orange-700 shadow-sm transition hover:bg-orange-50">
                    <span>⬇ Unduh Formulir PDF (Offline)</span>
                </a>
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-1 rounded-full bg-blue-900 px-4 py-1.5 text-xs font-bold text-white shadow-sm transition hover:bg-blue-950">
                    <span>← Kembali</span>
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 sm:py-10">

        <!-- KOP IDENTITAS RESMI (SESUAI DOKUMEN ASLI) -->
        <div class="mb-6 rounded-3xl border-2 border-orange-200/90 bg-white p-5 shadow-sm sm:p-7 text-center">
            <div class="inline-flex items-center justify-center gap-2 mb-2">
                <span class="rounded-full bg-orange-100 px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider text-orange-700">
                    Penerimaan Siswa Baru (PPDB Online)
                </span>
            </div>
            <h2 class="text-lg font-black text-blue-950 sm:text-2xl uppercase tracking-wide">
                Yayasan Hidayatullah Haqqul Yaqin
            </h2>
            <p class="text-[11px] text-slate-500 mt-0.5">
                SK. Menkumham RI No. : AHU-0015025.AH.01.04. Tahun 2024
            </p>
            <p class="text-[11px] text-slate-600 mt-1">
                Alamat : Jl. Menur, No. 15, Salakan, Mertoyudan, Kec. Mertoyudan, Kabupaten Magelang
            </p>
            <p class="text-[11px] text-slate-500 font-medium">
                WA: 081225852505 • Email: humas@haqqulyaqin.or.id
            </p>

            <div class="mt-4 border-t border-orange-100 pt-3">
                <h3 class="text-sm font-black text-orange-600 uppercase tracking-widest sm:text-base">
                    FORMULIR PENDAFTARAN SISWA BARU
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Silakan isi seluruh pertanyaan di bawah ini sesuai data asli pada Akta Kelahiran & Kartu Keluarga.
                </p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-2xl border-2 border-red-200 bg-red-50 p-4 text-xs text-red-800 shadow-sm">
                <p class="font-black text-red-900 mb-1">Mohon periksa kembali isian formulir Anda:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- PILIHAN PROGRAM PENDIDIKAN -->
            <div class="rounded-3xl border border-orange-200 bg-white p-5 shadow-sm sm:p-6">
                <h3 class="text-sm font-black uppercase tracking-wider text-blue-950 mb-3 border-b border-orange-100 pb-2">
                    Pilihan Program Belajar <span class="text-red-500">*</span>
                </h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <label class="relative flex cursor-pointer items-center justify-between rounded-2xl border-2 p-4 transition duration-200 hover:border-orange-400 has-checked:border-orange-500 has-checked:bg-orange-50/50">
                        <div>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-black text-emerald-800">Usia 2 - 4 Tahun</span>
                            <h4 class="mt-1 text-sm font-black text-blue-950">Kelompok Bermain (KB)</h4>
                        </div>
                        <input type="radio" name="program" value="KB" {{ old('program', 'KB') == 'KB' ? 'checked' : '' }} class="h-5 w-5 text-orange-500 focus:ring-orange-400">
                    </label>

                    <label class="relative flex cursor-pointer items-center justify-between rounded-2xl border-2 p-4 transition duration-200 hover:border-orange-400 has-checked:border-orange-500 has-checked:bg-orange-50/50">
                        <div>
                            <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-[10px] font-black text-blue-800">Usia 4 - 6 Tahun</span>
                            <h4 class="mt-1 text-sm font-black text-blue-950">Taman Kanak-Kanak (TK)</h4>
                        </div>
                        <input type="radio" name="program" value="TK" {{ old('program') == 'TK' ? 'checked' : '' }} class="h-5 w-5 text-orange-500 focus:ring-orange-400">
                    </label>
                </div>
            </div>

            <!-- BAGIAN 1: IDENTITAS SISWA -->
            <div class="rounded-3xl border border-orange-200 bg-white p-5 shadow-sm sm:p-6 space-y-4">
                <h3 class="text-sm font-black uppercase tracking-wider text-blue-950 border-b border-orange-100 pb-2 flex items-center justify-between">
                    <span>I. IDENTITAS SISWA</span>
                    <span class="text-[11px] font-normal text-slate-500 normal-case">Sesuai Akta Kelahiran</span>
                </h3>

                <!-- 1 & 2. NAMA LENGKAP & PANGGILAN -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 mb-1">
                            1. Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               placeholder="Nama lengkap anak sesuai akta"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="nama_panggilan" class="block text-xs font-bold text-slate-700 mb-1">
                            2. Nama Panggilan
                        </label>
                        <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan') }}"
                               placeholder="Nama panggilan akrab"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <!-- 3 & 4. TEMPAT TANGGAL LAHIR & JENIS KELAMIN -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <label for="tempat_lahir" class="block text-xs font-bold text-slate-700 mb-1">
                            3. Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                               placeholder="Kota/Kabupaten lahir"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-xs font-bold text-slate-700 mb-1">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                               onchange="hitungUsiaOtomatis(this.value)"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-xs font-bold text-slate-700 mb-1">
                            4. Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <!-- 5, 6, 7, 8. USIA, BERAT BADAN, TINGGI BADAN, LINGKAR KEPALA -->
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div>
                        <label for="usia" class="block text-xs font-bold text-slate-700 mb-1">
                            5. Usia Anak
                        </label>
                        <input type="text" name="usia" id="usia" value="{{ old('usia') }}"
                               placeholder="Contoh: 3 Tahun 4 Bulan"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="berat_badan" class="block text-xs font-bold text-slate-700 mb-1">
                            6. Berat Badan (kg)
                        </label>
                        <input type="text" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}"
                               placeholder="Contoh: 14 kg"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="tinggi_badan" class="block text-xs font-bold text-slate-700 mb-1">
                            7. Tinggi Badan (cm)
                        </label>
                        <input type="text" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan') }}"
                               placeholder="Contoh: 95 cm"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="lingkar_kepala" class="block text-xs font-bold text-slate-700 mb-1">
                            8. Lingkar Kepala (cm)
                        </label>
                        <input type="text" name="lingkar_kepala" id="lingkar_kepala" value="{{ old('lingkar_kepala') }}"
                               placeholder="Contoh: 48 cm"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <!-- 9. ANAK KE- & JUMLAH SAUDARA -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="anak_ke" class="block text-xs font-bold text-slate-700 mb-1">
                            9. Anak Ke-
                        </label>
                        <input type="number" name="anak_ke" id="anak_ke" min="1" max="25" value="{{ old('anak_ke') }}"
                               placeholder="Contoh: 1"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="jumlah_saudara" class="block text-xs font-bold text-slate-700 mb-1">
                            Jumlah Saudara
                        </label>
                        <input type="number" name="jumlah_saudara" id="jumlah_saudara" min="0" max="25" value="{{ old('jumlah_saudara') }}"
                               placeholder="Contoh: 2"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <!-- CITA-CITA & HOBBY -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="cita_cita" class="block text-xs font-bold text-slate-700 mb-1">
                            a. Cita-Cita Anak
                        </label>
                        <input type="text" name="cita_cita" id="cita_cita" value="{{ old('cita_cita') }}"
                               placeholder="Contoh: Dokter, Guru, Pilot, Hafidz"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="hobby" class="block text-xs font-bold text-slate-700 mb-1">
                            b. Hobby Anak
                        </label>
                        <input type="text" name="hobby" id="hobby" value="{{ old('hobby') }}"
                               placeholder="Contoh: Menggambar, Mewarnai, Bersepeda"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <!-- 10. RIWAYAT PENYAKIT & PANTANGAN -->
                <div>
                    <label for="riwayat_penyakit" class="block text-xs font-bold text-slate-700 mb-1">
                        10. Riwayat Penyakit (Bila Ada)
                    </label>
                    <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" value="{{ old('riwayat_penyakit') }}"
                           placeholder="Contoh: Asma, Kejang demam, Tidak ada"
                           class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="makanan_dihindari" class="block text-xs font-bold text-slate-700 mb-1">
                            Makanan yang Dihindari (Alergi/Pantangan)
                        </label>
                        <input type="text" name="makanan_dihindari" id="makanan_dihindari" value="{{ old('makanan_dihindari') }}"
                               placeholder="Contoh: Seafood, Telur, Cokelat, Tidak ada"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="minuman_dihindari" class="block text-xs font-bold text-slate-700 mb-1">
                            Minuman yang Dihindari (Alergi/Pantangan)
                        </label>
                        <input type="text" name="minuman_dihindari" id="minuman_dihindari" value="{{ old('minuman_dihindari') }}"
                               placeholder="Contoh: Susu sapi, Es, Minuman manis kemasan"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <!-- ALAMAT SISWA -->
                <div>
                    <label for="alamat" class="block text-xs font-bold text-slate-700 mb-1">
                        Alamat Tempat Tinggal Anak <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2" required
                              placeholder="Nama jalan, RT/RW, Dusun/Kelurahan, Kecamatan, Kabupaten/Kota"
                              class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">{{ old('alamat') }}</textarea>
                </div>
            </div>

            <!-- BAGIAN 2: IDENTITAS ORANG TUA / WALI MURID - AYAH -->
            <div class="rounded-3xl border border-orange-200 bg-white p-5 shadow-sm sm:p-6 space-y-4">
                <h3 class="text-sm font-black uppercase tracking-wider text-blue-950 border-b border-orange-100 pb-2 flex items-center justify-between">
                    <span>II. IDENTITAS ORANG TUA / WALI MURID — 1. AYAH</span>
                    <span class="text-[11px] font-normal text-slate-500 normal-case">Data Ayah Kandung / Wali</span>
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <label for="nama_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                            a. Nama Lengkap Ayah
                        </label>
                        <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah') }}"
                               placeholder="Nama lengkap ayah beserta gelar (bila ada)"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="usia_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                            f. Usia Ayah
                        </label>
                        <input type="text" name="usia_ayah" id="usia_ayah" value="{{ old('usia_ayah') }}"
                               placeholder="Contoh: 35 Tahun"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="ttl_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                            b. Tempat dan Tanggal Lahir Ayah
                        </label>
                        <input type="text" name="ttl_ayah" id="ttl_ayah" value="{{ old('ttl_ayah') }}"
                               placeholder="Contoh: Magelang, 15 Mei 1988"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="pendidikan_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                            d. Jenjang Pendidikan Ayah
                        </label>
                        <input type="text" name="pendidikan_ayah" id="pendidikan_ayah" value="{{ old('pendidikan_ayah') }}"
                               placeholder="Contoh: SMA / D3 / S1 / S2"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="pekerjaan_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                            c. Pekerjaan Ayah
                        </label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                               placeholder="Contoh: Karyawan Swasta, PNS, Wiraswasta"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="pendapatan_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                            e. Pendapatan per Bulan Ayah
                        </label>
                        <input type="text" name="pendapatan_ayah" id="pendapatan_ayah" value="{{ old('pendapatan_ayah') }}"
                               placeholder="Contoh: Rp 3.000.000 - Rp 5.000.000"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div>
                    <label for="no_hp_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                        h. No. Telpon / WhatsApp Ayah
                    </label>
                    <input type="text" name="no_hp_ayah" id="no_hp_ayah" value="{{ old('no_hp_ayah') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                </div>

                <div>
                    <label for="alamat_ayah" class="block text-xs font-bold text-slate-700 mb-1">
                        g. Alamat Ayah
                    </label>
                    <textarea name="alamat_ayah" id="alamat_ayah" rows="2"
                              placeholder="Alamat tempat tinggal ayah (bisa sama dengan anak)"
                              class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">{{ old('alamat_ayah') }}</textarea>
                </div>
            </div>

            <!-- BAGIAN 3: IDENTITAS ORANG TUA / WALI MURID - IBU -->
            <div class="rounded-3xl border border-orange-200 bg-white p-5 shadow-sm sm:p-6 space-y-4">
                <div class="border-b border-orange-100 pb-2 flex flex-wrap items-center justify-between gap-2">
                    <h3 class="text-sm font-black uppercase tracking-wider text-blue-950">
                        III. IDENTITAS ORANG TUA / WALI MURID — 2. IBU
                    </h3>
                    <button type="button" onclick="salinAlamatAyahKeIbu()" class="text-xs font-bold text-orange-600 hover:text-orange-700 underline cursor-pointer">
                        ↳ Salin Alamat dari Ayah
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <label for="nama_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                            a. Nama Lengkap Ibu
                        </label>
                        <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}"
                               placeholder="Nama lengkap ibu kandung"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="usia_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                            f. Usia Ibu
                        </label>
                        <input type="text" name="usia_ibu" id="usia_ibu" value="{{ old('usia_ibu') }}"
                               placeholder="Contoh: 32 Tahun"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="ttl_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                            b. Tempat dan Tanggal Lahir Ibu
                        </label>
                        <input type="text" name="ttl_ibu" id="ttl_ibu" value="{{ old('ttl_ibu') }}"
                               placeholder="Contoh: Magelang, 20 Agustus 1991"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="pendidikan_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                            d. Jenjang Pendidikan Ibu
                        </label>
                        <input type="text" name="pendidikan_ibu" id="pendidikan_ibu" value="{{ old('pendidikan_ibu') }}"
                               placeholder="Contoh: SMA / D3 / S1"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="pekerjaan_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                            c. Pekerjaan Ibu
                        </label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}"
                               placeholder="Contoh: Ibu Rumah Tangga, Guru, PNS, Karyawan"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                    <div>
                        <label for="pendapatan_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                            e. Pendapatan per Bulan Ibu
                        </label>
                        <input type="text" name="pendapatan_ibu" id="pendapatan_ibu" value="{{ old('pendapatan_ibu') }}"
                               placeholder="Contoh: Rp 2.000.000 / Tidak berpenghasilan"
                               class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    </div>
                </div>

                <div>
                    <label for="no_hp_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                        h. No. Telpon / WhatsApp Ibu
                    </label>
                    <input type="text" name="no_hp_ibu" id="no_hp_ibu" value="{{ old('no_hp_ibu') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
                </div>

                <div>
                    <label for="alamat_ibu" class="block text-xs font-bold text-slate-700 mb-1">
                        g. Alamat Ibu
                    </label>
                    <textarea name="alamat_ibu" id="alamat_ibu" rows="2"
                              placeholder="Alamat tempat tinggal ibu"
                              class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-blue-950 placeholder-slate-400 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300">{{ old('alamat_ibu') }}</textarea>
                </div>
            </div>

            <!-- PERNYATAAN & TOMBOL SUBMIT -->
            <div class="rounded-3xl border-2 border-orange-300 bg-orange-50/70 p-5 sm:p-7">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" required class="mt-1 h-5 w-5 rounded border-orange-300 text-orange-600 focus:ring-orange-400">
                    <span class="text-xs text-slate-700 leading-relaxed">
                        Dengan ini saya menyatakan bahwa data yang diisikan dalam formulir pendaftaran ini adalah benar dan dapat dipertanggungjawabkan sesuai dokumen resmi yang ada.
                    </span>
                </label>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-t border-orange-200 pt-4">
                    <a href="{{ route('landing') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                        ← Batal & Kembali
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FF8A24] px-7 py-3 text-sm font-extrabold text-white shadow-md shadow-orange-500/25 transition duration-300 hover:bg-[#F47B12] hover:shadow-lg cursor-pointer">
                        <span>Kirim Formulir Pendaftaran Sekarang</span>
                        <span aria-hidden="true">→</span>
                    </button>
                </div>
            </div>
        </form>

    </main>

    <footer class="border-t border-orange-200 bg-white py-5 text-center text-xs text-slate-500">
        <p>© 2026 PAUD Haqqul Yaqin • Yayasan Hidayatullah Haqqul Yaqin</p>
    </footer>

</div>

<script>
function hitungUsiaOtomatis(birthDate) {
    if (!birthDate) return;
    const dob = new Date(birthDate);
    const today = new Date();
    let years = today.getFullYear() - dob.getFullYear();
    let months = today.getMonth() - dob.getMonth();
    if (months < 0 || (months === 0 && today.getDate() < dob.getDate())) {
        years--;
        months = (months + 12) % 12;
    }
    const usiaInput = document.getElementById('usia');
    if (usiaInput) {
        usiaInput.value = years + ' Tahun ' + months + ' Bulan';
    }
}

function salinAlamatAyahKeIbu() {
    const alamatAyah = document.getElementById('alamat_ayah').value;
    const alamatAnak = document.getElementById('alamat').value;
    document.getElementById('alamat_ibu').value = alamatAyah || alamatAnak;
}
</script>
@endsection
