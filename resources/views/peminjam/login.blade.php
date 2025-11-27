@extends('layouts.app')

@section('title', 'Login Peminjam')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center mb-6">
        <i class="fas fa-sign-in-alt text-blue-600"></i> Login Peminjam
    </h2>

    <form action="{{ route('peminjam.login.submit') }}" method="POST">
        @csrf

        <!-- Username -->
        <div class="mb-4">
            <label for="user_peminjam" class="block text-gray-700 font-semibold mb-2">
                Username
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
                Password
            </label>
            <input type="password" 
                   id="pass_peminjam" 
                   name="pass_peminjam" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 @error('pass_peminjam') border-red-500 @enderror"
                   placeholder="Masukkan password"
                   required>
            @error('pass_peminjam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-gray-700">Ingat Saya</span>
            </label>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
            <i class="fas fa-sign-in-alt mr-2"></i> Login
        </button>
    </form>

    <!-- Link ke Registrasi -->
    <p class="text-center mt-4 text-gray-600">
        Belum punya akun? 
        <a href="{{ route('peminjam.register') }}" class="text-blue-600 hover:underline">
            Daftar di sini
        </a>
    </p>
</div>
@endsection