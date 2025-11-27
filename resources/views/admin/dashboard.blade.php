@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-tachometer-alt" style="color: #D7C097;"></i> Dashboard Admin
    </h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ $admin->nama_admin }}!</p>
</div>

<!-- Statistik Cards -->
<div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <!-- Total Peminjaman -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Peminjaman</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPeminjaman }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-4">
                <i class="fas fa-book-reader text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Diproses -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Menunggu Approval</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $diproses }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-4">
                <i class="fas fa-clock text-2xl text-yellow-600"></i>
            </div>
        </div>
        @if($diproses > 0)
        <a href="{{ route('admin.peminjaman.index', ['status' => 'DIPROSES']) }}" 
           class="text-sm hover:underline mt-2 inline-block"
           style="color: #D7C097;">
            <i class="fas fa-arrow-right"></i> Lihat Semua
        </a>
        @endif
    </div>

    <!-- Disetujui -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Disetujui</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $disetujui }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
        </div>
        @if($disetujui > 0)
        <a href="{{ route('admin.peminjaman.index', ['status' => 'DISETUJUI']) }}" 
           class="text-sm hover:underline mt-2 inline-block"
           style="color: #D7C097;">
            <i class="fas fa-arrow-right"></i> Lihat Semua
        </a>
        @endif
    </div>

    <!-- Selesai -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #D7C097;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Selesai</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $selesai }}</p>
            </div>
            <div class="rounded-full p-4" style="background-color: rgba(215, 192, 151, 0.2);">
                <i class="fas fa-check-double text-2xl" style="color: #D7C097;"></i>
            </div>
        </div>
    </div>

    <!-- Total Buku -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Buku</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalBuku }}</p>
            </div>
            <div class="bg-indigo-100 rounded-full p-4">
                <i class="fas fa-book text-2xl text-indigo-600"></i>
            </div>
        </div>
        <a href="{{ route('admin.buku.index') }}" 
           class="text-sm hover:underline mt-2 inline-block"
           style="color: #D7C097;">
            <i class="fas fa-arrow-right"></i> Kelola Buku
        </a>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid md:grid-cols-2 gap-6">
    <!-- Manajemen Peminjaman -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-book-reader mr-2" style="color: #D7C097;"></i>
            Manajemen Peminjaman
        </h2>
        <p class="text-gray-600 mb-4">
            Kelola pemesanan peminjaman buku, approve/reject, dan konfirmasi pengembalian.
        </p>
        <a href="{{ route('admin.peminjaman.index') }}" 
           style="background-color: #D7C097;"
           class="text-white px-6 py-2 rounded-lg hover:opacity-90 transition inline-block">
            <i class="fas fa-arrow-right mr-2"></i> Buka Halaman
        </a>
    </div>

    <!-- Manajemen Buku -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-book mr-2" style="color: #D7C097;"></i>
            Manajemen Buku
        </h2>
        <p class="text-gray-600 mb-4">
            Tambah, edit, atau hapus data buku di perpustakaan.
        </p>
        <a href="{{ route('admin.buku.index') }}" 
           style="background-color: #D7C097;"
           class="text-white px-6 py-2 rounded-lg hover:opacity-90 transition inline-block">
            <i class="fas fa-arrow-right mr-2"></i> Buka Halaman
        </a>
    </div>
</div>
@endsection