<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Developer\DashboardController as DeveloperDashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

use App\Models\Category;
use App\Models\Product;

// Public Routes
Route::get('/', function () {
    $categories = Category::all(); // Ambil semua kategori
    $selectedCategory = request()->input('category'); // Ambil kategori dari query string
    $products = Product::with(['category', 'primaryImage'])
        ->active()
        ->when($selectedCategory, function ($query) use ($selectedCategory) {
            return $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        })
        ->take(5)
        ->get();
    return view('welcome', compact('categories', 'products', 'selectedCategory'));
})->name('landing');

Route::get('/produk', function () {
    return view('landing.products');
})->name('produk');

Route::get('/detail-produk/{slug}', function ($slug) {
    // Logika sederhana buat testing (nanti ganti ke controller/database)
    return view('landing.detail-produk', ['productSlug' => $slug]);
})->name('produk.detail');

// Auth Routes (dari Breeze)
require __DIR__ . '/auth.php';

// Dashboard Routes (untuk semua role)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{product}/update-image-order', [ProductController::class, 'updateImageOrder'])->name('products.updateImageOrder');
    Route::resource('categories', CategoryController::class);
    Route::resource('rentals', RentalController::class);

    Route::get('/rentals/export/excel', [RentalController::class, 'export'])->name('rentals.export');

    // Route untuk profile admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk developer (superadmin)
Route::middleware(['auth', 'developer'])->group(function () {
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
    Route::resource('admin-users', AdminUserController::class);
});
