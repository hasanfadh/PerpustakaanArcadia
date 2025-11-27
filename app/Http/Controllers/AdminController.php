<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_admin' => 'required|string',
            'pass_admin' => 'required|string',
        ], [
            'user_admin.required' => 'Username wajib diisi',
            'pass_admin.required' => 'Password wajib diisi',
        ]);

        // Coba login
        $credentials = [
            'user_admin' => $request->user_admin,
            'password' => $request->pass_admin,
        ];

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'user_admin' => 'Username atau password salah.',
        ])->onlyInput('user_admin');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Logout berhasil!');
    }

    /**
     * Dashboard admin
     */
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        // Statistik
        $totalPeminjaman = Peminjaman::count();
        $diproses = Peminjaman::where('status_pinjam', 'DIPROSES')->count();
        $disetujui = Peminjaman::where('status_pinjam', 'DISETUJUI')->count();
        $selesai = Peminjaman::where('status_pinjam', 'SELESAI')->count();
        $totalBuku = Buku::count();

        return view('admin.dashboard', compact('admin', 'totalPeminjaman', 'diproses', 'disetujui', 'selesai', 'totalBuku'));
    }
}