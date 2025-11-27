@extends('layouts.admin')

@section('title', 'Manajemen Buku')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-book" style="color: #D7C097;"></i> Manajemen Buku
        </h1>
        <p class="text-gray-600 mt-2">Kelola data buku perpustakaan (Total: {{ $totalBuku }} buku)</p>
    </div>
    <a href="{{ route('admin.buku.create') }}" 
       style="background-color: #D7C097;"
       class="text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Buku
    </a>
</div>

<!-- Search -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.buku.index') }}" class="flex gap-4">
        <div class="flex-1">
            <label class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-search"></i> Cari Buku
            </label>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"
                   placeholder="Judul, pengarang, atau penerbit...">
        </div>
        <div class="flex items-end space-x-2">
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            <a href="{{ route('admin.buku.index') }}" 
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-redo"></i> Reset
            </a>
        </div>
    </form>
</div>

<!-- Tabel Buku -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Judul Buku
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengarang
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Penerbit
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tgl Terbit
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bukus as $index => $buku)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $bukus->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800">{{ $buku->judul_buku }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $buku->nama_pengarang }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $buku->nama_penerbit }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $buku->tgl_terbit->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex justify-center space-x-2">
                            <!-- Edit -->
                            <a href="{{ route('admin.buku.edit', $buku->id_buku) }}" 
                               class="text-blue-600 hover:text-blue-900 font-semibold">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <!-- Delete -->
                            <form action="{{ route('admin.buku.destroy', $buku->id_buku) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Tidak ada data buku</p>
                        <a href="{{ route('admin.buku.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                            Tambah buku pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 bg-gray-50">
        {{ $bukus->links() }}
    </div>
</div>
@endsection