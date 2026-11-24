@extends('layouts.app')

@section('title', 'Login Masuk | PAUD Haqqul Yaqin')

@section('content')
<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#FFF8ED] px-4 py-12 sm:px-6 lg:px-8">

    <!-- Ornamen Lingkaran Dekorasi -->
    <div class="pointer-events-none absolute -left-20 -top-20 h-80 w-80 rounded-full bg-orange-300/30 blur-2xl"></div>
    <div class="pointer-events-none absolute -right-20 -bottom-20 h-80 w-80 rounded-full bg-blue-300/30 blur-2xl"></div>

    <div class="relative w-full max-w-md">

        <!-- KARTU LOGIN -->
        <div class="rounded-3xl bg-white p-8 sm:p-10 shadow-xl ring-1 ring-blue-100">

            <!-- LOGO & IDENTITAS -->
            <div class="text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2">
                    <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD" class="h-12 w-12 object-contain">
                    <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan" class="h-12 w-12 object-contain">
                </a>

                <h2 class="mt-4 text-2xl font-black tracking-tight text-blue-950 sm:text-3xl">
                    Portal Masuk
                </h2>
                <p class="mt-1 text-xs font-semibold text-slate-500">
                    PAUD Haqqul Yaqin • Admin, Guru & Wali Murid
                </p>
            </div>

            <!-- NOTIFIKASI ERROR / INFO -->
            @if(session('error'))
                <div class="mt-6 rounded-2xl bg-red-50 p-4 text-xs font-semibold text-red-700 border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mt-6 rounded-2xl bg-blue-50 p-4 text-xs font-semibold text-blue-700 border border-blue-200">
                    {{ session('info') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mt-6 rounded-2xl bg-green-50 p-4 text-xs font-semibold text-green-700 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FORMULIR LOGIN -->
            <form action="{{ route('login.post') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <!-- KODE LOGIN -->
                <div>
                    <label for="kode_login" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kode Login / Username
                    </label>
                    <div class="mt-1.5">
                        <input
                            type="text"
                            name="kode_login"
                            id="kode_login"
                            value="{{ old('kode_login') }}"
                            required
                            autofocus
                            placeholder="Contoh: admin / guru / wali"
                            class="block w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition @error('kode_login') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('kode_login')
                        <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    <div class="mt-1.5">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="••••••••"
                            class="block w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition @error('password') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- REMEMBER ME -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- TOMBOL SUBMIT -->
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-orange-500 py-3.5 text-sm font-extrabold text-white shadow-md shadow-orange-200 transition duration-200 hover:bg-orange-600 active:scale-[0.99] cursor-pointer">
                    Masuk Sekarang →
                </button>
            </form>

            <!-- KEMBALI KE BERANDA -->
            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="text-xs font-bold text-slate-500 hover:text-blue-600 transition">
                    ← Kembali ke Halaman Utama
                </a>
            </div>

        </div>

        <!-- KOTAK AKUN DEMO PENGUJIAN -->
        <div class="mt-6 rounded-2xl bg-white/80 p-5 shadow-sm ring-1 ring-blue-100 backdrop-blur-sm text-xs text-slate-600">
            <p class="font-extrabold text-slate-800 flex items-center gap-1.5 mb-2">
                <span>🔑</span> Akun Uji Coba Cepat:
            </p>
            <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                <div class="rounded-xl bg-blue-50 p-2.5 border border-blue-100">
                    <p class="font-bold text-blue-800">1. Admin (Kepsek)</p>
                    <p class="text-[11px] text-slate-600">User: <code class="bg-white px-1 py-0.5 rounded font-mono font-bold text-blue-600">admin</code></p>
                    <p class="text-[11px] text-slate-600">Pass: <code class="bg-white px-1 py-0.5 rounded font-mono font-bold text-blue-600">admin123</code></p>
                </div>
                <div class="rounded-xl bg-emerald-50 p-2.5 border border-emerald-100">
                    <p class="font-bold text-emerald-800">2. Guru / Staff</p>
                    <p class="text-[11px] text-slate-600">User: <code class="bg-white px-1 py-0.5 rounded font-mono font-bold text-emerald-600">guru</code></p>
                    <p class="text-[11px] text-slate-600">Pass: <code class="bg-white px-1 py-0.5 rounded font-mono font-bold text-emerald-600">guru123</code></p>
                </div>
                <div class="rounded-xl bg-orange-50 p-2.5 border border-orange-100">
                    <p class="font-bold text-orange-800">3. Wali Murid</p>
                    <p class="text-[11px] text-slate-600">User: <code class="bg-white px-1 py-0.5 rounded font-mono font-bold text-orange-600">wali</code></p>
                    <p class="text-[11px] text-slate-600">Pass: <code class="bg-white px-1 py-0.5 rounded font-mono font-bold text-orange-600">wali123</code></p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
