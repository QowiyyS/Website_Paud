@extends('layouts.panel')

@section('title', 'Input Rapor Baru | PAUD Haqqul Yaqin')
@section('page-title', 'Input Rapor Baru')
@section('page-subtitle', 'Buat laporan perkembangan anak triwulan')

@section('panel-content')

    <div class="mx-auto max-w-4xl">

        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('rapor.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- PILIH SISWA & PERIODE TRIWULAN -->
            <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wider text-orange-600">Identitas</p>
                <h2 class="mb-4 text-lg font-bold text-slate-900">Anak didik dan periode</h2>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="id_anak" class="block text-xs font-extrabold uppercase tracking-wider text-orange-600 mb-2">
                            Pilih Anak Didik:
                        </label>
                        <select name="id_anak" id="id_anak" required class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/50 p-3.5 text-xs font-bold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($anaks as $anak)
                                <option value="{{ $anak->id_anak }}" {{ old('id_anak', $selectedAnak) == $anak->id_anak ? 'selected' : '' }}>
                                    {{ $anak->nama_anak }} (NIS: {{ $anak->nis }} - {{ $anak->kelompok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="id_periode" class="block text-xs font-extrabold uppercase tracking-wider text-orange-600 mb-2">
                            Periode Triwulan:
                        </label>
                        <select name="id_periode" id="id_periode" required class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/50 p-3.5 text-xs font-bold text-blue-950 focus:outline-none focus:ring-2 focus:ring-orange-300">
                            <option value="">-- Pilih Periode Triwulan --</option>
                            @foreach($periodes as $p)
                                <option value="{{ $p->id_periode }}" {{ old('id_periode') == $p->id_periode ? 'selected' : '' }}>
                                    {{ $p->nama_periode }} (T.A {{ $p->tahun_ajaran }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- ASPEK 1: NILAI AGAMA -->
            <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
                <div class="flex items-center gap-3 border-b-2 border-orange-100 pb-3 mb-4">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white shadow-sm">1</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-blue-950">Nilai Agama dan Budi Pekerti</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Pengenalan doa, ibadah harian, adab sopan santun, dan kasih sayang sesama ciptaan.</p>
                    </div>
                </div>
                <textarea
                    name="narasi[1]"
                    rows="3"
                    required
                    placeholder="Contoh: Menunjukkan kemampuan mengenal doa sehari-hari, menirukan gerakan salat, dan bersikap santun..."
                    class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/40 p-4 text-xs font-medium text-slate-800 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 focus:outline-none transition leading-relaxed">{{ old('narasi.1') }}</textarea>
            </div>

            <!-- ASPEK 2: JATI DIRI -->
            <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
                <div class="flex items-center gap-3 border-b-2 border-orange-100 pb-3 mb-4">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white shadow-sm">2</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-blue-950">Jati Diri (Fisik Motorik & Sosial-Emosional)</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Kemandirian, kemampuan berbagi, motorik kasar & halus, serta ekspresi emosi anak.</p>
                    </div>
                </div>
                <textarea
                    name="narasi[2]"
                    rows="3"
                    required
                    placeholder="Contoh: Mampu mengontrol gerakan motorik kasar, aktif bergerak saat senam ceria, dan mampu berbagi dengan teman..."
                    class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/40 p-4 text-xs font-medium text-slate-800 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 focus:outline-none transition leading-relaxed">{{ old('narasi.2') }}</textarea>
            </div>

            <!-- ASPEK 3: LITERASI & SAINS -->
            <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
                <div class="flex items-center gap-3 border-b-2 border-orange-100 pb-3 mb-4">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white shadow-sm">3</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-blue-950">Dasar Literasi, Sains & Seni</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Kosakata, eksplorasi alam, rasa ingin tahu, mewarnai, serta bernyanyi gembira.</p>
                    </div>
                </div>
                <textarea
                    name="narasi[3]"
                    rows="3"
                    required
                    placeholder="Contoh: Mengenal simbol huruf dan angka sederhana, senang mendengarkan dongeng, dan mengeksplorasi warna..."
                    class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/40 p-4 text-xs font-medium text-slate-800 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 focus:outline-none transition leading-relaxed">{{ old('narasi.3') }}</textarea>
            </div>

            <!-- ASPEK 4: CATATAN GURU -->
            <div class="rounded-[2.5rem] bg-white p-6 sm:p-8 shadow-sm ring-1 ring-orange-200/80">
                <div class="flex items-center gap-3 border-b-2 border-orange-100 pb-3 mb-4">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-white shadow-sm">4</span>
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-blue-950">Catatan & Saran Perkembangan Pendidik</h3>
                        <p class="text-[11px] text-slate-500 font-semibold">Pesan kasih sayang dan rekomendasi kegiatan stimulasi di rumah bagi orang tua.</p>
                    </div>
                </div>
                <textarea
                    name="narasi[4]"
                    rows="3"
                    required
                    placeholder="Contoh: Ananda berkembang dengan sangat baik di triwulan ini. Mohon terus didukung kebiasaan membaca buku di rumah..."
                    class="w-full rounded-2xl border-2 border-orange-200/80 bg-[#FFF8ED]/40 p-4 text-xs font-medium text-slate-800 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 focus:outline-none transition leading-relaxed">{{ old('narasi.4') }}</textarea>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="rounded-[2.5rem] bg-white p-6 shadow-sm ring-1 ring-orange-200/80">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('rapor.index') }}" class="text-sm text-slate-500 hover:text-slate-800">
                        Batal
                    </a>

                    <div class="flex flex-wrap items-center justify-end gap-3 w-full sm:w-auto">
                        <button
                            type="submit"
                            name="aksi"
                            value="draf"
                            class="rounded-full bg-slate-100 px-5 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 active:scale-95 transition cursor-pointer">
                            Simpan Sebagai Draf
                        </button>

                        <button
                            type="submit"
                            name="aksi"
                            value="ajukan"
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800 transition cursor-pointer">
                            Ajukan ke Kepala Sekolah
                        </button>

                        @if(auth()->user()->isAdmin())
                            <button
                                type="submit"
                                name="aksi"
                                value="terbitkan"
                                class="rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800 transition cursor-pointer">
                                Terbitkan Langsung
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </form>

    </div>

@endsection
