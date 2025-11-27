@extends('layouts.app')

@section('title', 'Selamat Datang - Perpustakaan Arcadia')

@section('content')
<div class="text-center py-12">
    <i class="fas fa-book-reader text-6xl text-blue-600 mb-6"></i>
    <h1 class="text-4xl font-bold text-gray-800 mb-4">
        Selamat Datang di Perpustakaan Arcadia
    </h1>
    <p class="text-xl text-gray-600 mb-8">
        Sistem Drive-Thru Perpustakaan - Pinjam Buku Secara Online
    </p>
    
    <div class="flex justify-center space-x-4">
        <a href="{{ route('peminjam.register') }}" 
           class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-user-plus mr-2"></i>
            Daftar Sekarang
        </a>
        <a href="{{ route('peminjam.login') }}" 
           class="bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Login
        </a>
    </div>
</div>

<!-- Fitur -->
<div class="grid md:grid-cols-3 gap-8 mt-12">
    <div class="bg-white p-6 rounded-lg shadow-md text-center">
        <i class="fas fa-laptop text-4xl text-blue-600 mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Pesan Online</h3>
        <p class="text-gray-600">Pesan buku yang ingin dipinjam secara online kapan saja</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md text-center">
        <i class="fas fa-car text-4xl text-blue-600 mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Drive-Thru</h3>
        <p class="text-gray-600">Ambil buku melalui jalur drive-thru dengan cepat</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md text-center">
        <i class="fas fa-qrcode text-4xl text-blue-600 mb-4"></i>
        <h3 class="text-xl font-semibold mb-2">Kode Pinjam</h3>
        <p class="text-gray-600">Tunjukkan kode pinjam untuk pengambilan buku</p>
    </div>
</div>
@endsection
