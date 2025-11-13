<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(['name' => 'Makanan Ringan'], ['description' => 'Snack dan camilan']);
        Category::firstOrCreate(['name' => 'Minuman'], ['description' => 'Minuman kemasan']);
        Category::firstOrCreate(['name' => 'Elektronik'], ['description' => 'Laptop, HP, dan aksesoris']);
        Category::firstOrCreate(['name' => 'ATK'], ['description' => 'Alat Tulis Kantor']);
        Category::firstOrCreate(['name' => 'Sembako'], ['description' => 'Kebutuhan pokok']);
    }
}