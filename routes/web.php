<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Products routes
Route::resource('products', ProductsController::class)
    ->middleware(['auth', 'role:admin']);

// Suppliers routes
Route::resource('suppliers', SuppliersController::class)
    ->middleware(['auth', 'role:admin']);

// Stock In routes
Route::resource('stock-in', StockInController::class)
    ->middleware(['auth', 'role:admin|cashier']);

// Stock Out routes
Route::resource('stock-out', StockOutController::class)
    ->middleware(['auth', 'role:admin|cashier']);

// POS routes
Route::get('/pos', [POSController::class, 'index'])
    ->middleware(['auth', 'role:admin|cashier'])
    ->name('pos.index');

Route::post('/pos/process', [POSController::class, 'processSale'])
    ->middleware(['auth', 'role:admin|cashier'])
    ->name('pos.process');

Route::get('/pos/search', function () {
    $query = request('q');
    return \App\Models\Product::where('name', 'LIKE', "%{$query}%")
        ->orWhere('sku', 'LIKE', "%{$query}%")
        ->get(['id', 'name', 'sku', 'selling_price', 'stock', 'unit']);
})->middleware(['auth', 'role:admin|cashier'])->name('pos.search');

// Reports routes
Route::prefix('reports')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/sales', [ReportsController::class, 'salesReport'])->name('reports.sales');
    Route::get('/stock', [ReportsController::class, 'stockReport'])->name('reports.stock');
    Route::get('/profit', [ReportsController::class, 'profitReport'])->name('reports.profit');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
