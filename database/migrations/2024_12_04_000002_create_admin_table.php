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
        Schema::create('admin_sewa_motor', function (Blueprint $table) {
            $table->string('Id_admin_rental_motor')->primary();
            $table->string('Nama_admin');
            $table->text('Alamat');
            $table->string('No_telp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_sewa_motor');
    }
};
