@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-book-reader" style="color: #D7C097;"></i> Manajemen Peminjaman
    </h1>
    <p class="text-gray-600 mt-2">Kelola seluruh pemesanan peminjaman buku</p>
</div>

<!-- Statistik Badge -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-yellow-100 rounded-lg p-4 text-center">
        <p class="text-2xl font-bold text-yellow-700">{{ $stats['diproses'] }}</p>
        <p class="text-sm text-yellow-600">Diproses</p>
    </div>
    <div class="bg-green-100 rounded-lg p-4 text-center">
        <p class="text-2xl font-bold text-green-700">{{ $stats['disetujui'] }}</p>
        <p class="text-sm text-green-600">Disetujui</p>
    </div>
    <div class="bg-red-100 rounded-lg p-4 text-center">
        <p class="text-2xl font-bold text-red-700">{{ $stats['ditolak'] }}</p>
        <p class="text-sm text-red-600">Ditolak</p>
    </div>
    <div class="bg-purple-100 rounded-lg p-4 text-center">
        <p class="text-2xl font-bold text-purple-700">{{ $stats['selesai'] }}</p>
        <p class="text-sm text-purple-600">Selesai</p>
    </div>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="grid md:grid-cols-3 gap-4">
        <!-- Search -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-search"></i> Cari
            </label>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                   placeholder="Kode pinjam atau nama peminjam...">
        </div>

        <!-- Filter Status -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-filter"></i> Status
            </label>
            <select name="status" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                <option value="">Semua Status</option>
                <option value="DIPROSES" {{ request('status') == 'DIPROSES' ? 'selected' : '' }}>Diproses</option>
                <option value="DISETUJUI" {{ request('status') == 'DISETUJUI' ? 'selected' : '' }}>Disetujui</option>
                <option value="DITOLAK" {{ request('status') == 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex items-end space-x-2">
            <button type="submit" 
                    class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            <a href="{{ route('admin.peminjaman.index') }}" 
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-redo"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- Tabel Peminjaman -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kode Pinjam
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Peminjam
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tgl Pesan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jumlah Buku
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($peminjamans as $peminjaman)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-semibold text-purple-600">{{ $peminjaman->kode_pinjam }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                            {{ $peminjaman->peminjam->nama_peminjam }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $peminjaman->tgl_pesan->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $peminjaman->bukus->count() }} buku
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($peminjaman->status_pinjam == 'DIPROSES')
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-clock"></i> DIPROSES
                            </span>
                        @elseif($peminjaman->status_pinjam == 'DISETUJUI')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-check-circle"></i> DISETUJUI
                            </span>
                        @elseif($peminjaman->status_pinjam == 'DITOLAK')
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-times-circle"></i> DITOLAK
                            </span>
                        @else
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-check-double"></i> SELESAI
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.peminjaman.show', $peminjaman->id_peminjaman) }}" 
                           class="text-purple-600 hover:text-purple-900 font-semibold">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Tidak ada data peminjaman</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 bg-gray-50">
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection