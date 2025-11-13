<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder dalam urutan yang benar 
        // untuk menghindari error foreign key
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            WarehouseSeeder::class, 
            SupplierSeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
        ]);
    }
}