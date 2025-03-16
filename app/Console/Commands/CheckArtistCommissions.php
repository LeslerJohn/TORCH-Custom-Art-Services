<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ArtistProfile;

class CheckArtistCommissions extends Command
{
    protected $signature = 'artist:check-commissions';
    protected $description = 'Check artist commissions count and update availability';

    public function handle()
    {
        $artists = ArtistProfile::with(['services.commissions' => function ($query) {
            $query->whereIn('commission.status', ['ready', 'wip']);
        }])->get();
    
        // Log::info($artists);
    
        foreach ($artists as $artist) {
            $commissionCount = 0;
            foreach ($artist->services as $service) {
                foreach ($service->commissions as $commission) {
                    $commissionCount += $commission->request_quantity;
                }
            }
    
            if ($commissionCount >= $artist->max_commissions) {
                $artist->available = false;
                $artist->save();
            } else {
                $artist->available = true;
                $artist->save();
            }
    
            // Log::info($artist->username . ' - ' . $commissionCount . ' - ' . $artist->max_commissions);
        }
    
        $this->info('Artist commissions checked and availability updated.');
    }
}
