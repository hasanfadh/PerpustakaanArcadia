<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Arcadia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/book.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-book-open text-2xl"></i>
                    <h1 class="text-xl font-bold">Perpustakaan Arcadia</h1>
                </div>
                
                @auth('peminjam')
                <div class="flex items-center space-x-4">
                    <span>Halo, {{ Auth::guard('peminjam')->user()->nama_peminjam }}</span>
                    <a href="{{ route('peminjam.dashboard') }}" class="hover:text-blue-200">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="hover:text-blue-200">
                        <i class="fas fa-book"></i> Pinjam Buku
                    </a>
                    <form action="{{ route('peminjam.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('peminjam.login') }}" class="hover:text-blue-200">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('peminjam.register') }}" class="hover:text-blue-200">
                        <i class="fas fa-user-plus"></i> Registrasi
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('info') }}</span>
            <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12 py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Perpustakaan Arcadia. Drive-Thru Library System.</p>
        </div>
    </footer>
</body>
</html>