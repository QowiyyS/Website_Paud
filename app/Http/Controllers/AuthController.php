<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->peran);
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'kode_login' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ], [
            'kode_login.required' => 'Kode login / username wajib diisi.',
            'password.required'   => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['kode_login' => $credentials['kode_login'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return $this->redirectBasedOnRole($user->peran)
                ->with('success', 'Selamat datang kembali, ' . $user->nama_lengkap . '!');
        }

        return back()->withInput($request->only('kode_login', 'remember'))->withErrors([
            'kode_login' => 'Kode login atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari akun.');
    }

    /**
     * Alihkan pengguna ke dashboard sesuai peran mereka.
     */
    protected function redirectBasedOnRole(string $peran)
    {
        return match ($peran) {
            'admin', 'admin_guru' => redirect()->route('admin.dashboard'),
            'guru'                => redirect()->route('guru.dashboard'),
            'walimurid'           => redirect()->route('wali.dashboard'),
            default               => redirect()->route('landing'),
        };
    }
}
