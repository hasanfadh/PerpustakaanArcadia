@extends('layouts.admin')

@section('title', 'Edit Buku')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.buku.index') }}" style="color: #D7C097;" class="hover:opacity-80 font-semibold">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Buku
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-edit mr-3" style="color: #D7C097;"></i>
        Edit Buku
    </h1>

    <form action="{{ route('admin.buku.update', $buku->id_buku) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Judul Buku -->
        <div class="mb-6">
            <label for="judul_buku" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-book mr-1"></i> Judul Buku <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="judul_buku" 
                   name="judul_buku" 
                   value="{{ old('judul_buku', $buku->judul_buku) }}"
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('judul_buku') border-red-500 @enderror"
                   placeholder="Masukkan judul buku"
                   required>
            @error('judul_buku')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nama Pengarang -->
        <div class="mb-6">
            <label for="nama_pengarang" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-pen mr-1"></i> Nama Pengarang <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="nama_pengarang" 
                   name="nama_pengarang" 
                   value="{{ old('nama_pengarang', $buku->nama_pengarang) }}"
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('nama_pengarang') border-red-500 @enderror"
                   placeholder="Masukkan nama pengarang"
                   required>
            @error('nama_pengarang')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nama Penerbit -->
        <div class="mb-6">
            <label for="nama_penerbit" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-building mr-1"></i> Nama Penerbit <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="nama_penerbit" 
                   name="nama_penerbit" 
                   value="{{ old('nama_penerbit', $buku->nama_penerbit) }}"
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('nama_penerbit') border-red-500 @enderror"
                   placeholder="Masukkan nama penerbit"
                   required>
            @error('nama_penerbit')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Terbit -->
        <div class="mb-6">
            <label for="tgl_terbit" class="block text-gray-700 font-semibold mb-2">
                <i class="fas fa-calendar mr-1"></i> Tanggal Terbit <span class="text-red-500">*</span>
            </label>
            <input type="date" 
                   id="tgl_terbit" 
                   name="tgl_terbit" 
                   value="{{ old('tgl_terbit', $buku->tgl_terbit->format('Y-m-d')) }}"
                   class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('tgl_terbit') border-red-500 @enderror"
                   required>
            @error('tgl_terbit')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <button type="submit" 
                    style="background-color: #D7C097;"
                    class="flex-1 text-white py-3 rounded-lg hover:opacity-90 transition font-semibold">
                <i class="fas fa-save mr-2"></i> Update Buku
            </button>
            <a href="{{ route('admin.buku.index') }}" 
               class="flex-1 bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection