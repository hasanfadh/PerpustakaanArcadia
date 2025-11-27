<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManajemenBukuController extends Controller
{
    /**
     * Menampilkan halaman daftar buku
     * Admin dapat melihat seluruh daftar buku
     */
    public function index(Request $request)
    {
        // Hitung total buku
        $totalBuku = Buku::count();
        
        // Query dengan pencarian
        $query = Buku::query();
        
        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('nama_pengarang', 'like', "%{$search}%")
                  ->orWhere('nama_penerbit', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan judul
        $bukus = $query->orderBy('judul_buku', 'asc')
                       ->paginate(10);

        return view('admin.buku.index', compact('bukus', 'totalBuku'));
    }

    /**
     * Menampilkan form tambah buku
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Menyimpan buku baru
     * Admin dapat menambahkan buku baru (create)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_buku' => 'required|string|max:150',
            'tgl_terbit' => 'required|date',
            'nama_pengarang' => 'required|string|max:150',
            'nama_penerbit' => 'required|string|max:150',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi',
            'tgl_terbit.required' => 'Tanggal terbit wajib diisi',
            'tgl_terbit.date' => 'Format tanggal tidak valid',
            'nama_pengarang.required' => 'Nama pengarang wajib diisi',
            'nama_penerbit.required' => 'Nama penerbit wajib diisi',
        ]);

        try {
            // Simpan buku baru
            Buku::create([
                'judul_buku' => $request->judul_buku,
                'tgl_terbit' => $request->tgl_terbit,
                'nama_pengarang' => $request->nama_pengarang,
                'nama_penerbit' => $request->nama_penerbit,
            ]);

            return redirect()->route('admin.buku.index')
                ->with('success', 'Buku "' . $request->judul_buku . '" berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan form edit buku
     */
    public function edit($id_buku)
    {
        $buku = Buku::findOrFail($id_buku);
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Update data buku
     * Admin dapat mengubah data buku (update)
     */
    public function update(Request $request, $id_buku)
    {
        // Validasi input
        $request->validate([
            'judul_buku' => 'required|string|max:150',
            'tgl_terbit' => 'required|date',
            'nama_pengarang' => 'required|string|max:150',
            'nama_penerbit' => 'required|string|max:150',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi',
            'tgl_terbit.required' => 'Tanggal terbit wajib diisi',
            'tgl_terbit.date' => 'Format tanggal tidak valid',
            'nama_pengarang.required' => 'Nama pengarang wajib diisi',
            'nama_penerbit.required' => 'Nama penerbit wajib diisi',
        ]);

        try {
            $buku = Buku::findOrFail($id_buku);
            
            $buku->update([
                'judul_buku' => $request->judul_buku,
                'tgl_terbit' => $request->tgl_terbit,
                'nama_pengarang' => $request->nama_pengarang,
                'nama_penerbit' => $request->nama_penerbit,
            ]);

            return redirect()->route('admin.buku.index')
                ->with('success', 'Buku "' . $buku->judul_buku . '" berhasil diupdate!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus buku
     * Admin dapat menghapus buku (delete)
     */
    public function destroy($id_buku)
    {
        try {
            $buku = Buku::findOrFail($id_buku);
            
            // Cek apakah buku sedang dipinjam (status DIPROSES atau DISETUJUI)
            $dipinjam = $buku->peminjamans()
                ->whereIn('status_pinjam', ['DIPROSES', 'DISETUJUI'])
                ->exists();
            
            if ($dipinjam) {
                return back()->with('error', 'Buku tidak dapat dihapus karena sedang dalam peminjaman aktif.');
            }

            $judulBuku = $buku->judul_buku;
            $buku->delete();

            return redirect()->route('admin.buku.index')
                ->with('success', 'Buku "' . $judulBuku . '" berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}