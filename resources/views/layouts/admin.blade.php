<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Perpustakaan Arcadia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/book.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar Admin -->
    <nav style="background-color: #D7C097;" class="text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-user-shield text-2xl"></i>
                    <h1 class="text-xl font-bold">Admin Panel - Perpustakaan Arcadia</h1>
                </div>
                
                @auth('admin')
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ Auth::guard('admin')->user()->nama_admin }}
                    </span>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-200 transition">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.peminjaman.index') }}" class="hover:text-purple-200 transition">
                        <i class="fas fa-book-reader"></i> Peminjaman
                    </a>
                    <a href="{{ route('admin.buku.index') }}" class="hover:text-purple-200 transition">
                        <i class="fas fa-book"></i> Buku
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-purple-200 transition">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-md" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-md" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded shadow-md" role="alert">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                <span>{{ session('info') }}</span>
            </div>
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
            <p>&copy; 2024 Perpustakaan Arcadia - Admin Panel</p>
            <p class="text-sm text-gray-400 mt-2">Drive-Thru Library Management System</p>
        </div>
    </footer>

    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>