<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PeminjamController extends Controller
{
    /**
     * Menampilkan halaman form registrasi
     */
    public function showRegistrationForm()
    {
        return view('peminjam.register');
    }

    /**
     * Proses registrasi peminjam baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_peminjam' => 'required|string|max:150',
            'user_peminjam' => 'required|string|max:50|unique:peminjams,user_peminjam',
            'pass_peminjam' => 'required|string|min:6|confirmed',
            'foto_peminjam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ], [
            'nama_peminjam.required' => 'Nama peminjam wajib diisi',
            'user_peminjam.required' => 'Username wajib diisi',
            'user_peminjam.unique' => 'Username sudah digunakan',
            'pass_peminjam.required' => 'Password wajib diisi',
            'pass_peminjam.min' => 'Password minimal 6 karakter',
            'pass_peminjam.confirmed' => 'Konfirmasi password tidak cocok',
            'foto_peminjam.image' => 'File harus berupa gambar',
            'foto_peminjam.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto_peminjam.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto_peminjam')) {
            $fotoPath = $request->file('foto_peminjam')->store('foto_peminjam', 'public');
        }

        // Simpan data peminjam
        $peminjam = Peminjam::create([
            'nama_peminjam' => $request->nama_peminjam,
            'tgl_daftar' => now()->toDateString(),
            'user_peminjam' => $request->user_peminjam,
            'pass_peminjam' => Hash::make($request->pass_peminjam),
            'foto_peminjam' => $fotoPath,
            'status_peminjam' => true,
        ]);

        // Auto login setelah registrasi berhasil
        Auth::guard('peminjam')->login($peminjam);

        return redirect()->route('peminjam.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di Perpustakaan Arcadia.');
    }

    /**
     * Menampilkan halaman login peminjam
     */
    public function showLoginForm()
    {
        return view('peminjam.login');
    }

    /**
     * Proses login peminjam
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_peminjam' => 'required|string',
            'pass_peminjam' => 'required|string',
        ], [
            'user_peminjam.required' => 'Username wajib diisi',
            'pass_peminjam.required' => 'Password wajib diisi',
        ]);

        // Coba login
        $credentials = [
            'user_peminjam' => $request->user_peminjam,
            'password' => $request->pass_peminjam,
        ];

        if (Auth::guard('peminjam')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('peminjam.dashboard'))
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'user_peminjam' => 'Username atau password salah.',
        ])->onlyInput('user_peminjam');
    }

    /**
     * Logout peminjam
     */
    public function logout(Request $request)
    {
        Auth::guard('peminjam')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('peminjam.login')
            ->with('success', 'Logout berhasil!');
    }

    /**
     * Dashboard peminjam
     */
    public function dashboard()
    {
        $peminjam = Auth::guard('peminjam')->user();
        
        // Ambil riwayat peminjaman
        $peminjamans = $peminjam->peminjamans()
            ->with('bukus')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjam.dashboard', compact('peminjam', 'peminjamans'));
    }
}