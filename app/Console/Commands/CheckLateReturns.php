<?php

namespace App\Console\Commands;

use App\Models\Pengembalian;
use Illuminate\Console\Command;

class CheckLateReturns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'returns:check-late {--force : Force check all returns}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and auto-update late returns. Can be scheduled daily to detect overdue returns.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');

        // Get pengembalian yang belum di-check atau masih dalam status Diproses
        $query = Pengembalian::where('Status_pengembalian', 'Diproses')
            ->orWhere(function($q) {
                // Re-check yang sudah dikembalikan jika ada tanggal sebenarnya
                $q->whereNotNull('Tanggal_kembali_sebenarnya')
                  ->where('Status_pengembalian', '!=', 'Dikembalikan_Terlambat');
            });

        if ($force) {
            // Check semua pengembalian jika force
            $query = Pengembalian::query();
        }

        $pengembalians = $query->get();
        $lateCount = 0;
        $onTimeCount = 0;

        foreach ($pengembalians as $pengembalian) {
            if ($pengembalian->checkAndUpdateLateness()) {
                $lateCount++;
                $this->line("❌ <fg=red>{$pengembalian->Id_pengembalian}</> - TERLAMBAT (Denda: Rp " . 
                    number_format($pengembalian->Biaya_keterlambatan, 0, ',', '.') . ")");
            } elseif ($pengembalian->Tanggal_kembali_sebenarnya) {
                $onTimeCount++;
                $this->line("✓ <fg=green>{$pengembalian->Id_pengembalian}</> - Tepat Waktu");
            }
        }

        $this->newLine();
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("Pengembalian Terlambat: <fg=red>{$lateCount}</>");
        $this->info("Pengembalian Tepat Waktu: <fg=green>{$onTimeCount}</>");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

        return Command::SUCCESS;
    }
}
