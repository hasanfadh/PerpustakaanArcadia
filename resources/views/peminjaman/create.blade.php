@extends('layouts.app')

@section('title', 'Form Pemesanan Peminjaman')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-clipboard-list text-blue-600"></i> Form Pemesanan Peminjaman
    </h1>
    <p class="text-gray-600 mt-2">Periksa kembali buku yang akan dipinjam</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Daftar Buku yang Dipilih -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-book text-blue-600"></i> Buku yang Akan Dipinjam
            </h2>

            @if(count($cart) > 0)
            <div class="space-y-4">
                @foreach($cart as $item)
                <div class="border rounded-lg p-4 flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $item['judul_buku'] }}</h3>
                        <p class="text-gray-600 mt-1">
                            <i class="fas fa-user text-blue-600"></i> {{ $item['nama_pengarang'] }}
                        </p>
                        <p class="text-gray-600">
                            <i class="fas fa-building text-blue-600"></i> {{ $item['nama_penerbit'] }}
                        </p>
                    </div>
                    <form action="{{ route('peminjaman.cart.remove', $item['id_buku']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 ml-4">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">
                Keranjang kosong. <a href="{{ route('peminjaman.index') }}" class="text-blue-600 hover:underline">Pilih buku terlebih dahulu</a>
            </p>
            @endif
        </div>
    </div>

    <!-- Info Pemesanan -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-info-circle text-blue-600"></i> Ringkasan Pemesanan
            </h2>

            <div class="mb-4 pb-4 border-b">
                <p class="text-gray-600 mb-2">Jumlah Buku:</p>
                <p class="text-2xl font-bold">{{ count($cart) }} Buku</p>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-info-circle text-blue-600"></i> 
                    Setelah pemesanan dibuat, status akan menjadi <strong>DIPROSES</strong>. 
                    Harap menunggu persetujuan admin.
                </p>
            </div>

            @if(count($cart) > 0)
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-check mr-2"></i> Buat Pemesanan
                </button>
            </form>
            @else
            <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed">
                <i class="fas fa-times mr-2"></i> Keranjang Kosong
            </button>
            @endif

            <a href="{{ route('peminjaman.index') }}" 
               class="block text-center mt-3 text-blue-600 hover:underline">
                <i class="fas fa-arrow-left mr-2"></i> Kembali Pilih Buku
            </a>
        </div>
    </div>
</div>
@endsection