<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetilPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManajemenPeminjamanController extends Controller
{
    /**
     * Menampilkan halaman daftar peminjaman
     * Admin dapat melihat seluruh daftar pemesanan peminjaman buku
     */
    public function index(Request $request)
    {
        // Hitung statistik untuk badge (sebelum filter)
        $stats = [
            'diproses' => Peminjaman::where('status_pinjam', 'DIPROSES')->count(),
            'disetujui' => Peminjaman::where('status_pinjam', 'DISETUJUI')->count(),
            'ditolak' => Peminjaman::where('status_pinjam', 'DITOLAK')->count(),
            'selesai' => Peminjaman::where('status_pinjam', 'SELESAI')->count(),
        ];

        // Query dengan filter status
        $query = Peminjaman::with(['peminjam', 'admin', 'bukus']);
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pinjam', $request->status);
        }

        // Filter berdasarkan pencarian (kode pinjam atau nama peminjam)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pinjam', 'like', "%{$search}%")
                  ->orWhereHas('peminjam', function($q2) use ($search) {
                      $q2->where('nama_peminjam', 'like', "%{$search}%");
                  });
            });
        }

        // Urutkan berdasarkan tanggal pesan terbaru
        $peminjamans = $query->orderBy('tgl_pesan', 'desc')
                             ->paginate(10);

        return view('admin.peminjaman.index', compact('peminjamans', 'stats'));
    }

    /**
     * Menampilkan detail peminjaman dan daftar buku yang dipesan
     * Admin dapat melihat detil pemesanan peminjaman buku
     */
    public function show($id_peminjaman)
    {
        $peminjaman = Peminjaman::with(['peminjam', 'admin', 'bukus'])
            ->findOrFail($id_peminjaman);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Menyetujui pemesanan peminjaman buku
     * Admin dapat menyetujui pemesanan peminjaman (status berubah menjadi DISETUJUI)
     */
    public function approve($id_peminjaman)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id_peminjaman);

            // Cek apakah status masih DIPROSES
            if ($peminjaman->status_pinjam != 'DIPROSES') {
                return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
            }

            // Update status dan set tanggal ambil serta wajib kembali
            $peminjaman->update([
                'status_pinjam' => 'DISETUJUI',
                'id_admin' => Auth::guard('admin')->id(),
                'tgl_ambil' => now()->toDateString(),
                'tgl_wajibkembali' => now()->addDays(7)->toDateString(), // 7 hari dari sekarang
            ]);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman dengan kode ' . $peminjaman->kode_pinjam . ' berhasil disetujui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak pemesanan peminjaman buku
     * Admin dapat menolak pemesanan peminjaman (status berubah menjadi DITOLAK)
     */
    public function reject($id_peminjaman)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id_peminjaman);

            // Cek apakah status masih DIPROSES
            if ($peminjaman->status_pinjam != 'DIPROSES') {
                return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
            }

            // Update status
            $peminjaman->update([
                'status_pinjam' => 'DITOLAK',
                'id_admin' => Auth::guard('admin')->id(),
            ]);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman dengan kode ' . $peminjaman->kode_pinjam . ' berhasil ditolak.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Konfirmasi pengembalian buku
     * Admin dapat melakukan konfirmasi pengembalian buku (status berubah menjadi SELESAI)
     */
    public function returnBook($id_peminjaman)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id_peminjaman);

            // Cek apakah status DISETUJUI (buku sudah diambil)
            if ($peminjaman->status_pinjam != 'DISETUJUI') {
                return back()->with('error', 'Peminjaman ini belum disetujui atau sudah selesai.');
            }

            // Update status dan set tanggal kembali
            $peminjaman->update([
                'status_pinjam' => 'SELESAI',
                'tgl_kembali' => now()->toDateString(),
            ]);

            return redirect()->route('admin.peminjaman.index')
                ->with('success', 'Pengembalian buku dengan kode ' . $peminjaman->kode_pinjam . ' berhasil dikonfirmasi!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus buku dari daftar pemesanan (mengurangi buku)
     * Admin dapat mengurangi buku dari daftar buku yang dipesan jika buku tidak tersedia
     */
    public function removeBook($id_peminjaman, $id_buku)
    {
        try {
            $peminjaman = Peminjaman::findOrFail($id_peminjaman);

            // Cek apakah status masih DIPROSES
            if ($peminjaman->status_pinjam != 'DIPROSES') {
                return back()->with('error', 'Tidak dapat menghapus buku. Peminjaman sudah diproses.');
            }

            // Hapus buku dari detil peminjaman
            $detil = DetilPeminjaman::where('id_peminjaman', $id_peminjaman)
                ->where('id_buku', $id_buku)
                ->first();

            if (!$detil) {
                return back()->with('error', 'Buku tidak ditemukan dalam pemesanan ini.');
            }

            $namaBuku = $detil->buku->judul_buku;
            $detil->delete();

            // Cek apakah masih ada buku yang tersisa
            $sisaBuku = DetilPeminjaman::where('id_peminjaman', $id_peminjaman)->count();
            
            if ($sisaBuku == 0) {
                // Jika tidak ada buku lagi, tolak otomatis
                $peminjaman->update([
                    'status_pinjam' => 'DITOLAK',
                    'id_admin' => Auth::guard('admin')->id(),
                ]);
                return redirect()->route('admin.peminjaman.index')
                    ->with('info', 'Semua buku telah dihapus. Peminjaman ditolak otomatis.');
            }

            return back()->with('success', 'Buku "' . $namaBuku . '" berhasil dihapus dari pemesanan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}