@extends('layouts.panel')

@section('title', 'Detail Pendaftaran ' . $pendaftaran->nomor_registrasi . ' | Panel Admin')
@section('page-title', 'Detail Formulir Pendaftaran')

@section('panel-content')

    <!-- NAVIGASI KEMBALI -->
    <div class="mb-5 flex items-center justify-between">
        <a href="{{ route('admin.pendaftaran.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 transition">
            <span>← Kembali ke Daftar Pendaftaran</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="rounded-full border px-3 py-1 text-xs font-bold {{ $pendaftaran->status_badge_class }}">
                Status: {{ $pendaftaran->status_label }}
            </span>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-bold text-emerald-800 shadow-sm">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-xs font-bold text-red-800 shadow-sm">
            ✕ {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        <!-- KIRI: INFORMASI LENGKAP FORMULIR (8 KOLOM) -->
        <div class="space-y-6 lg:col-span-8">

            <div class="rounded-3xl border border-orange-200/80 bg-white p-5 sm:p-7 shadow-sm">
                <!-- HEADER FORMULIR -->
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-orange-100 pb-4 mb-5">
                    <div>
                        <span class="font-mono text-xs font-bold text-orange-600">
                            {{ $pendaftaran->nomor_registrasi }}
                        </span>
                        <h2 class="text-xl font-black text-blue-950">
                            {{ $pendaftaran->nama_lengkap }}
                        </h2>
                        <p class="text-xs text-slate-500">
                            Didaftarkan pada: {{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB (Jalur {{ ucfirst($pendaftaran->jalur) }})
                        </p>
                    </div>

                    <div>
                        <span class="rounded-full px-3 py-1 text-xs font-black {{ $pendaftaran->program === 'KB' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            Program {{ $pendaftaran->program }} ({{ $pendaftaran->program === 'KB' ? 'Kelompok Bermain' : 'Taman Kanak-Kanak' }})
                        </span>
                    </div>
                </div>

                <!-- I. IDENTITAS SISWA -->
                <h3 class="text-xs font-black uppercase tracking-wider text-orange-600 mb-2.5">
                    I. Identitas Calon Siswa
                </h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 text-xs bg-orange-50/30 p-4 rounded-2xl mb-5">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Nama Lengkap / Panggilan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->nama_lengkap }} ({{ $pendaftaran->nama_panggilan ?: '-' }})</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Jenis Kelamin</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->jenis_kelamin === 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-blue-950">
                            {{ $pendaftaran->tempat_lahir ?: '-' }}, {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Usia Anak</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->usia ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Fisik (BB / TB / Lingkar Kepala)</p>
                        <p class="font-bold text-blue-950">
                            {{ $pendaftaran->berat_badan ?: '-' }} / {{ $pendaftaran->tinggi_badan ?: '-' }} / {{ $pendaftaran->lingkar_kepala ?: '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Anak Ke- / Jumlah Saudara</p>
                        <p class="font-bold text-blue-950">
                            {{ $pendaftaran->anak_ke ? 'Anak ke-' . $pendaftaran->anak_ke : '-' }}
                            {{ $pendaftaran->jumlah_saudara ? 'dari ' . $pendaftaran->jumlah_saudara . ' bersaudara' : '' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Cita-Cita Anak</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->cita_cita ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Hobby Anak</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->hobby ?: '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] font-bold text-slate-500">Riwayat Penyakit</p>
                        <p class="font-bold text-rose-800">{{ $pendaftaran->riwayat_penyakit ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Makanan yang Dihindari</p>
                        <p class="font-bold text-amber-800">{{ $pendaftaran->makanan_dihindari ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Minuman yang Dihindari</p>
                        <p class="font-bold text-amber-800">{{ $pendaftaran->minuman_dihindari ?: 'Tidak ada' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] font-bold text-slate-500">Alamat Tempat Tinggal Anak</p>
                        <p class="font-semibold text-blue-950 leading-relaxed">{{ $pendaftaran->alamat ?: '-' }}</p>
                    </div>
                </div>

                <!-- II. IDENTITAS AYAH -->
                <h3 class="text-xs font-black uppercase tracking-wider text-blue-800 mb-2.5">
                    II. Identitas Orang Tua / Wali — 1. AYAH
                </h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 text-xs bg-blue-50/30 p-4 rounded-2xl mb-5">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Nama Lengkap Ayah</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->nama_ayah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Usia Ayah</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->usia_ayah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->ttl_ayah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Jenjang Pendidikan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->pendidikan_ayah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Pekerjaan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->pekerjaan_ayah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Pendapatan per Bulan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->pendapatan_ayah ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">No. Telpon / WhatsApp Ayah</p>
                        <p class="font-mono font-bold text-emerald-700">
                            {{ $pendaftaran->no_hp_ayah ? '+' . $pendaftaran->no_hp_ayah : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Alamat Ayah</p>
                        <p class="font-semibold text-blue-950">{{ $pendaftaran->alamat_ayah ?: '-' }}</p>
                    </div>
                </div>

                <!-- III. IDENTITAS IBU -->
                <h3 class="text-xs font-black uppercase tracking-wider text-teal-800 mb-2.5">
                    III. Identitas Orang Tua / Wali — 2. IBU
                </h3>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 text-xs bg-teal-50/30 p-4 rounded-2xl mb-5">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Nama Lengkap Ibu</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->nama_ibu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Usia Ibu</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->usia_ibu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Tempat, Tanggal Lahir</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->ttl_ibu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Jenjang Pendidikan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->pendidikan_ibu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Pekerjaan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->pekerjaan_ibu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Pendapatan per Bulan</p>
                        <p class="font-bold text-blue-950">{{ $pendaftaran->pendapatan_ibu ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">No. Telpon / WhatsApp Ibu</p>
                        <p class="font-mono font-bold text-emerald-700">
                            {{ $pendaftaran->no_hp_ibu ? '+' . $pendaftaran->no_hp_ibu : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500">Alamat Ibu</p>
                        <p class="font-semibold text-blue-950">{{ $pendaftaran->alamat_ibu ?: '-' }}</p>
                    </div>
                </div>

                <!-- STATUS SISWA AKTIF -->
                @if($pendaftaran->anak)
                    <div class="rounded-2xl border-2 border-emerald-300 bg-emerald-50/70 p-4">
                        <p class="text-xs font-bold text-emerald-900">
                            ✓ Calon siswa ini telah terdaftar di Data Siswa Aktif:
                        </p>
                        <p class="mt-0.5 text-sm font-black text-emerald-950">
                            NIS: {{ $pendaftaran->anak->nis }} • {{ $pendaftaran->anak->nama_anak }} (Kelompok {{ $pendaftaran->anak->kelompok }})
                        </p>
                        <div class="mt-2">
                            <a href="{{ route('admin.anak.edit', $pendaftaran->anak->id_anak) }}" class="text-xs font-bold text-emerald-800 underline hover:text-emerald-950">
                                Buka Master Data Siswa →
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <!-- KANAN: PANEL AKSI ADMIN (4 KOLOM) -->
        <div class="space-y-6 lg:col-span-4">

            <!-- KOTAK HUBUNGI VIA WHATSAPP -->
            @php
                $kontakHp = $pendaftaran->no_hp_ayah ?: ($pendaftaran->no_hp_ibu ?: '');
            @endphp
            @if($kontakHp)
                <div class="rounded-3xl border border-emerald-200 bg-emerald-50/70 p-5 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-wider text-emerald-900 mb-1.5">
                        Kontak WhatsApp Orang Tua
                    </h3>
                    <p class="text-xs text-emerald-800 leading-relaxed mb-3">
                        Hubungi wali murid (+{{ $kontakHp }}) via WhatsApp untuk konfirmasi berkas atau jadwal observasi tatap muka.
                    </p>
                    <a href="{{ $waUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-black text-white shadow-md hover:bg-emerald-700 transition">
                        <span>💬 Hubungi via WhatsApp</span>
                    </a>
                </div>
            @endif

            <!-- UPDATE STATUS VERIFIKASI -->
            <div class="rounded-3xl border border-orange-200/80 bg-white p-5 shadow-sm">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-500 mb-3">
                    Status Verifikasi
                </h3>

                <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Status Pendaftaran</label>
                        <select name="status" class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3 py-2 text-xs font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="menunggu" {{ $pendaftaran->status === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="diterima" {{ $pendaftaran->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $pendaftaran->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="2" placeholder="Catatan internal panitia..."
                                  class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3 py-2 text-xs text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">{{ old('catatan_admin', $pendaftaran->catatan_admin) }}</textarea>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-blue-900 px-4 py-2 text-xs font-bold text-white hover:bg-blue-950 transition cursor-pointer">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- JADIKAN SISWA AKTIF -->
            @if(!$pendaftaran->id_anak)
                <div class="rounded-3xl border-2 border-orange-300 bg-orange-50/50 p-5 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-wider text-orange-800 mb-1">
                        Terbitkan ke Data Siswa Aktif
                    </h3>
                    <p class="text-[11px] text-slate-600 leading-relaxed mb-3">
                        Masukkan calon siswa ini ke Master Data Siswa PAUD (tabel anak) secara instan.
                    </p>

                    @php
                        $tahun = date('Y');
                        $nextNis = $pendaftaran->program . $tahun . sprintf('%03d', rand(100, 999));
                    @endphp

                    <form action="{{ route('admin.pendaftaran.jadikan-siswa', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Nomor Induk Siswa (NIS) <span class="text-red-500">*</span></label>
                            <input type="text" name="nis" value="{{ old('nis', $nextNis) }}" required
                                   class="w-full rounded-xl border border-orange-200 bg-white px-3 py-2 text-xs font-mono font-bold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        </div>

                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin memasukkan calon siswa ini ke Data Siswa Aktif?')"
                                class="w-full rounded-xl bg-orange-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition cursor-pointer">
                            ✓ Terbitkan ke Siswa Aktif
                        </button>
                    </form>
                </div>
            @endif

            <!-- HAPUS BERKAS PENDAFTARAN -->
            <div class="pt-1">
                <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran->id_pendaftaran) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-center text-xs font-bold text-red-500 hover:text-red-700 transition cursor-pointer">
                        Hapus Data Pendaftaran Ini
                    </button>
                </form>
            </div>

        </div>

    </div>

@endsection
