@extends('layouts.app')

@section('title', 'Beranda | PAUD Haqqul Yaqin')

@section('content')

<!-- ================= NAVBAR ================= -->
<header class="sticky top-0 z-50 border-b-4 border-orange-200 bg-[#FFF8ED]/95 shadow-sm backdrop-blur-md">
    <nav class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-4 lg:px-8">

        <!-- IDENTITAS SEKOLAH -->
        <a href="#beranda" class="group relative flex shrink-0 items-center gap-3">

            <span class="absolute -right-1 -top-2 text-lg text-orange-400 transition group-hover:rotate-45">
                ✦
            </span>

            <div class="flex items-center gap-2 rounded-2xl bg-white px-3 py-2 shadow-sm ring-1 ring-blue-100">
                <img
                    src="{{ asset('images/logo-paud.png') }}"
                    alt="Logo PAUD Haqqul Yaqin"
                    class="h-12 w-12 object-contain">

                <img
                    src="{{ asset('images/logo-yayasan.png') }}"
                    alt="Logo Yayasan Hidayatullah Haqqul Yaqin"
                    class="h-12 w-12 object-contain">
            </div>

            <div>
                <h1 class="text-base font-black tracking-wide text-blue-800 sm:text-lg">
                    PAUD HAQQUL YAQIN
                </h1>

                <p class="mt-1 text-[10px] font-bold tracking-widest text-orange-500 sm:text-xs">
                    BELAJAR • BERMAIN • BERTUMBUH
                </p>
            </div>
        </a>

        <!-- MENU NAVIGASI -->
        <div class="flex flex-wrap items-center justify-center gap-1 rounded-full bg-white p-1.5 shadow-sm ring-1 ring-blue-100" id="nav-container">

            <a href="#beranda"
                class="nav-menu-link rounded-full bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition duration-200 active:scale-95 hover:bg-blue-700">
                Beranda
            </a>

            <a href="#tentang"
                class="nav-menu-link rounded-full px-4 py-2.5 text-sm font-semibold text-slate-600 transition duration-200 active:scale-95 hover:bg-orange-100 hover:text-orange-700">
                Tentang Kami
            </a>

            <a href="#program"
                class="nav-menu-link rounded-full px-4 py-2.5 text-sm font-semibold text-slate-600 transition duration-200 active:scale-95 hover:bg-orange-100 hover:text-orange-700">
                Program
            </a>

            <a href="#pendaftaran"
                class="nav-menu-link rounded-full px-4 py-2.5 text-sm font-semibold text-slate-600 transition duration-200 active:scale-95 hover:bg-orange-100 hover:text-orange-700">
                Pendaftaran
            </a>
        </div>

        <!-- TOMBOL LOGIN / PORTAL -->
        @auth
            <a href="{{ auth()->user()->peran === 'admin' ? route('admin.dashboard') : (auth()->user()->peran === 'guru' ? route('guru.dashboard') : route('wali.dashboard')) }}"
                class="group inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-3 text-sm font-extrabold text-white shadow-md shadow-blue-200 transition duration-300 hover:-translate-y-1 hover:bg-blue-700 hover:shadow-lg">
                Dashboard ({{ auth()->user()->peran }})
                <span class="transition group-hover:translate-x-1">→</span>
            </a>
        @else
            <a href="{{ route('login') }}"
                class="group inline-flex items-center gap-2 rounded-full bg-orange-500 px-6 py-3 text-sm font-extrabold text-white shadow-md shadow-orange-200 transition duration-300 hover:-translate-y-1 hover:bg-orange-600 hover:shadow-lg">
                Portal Masuk / Login
                <span class="transition group-hover:translate-x-1">→</span>
            </a>
        @endauth

    </nav>
</header>


