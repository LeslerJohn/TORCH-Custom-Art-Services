<?php

use App\Mail\WelcomeMail;
use App\Models\ArtistProfile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('send-welcome-mail', function () {
    Mail::to('leslerjohngantalao@gmail.com')->send(new WelcomeMail("Lesler John"));
    
    // Also, you can use specific mailer if your default mailer is not "mailtrap" but you want to use it for welcome mails
    // Mail::mailer('mailtrap')->to('testreceiver@gmail.com')->send(new WelcomeMail("Jon"));
})->purpose('Send welcome mail');

Artisan::command('artist:check-commissions', function () {
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
})->purpose('Check artist commissions count and update availability');

Schedule::command('artist:check-commissions')->everyFiveSeconds();