<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruManagementController extends Controller
{
    /**
     * Tampilkan daftar guru dan staff pengajar.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Pengguna::whereIn('peran', ['guru', 'admin_guru'])
            ->orderBy('nama_lengkap', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('kode_login', 'like', "%{$search}%");
            });
        }

        $gurus = $query->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('gurus', 'search'));
    }

    /**
     * Tampilkan form penambahan guru / staff baru.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Simpan data guru / staff baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'kode_login'   => ['required', 'string', 'alpha_dash', 'max:50', 'unique:pengguna,kode_login'],
            'password'     => ['required', 'string', 'min:6'],
            'peran'        => ['required', Rule::in(['guru', 'admin_guru'])],
        ], [
            'nama_lengkap.required' => 'Nama lengkap guru / staf wajib diisi.',
            'kode_login.required'   => 'Kode login / username wajib diisi.',
            'kode_login.unique'     => 'Kode login / username tersebut sudah digunakan oleh pengguna lain.',
            'kode_login.alpha_dash' => 'Kode login hanya boleh huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'password.required'     => 'Kata sandi awal wajib diisi.',
            'password.min'          => 'Kata sandi minimal terdiri dari 6 karakter.',
            'peran.required'        => 'Pilihan peran / jabatan wajib dipilih.',
        ]);

        Pengguna::create([
            'nama_lengkap'  => $validated['nama_lengkap'],
            'kode_login'    => strtolower($validated['kode_login']),
            'password_hash' => Hash::make($validated['password']),
            'peran'         => $validated['peran'],
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data tenaga pendidik "' . $validated['nama_lengkap'] . '" berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit guru / staff.
     */
    public function edit($id)
    {
        $guru = Pengguna::whereIn('peran', ['guru', 'admin_guru'])->findOrFail($id);

        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Perbarui data guru / staff.
     */
    public function update(Request $request, $id)
    {
        $guru = Pengguna::whereIn('peran', ['guru', 'admin_guru'])->findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'kode_login'   => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique('pengguna', 'kode_login')->ignore($guru->id_pengguna, 'id_pengguna'),
            ],
            'password'     => ['nullable', 'string', 'min:6'],
            'peran'        => ['required', Rule::in(['guru', 'admin_guru'])],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'kode_login.required'   => 'Kode login wajib diisi.',
            'kode_login.unique'     => 'Kode login sudah dipakai oleh pengguna lain.',
            'password.min'          => 'Kata sandi baru minimal 6 karakter jika ingin diubah.',
        ]);

        $guru->nama_lengkap = $validated['nama_lengkap'];
        $guru->kode_login   = strtolower($validated['kode_login']);
        $guru->peran        = $validated['peran'];

        if (!empty($validated['password'])) {
            $guru->password_hash = Hash::make($validated['password']);
        }

        $guru->save();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data pendidik "' . $guru->nama_lengkap . '" berhasil diperbarui.');
    }

    /**
     * Hapus data guru / staff.
     */
    public function destroy($id)
    {
        $guru = Pengguna::whereIn('peran', ['guru', 'admin_guru'])->findOrFail($id);

        // Cek apakah guru sudah membuat rapor untuk mencegah error foreign key
        if ($guru->raporDibuat()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus data pendidik ini karena sudah memiliki riwayat pembuatan rapor anak didik.');
        }

        $nama = $guru->nama_lengkap;
        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data pendidik "' . $nama . '" berhasil dihapus dari sistem.');
    }
}
