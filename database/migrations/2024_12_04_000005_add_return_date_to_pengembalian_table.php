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
        Schema::table('pengembalian', function (Blueprint $table) {
            // Add actual return date if not exists
            if (!Schema::hasColumn('pengembalian', 'Tanggal_kembali_sebenarnya')) {
                $table->date('Tanggal_kembali_sebenarnya')->nullable()->after('Tanggal_pengembalian');
            }
            
            // Add status if not exists
            if (!Schema::hasColumn('pengembalian', 'Status_pengembalian')) {
                $table->enum('Status_pengembalian', ['Diproses', 'Dikembalikan', 'Dikembalikan_Terlambat'])->default('Diproses')->after('Catatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            if (Schema::hasColumn('pengembalian', 'Tanggal_kembali_sebenarnya')) {
                $table->dropColumn('Tanggal_kembali_sebenarnya');
            }
            if (Schema::hasColumn('pengembalian', 'Status_pengembalian')) {
                $table->dropColumn('Status_pengembalian');
            }
        });
    }
};
