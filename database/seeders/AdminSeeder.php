<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test admin user for rental motor admin
        \DB::table('admin_sewa_motor')->insertOrIgnore([
            'Id_admin_rental_motor' => 'ADM001',
            'Nama_admin' => 'Admin Rental Motor',
            'No_telp' => '081234567890',
            'Alamat' => 'Jl. Admin, Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
    }
}

