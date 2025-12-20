<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motor;

class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Motor::create([
            'Id_motor' => 'MTR001',
            'Merk_motor' => 'Honda CB150R',
            'Warna_motor' => 'Merah',
            'Harga' => 150000,
            'Plat_nomor' => 'B 1234 ABC',
            'Tahun_motor' => '2023',
            'Status_motor' => 'Tersedia',
            'Deskripsi' => 'Motor sport style, mesin 4 tak, 150cc'
        ]);

        Motor::create([
            'Id_motor' => 'MTR002',
            'Merk_motor' => 'Yamaha Vixion',
            'Warna_motor' => 'Hitam',
            'Harga' => 180000,
            'Plat_nomor' => 'B 5678 XYZ',
            'Tahun_motor' => '2022',
            'Status_motor' => 'Tersedia',
            'Deskripsi' => 'Motor standar, mesin 4 tak, 155cc'
        ]);

        Motor::create([
            'Id_motor' => 'MTR003',
            'Merk_motor' => 'Suzuki GSX',
            'Warna_motor' => 'Biru',
            'Harga' => 200000,
            'Plat_nomor' => 'B 9012 DEF',
            'Tahun_motor' => '2023',
            'Status_motor' => 'Tersedia',
            'Deskripsi' => 'Motor sport premium, mesin 4 tak, 150cc'
        ]);

        Motor::create([
            'Id_motor' => 'MTR004',
            'Merk_motor' => 'Kawasaki Ninja',
            'Warna_motor' => 'Hijau',
            'Harga' => 250000,
            'Plat_nomor' => 'B 3456 GHI',
            'Tahun_motor' => '2023',
            'Status_motor' => 'Tersedia',
            'Deskripsi' => 'Motor sport racing, mesin 4 tak, 250cc'
        ]);

        Motor::create([
            'Id_motor' => 'MTR005',
            'Merk_motor' => 'Honda PCX',
            'Warna_motor' => 'Abu-abu',
            'Harga' => 120000,
            'Plat_nomor' => 'B 7890 JKL',
            'Tahun_motor' => '2022',
            'Status_motor' => 'Tersedia',
            'Deskripsi' => 'Motor scooter, otomatis, 160cc'
        ]);
    }
}
