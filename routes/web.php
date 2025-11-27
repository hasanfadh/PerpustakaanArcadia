<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PeminjamanController;

// Halaman Landing/Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ========================================
// ROUTES UNTUK PEMINJAM
// ========================================

// Routes untuk registrasi dan login peminjam (guest)
Route::middleware('guest:peminjam')->group(function () {
    // Registrasi
    Route::get('/register', [PeminjamController::class, 'showRegistrationForm'])
        ->name('peminjam.register');
    Route::post('/register', [PeminjamController::class, 'register'])
        ->name('peminjam.register.submit');
    
    // Login
    Route::get('/login', [PeminjamController::class, 'showLoginForm'])
        ->name('peminjam.login');
    Route::post('/login', [PeminjamController::class, 'login'])
        ->name('peminjam.login.submit');
});

// Routes untuk peminjam yang sudah login
Route::middleware('peminjam')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PeminjamController::class, 'dashboard'])
        ->name('peminjam.dashboard');
    
    // Logout
    Route::post('/logout', [PeminjamController::class, 'logout'])
        ->name('peminjam.logout');
    
    // Peminjaman
    Route::prefix('peminjaman')->group(function () {
        // Menampilkan daftar buku
        Route::get('/', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');
        
        // Tambah buku ke keranjang
        Route::post('/cart/add/{id_buku}', [PeminjamanController::class, 'addToCart'])
            ->name('peminjaman.cart.add');
        
        // Hapus buku dari keranjang
        Route::delete('/cart/remove/{id_buku}', [PeminjamanController::class, 'removeFromCart'])
            ->name('peminjaman.cart.remove');
        
        // Form pemesanan peminjaman
        Route::get('/create', [PeminjamanController::class, 'create'])
            ->name('peminjaman.create');
        
        // Simpan pemesanan peminjaman
        Route::post('/store', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');
        
        // Detail peminjaman
        Route::get('/{id_peminjaman}', [PeminjamanController::class, 'show'])
            ->name('peminjaman.show');
    });
});

// ========================================
// ROUTES UNTUK ADMIN
// ========================================

// Routes untuk login admin (guest)
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [App\Http\Controllers\AdminController::class, 'showLoginForm'])
        ->name('admin.login');
    Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'login'])
        ->name('admin.login.submit');
});

// Routes untuk admin yang sudah login
Route::middleware('admin')->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
    
    // Logout
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])
        ->name('admin.logout');
    
    // Manajemen Peminjaman
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ManajemenPeminjamanController::class, 'index'])
            ->name('admin.peminjaman.index');
        Route::get('/{id_peminjaman}', [App\Http\Controllers\Admin\ManajemenPeminjamanController::class, 'show'])
            ->name('admin.peminjaman.show');
        Route::post('/{id_peminjaman}/approve', [App\Http\Controllers\Admin\ManajemenPeminjamanController::class, 'approve'])
            ->name('admin.peminjaman.approve');
        Route::post('/{id_peminjaman}/reject', [App\Http\Controllers\Admin\ManajemenPeminjamanController::class, 'reject'])
            ->name('admin.peminjaman.reject');
        Route::post('/{id_peminjaman}/return', [App\Http\Controllers\Admin\ManajemenPeminjamanController::class, 'returnBook'])
            ->name('admin.peminjaman.return');
        Route::delete('/{id_peminjaman}/book/{id_buku}', [App\Http\Controllers\Admin\ManajemenPeminjamanController::class, 'removeBook'])
            ->name('admin.peminjaman.remove-book');
    });
    
    // Manajemen Buku
    Route::prefix('buku')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ManajemenBukuController::class, 'index'])
            ->name('admin.buku.index');
        Route::get('/create', [App\Http\Controllers\Admin\ManajemenBukuController::class, 'create'])
            ->name('admin.buku.create');
        Route::post('/', [App\Http\Controllers\Admin\ManajemenBukuController::class, 'store'])
            ->name('admin.buku.store');
        Route::get('/{id_buku}/edit', [App\Http\Controllers\Admin\ManajemenBukuController::class, 'edit'])
            ->name('admin.buku.edit');
        Route::put('/{id_buku}', [App\Http\Controllers\Admin\ManajemenBukuController::class, 'update'])
            ->name('admin.buku.update');
        Route::delete('/{id_buku}', [App\Http\Controllers\Admin\ManajemenBukuController::class, 'destroy'])
            ->name('admin.buku.destroy');
    });
});