<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get test customer and admin
        $customer = \App\Models\User::where('email', 'customer@rental.com')->first();
        $admin = \App\Models\Admin::first();
        $motor = \App\Models\Motor::first();

        if (!$customer || !$admin || !$motor) {
            $this->command->error('Please run AdminUserSeeder and AdminSeeder first');
            return;
        }

        // Create a test transaksi
        $transaksi = \App\Models\Transaksi::create([
            'Id_transaksi' => 'TRX-' . Str::random(10),
            'user_id' => $customer->id,
            'Id_motor' => $motor->Id_motor,
            'Id_admin_rental_motor' => $admin->Id_admin_rental_motor,
            'Tanggal_sewa' => now()->subDays(7)->toDateString(),
            'Tanggal_kembali' => now()->subDays(2)->toDateString(),
            'Status_sewa' => 'Selesai',
            'Total_biaya' => $motor->Harga * 6, // 6 hari
        ]);

        // Create pengembalian untuk transaksi tersebut
        \App\Models\Pengembalian::create([
            'Id_pengembalian' => 'PGB-' . Str::random(10),
            'Id_transaksi' => $transaksi->Id_transaksi,
            'Tanggal_pengembalian' => now()->subDays(2)->toDateString(),
            'Tanggal_kembali_sebenarnya' => now()->subDays(1)->toDateString(), // 1 hari terlambat
            'Biaya_keterlambatan' => $motor->Harga, // Denda 1 hari
            'Status_pengembalian' => 'Dikembalikan_Terlambat',
            'Catatan' => 'Motor dikembalikan terlambat 1 hari',
        ]);

        $this->command->info('Test transaksi and pengembalian created successfully!');
    }
}
