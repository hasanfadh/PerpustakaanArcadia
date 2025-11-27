<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\DetilPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar buku untuk dipilih
     */
    public function index()
    {
        $bukus = Buku::orderBy('judul_buku')->paginate(10);
        
        // Ambil cart dari session (keranjang buku yang akan dipinjam)
        $cart = session()->get('cart', []);
        
        return view('peminjaman.index', compact('bukus', 'cart'));
    }

    /**
     * Tambah buku ke keranjang peminjaman
     */
    public function addToCart(Request $request, $id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        
        // Ambil cart dari session
        $cart = session()->get('cart', []);
        
        // Cek apakah buku sudah ada di cart
        if (isset($cart[$id_buku])) {
            return back()->with('info', 'Buku "' . $buku->judul_buku . '" sudah ada di keranjang.');
        }
        
        // Tambahkan buku ke cart
        $cart[$id_buku] = [
            'id_buku' => $buku->id_buku,
            'judul_buku' => $buku->judul_buku,
            'nama_pengarang' => $buku->nama_pengarang,
            'nama_penerbit' => $buku->nama_penerbit,
        ];
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Buku "' . $buku->judul_buku . '" berhasil ditambahkan ke keranjang!');
    }

    /**
     * Hapus buku dari keranjang
     */
    public function removeFromCart($id_buku)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id_buku])) {
            $judulBuku = $cart[$id_buku]['judul_buku'];
            unset($cart[$id_buku]);
            session()->put('cart', $cart);
            
            return back()->with('success', 'Buku "' . $judulBuku . '" berhasil dihapus dari keranjang.');
        }
        
        return back()->with('error', 'Buku tidak ditemukan di keranjang.');
    }

    /**
     * Menampilkan form data pemesanan peminjaman
     */
    public function create()
    {
        $cart = session()->get('cart', []);
        
        // Cek apakah cart kosong
        if (empty($cart)) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Keranjang kosong. Silakan pilih buku terlebih dahulu.');
        }
        
        return view('peminjaman.create', compact('cart'));
    }

    /**
     * Proses penyimpanan pemesanan peminjaman
     */
    public function store(Request $request)
    {
        // Validasi (contoh data untuk 1 pemesanan peminjaman)
        // Tidak perlu validasi tambahan karena data sudah di-handle dari cart
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Keranjang kosong. Silakan pilih buku terlebih dahulu.');
        }
        
        try {
            DB::beginTransaction();
            
            // Buat peminjaman baru
            $peminjaman = Peminjaman::create([
                'kode_pinjam' => Peminjaman::generateKodePinjam(),
                'id_peminjam' => Auth::guard('peminjam')->id(),
                'tgl_pesan' => now()->toDateString(),
                'status_pinjam' => 'DIPROSES',
            ]);
            
            // Simpan detil peminjaman (buku-buku yang dipinjam)
            foreach ($cart as $item) {
                DetilPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'id_buku' => $item['id_buku'],
                ]);
            }
            
            DB::commit();
            
            // Hapus cart setelah berhasil
            session()->forget('cart');
            
            return redirect()->route('peminjam.dashboard')
                ->with('success', 'Pemesanan peminjaman berhasil dibuat! Kode Pinjam: ' . $peminjaman->kode_pinjam . '. Status: DIPROSES. Harap menunggu persetujuan admin.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail peminjaman
     */
    public function show($id_peminjaman)
    {
        $peminjaman = Peminjaman::with(['bukus', 'peminjam', 'admin'])
            ->findOrFail($id_peminjaman);
        
        // Pastikan peminjam hanya bisa melihat peminjamannya sendiri
        if (Auth::guard('peminjam')->check() && 
            $peminjaman->id_peminjam != Auth::guard('peminjam')->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        return view('peminjaman.show', compact('peminjaman'));
    }
}