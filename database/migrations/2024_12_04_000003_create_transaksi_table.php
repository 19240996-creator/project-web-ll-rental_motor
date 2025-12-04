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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('Id_transaksi')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('Id_motor');
            $table->string('Id_admin_rental_motor');
            $table->date('Tanggal_sewa');
            $table->date('Tanggal_kembali');
            $table->enum('Status_sewa', ['Proses', 'Aktif', 'Selesai', 'Batal'])->default('Proses');
            $table->integer('Total_biaya');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Id_motor')->references('Id_motor')->on('motor')->onDelete('cascade');
            $table->foreign('Id_admin_rental_motor')->references('Id_admin_rental_motor')->on('admin_sewa_motor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
