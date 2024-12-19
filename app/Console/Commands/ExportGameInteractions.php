<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GameStore;

class ExportGameInteractions extends Command
{
    protected $signature = 'export:game-interactions';
    protected $description = 'Export game interactions to CSV';

    public function handle()
    {
        $filePath = base_path('python/interactions.csv');
        $interactions = GameStore::select('PlayerID', 'GameID', 'TotalPlayTime')->get();

        $file = fopen($filePath, 'w');
        fputcsv($file, ['PlayerID', 'GameID', 'TotalPlayTime']);

        foreach ($interactions as $interaction) {
            fputcsv($file, [$interaction->PlayerID, $interaction->GameID, $interaction->TotalPlayTime]);
        }

        fclose($file);
        $this->info('Game interactions exported to ' . $filePath);
    }
}
