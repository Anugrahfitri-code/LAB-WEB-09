<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::firstOrCreate(['name' => 'PT. Indofood Sukses Makmur Tbk']);
        Supplier::firstOrCreate(['name' => 'PT. Mayora Indah Tbk']);
        Supplier::firstOrCreate(['name' => 'PT. Sinar Dunia']);
        Supplier::firstOrCreate(['name' => 'Distributor ASUS Indonesia']);
    }
}