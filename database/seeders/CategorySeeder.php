<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan Utama', 'slug' => 'makanan-utama'],
            ['name' => 'Minuman', 'slug' => 'minuman'],
            ['name' => 'Cemilan', 'slug' => 'cemilan'],
            ['name' => 'Dessert', 'slug' => 'dessert'],
            ['name' => 'Paket Spesial', 'slug' => 'paket-spesial'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
