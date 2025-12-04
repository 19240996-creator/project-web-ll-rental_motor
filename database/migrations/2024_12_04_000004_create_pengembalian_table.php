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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->string('Id_pengembalian')->primary();
            $table->string('Id_transaksi');
            $table->date('Tanggal_pengembalian');
            $table->integer('Biaya_keterlambatan')->default(0);
            $table->text('Catatan')->nullable();
            $table->timestamps();

            $table->foreign('Id_transaksi')->references('Id_transaksi')->on('transaksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
