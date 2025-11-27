@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-file-alt text-blue-600"></i> Detail Peminjaman
    </h1>
    <p class="text-gray-600 mt-2">Informasi lengkap pemesanan peminjaman buku</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Info Peminjaman -->
    <div class="lg:col-span-2">
        <!-- Status dan Kode Pinjam -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold mb-2">{{ $peminjaman->kode_pinjam }}</h2>
                @php
                    $statusColors = [
                        'DIPROSES' => 'bg-yellow-100 text-yellow-800',
                        'DISETUJUI' => 'bg-green-100 text-green-800',
                        'DITOLAK' => 'bg-red-100 text-red-800',
                        'SELESAI' => 'bg-blue-100 text-blue-800',
                    ];
                    $statusIcons = [
                        'DIPROSES' => 'fa-clock',
                        'DISETUJUI' => 'fa-check-circle',
                        'DITOLAK' => 'fa-times-circle',
                        'SELESAI' => 'fa-flag-checkered',
                    ];
                @endphp
                <span class="inline-block px-6 py-2 rounded-full text-lg font-semibold {{ $statusColors[$peminjaman->status_pinjam] ?? 'bg-gray-100 text-gray-800' }}">
                    <i class="fas {{ $statusIcons[$peminjaman->status_pinjam] ?? 'fa-question' }} mr-2"></i>
                    {{ $peminjaman->status_pinjam }}
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-4 border-t pt-6">
                <div>
                    <p class="text-gray-600 mb-1">Tanggal Pesan</p>
                    <p class="font-semibold">{{ $peminjaman->tgl_pesan->format('d F Y') }}</p>
                </div>
                @if($peminjaman->tgl_ambil)
                <div>
                    <p class="text-gray-600 mb-1">Tanggal Ambil</p>
                    <p class="font-semibold">{{ $peminjaman->tgl_ambil->format('d F Y') }}</p>
                </div>
                @endif
                @if($peminjaman->tgl_wajibkembali)
                <div>
                    <p class="text-gray-600 mb-1">Tanggal Wajib Kembali</p>
                    <p class="font-semibold">{{ $peminjaman->tgl_wajibkembali->format('d F Y') }}</p>
                </div>
                @endif
                @if($peminjaman->tgl_kembali)
                <div>
                    <p class="text-gray-600 mb-1">Tanggal Kembali</p>
                    <p class="font-semibold">{{ $peminjaman->tgl_kembali->format('d F Y') }}</p>
                </div>
                @endif
            </div>

            @if($peminjaman->admin)
            <div class="border-t mt-4 pt-4">
                <p class="text-gray-600 mb-1">Diproses oleh Admin</p>
                <p class="font-semibold">{{ $peminjaman->admin->nama_admin }}</p>
            </div>
            @endif
        </div>

        <!-- Daftar Buku -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-book text-blue-600"></i> Daftar Buku ({{ $peminjaman->bukus->count() }})
            </h2>

            <div class="space-y-4">
                @foreach($peminjaman->bukus as $buku)
                <div class="border rounded-lg p-4">
                    <h3 class="font-semibold text-lg">{{ $buku->judul_buku }}</h3>
                    <p class="text-gray-600 mt-1">
                        <i class="fas fa-user text-blue-600"></i> {{ $buku->nama_pengarang }}
                    </p>
                    <p class="text-gray-600">
                        <i class="fas fa-building text-blue-600"></i> {{ $buku->nama_penerbit }}
                    </p>
                    <p class="text-gray-600">
                        <i class="fas fa-calendar text-blue-600"></i> {{ $buku->tgl_terbit->format('Y') }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-info-circle text-blue-600"></i> Informasi
            </h2>

            @if($peminjaman->status_pinjam == 'DIPROSES')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-clock text-yellow-600"></i> 
                    Pemesanan Anda sedang diproses. Harap menunggu persetujuan dari admin.
                </p>
            </div>
            @elseif($peminjaman->status_pinjam == 'DISETUJUI')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-green-800">
                    <i class="fas fa-check-circle text-green-600"></i> 
                    Pemesanan disetujui! Silakan ambil buku melalui jalur drive-thru dengan menunjukkan kode pinjam.
                </p>
            </div>
            @elseif($peminjaman->status_pinjam == 'DITOLAK')
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-red-800">
                    <i class="fas fa-times-circle text-red-600"></i> 
                    Maaf, pemesanan Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                </p>
            </div>
            @elseif($peminjaman->status_pinjam == 'SELESAI')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-flag-checkered text-blue-600"></i> 
                    Peminjaman selesai. Terima kasih telah menggunakan layanan kami!
                </p>
            </div>
            @endif

            <a href="{{ route('peminjam.dashboard') }}" 
               class="block text-center bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection