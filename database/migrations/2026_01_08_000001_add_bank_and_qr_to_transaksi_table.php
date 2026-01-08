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
        Schema::table('transaksi', function (Blueprint $table) {
            // Kolom untuk menyimpan pilihan bank customer
            $table->enum('bank_tujuan', ['BCA', 'Mandiri', 'BRI', 'BNI', 'Lainnya'])->nullable()->after('metode_pembayaran');
            
            // Kolom untuk menyimpan kode QR (path ke file atau base64)
            $table->longText('qr_code')->nullable()->after('bank_tujuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['bank_tujuan', 'qr_code']);
        });
    }
};
