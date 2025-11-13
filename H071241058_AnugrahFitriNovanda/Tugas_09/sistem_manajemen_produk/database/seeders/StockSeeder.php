<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\User;
use App\Models\StockMovement;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data yang kita butuhkan
        $products = Product::all();
        $gudangMakassar = Warehouse::where('name', 'Gudang Utama Makassar')->first();
        $gudangGowa = Warehouse::where('name', 'Gudang Cabang Gowa')->first();
        $supplierIndofood = Supplier::where('name', 'PT. Indofood Sukses Makmur Tbk')->first();
        $supplierAsus = Supplier::where('name', 'Distributor ASUS Indonesia')->first();
        $admin = User::where('email', 'admin@app.com')->first();

        // Loop setiap produk dan beri stok awal
        foreach ($products as $product) {
            // Beri stok acak
            $stokGudangMakassar = rand(50, 200);
            $stokGudangGowa = rand(20, 100);

            // 1. Beri stok di Gudang Makassar
            $this->addStock(
                $admin, $product, $gudangMakassar, $stokGudangMakassar, 
                'Stok awal dari supplier'
            );

            // 2. Beri stok di Gudang Gowa
            $this->addStock(
                $admin, $product, $gudangGowa, $stokGudangGowa, 
                'Stok awal dari supplier'
            );

            // 3. Hubungkan supplier ke produk (Contoh)
            if ($product->category->name == 'Elektronik') {
                $product->suppliers()->syncWithoutDetaching([$supplierAsus->id]);
            } else {
                $product->suppliers()->syncWithoutDetaching([$supplierIndofood->id]);
            }
        }
    }

    /**
     * Fungsi helper untuk menambah stok awal
     */
    private function addStock($user, $product, $warehouse, $quantity, $notes)
    {
        // 1. Buat catatan di tabel pivot (total)
        DB::table('product_warehouse')->updateOrInsert(
            ['product_id' => $product->id, 'warehouse_id' => $warehouse->id],
            ['quantity' => $quantity]
        );

        // 2. Buat log riwayat di stock_movements
        StockMovement::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'warehouse_id' => $warehouse->id,
            'type' => 'in',
            'quantity' => $quantity,
            'notes' => $notes,
            'created_at' => now(),
        ]);
    }
}