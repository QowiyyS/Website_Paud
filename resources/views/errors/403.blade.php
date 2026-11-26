@extends('layouts.app')

@section('title', '403 | Akses Ditolak')

@section('content')
<div class="flex min-h-screen flex-col items-center justify-center bg-[#FFF8ED] px-6 py-12">
    <div class="relative w-full max-w-lg rounded-3xl bg-white p-8 sm:p-10 text-center shadow-xl ring-1 ring-orange-100">
        <!-- Ikon Peringatan -->
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-4xl text-red-600 shadow-inner">
            🛡️
        </div>

        <span class="mt-6 inline-block rounded-full bg-red-50 px-4 py-1.5 text-xs font-black tracking-widest text-red-600 uppercase">
            Error 403 • Akses Ditolak
        </span>

        <h1 class="mt-4 text-2xl sm:text-3xl font-black text-slate-800">
            Halaman Ini Dibatasi
        </h1>

        <p class="mt-3 text-sm leading-relaxed text-slate-600">
            {{ $exception->getMessage() ?: 'Maaf, akun Anda tidak memiliki hak akses untuk membuka halaman ini. Halaman ini hanya diperuntukkan bagi Admin, Guru, atau Staff berwenang.' }}
        </p>

        @auth
        <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-xs text-slate-600 border border-slate-200">
            <span class="font-bold text-slate-700">Akun Anda saat ini:</span> {{ auth()->user()->nama_lengkap }} 
            <span class="ml-1 inline-block rounded bg-orange-100 px-2 py-0.5 font-bold text-orange-700 uppercase">{{ auth()->user()->peran }}</span>
        </div>
        @endauth

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('landing') }}" class="w-full sm:w-auto rounded-full bg-slate-100 px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-200 transition">
                ← Kembali ke Beranda
            </a>

            @auth
            <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full rounded-full bg-orange-500 px-6 py-3 text-sm font-bold text-white hover:bg-orange-600 shadow-sm transition">
                    Ganti Akun / Logout
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="w-full sm:w-auto rounded-full bg-blue-600 px-6 py-3 text-sm font-bold text-white hover:bg-blue-700 shadow-sm transition">
                Masuk / Login
            </a>
            @endauth
        </div>
    </div>
</div>
@endsection
