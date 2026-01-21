<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController; // <--- PENTING: Jangan lupa baris ini
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN UTAMA (Public)
// Menggantikan view 'welcome' bawaan dengan Sales Controller agar grafik langsung muncul
Route::get('/', [SaleController::class, 'index'])->name('sales.index');

// 2. ROUTE DASHBOARD
// Kita arahkan juga ke halaman penjualan agar saat login tidak masuk ke halaman kosong
Route::get('/dashboard', [SaleController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. GRUP KHUSUS ADMIN (Wajib Login)
Route::middleware('auth')->group(function () {
    
    // --- FITUR CRUD PENJUALAN (Hanya Admin) ---
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{id}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::put('/sales/{id}', [SaleController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');

    // --- FITUR PROFILE (Bawaan Breeze - Biarkan saja) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route otentikasi (Login/Register/Logout)
require __DIR__.'/auth.php';