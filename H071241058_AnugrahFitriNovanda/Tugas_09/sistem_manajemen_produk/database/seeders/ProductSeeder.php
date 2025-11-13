<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori
        $cSnack = Category::where('name', 'Makanan Ringan')->first();
        $cMinuman = Category::where('name', 'Minuman')->first();
        $cAtk = Category::where('name', 'ATK')->first();
        $cElektronik = Category::where('name', 'Elektronik')->first();

        // --- Produk Makanan ---
        $this->createProduct(
            $cSnack, 'Chocolatos Wafer Roll', 1000, 'SNK-MAYORA-001',
            1.50, 'Box 20pcs', 'Wafer roll coklat nikmat'
        );
        $this->createProduct(
            $cSnack, 'Momogi Coklat', 5000, 'SNK-FORISA-001',
            0.50, 'Pack 10pcs', 'Snack jagung rasa coklat'
        );

        // --- Produk Minuman ---
        $this->createProduct(
            $cMinuman, 'Aqua Botol 600ml', 3500, 'MIN-DANONE-001',
            0.60, '600 ml', 'Air mineral'
        );
        $this->createProduct(
            $cMinuman, 'Teh Pucuk Harum 350ml', 3000, 'MIN-MAYORA-001',
            0.35, '350 ml', 'Minuman teh melati'
        );

        // --- Produk ATK ---
        $this->createProduct(
            $cAtk, 'Kertas A4 Sinar Dunia 70gr', 55000, 'ATK-SIDU-001',
            2.50, '1 Rim (500 lbr)', 'Kertas HVS A4 70gsm'
        );

        // --- Produk Elektronik ---
        $this->createProduct(
            $cElektronik, 'Laptop ASUS Zenbook 14', 14500000, 'LAP-ASUS-001',
            1.40, '14 inch', 'Laptop tipis dengan Intel Core i5'
        );
    }

    /**
     * Fungsi helper untuk membuat produk dan detailnya
     */
    private function createProduct($category, $name, $price, $sku, $weight, $size, $description)
    {
        // Buat Produk
        $product = Product::firstOrCreate(
            ['sku' => $sku], 
            [
                'name' => $name,
                'category_id' => $category->id,
                'price' => $price,
                'status' => 'active',
            ]
        );

        // Buat Detail Produk
        $product->productDetail()->create([
            'weight' => $weight,
            'size' => $size,
            'description' => $description,
        ]);
    }
}