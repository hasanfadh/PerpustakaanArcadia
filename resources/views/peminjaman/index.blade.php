@extends('layouts.app')

@section('title', 'Pilih Buku untuk Dipinjam')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-book text-blue-600"></i> Pilih Buku untuk Dipinjam
    </h1>
    <p class="text-gray-600 mt-2">Pilih buku yang ingin Anda pinjam dan tambahkan ke keranjang</p>
</div>

<!-- Keranjang -->
@if(count($cart) > 0)
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-semibold text-lg">
                <i class="fas fa-shopping-cart text-blue-600"></i> 
                Keranjang ({{ count($cart) }} buku)
            </h3>
        </div>
        <a href="{{ route('peminjaman.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-arrow-right mr-2"></i> Lanjut ke Pemesanan
        </a>
    </div>
    
    <div class="mt-4 grid gap-2">
        @foreach($cart as $item)
        <div class="flex justify-between items-center bg-white p-3 rounded">
            <div>
                <p class="font-semibold">{{ $item['judul_buku'] }}</p>
                <p class="text-sm text-gray-600">{{ $item['nama_pengarang'] }}</p>
            </div>
            <form action="{{ route('peminjaman.cart.remove', $item['id_buku']) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Daftar Buku -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4">
        <i class="fas fa-list text-blue-600"></i> Daftar Buku Tersedia
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bukus as $buku)
        <div class="border rounded-lg p-4 hover:shadow-lg transition">
            <div class="mb-3">
                <div class="w-full h-48 bg-blue-100 rounded flex items-center justify-center mb-3">
                    <i class="fas fa-book text-6xl text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">{{ $buku->judul_buku }}</h3>
                <p class="text-sm text-gray-600 mb-1">
                    <i class="fas fa-user text-blue-600"></i> {{ $buku->nama_pengarang }}
                </p>
                <p class="text-sm text-gray-600 mb-1">
                    <i class="fas fa-building text-blue-600"></i> {{ $buku->nama_penerbit }}
                </p>
                <p class="text-sm text-gray-600">
                    <i class="fas fa-calendar text-blue-600"></i> {{ $buku->tgl_terbit->format('Y') }}
                </p>
            </div>
            
            @if(isset($cart[$buku->id_buku]))
            <button disabled class="w-full bg-gray-400 text-white py-2 rounded cursor-not-allowed">
                <i class="fas fa-check mr-2"></i> Sudah di Keranjang
            </button>
            @else
            <form action="{{ route('peminjaman.cart.add', $buku->id_buku) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Tambah ke Keranjang
                </button>
            </form>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $bukus->links() }}
    </div>
</div>
@endsection