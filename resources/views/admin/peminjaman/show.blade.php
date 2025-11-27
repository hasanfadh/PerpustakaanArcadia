@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.peminjaman.index') }}" style="color: #D7C097;" class="hover:opacity-80 font-semibold">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Peminjaman
    </a>
</div>

<!-- Header -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Detail Peminjaman
            </h1>
            <p class="text-gray-600">Kode Pinjam: <span class="font-bold" style="color: #D7C097;">{{ $peminjaman->kode_pinjam }}</span></p>
        </div>
        <div>
            @if($peminjaman->status_pinjam == 'DIPROSES')
                <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-clock"></i> DIPROSES
                </span>
            @elseif($peminjaman->status_pinjam == 'DISETUJUI')
                <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-circle"></i> DISETUJUI
                </span>
            @elseif($peminjaman->status_pinjam == 'DITOLAK')
                <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-times-circle"></i> DITOLAK
                </span>
            @else
                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-double"></i> SELESAI
                </span>
            @endif
        </div>
    </div>
</div>

<!-- Informasi Peminjaman -->
<div class="grid md:grid-cols-2 gap-6 mb-6">
    <!-- Info Peminjam -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-user-circle mr-2" style="color: #D7C097;"></i>
            Informasi Peminjam
        </h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Nama:</span>
                <span class="font-semibold">{{ $peminjaman->peminjam->nama_peminjam }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Username:</span>
                <span class="font-semibold">{{ $peminjaman->peminjam->user_peminjam }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tgl Daftar:</span>
                <span class="font-semibold">{{ $peminjaman->peminjam->tgl_daftar->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Info Peminjaman -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2" style="color: #D7C097;"></i>
            Informasi Peminjaman
        </h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Tgl Pesan:</span>
                <span class="font-semibold">{{ $peminjaman->tgl_pesan->format('d M Y') }}</span>
            </div>
            @if($peminjaman->tgl_ambil)
            <div class="flex justify-between">
                <span class="text-gray-600">Tgl Ambil:</span>
                <span class="font-semibold">{{ $peminjaman->tgl_ambil->format('d M Y') }}</span>
            </div>
            @endif
            @if($peminjaman->tgl_wajibkembali)
            <div class="flex justify-between">
                <span class="text-gray-600">Tgl Wajib Kembali:</span>
                <span class="font-semibold">{{ $peminjaman->tgl_wajibkembali->format('d M Y') }}</span>
            </div>
            @endif
            @if($peminjaman->tgl_kembali)
            <div class="flex justify-between">
                <span class="text-gray-600">Tgl Kembali:</span>
                <span class="font-semibold">{{ $peminjaman->tgl_kembali->format('d M Y') }}</span>
            </div>
            @endif
            @if($peminjaman->admin)
            <div class="flex justify-between">
                <span class="text-gray-600">Diproses oleh:</span>
                <span class="font-semibold">{{ $peminjaman->admin->nama_admin }}</span>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Daftar Buku yang Dipesan -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-book mr-2" style="color: #D7C097;"></i>
        Daftar Buku yang Dipesan ({{ $peminjaman->bukus->count() }} buku)
    </h2>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Buku</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengarang</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penerbit</th>
                    @if($peminjaman->status_pinjam == 'DIPROSES')
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($peminjaman->bukus as $index => $buku)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 whitespace-nowrap text-sm">{{ $index + 1 }}</td>
                    <td class="px-4 py-4">
                        <span class="font-semibold text-gray-800">{{ $buku->judul_buku }}</span>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-600">{{ $buku->nama_pengarang }}</td>
                    <td class="px-4 py-4 text-sm text-gray-600">{{ $buku->nama_penerbit }}</td>
                    @if($peminjaman->status_pinjam == 'DIPROSES')
                    <td class="px-4 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.peminjaman.remove-book', [$peminjaman->id_peminjaman, $buku->id_buku]) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus buku ini dari pemesanan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Action Buttons -->
@if($peminjaman->status_pinjam == 'DIPROSES')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">
        <i class="fas fa-cogs mr-2" style="color: #D7C097;"></i>
        Aksi Peminjaman
    </h2>
    <div class="flex space-x-4">
        <!-- Setujui -->
        <form action="{{ route('admin.peminjaman.approve', $peminjaman->id_peminjaman) }}" 
              method="POST" 
              onsubmit="return confirm('Yakin ingin menyetujui peminjaman ini?')">
            @csrf
            <button type="submit" 
                    class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                <i class="fas fa-check-circle mr-2"></i> Setujui Peminjaman
            </button>
        </form>

        <!-- Tolak -->
        <form action="{{ route('admin.peminjaman.reject', $peminjaman->id_peminjaman) }}" 
              method="POST" 
              onsubmit="return confirm('Yakin ingin menolak peminjaman ini?')">
            @csrf
            <button type="submit" 
                    class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                <i class="fas fa-times-circle mr-2"></i> Tolak Peminjaman
            </button>
        </form>
    </div>
</div>
@elseif($peminjaman->status_pinjam == 'DISETUJUI')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">
        <i class="fas fa-undo mr-2" style="color: #D7C097;"></i>
        Konfirmasi Pengembalian
    </h2>
    <p class="text-gray-600 mb-4">
        Peminjaman ini sudah disetujui. Jika peminjam sudah mengembalikan buku, klik tombol di bawah untuk konfirmasi pengembalian.
    </p>
    <form action="{{ route('admin.peminjaman.return', $peminjaman->id_peminjaman) }}" 
          method="POST" 
          onsubmit="return confirm('Yakin buku sudah dikembalikan?')">
        @csrf
        <button type="submit" 
                style="background-color: #D7C097;"
                class="text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold">
            <i class="fas fa-check-double mr-2"></i> Konfirmasi Pengembalian
        </button>
    </form>
</div>
@endif
@endsection