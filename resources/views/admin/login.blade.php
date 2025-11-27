<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Perpustakaan Arcadia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/book.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom {
            background-color: #D7C097;
        }
        .text-custom {
            color: #D7C097;
        }
        .border-custom {
            border-color: #D7C097;
        }
        .hover-custom:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body class="bg-custom min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center mb-6">
                <i class="fas fa-user-shield text-6xl text-custom mb-4"></i>
                <h2 class="text-3xl font-bold text-gray-800">Admin Login</h2>
                <p class="text-gray-600 mt-2">Perpustakaan Arcadia</p>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <!-- Username -->
                <div class="mb-4">
                    <label for="user_admin" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-1"></i> Username
                    </label>
                    <input type="text" 
                           id="user_admin" 
                           name="user_admin" 
                           value="{{ old('user_admin') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:border-custom @error('user_admin') border-red-500 @enderror"
                           placeholder="Masukkan username admin"
                           required>
                    @error('user_admin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="pass_admin" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-1"></i> Password
                    </label>
                    <input type="password" 
                           id="pass_admin" 
                           name="pass_admin" 
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:border-custom @error('pass_admin') border-red-500 @enderror"
                           placeholder="Masukkan password"
                           required>
                    @error('pass_admin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 rounded">
                        <span class="text-gray-700">Ingat Saya</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" 
                        class="w-full bg-custom text-white py-3 rounded-lg hover-custom transition font-semibold shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login sebagai Admin
                </button>
            </form>

            <!-- Link ke Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-custom hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>