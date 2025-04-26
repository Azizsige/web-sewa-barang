<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Produk 1: Laptop
        $product1 = Product::create([
            'id' => Str::uuid()->toString(),
            'category_id' => '56318ee4-cf3f-4a8f-9007-3f641e3c6aa9', // Elektronik
            'name' => 'Laptop',
            'slug' => 'laptop',
            'description' => 'Laptop untuk kebutuhan kerja',
            'price' => 50000,
            'status' => 'active',
            'stock' => 5,
            'is_bundle' => false,
        ]);

        // Tambah gambar untuk Laptop
        ProductImage::create([
            'id' => Str::uuid()->toString(),
            'product_id' => $product1->id,
            'image_path' => 'product_images/laptop.jpg',
            'is_primary' => true,
            'order' => 0, // Set order
        ]);
        ProductImage::create([
            'id' => Str::uuid()->toString(),
            'product_id' => $product1->id,
            'image_path' => 'product_images/laptop-side.jpg',
            'is_primary' => false,
            'order' => 1, // Set order
        ]);

        // Produk 2: Jaket
        $product2 = Product::create([
            'id' => Str::uuid()->toString(),
            'category_id' => 'a9d8b7e2-fc5d-4b9e-8c3f-2e5d9a7b6c2d', // Pakaian
            'name' => 'Jaket',
            'slug' => 'jaket',
            'description' => 'Jaket musim dingin',
            'price' => 20000,
            'status' => 'active',
            'stock' => 10,
            'is_bundle' => false,
        ]);

        // Tambah gambar untuk Jaket
        ProductImage::create([
            'id' => Str::uuid()->toString(),
            'product_id' => $product2->id,
            'image_path' => 'product_images/jaket.jpg',
            'is_primary' => true,
            'order' => 0, // Set order
        ]);

        // Produk 3: Paket Laptop + Mouse
        $product3 = Product::create([
            'id' => Str::uuid()->toString(),
            'category_id' => '56318ee4-cf3f-4a8f-9007-3f641e3c6aa9', // Elektronik
            'name' => 'Paket Laptop + Mouse',
            'slug' => 'paket-laptop-mouse',
            'description' => 'Paket sewa laptop dan mouse',
            'price' => 60000,
            'status' => 'inactive',
            'stock' => 3,
            'is_bundle' => true,
        ]);

        // Tambah gambar untuk Paket Laptop + Mouse
        ProductImage::create([
            'id' => Str::uuid()->toString(),
            'product_id' => $product3->id,
            'image_path' => 'product_images/paket-laptop-mouse.jpg',
            'is_primary' => true,
            'order' => 0, // Set order
        ]);
    }
}
