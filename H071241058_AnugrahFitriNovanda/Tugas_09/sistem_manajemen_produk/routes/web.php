<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


// === GRUP UTAMA APLIKASI (HARUS LOGIN) ===
Route::middleware('auth')->group(function () {
    
    // Rute Dashboard & Logout (Bisa diakses semua peran)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // --- KATEGORI (Hanya Admin) ---
    Route::middleware('role:Admin')->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    // --- PRODUK ---
    // Staf Produk & Admin bisa Tambah/Edit/Hapus
    Route::middleware('role:Admin,Staf Produk')->group(function () {
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::patch('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
    // Staf Gudang (dan yg lain) bisa LIHAT
    Route::middleware('role:Admin,Staf Produk,Staf Gudang')->group(function () {
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    });


    // --- GUDANG ---
    // Admin bisa Tambah/Edit/Hapus
    Route::middleware('role:Admin')->group(function () {
        Route::get('warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
        Route::post('warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
        Route::get('warehouses/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
        Route::put('warehouses/{warehouse}', [WarehouseController::class, 'update'])->name('warehouses.update');
        Route::patch('warehouses/{warehouse}', [WarehouseController::class, 'update']);
        Route::delete('warehouses/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
    });
    // Staf Produk (dan Admin) bisa LIHAT
    Route::middleware('role:Admin,Staf Produk')->group(function () {
        Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
        Route::get('warehouses/{warehouse}', [WarehouseController::class, 'show'])->name('warehouses.show');
    });


    // --- STOK (Hanya Admin & Staf Gudang) ---
    Route::middleware('role:Admin,Staf Gudang')->group(function () {
        Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
        Route::get('stocks/transfer', [StockController::class, 'createTransfer'])->name('stocks.transfer.create');
        Route::post('stocks/transfer', [StockController::class, 'storeTransfer'])->name('stocks.transfer.store');
    });

});