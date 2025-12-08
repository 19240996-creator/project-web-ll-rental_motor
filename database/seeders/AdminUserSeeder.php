<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@rental.com'],
            [
                'name' => 'Admin Rental Motor',
                'email' => 'admin@rental.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Admin, Jakarta',
                'no_identitas' => '1234567890123456',
                'tipe_identitas' => 'KTP'
            ]
        );

        // Create test customer user
        User::firstOrCreate(
            ['email' => 'customer@rental.com'],
            [
                'name' => 'Pelanggan Test',
                'email' => 'customer@rental.com',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'no_telepon' => '082234567890',
                'alamat' => 'Jl. Pelanggan, Jakarta',
                'no_identitas' => '9876543210123456',
                'tipe_identitas' => 'KTP'
            ]
        );

        $this->command->info('Admin dan Customer users created successfully!');
    }
}
