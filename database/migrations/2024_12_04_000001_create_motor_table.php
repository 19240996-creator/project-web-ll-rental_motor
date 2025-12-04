<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('motor', function (Blueprint $table) {
            $table->string('Id_motor')->primary();
            $table->string('Merk_motor');
            $table->string('Warna_motor');
            $table->integer('Harga');
            $table->string('Plat_nomor')->unique();
            $table->string('Tahun_motor');
            $table->enum('Status_motor', ['Tersedia', 'Disewa', 'Maintenance'])->default('Tersedia');
            $table->text('Deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motor');
    }
};