<main>

    <!-- ================= HERO SECTION ================= -->
    <section
        id="beranda"
        class="relative isolate min-h-[620px] overflow-hidden bg-blue-900 scroll-mt-24">
        <!-- FOTO GEDUNG PAUD -->
        <img
            src="{{ asset('images/paud-haqqul-yaqin.jpg') }}"
            alt="Gedung PAUD Haqqul Yaqin"
            class="absolute inset-0 z-0 h-full w-full object-cover object-center">

        <!-- OVERLAY FOTO -->
        <div class="absolute inset-0 z-0 bg-gradient-to-r from-blue-950/90 via-blue-900/75 to-blue-900/35"></div>

        <!-- DEKORASI LINGKARAN -->
        <div class="pointer-events-none absolute -right-20 -top-24 z-0 h-72 w-72 rounded-full border-[35px] border-orange-400/30"></div>

        <div class="pointer-events-none absolute -bottom-24 -left-20 z-0 h-64 w-64 rounded-full bg-orange-400/20"></div>

        <!-- ORNAMEN -->
        <div class="pointer-events-none absolute right-[12%] top-24 z-10 hidden text-5xl text-orange-300 sm:block">
            ✦
        </div>

        <div class="pointer-events-none absolute bottom-32 right-[8%] z-10 hidden text-3xl text-white/80 sm:block">
            ✧
        </div>

        <div class="pointer-events-none absolute left-[45%] top-20 z-10 hidden text-2xl text-orange-300 sm:block">
            ✦
        </div>

        <!-- KONTEN HERO -->
        <div class="relative z-10 mx-auto flex min-h-[620px] max-w-7xl items-center px-6 py-20 lg:px-8">

            <div class="max-w-3xl">

                <!-- LABEL -->
                <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-5 py-2.5 shadow-lg backdrop-blur-md">

                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-orange-400 text-sm text-white">
                        ✦
                    </span>

                    <span class="text-sm font-bold tracking-wide text-white">
                        Selamat Datang di PAUD Haqqul Yaqin
                    </span>

                </div>

                <!-- JUDUL -->
                <h2 class="mt-8 text-4xl font-black leading-[1.15] tracking-tight text-white sm:text-5xl lg:text-6xl">

                    Tempat Kecil untuk

                    <span class="relative inline-block text-orange-400">
                        Mimpi Besar!
                        <span class="absolute -bottom-2 left-0 h-2 w-full rounded-full bg-orange-400/50"></span>
                    </span>

                    <span class="mt-2 block">
                        Si Kecil Bertumbuh.
                    </span>

                </h2>

                <!-- DESKRIPSI -->
                <p class="mt-8 max-w-2xl text-base leading-8 text-blue-50 sm:text-lg">
                    Setiap anak memiliki potensi dan keistimewaan.

                    Mari tumbuh, belajar, bermain, dan mengenal dunia
                    bersama PAUD Haqqul Yaqin dalam suasana belajar
                    yang menyenangkan.
                </p>

                <!-- TOMBOL -->
                <div class="mt-9 flex flex-wrap gap-4">

                    <a
                        href="#program"
                        class="inline-flex items-center gap-3 rounded-full bg-orange-500 px-8 py-4 text-sm font-extrabold text-white shadow-lg shadow-orange-900/20 transition duration-300 hover:-translate-y-1 hover:bg-orange-600">

                        Jelajahi Program
                        <span class="text-lg">→</span>
                    </a>

                    <a
                        href="#tentang"
                        class="rounded-full border-2 border-white/80 bg-white/10 px-8 py-4 text-sm font-bold text-white backdrop-blur-sm transition duration-300 hover:bg-white hover:text-blue-900">

                        Kenali Sekolah Kami
                    </a>

                </div>

            </div>
        </div>


        <!-- PEMBATAS GELOMBANG HERO -->
        <div class="absolute bottom-0 left-0 z-20 w-full overflow-hidden leading-none">
            <svg
                class="block h-24 w-full md:h-32"
                viewBox="0 0 1440 150"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg">

                <!-- Bidang putih -->
                <path
                    d="M0 85
               C180 75 230 110 420 112
               C650 115 790 90 960 65
               C1140 38 1300 25 1440 12
               L1440 150 L0 150 Z"
                    fill="#FFF8ED" />

                <!-- Garis oranye melengkung -->
                <path
                    d="M0 85
               C120 85 175 105 250 65
               C310 32 285 0 250 8
               C210 18 220 65 270 88
               C320 112 390 116 470 112"
                    fill="none"
                    stroke="#F97316"
                    stroke-width="10"
                    stroke-linecap="round" />

                <!-- Garis kuning -->
                <path
                    d="M470 112
               C720 105 900 72 1080 45
               C1220 25 1340 18 1440 12"
                    fill="none"
                    stroke="#FBBF24"
                    stroke-width="9"
                    stroke-linecap="round" />

            </svg>
        </div>

    </section>


    <!-- ================= TENTANG KAMI ================= -->
    <section id="tentang" class="relative overflow-hidden bg-[#FFF8ED] px-6 pb-36 pt-20 lg:pt-24 scroll-mt-24">

        <!-- DEKORASI BACKGROUND -->
        <div class="pointer-events-none absolute -left-20 top-20 h-56 w-56 rounded-full bg-blue-200/40"></div>

        <div class="pointer-events-none absolute -right-16 bottom-10 h-48 w-48 rounded-full bg-orange-200/50"></div>

        <div class="relative mx-auto max-w-7xl">

            <!-- JUDUL SECTION -->
            <div class="mx-auto max-w-3xl text-center">

                <span class="inline-block rounded-lg bg-[#FFE5CC] px-5 py-2 text-3xl font-bold text-[#E87924] md:text-4xl lg:text-5xl">
                    Tentang Kami
                </span>

                <h2 class="mt-5 text-3xl font-extrabold leading-tight text-blue-950 sm:text-4xl">
                    Setiap Anak Berhak Mendapatkan Awal yang Baik
                </h2>

                <p class="mt-5 leading-8 text-slate-600">
                    PAUD Haqqul Yaqin merupakan lembaga pendidikan
                    anak usia dini yang menyediakan program Kelompok
                    Bermain dan Taman Kanak-Kanak. Kami menghadirkan
                    lingkungan belajar yang menyenangkan untuk mendukung
                    proses tumbuh kembang setiap anak.
                </p>

            </div>


            <!-- KARTU KEUNGGULAN -->
            <div class="mt-14 grid gap-8 md:grid-cols-3">

                <!-- KARTU 1: PENUH KEPEDULIAN -->
                <div class="group overflow-hidden rounded-[2rem] bg-white shadow-md transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                    <!-- FOTO -->
                    <div class="relative h-56 overflow-hidden bg-blue-100">

                        <img
                            src="{{ asset('images/penuh_kepedulian.jpg') }}"
                            alt="Kegiatan anak-anak bersama pendamping PAUD"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                        <!-- EFEK BUBBLE DEKORATIF -->
                        <div class="pointer-events-none absolute -left-10 -top-12 z-[1] h-36 w-36 rounded-full bg-orange-200/50"></div>

                        <div class="pointer-events-none absolute -right-10 -top-10 z-[1] h-32 w-32 rounded-full bg-sky-200/40"></div>

                        <div class="pointer-events-none absolute right-16 top-24 z-[1] h-12 w-12 rounded-full bg-yellow-200/30 blur-sm"></div>


                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 via-transparent to-transparent"></div>

                        <span class="absolute bottom-4 left-5 rounded-full bg-white/90 px-4 py-2 text-xs font-extrabold text-blue-800">
                            Penuh Kepedulian
                        </span>

                        <span class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-xl text-white shadow-lg">
                            ♡
                        </span>

                    </div>

                    <!-- DESKRIPSI -->
                    <div class="p-7">

                        <h3 class="text-xl font-extrabold text-blue-950">
                            Penuh Kepedulian
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-600">
                            Menghargai setiap anak sebagai individu yang unik
                            dengan potensi masing-masing, serta menciptakan
                            lingkungan yang penuh perhatian dan kasih sayang.
                        </p>

                        <div class="mt-5 h-1.5 w-16 rounded-full bg-blue-500"></div>

                    </div>

                </div>


                <!-- KARTU 2: BELAJAR MENYENANGKAN -->
                <div class="group overflow-hidden rounded-[2rem] bg-white shadow-md transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                    <!-- FOTO -->
                    <div class="relative h-56 overflow-hidden bg-orange-100">

                        <img
                            src="{{ asset('images/belajar_menyenangkan.jpg') }}"
                            alt="Anak-anak mengikuti permainan edukatif"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                        <!-- EFEK BUBBLE DEKORATIF -->
                        <div class="pointer-events-none absolute -left-10 -top-12 z-[1] h-36 w-36 rounded-full bg-orange-200/50"></div>

                        <div class="pointer-events-none absolute -right-10 -top-10 z-[1] h-32 w-32 rounded-full bg-sky-200/40"></div>

                        <div class="pointer-events-none absolute right-16 top-24 z-[1] h-12 w-12 rounded-full bg-yellow-200/30 blur-sm"></div>


                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 via-transparent to-transparent"></div>

                        <span class="absolute bottom-4 left-5 rounded-full bg-white/90 px-4 py-2 text-xs font-extrabold text-orange-700">
                            Belajar Menyenangkan
                        </span>

                        <span class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500 text-xl text-white shadow-lg">
                            ✦
                        </span>

                    </div>

                    <!-- DESKRIPSI -->
                    <div class="p-7">

                        <h3 class="text-xl font-extrabold text-blue-950">
                            Belajar Menyenangkan
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-600">
                            Memberikan ruang bagi anak untuk mengenal,
                            bermain, bereksplorasi, dan memperoleh pengalaman
                            belajar yang menyenangkan.
                        </p>

                        <div class="mt-5 h-1.5 w-16 rounded-full bg-orange-500"></div>

                    </div>

                </div>


                <!-- KARTU 3: MENDUKUNG POTENSI -->
                <div class="group overflow-hidden rounded-[2rem] bg-white shadow-md transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                    <!-- FOTO -->
                    <div class="relative h-56 overflow-hidden bg-blue-100">

                        <img
                            src="{{ asset('images/mendukung_potensi.jpg') }}"
                            alt="Kegiatan untuk mendukung potensi anak"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                        <!-- EFEK BUBBLE DEKORATIF -->
                        <div class="pointer-events-none absolute -left-10 -top-12 z-[1] h-36 w-36 rounded-full bg-orange-200/50"></div>

                        <div class="pointer-events-none absolute -right-10 -top-10 z-[1] h-32 w-32 rounded-full bg-sky-200/40"></div>

                        <div class="pointer-events-none absolute right-16 top-24 z-[1] h-12 w-12 rounded-full bg-yellow-200/30 blur-sm"></div>


                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 via-transparent to-transparent"></div>

                        <span class="absolute bottom-4 left-5 rounded-full bg-white/90 px-4 py-2 text-xs font-extrabold text-blue-800">
                            Mendukung Potensi
                        </span>

                        <span class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-xl text-white shadow-lg">
                            ☆
                        </span>

                    </div>

                    <!-- DESKRIPSI -->
                    <div class="p-7">

                        <h3 class="text-xl font-extrabold text-blue-950">
                            Mendukung Potensi
                        </h3>

                        <p class="mt-3 text-sm leading-7 text-slate-600">
                            Mendukung perkembangan dan pembelajaran
                            sesuai tahap tumbuh kembang, minat,
                            serta kemampuan setiap anak.
                        </p>

                        <div class="mt-5 h-1.5 w-16 rounded-full bg-blue-500"></div>

                    </div>

                </div>

            </div>

        </div>

        <!-- GELOMBANG PEMBATAS TENTANG KAMI - PROGRAM -->
        <div class="pointer-events-none absolute bottom-0 left-0 z-20 w-full overflow-hidden leading-none">
            <svg
                class="block h-24 w-full md:h-32"
                viewBox="0 0 1440 120"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg">

                <path
                    d="M0 35
               C180 95 300 95 480 55
               C660 15 790 15 960 55
               C1140 100 1300 95 1440 35
               L1440 120 L0 120 Z"
                    fill="#FFFFFF" />

            </svg>
        </div>

    </section>



    <!-- ================= PROGRAM PENDIDIKAN ================= -->
    <section id="program" class="relative overflow-hidden bg-white px-6 pb-36 pt-20 lg:pt-24 scroll-mt-24">

        <!-- ORNAMEN -->
        <div class="pointer-events-none absolute -left-16 top-20 h-40 w-40 rounded-full bg-orange-100"></div>
        <div class="pointer-events-none absolute -right-16 bottom-10 h-48 w-48 rounded-full bg-blue-100"></div>

        <div class="relative mx-auto max-w-7xl">

            <!-- JUDUL SECTION -->
            <div class="text-center">

                <span class="inline-block rounded-lg bg-[#FFE5CC] px-5 py-2 text-3xl font-bold text-[#E87924] md:text-4xl lg:text-5xl">
                    Program Pendidikan
                </span>

                <h2 class="mt-5 text-3xl font-extrabold text-blue-950 sm:text-4xl">
                    Pilihan Program untuk Si Kecil
                </h2>

                <p class="mx-auto mt-4 max-w-2xl leading-8 text-slate-600">
                    PAUD Haqqul Yaqin menyediakan program pendidikan
                    untuk mendukung perjalanan belajar anak usia dini.
                </p>

            </div>


            <!-- KARTU PROGRAM -->
            <div class="mt-14 grid gap-8 md:grid-cols-2">

                <!-- ================= PROGRAM KB ================= -->
                <div class="overflow-hidden rounded-[2rem] bg-orange-50 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                    <!-- FOTO DAN DEKORASI KB -->
                    <div class="relative flex h-52 items-center justify-center overflow-hidden bg-orange-100">

                        <!-- FOTO BACKGROUND -->
                        <img
                            src="{{ asset('images/fotoprogramKB.jpg') }}"
                            alt="Kegiatan Program Kelompok Bermain"
                            class="absolute inset-0 z-0 h-full w-full object-cover opacity-55">

                        <!-- LAPISAN WARNA -->
                        <div class="absolute inset-0 z-[1] bg-orange-100/25"></div>

                        <!-- BUBBLE DEKORASI -->
                        <div class="absolute -left-8 -top-10 z-[2] h-36 w-36 rounded-full bg-orange-200/65"></div>

                        <div class="absolute -bottom-12 -right-8 z-[2] h-40 w-40 rounded-full bg-yellow-200/65"></div>

                        <!-- IKON UTAMA -->
                        <div class="relative z-10 flex h-28 w-28 items-center justify-center rounded-full bg-orange-500 text-5xl text-white shadow-lg">
                            ☀
                        </div>

                        <!-- ORNAMEN -->
                        <span class="absolute right-8 top-7 z-10 text-3xl text-orange-500">
                            ✦
                        </span>

                    </div>


                    <!-- DESKRIPSI KB -->
                    <div class="p-8">

                        <span class="rounded-full bg-orange-200 px-4 py-2 text-xs font-bold text-orange-800">
                            PROGRAM 01
                        </span>

                        <h3 class="mt-5 text-2xl font-extrabold text-blue-950">
                            Kelompok Bermain (KB)
                        </h3>

                        <p class="mt-4 leading-8 text-slate-600">
                            Program yang mendukung tahap awal pengalaman
                            belajar anak melalui kegiatan bermain,
                            interaksi, dan eksplorasi lingkungan.
                        </p>

                    </div>

                </div>


                <!-- ================= PROGRAM TK ================= -->
                <div class="overflow-hidden rounded-[2rem] bg-blue-50 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                    <!-- FOTO DAN DEKORASI TK -->
                    <div class="relative flex h-52 items-center justify-center overflow-hidden bg-blue-100">

                        <!-- FOTO BACKGROUND -->
                        <img
                            src="{{ asset('images/fotoprogramTK.jpg') }}"
                            alt="Kegiatan Program Taman Kanak-Kanak"
                            class="absolute inset-0 z-0 h-full w-full object-cover opacity-55">

                        <!-- LAPISAN WARNA -->
                        <div class="absolute inset-0 z-[1] bg-blue-100/25"></div>

                        <!-- BUBBLE DEKORASI -->
                        <div class="absolute -left-8 -top-10 z-[2] h-36 w-36 rounded-full bg-blue-200/65"></div>

                        <div class="absolute -bottom-12 -right-8 z-[2] h-40 w-40 rounded-full bg-sky-200/65"></div>

                        <!-- IKON UTAMA -->
                        <div class="relative z-10 flex h-28 w-28 items-center justify-center rounded-full bg-blue-600 text-5xl text-white shadow-lg">
                            ★
                        </div>

                        <!-- ORNAMEN -->
                        <span class="absolute right-8 top-7 z-10 text-3xl text-blue-500">
                            ✧
                        </span>

                    </div>


                    <!-- DESKRIPSI TK -->
                    <div class="p-8">

                        <span class="rounded-full bg-blue-200 px-4 py-2 text-xs font-bold text-blue-800">
                            PROGRAM 02
                        </span>

                        <h3 class="mt-5 text-2xl font-extrabold text-blue-950">
                            Taman Kanak-Kanak (TK)
                        </h3>

                        <p class="mt-4 leading-8 text-slate-600">
                            Program yang mendukung perkembangan anak
                            melalui pengalaman belajar, pengenalan
                            lingkungan, dan kegiatan edukatif.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- GELOMBANG PEMBATAS PROGRAM - PENDAFTARAN -->
        <div class="pointer-events-none absolute bottom-0 left-0 z-20 w-full overflow-hidden leading-none">

            <svg
                class="block h-24 w-full md:h-32"
                viewBox="0 0 1440 120"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg">

                <path
                    d="M0 35
                   C180 95 300 95 480 55
                   C660 15 790 15 960 55
                   C1140 100 1300 95 1440 35
                   L1440 120 L0 120 Z"
                    fill="#FFF8ED" />

            </svg>

        </div>

    </section>



    <!-- ================= PENDAFTARAN ================= -->
    <section id="pendaftaran" class="relative overflow-hidden bg-[#FFF8ED] px-4 py-20 sm:px-6 lg:py-24 scroll-mt-24">

        <!-- DEKORASI KECIL -->
        <div class="pointer-events-none absolute left-[8%] top-12 h-5 w-5 rounded-full bg-[#FFB45E]/40"></div>

        <div class="pointer-events-none absolute right-[10%] bottom-16 h-7 w-7 rounded-full bg-[#A9D2E6]/50"></div>

        <div class="relative mx-auto max-w-5xl">

            <!-- BACKGROUND PERSEGI PANJANG DENGAN OUTLINE BERGELOMBANG -->
            <svg
                class="pointer-events-none absolute inset-0 h-full w-full"
                viewBox="0 0 1000 400"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">

                <path
                    d="
                    M 75,45
                    C 105,15 145,15 180,32
                    C 215,49 245,45 280,28
                    C 315,10 355,15 390,32
                    C 425,49 460,48 495,29
                    C 530,10 570,15 605,32
                    C 640,49 675,48 710,29
                    C 745,10 785,15 820,32
                    C 855,49 895,45 925,45
                    C 955,45 965,75 950,100
                    C 935,125 935,155 952,180
                    C 969,205 965,235 945,255
                    C 925,275 925,305 942,330
                    C 959,355 940,380 910,370
                    C 875,360 845,360 810,377
                    C 775,394 735,390 700,373
                    C 665,356 630,357 595,375
                    C 560,393 520,390 485,373
                    C 450,356 415,357 380,375
                    C 345,393 305,390 270,373
                    C 235,356 200,357 165,375
                    C 130,393 90,380 80,355
                    C 70,330 65,305 48,285
                    C 31,265 35,235 52,210
                    C 69,185 69,155 52,130
                    C 35,105 45,65 75,45
                    Z
                    "
                    fill="#DCEEF7"
                    stroke="#A9D2E6"
                    stroke-width="4"
                    vector-effect="non-scaling-stroke" />

            </svg>


            <!-- ISI BANNER -->
            <div class="relative z-10 flex min-h-[320px] flex-col items-center justify-center px-8 py-20 text-center sm:min-h-[360px] sm:px-20">

                <span class="mb-4 inline-flex items-center rounded-full bg-white/70 px-5 py-2 text-xs font-bold uppercase tracking-[0.2em] text-[#35627D] sm:text-sm">
                    Pendaftaran Peserta Didik
                </span>

                <h2 class="max-w-2xl text-2xl font-extrabold leading-tight text-[#245477] sm:text-3xl lg:text-4xl">
                    Yuk, Mulai Perjalanan Belajar Si Kecil Bersama Kami!
                </h2>

                <p class="mt-4 max-w-xl text-sm leading-relaxed text-[#45677D] sm:text-base">
                    Berikan pengalaman belajar yang menyenangkan, penuh kasih sayang,
                    dan mendukung tumbuh kembang anak sejak dini.
                </p>

                <a
                    href="#pendaftaran"
                    class="mt-7 inline-flex items-center gap-2 rounded-full bg-[#FF8A24] px-7 py-3.5 text-sm font-bold text-white shadow-md transition duration-300 hover:-translate-y-1 hover:bg-[#F47B12] hover:shadow-lg">

                    Informasi Pendaftaran
                    <span aria-hidden="true">→</span>
                </a>

            </div>

        </div>

    </section>

