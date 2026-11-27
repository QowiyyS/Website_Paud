@extends('layouts.panel')

@section('title', 'Pendaftaran Masuk | Panel Admin')
@section('page-title', 'Pendaftaran Siswa Baru (PPDB)')

@section('panel-content')

    <!-- KARTU STATISTIK PENDAFTARAN -->
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6 mb-6">
        <div class="rounded-2xl border border-orange-200/80 bg-white p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-wider text-slate-500">Total Pendaftar</p>
            <p class="mt-1 text-2xl font-black text-blue-950">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-amber-300 bg-amber-50/60 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-wider text-amber-700">Menunggu</p>
            <p class="mt-1 text-2xl font-black text-amber-900">{{ $stats['menunggu'] }}</p>
        </div>
        <div class="rounded-2xl border border-emerald-300 bg-emerald-50/60 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-wider text-emerald-700">Diterima</p>
            <p class="mt-1 text-2xl font-black text-emerald-900">{{ $stats['diterima'] }}</p>
        </div>
        <div class="rounded-2xl border border-rose-300 bg-rose-50/60 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-wider text-rose-700">Ditolak</p>
            <p class="mt-1 text-2xl font-black text-rose-900">{{ $stats['ditolak'] }}</p>
        </div>
        <div class="rounded-2xl border border-blue-200 bg-blue-50/60 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-wider text-blue-700">Program KB</p>
            <p class="mt-1 text-2xl font-black text-blue-950">{{ $stats['kb'] }}</p>
        </div>
        <div class="rounded-2xl border border-purple-200 bg-purple-50/60 p-4 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-wider text-purple-700">Program TK</p>
            <p class="mt-1 text-2xl font-black text-purple-950">{{ $stats['tk'] }}</p>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR -->
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

    <!-- FILTER & PENCARIAN -->
    <div class="rounded-3xl border border-orange-200/80 bg-white p-5 shadow-sm mb-6">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="grid grid-cols-1 gap-3 sm:grid-cols-4">
            <!-- PENCARIAN -->
            <div class="sm:col-span-2">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Cari Nama / No. Registrasi / No. HP</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..."
                       class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2 text-xs font-semibold text-blue-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-300">
            </div>

            <!-- FILTER STATUS -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status Verifikasi</label>
                <select name="status" class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2 text-xs font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- FILTER PROGRAM -->
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Program</label>
                <div class="flex gap-2">
                    <select name="program" class="w-full rounded-xl border border-orange-200 bg-orange-50/20 px-3.5 py-2 text-xs font-semibold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                        <option value="">Semua Program</option>
                        <option value="KB" {{ request('program') === 'KB' ? 'selected' : '' }}>KB (Kelompok Bermain)</option>
                        <option value="TK" {{ request('program') === 'TK' ? 'selected' : '' }}>TK (Taman Kanak-Kanak)</option>
                    </select>
                    <button type="submit" class="rounded-xl bg-orange-500 px-4 py-2 text-xs font-bold text-white hover:bg-orange-600 transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['q', 'status', 'program']))
                        <a href="{{ route('admin.pendaftaran.index') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 transition flex items-center">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- TABEL DATA PENDAFTARAN -->
    <div class="overflow-hidden rounded-3xl border border-orange-200/80 bg-white shadow-sm">
        <div class="border-b border-orange-100 bg-orange-50/40 px-6 py-4 flex items-center justify-between">
            <h3 class="text-sm font-black text-blue-950">Daftar Formulir Pendaftaran</h3>
            <span class="text-xs text-slate-500">Ditemukan <strong>{{ $pendaftaranList->total() }}</strong> berkas</span>
        </div>

        @if($pendaftaranList->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-b border-orange-100 bg-white text-[10px] font-black uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">No. Registrasi</th>
                            <th class="px-5 py-3">Nama Calon Siswa</th>
                            <th class="px-5 py-3">Program</th>
                            <th class="px-5 py-3">Orang Tua / Kontak</th>
                            <th class="px-5 py-3">Tgl Daftar</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-100/70">
                        @foreach($pendaftaranList as $item)
                            <tr class="hover:bg-orange-50/30 transition">
                                <td class="px-5 py-3.5 font-mono font-bold text-blue-950">
                                    {{ $item->nomor_registrasi }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="font-bold text-blue-950">{{ $item->nama_lengkap }}</p>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} · {{ $item->tanggal_lahir ? (int) $item->tanggal_lahir->diffInYears(now()) . ' Tahun' : '-' }}
                                    </p>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-black {{ $item->program === 'KB' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $item->program }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="font-semibold text-slate-800">{{ $item->nama_wali_utama }}</p>
                                    @if($item->kontak_utama && $item->kontak_utama !== '-')
                                        <a href="https://wa.me/{{ $item->kontak_utama }}" target="_blank" class="font-mono text-emerald-700 hover:underline">
                                            +{{ $item->kontak_utama }}
                                        </a>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-slate-500">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="rounded-full border px-2.5 py-0.5 text-[10px] font-bold {{ $item->status_badge_class }}">
                                        {{ $item->status_label }}
                                    </span>
                                    @if($item->id_anak)
                                        <span class="block mt-1 text-[9px] font-bold text-emerald-700">✓ Siswa Aktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.pendaftaran.show', $item->id_pendaftaran) }}"
                                       class="inline-flex items-center gap-1 rounded-xl bg-orange-500 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-orange-600 transition">
                                        <span>Detail</span>
                                        <span>→</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-orange-100 p-4">
                {{ $pendaftaranList->links() }}
            </div>
        @else
            <div class="p-12 text-center text-slate-500">
                <p class="text-3xl mb-2">📂</p>
                <p class="font-bold text-sm text-blue-950">Belum ada formulir pendaftaran.</p>
                <p class="text-xs text-slate-400 mt-1">Pendaftaran online yang diisi oleh calon wali murid akan muncul di halaman ini.</p>
            </div>
        @endif
    </div>

@endsection
