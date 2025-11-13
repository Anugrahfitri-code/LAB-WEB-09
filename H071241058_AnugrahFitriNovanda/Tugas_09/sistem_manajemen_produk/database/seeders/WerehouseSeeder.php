<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::firstOrCreate(['name' => 'Gudang Utama Makassar'], ['location' => 'Jl. Perintis Kemerdekaan KM. 10']);
        Warehouse::firstOrCreate(['name' => 'Gudang Cabang Gowa'], ['location' => 'Jl. Poros Malino']);
        Warehouse::firstOrCreate(['name' => 'Gudang Maros'], ['location' => 'Kawasan Industri Maros']);
    }
}