@extends('layouts.panel')

@section('title', 'Guru dan Staf | PAUD Haqqul Yaqin')
@section('page-title', 'Guru dan Staf')

@section('panel-content')

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Daftar tenaga pendidik</h2>
            <p class="text-sm text-slate-500">Akun yang terdaftar dapat masuk dan menyusun rapor.</p>
        </div>
        <a href="{{ route('admin.guru.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-center text-xs font-semibold text-white hover:bg-slate-800">
            Tambah Guru / Staf
        </a>
    </div>

    <form action="{{ route('admin.guru.index') }}" method="GET" class="mt-5 flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau kode login"
               class="w-64 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-400 focus:outline-none">
        <button type="submit" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cari</button>
        @if($search)
            <a href="{{ route('admin.guru.index') }}" class="text-sm text-red-600 hover:underline">Reset</a>
        @endif
        <span class="ml-auto text-xs text-slate-500">{{ $gurus->total() }} orang</span>
    </form>

    <div class="mt-4 overflow-hidden rounded-xl border border-orange-100 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-orange-100 bg-orange-50/40 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Kode login</th>
                        <th class="px-4 py-3 font-semibold">Peran</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-50">
                    @forelse($gurus as $g)
                        <tr class="hover:bg-orange-50/30">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ $g->nama_lengkap }}</p>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $g->kode_login }}</td>
                            <td class="px-4 py-3 text-xs text-slate-600">
                                {{ $g->peran === 'admin_guru' ? 'Guru dan staf admin' : 'Guru / pendidik' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.guru.edit', $g->id_pengguna) }}" class="text-xs font-semibold text-blue-700 hover:underline">Ubah</a>
                                    <form action="{{ route('admin.guru.destroy', $g->id_pengguna) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun {{ $g->nama_lengkap }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-400">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($gurus->hasPages())
            <div class="border-t border-orange-100 px-4 py-3">{{ $gurus->links() }}</div>
        @endif
    </div>

@endsection
