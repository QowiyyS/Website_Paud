@extends('layouts.panel')

@section('title', 'Edit Rapor | PAUD Haqqul Yaqin')
@section('page-title', 'Edit Rapor Triwulan')
@section('page-subtitle', 'Koreksi dan pengesahan laporan perkembangan anak')

@section('panel-content')

    <div class="mx-auto max-w-4xl">

        <!-- NOTIFIKASI -->
        @if(session('error'))
            <div class="mb-5 rounded-[2rem] bg-red-50 p-4 text-xs font-extrabold text-red-700 border-2 border-red-200 shadow-sm flex items-center gap-2">
                <span>⚠️</span> {{ session('error') }}
            </div>
        @endif

        <!-- KARTU IDENTITAS RAPOR & SISWA -->
        <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-orange-100 text-3xl shadow-sm ring-1 ring-orange-200">
                        👶
                    </div>
                    <div>
                        <span class="rounded-full bg-orange-100 px-3 py-1 text-[10px] font-black text-orange-800 uppercase tracking-wider">
                            {{ $rapor->periode->nama_periode }} • T.A {{ $rapor->periode->tahun_ajaran }}
                        </span>
                        <h2 class="mt-1.5 text-xl sm:text-2xl font-black text-blue-950">{{ $rapor->anak->nama_anak }}</h2>
                        <p class="text-xs text-slate-500 font-mono mt-0.5">NIS: {{ $rapor->anak->nis }} • Kelompok: <span class="font-bold text-blue-800">{{ $rapor->anak->kelompok }}</span></p>
                    </div>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-[11px] font-extrabold text-slate-400 block uppercase tracking-wider mb-1">Status Rapor:</span>
                    @if($rapor->status_rapor === 'diterbitkan')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-black text-emerald-800 uppercase shadow-sm">
                            <span>✓</span> Diterbitkan (Terpublikasi)
                        </span>
                    @elseif($rapor->status_rapor === 'diajukan')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-4 py-1.5 text-xs font-black text-blue-800 uppercase shadow-sm">
                            <span>⏳</span> Menunggu Pengesahan Kepsek
                        </span>
                    @elseif($rapor->status_rapor === 'perlu_revisi')
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-4 py-1.5 text-xs font-black text-amber-800 uppercase shadow-sm">
                            <span>⚠️</span> Perlu Revisi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-4 py-1.5 text-xs font-black text-slate-600 uppercase shadow-sm">
                            Draf
                        </span>
                    @endif
                </div>
            </div>

            <!-- KOTAK WEWENANG & PETUNJUK -->
            <div class="mt-6 rounded-2xl border-2 p-5 text-xs leading-relaxed {{ $user->isAdmin() ? 'border-blue-200 bg-blue-50/70 text-blue-950' : 'border-orange-200 bg-orange-50/70 text-orange-950' }}">
                @if($user->isAdmin())
                    <p class="font-black flex items-center gap-1.5 text-blue-900 text-sm">
                        <span>👑</span> Wewenang Kepala Sekolah:
                    </p>
                    <p class="mt-1 text-slate-700">
                        Anda dapat memeriksa serta mengoreksi narasi penilaian anak ini. Anda memiliki hak tunggal untuk menekan tombol <strong>"Setujui & Publikasikan Rapor"</strong> agar laporan langsung dapat dilihat dan dicetak oleh orang tua/wali murid, atau meminta revisi jika masih memerlukan perbaikan guru.
                    </p>
                @else
                    <p class="font-black flex items-center gap-1.5 text-orange-900 text-sm">
                        <span>👩‍🏫</span> Wewenang Guru / Pendidik:
                    </p>
                    <p class="mt-1 text-slate-700">
                        Anda dapat mengedit catatan perkembangan anak ini. Sesuai kebijakan PAUD Haqqul Yaqin, <strong>guru tidak dapat mempublikasikan rapor langsung ke wali murid</strong>. Silakan tekan <strong>"Ajukan ke Kepala Sekolah"</strong> agar disahkan.
                    </p>
                @endif
            </div>
        </div>

        <!-- FORMULIR EDIT RAPOR -->
        <form action="{{ route('rapor.update', $rapor->id_rapor) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- BLOK-BLOK ASPEK PENILAIAN -->
            @foreach($rapor->bagian as $bagian)
                <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
                    <div class="flex items-center justify-between border-b-2 border-orange-100 pb-3 mb-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white shadow-sm">
                                {{ $bagian->urutan }}
                            </span>
                            <h3 class="text-sm sm:text-base font-black text-blue-950">
                                {{ $bagian->judul_bagian }}
                            </h3>
                        </div>
                        <span class="text-[10px] font-extrabold text-orange-500 uppercase tracking-widest">Aspek {{ $bagian->urutan }}</span>
                    </div>

                    <div>
                        <label for="narasi_{{ $bagian->urutan }}" class="block text-xs font-extrabold text-slate-600 mb-2">
                            Uraian Narasi Capaian & Catatan Khusus Anak:
                        </label>
                        <textarea
                            name="narasi[{{ $bagian->urutan }}]"
                            id="narasi_{{ $bagian->urutan }}"
                            rows="4"
                            required
                            class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/40 p-4 text-xs font-medium text-slate-800 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 focus:outline-none transition leading-relaxed">{{ old('narasi.'.$bagian->urutan, $bagian->isi_narasi) }}</textarea>
                    </div>
                </div>
            @endforeach

            <!-- TOMBOL AKSI BERDASARKAN ROLE -->
            <div class="rounded-[2.5rem] bg-white p-6 shadow-sm ring-1 ring-orange-200/80">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('rapor.index') }}" class="text-xs font-extrabold text-slate-500 hover:text-slate-800 transition">
                        ← Kembali tanpa simpan
                    </a>

                    <div class="flex flex-wrap items-center justify-end gap-3 w-full sm:w-auto">
                        @if($user->isAdmin())
                            <!-- AKSI KEPALA SEKOLAH -->
                            <button
                                type="submit"
                                name="aksi"
                                value="draf"
                                class="rounded-full bg-slate-100 px-5 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 active:scale-95 transition cursor-pointer">
                                Simpan Catatan Narasi
                            </button>

                            <button
                                type="submit"
                                name="aksi"
                                value="revisi"
                                class="rounded-full bg-amber-50 border-2 border-amber-300 px-5 py-3 text-xs font-extrabold text-amber-800 hover:bg-amber-100 active:scale-95 transition cursor-pointer">
                                ⚠️ Minta Guru Revisi
                            </button>

                            <button
                                type="submit"
                                name="aksi"
                                value="terbitkan"
                                class="rounded-full bg-emerald-600 px-6 py-3 text-xs font-extrabold text-white shadow-md shadow-emerald-300 hover:bg-emerald-700 active:scale-95 transition cursor-pointer flex items-center gap-2">
                                <span>✓</span>
                                <span>Setujui & Publikasikan Rapor</span>
                            </button>

                        @else
                            <!-- AKSI GURU -->
                            <button
                                type="submit"
                                name="aksi"
                                value="draf"
                                class="rounded-full bg-slate-100 px-5 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 active:scale-95 transition cursor-pointer">
                                Simpan Draf
                            </button>

                            <button
                                type="submit"
                                name="aksi"
                                value="ajukan"
                                class="rounded-full bg-blue-600 px-6 py-3 text-xs font-extrabold text-white shadow-md shadow-blue-300 hover:bg-blue-700 active:scale-95 transition cursor-pointer flex items-center gap-2">
                                <span>📤</span>
                                <span>Ajukan ke Kepala Sekolah</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </form>

    </main>

</div>
@endsection
