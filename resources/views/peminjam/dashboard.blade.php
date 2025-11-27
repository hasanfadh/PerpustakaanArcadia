@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">
        <i class="fas fa-home text-blue-600"></i> Dashboard Peminjam
    </h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ $peminjam->nama_peminjam }}!</p>
</div>

<!-- Info Peminjam -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4">
        <i class="fas fa-user-circle text-blue-600"></i> Informasi Peminjam
    </h2>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            @if($peminjam->foto_peminjam)
            <img src="{{ asset('storage/' . $peminjam->foto_peminjam) }}" 
                 alt="Foto {{ $peminjam->nama_peminjam }}"
                 class="w-32 h-32 rounded-full object-cover mb-4 border-4 border-blue-600">
            @else
            <div class="w-32 h-32 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl mb-4">
                {{ strtoupper(substr($peminjam->nama_peminjam, 0, 1)) }}
            </div>
            @endif
        </div>
        <div>
            <p class="mb-2"><span class="font-semibold">Nama:</span> {{ $peminjam->nama_peminjam }}</p>
            <p class="mb-2"><span class="font-semibold">Username:</span> {{ $peminjam->user_peminjam }}</p>
            <p class="mb-2"><span class="font-semibold">Tanggal Daftar:</span> {{ $peminjam->tgl_daftar->format('d F Y') }}</p>
            <p class="mb-2">
                <span class="font-semibold">Status:</span> 
                <span class="px-3 py-1 rounded-full text-sm {{ $peminjam->status_peminjam ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $peminjam->status_peminjam ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </p>
        </div>
    </div>
</div>

<!-- Tombol Pinjam Buku -->
<div class="mb-8">
    <a href="{{ route('peminjaman.index') }}" 
       class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
        <i class="fas fa-book mr-2"></i> Pinjam Buku Baru
    </a>
</div>

<!-- Riwayat Peminjaman -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4">
        <i class="fas fa-history text-blue-600"></i> Riwayat Peminjaman
    </h2>

    @if($peminjamans->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Kode Pinjam</th>
                    <th class="px-4 py-3 text-left">Tanggal Pesan</th>
                    <th class="px-4 py-3 text-left">Jumlah Buku</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $peminjaman)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-semibold">{{ $peminjaman->kode_pinjam }}</td>
                    <td class="px-4 py-3">{{ $peminjaman->tgl_pesan->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $peminjaman->bukus->count() }} buku</td>
                    <td class="px-4 py-3">
                        @php
                            $statusColors = [
                                'DIPROSES' => 'bg-yellow-100 text-yellow-800',
                                'DISETUJUI' => 'bg-green-100 text-green-800',
                                'DITOLAK' => 'bg-red-100 text-red-800',
                                'SELESAI' => 'bg-blue-100 text-blue-800',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm {{ $statusColors[$peminjaman->status_pinjam] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $peminjaman->status_pinjam }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('peminjaman.show', $peminjaman->id_peminjaman) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-500 text-center py-8">
        <i class="fas fa-inbox text-4xl mb-4"></i><br>
        Belum ada riwayat peminjaman.
    </p>
    @endif
</div>
@endsection