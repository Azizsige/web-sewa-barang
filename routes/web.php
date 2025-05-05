<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Developer\DashboardController as DeveloperDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Auth Routes (dari Breeze)
require __DIR__ . '/auth.php';

// Dashboard Routes (untuk semua role)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    // Tambah route untuk updateImageOrder
    Route::post('products/{product}/update-image-order', [ProductController::class, 'updateImageOrder'])->name('products.updateImageOrder');
    Route::resource('categories', CategoryController::class);
    Route::resource('rentals', RentalController::class);

    Route::get('/rentals/export/excel', [RentalController::class, 'export'])->name('rentals.export');

    // Route untuk profile admin
    // Route untuk profile admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
