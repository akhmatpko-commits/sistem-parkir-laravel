<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class AuthController extends Controller
{
    // Mengarahkan pengguna yang sudah login
    private function redirectByRole()
    {
        $role = Auth::user()->role;

        if ($role === 'owner') {
            return redirect()->route('owner.dashboard');
        }

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        Auth::logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Role pengguna tidak dikenali.',
        ]);
    }

    // Menampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            ActivityLogger::log(
                'LOGIN',
                'Autentikasi',
                'Pengguna berhasil login'
            );

            return $this->redirectByRole();
        }

        ActivityLogger::log(
            'LOGIN GAGAL',
            'Autentikasi',
            'Percobaan login gagal untuk email: ' . $request->email
        );

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        ActivityLogger::log(
            'LOGOUT',
            'Autentikasi',
            'Pengguna berhasil logout'
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
