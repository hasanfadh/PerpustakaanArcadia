@extends('layouts.app')

@section('title', 'Registrasi Peminjam')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center mb-6">
        <i class="fas fa-user-plus text-blue-600"></i> Registrasi Peminjam
    </h2>

    <form action="{{ route('peminjam.register.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Peminjam -->
        <div class="mb-4">
            <label for="nama_peminjam" class="block text-gray-700 font-semibold mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="nama_peminjam" 
                   name="nama_peminjam" 
                   value="{{ old('nama_peminjam') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('nama_peminjam') border-red-500 @enderror"
                   placeholder="Masukkan nama lengkap"
                   required>
            @error('nama_peminjam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label for="user_peminjam" class="block text-gray-700 font-semibold mb-2">
                Username <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="user_peminjam" 
                   name="user_peminjam" 
                   value="{{ old('user_peminjam') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('user_peminjam') border-red-500 @enderror"
                   placeholder="Masukkan username"
                   required>
            @error('user_peminjam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="pass_peminjam" class="block text-gray-700 font-semibold mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   id="pass_peminjam" 
                   name="pass_peminjam" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('pass_peminjam') border-red-500 @enderror"
                   placeholder="Minimal 6 karakter"
                   required>
            @error('pass_peminjam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-4">
            <label for="pass_peminjam_confirmation" class="block text-gray-700 font-semibold mb-2">
                Konfirmasi Password <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   id="pass_peminjam_confirmation" 
                   name="pass_peminjam_confirmation" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                   placeholder="Ulangi password"
                   required>
        </div>

        <!-- Foto Peminjam (Opsional) -->
        <div class="mb-6">
            <label for="foto_peminjam" class="block text-gray-700 font-semibold mb-2">
                Foto Profil (Opsional)
            </label>
            <input type="file" 
                   id="foto_peminjam" 
                   name="foto_peminjam" 
                   accept="image/*"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('foto_peminjam') border-red-500 @enderror">
            <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG. Maksimal 2MB</p>
            @error('foto_peminjam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <button type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
            <i class="fas fa-user-check mr-2"></i> Daftar
        </button>
    </form>

    <!-- Link ke Login -->
    <p class="text-center mt-4 text-gray-600">
        Sudah punya akun? 
        <a href="{{ route('peminjam.login') }}" class="text-blue-600 hover:underline">
            Login di sini
        </a>
    </p>
</div>
@endsection