<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'id' => '56318ee4-cf3f-4a8f-9007-3f641e3c6aa9',
            'name' => 'Elektronik',
            'slug' => 'elektronik',
            'image' => 'categories/elektronik.jpg',
        ]);

        Category::create([
            'id' => 'a9d8b7e2-fc5d-4b9e-8c3f-2e5d9a7b6c2d',
            'name' => 'Pakaian',
            'slug' => 'pakaian',
            'image' => 'categories/pakaian.jpg',
        ]);

        Category::create([
            'id' => 'b7c6a5d3-eb4f-4c8d-9d2e-1f4c8a6b5e3c',
            'name' => 'Alat Olahraga',
            'slug' => 'alat-olahraga',
            'image' => 'categories/alat_olahraga.jpg',
        ]);
    }
}