</main>


<!-- ================= FOOTER ================= -->
<footer class="relative ml-0 overflow-hidden bg-blue-950 px-6 py-10 text-white">

    <!-- GELOMBANG ATAS -->
    <div class="absolute left-0 top-0 w-full overflow-hidden leading-none">

        <svg
            class="block h-8 w-full"
            viewBox="0 0 1440 60"
            preserveAspectRatio="none"
            xmlns="http://www.w3.org/2000/svg">

            <path
                d="M0,30 C180,70 320,0 500,30 C700,65 850,5 1050,30 C1220,60 1340,5 1440,30 L1440,0 L0,0 Z"
                fill="#FFF8ED" />

        </svg>

    </div>

    <div class="relative mx-auto max-w-7xl pt-8">

        <div class="flex flex-col justify-between gap-8 md:flex-row md:items-center">

            <div>
                <h2 class="text-xl font-extrabold">
                    PAUD Haqqul Yaqin
                </h2>

                <p class="mt-2 text-sm text-blue-200">
                    Pendidikan Anak Usia Dini
                </p>
            </div>

            <div class="flex flex-wrap gap-6 text-sm text-blue-100">

                <a href="#beranda" class="transition hover:text-orange-400">
                    Beranda
                </a>

                <a href="#tentang" class="transition hover:text-orange-400">
                    Tentang Kami
                </a>

                <a href="#program" class="transition hover:text-orange-400">
                    Program
                </a>

                <a href="#pendaftaran" class="transition hover:text-orange-400">
                    Pendaftaran
                </a>

            </div>

        </div>

        <div class="mt-8 border-t border-blue-800 pt-6 text-center text-xs text-blue-300">
            &copy; {{ date('Y') }} PAUD Haqqul Yaqin. All rights reserved.
        </div>

    </div>

</footer>

@endsection