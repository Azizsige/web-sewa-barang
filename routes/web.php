<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
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
    Route::resource('categories', CategoryController::class);
    Route::resource('rentals', RentalController::class);
});
