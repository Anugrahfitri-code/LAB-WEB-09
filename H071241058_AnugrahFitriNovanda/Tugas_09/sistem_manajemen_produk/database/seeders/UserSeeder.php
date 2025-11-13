<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $stafProdukRole = Role::where('name', 'Staf Produk')->first();
        $stafGudangRole = Role::where('name', 'Staf Gudang')->first();

        if (!$adminRole || !$stafProdukRole || !$stafGudangRole) {
            $this->command->error('Gagal menjalankan UserSeeder: Pastikan RoleSeeder sudah dijalankan dan berisi "Admin", "Staf Produk", dan "Staf Gudang".');
            return;
        }

        User::firstOrCreate(
            ['email' => 'admin@app.com'],
            [
                'name' => 'Admin Utama',
                'role_id' => $adminRole->id,
                'password' => Hash::make('password'), // Password-nya adalah "password"
            ]
        );

        // 3. Buat User Staf Produk
        User::firstOrCreate(
            ['email' => 'produk@app.com'],
            [
                'name' => 'Staf Produk',
                'role_id' => $stafProdukRole->id,
                'password' => Hash::make('password'), // Password-nya adalah "password"
            ]
        );

        // 4. Buat User Staf Gudang
        User::firstOrCreate(
            ['email' => 'gudang@app.com'],
            [
                'name' => 'Staf Gudang',
                'role_id' => $stafGudangRole->id,
                'password' => Hash::make('password'), // Password-nya adalah "password"
            ]
        );
    }
}