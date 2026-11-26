@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-[#FFF8ED]">

    <!-- OVERLAY MOBILE -->
    <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR BIRU GELAP (KONTRAS DENGAN BACKGROUND KREM) -->
    <aside id="sidebar" class="fixed left-0 top-0 z-40 flex h-screen w-64 -translate-x-full flex-col bg-blue-950 text-blue-100 shadow-xl transition-transform duration-200 lg:translate-x-0">

        <!-- LOGO GANDA & IDENTITAS (SAMA DENGAN BERANDA) -->
        <div class="border-b border-blue-900/80 px-5 py-5">
            <a href="{{ route('landing') }}" class="flex items-center gap-3">
                <div class="flex shrink-0 items-center gap-1.5 rounded-xl bg-white px-2 py-1.5 shadow-sm">
                    <img src="{{ asset('images/logo-paud.png') }}" alt="Logo PAUD Haqqul Yaqin" class="h-8 w-8 object-contain">
                    <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo Yayasan" class="h-8 w-8 object-contain">
                </div>
                <div class="min-w-0">
                    <p class="truncate text-xs font-black tracking-wide text-white leading-tight">PAUD HAQQUL YAQIN</p>
                    <p class="mt-0.5 text-[9px] font-bold tracking-widest text-orange-400">PANEL ADMINISTRASI</p>
                </div>
            </a>
        </div>

        <!-- NAVIGASI LURUS KE BAWAH -->
        <nav class="flex-1 overflow-y-auto px-3 py-5">
            @php
                $raporMenungguCount = \App\Models\HeadRaport::where('status_rapor', 'diajukan')->count();
                $menu = [
                    ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard'), 'badge' => null],
                    ['label' => 'Data Siswa (KB & TK)', 'url' => route('admin.anak.index'), 'active' => request()->routeIs('admin.anak.*'), 'badge' => null],
                    ['label' => 'Akun & Relasi Wali', 'url' => route('admin.pengguna.index'), 'active' => request()->routeIs('admin.pengguna.*'), 'badge' => null],
                    ['label' => 'Guru & Staf', 'url' => route('admin.guru.index'), 'active' => request()->routeIs('admin.guru.*'), 'badge' => null],
                    ['label' => 'Periode Rapor', 'url' => route('admin.periode.index'), 'active' => request()->routeIs('admin.periode.*'), 'badge' => null],
                    ['label' => 'Pengesahan Rapor', 'url' => route('admin.rapor.index'), 'active' => request()->routeIs('admin.rapor.*'), 'badge' => $raporMenungguCount],
                    ['label' => 'Rapor Triwulan', 'url' => route('rapor.index'), 'active' => request()->routeIs('rapor.*'), 'badge' => null],
                    ['label' => 'Website Publik', 'url' => route('landing'), 'active' => false, 'badge' => null, 'blank' => true],
                ];
            @endphp
            <ul class="flex flex-col space-y-1">
                @foreach($menu as $item)
                    <li>
                        <a href="{{ $item['url'] }}" @if(!empty($item['blank'])) target="_blank" @endif
                           class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition
                                  {{ $item['active']
                                      ? 'bg-orange-500 text-white shadow-md shadow-orange-950/30'
                                      : 'text-blue-200 hover:bg-blue-900 hover:text-white' }}">
                            <span>{{ $item['label'] }}</span>
                            @if(!empty($item['badge']))
                                <span class="rounded-full px-2 py-0.5 text-[11px] font-bold {{ $item['active'] ? 'bg-white text-orange-600' : 'bg-orange-500 text-white' }}">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <!-- PENGGUNA & KELUAR -->
        <div class="border-t border-blue-900/80 bg-blue-900/40 p-4 text-xs">
            <div class="mb-3 px-1">
                <p class="truncate font-bold text-white">{{ auth()->user()->nama_lengkap }}</p>
                <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-wider text-orange-300">
                    {{ auth()->user()->isAdmin() ? 'Kepala Sekolah' : 'Pendidik' }}
                </p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-red-400/30 bg-red-500/10 px-3 py-2.5 text-left font-semibold text-red-300 transition hover:bg-red-500 hover:text-white cursor-pointer">
                    Keluar Sistem
                </button>
            </form>
        </div>

    </aside>

    <!-- AREA KONTEN -->
    <div class="lg:pl-64">

        <!-- HEADER MINIMALIS SELARAS BERANDA -->
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b-2 border-orange-200/70 bg-[#FFF8ED]/95 px-6 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="rounded-xl border border-orange-200 bg-white px-3 py-1.5 text-xs font-bold text-blue-950 shadow-sm lg:hidden">
                    Menu
                </button>
                <div>
                    <h1 class="text-sm font-black uppercase tracking-wider text-blue-950">@yield('page-title')</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="rounded-full border border-orange-200 bg-white px-3.5 py-1 text-xs font-bold text-orange-600 shadow-sm">
                    Tahun Ajaran 2026/2027
                </span>
            </div>
        </header>

        <!-- KONTEN -->
        <main class="p-6 lg:p-8">
            @yield('panel-content')
        </main>

    </div>

</div>

<script>
function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebar-overlay');
    s.classList.toggle('-translate-x-full');
    o.classList.toggle('hidden');
}
</script>
@endsection
